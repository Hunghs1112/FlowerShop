<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * Unifies `product_images` into `product_media` so a single row may be
     * either an image (the historical case) OR a video (new). New columns:
     *
     *   - media_type       : 'image' (default for backward compatibility) | 'video'
     *   - video_url        : nullable external URL (YouTube, etc.) when no upload
     *   - thumbnail_path   : nullable poster frame for videos (auto-generated later)
     *   - mime_type        : server-detected MIME for safer validation (mostly video/mp4 ...)
     *
     * The table is renamed to `product_media` to better reflect its new role.
     * Existing rows keep `image_path` / `is_primary` / `sort_order` intact and
     * default to `media_type = 'image'`, so legacy code continues to function.
     */
    public function up(): void
    {
        // Determine which table name to use
        $tableName = Schema::hasTable('product_media') ? 'product_media' : 'product_images';
        
        Schema::table($tableName, function (Blueprint $table) use ($tableName) {
            // Only add columns if they don't exist
            if (!Schema::hasColumn($tableName, 'mime_type')) {
                $table->string('mime_type', 100)->nullable()->after('image_path');
            }
            if (!Schema::hasColumn($tableName, 'media_type')) {
                $table->enum('media_type', ['image', 'video'])->default('image')->after('mime_type');
            }
            if (!Schema::hasColumn($tableName, 'video_url')) {
                $table->string('video_url', 500)->nullable()->after('media_type');
            }
            if (!Schema::hasColumn($tableName, 'thumbnail_path')) {
                $table->string('thumbnail_path', 255)->nullable()->after('video_url');
            }
        });

        // Check if table needs to be renamed
        if (Schema::hasTable('product_images') && !Schema::hasTable('product_media')) {
            // Drop the legacy foreign key before renaming, then rename, then
            // recreate the FK so the column still cascades on delete.
            Schema::table('product_images', function (Blueprint $table) {
                // Check if the foreign key exists before dropping
                // Try to drop by column name first
                try {
                    $table->dropForeign(['product_id']);
                } catch (\Throwable $e) {
                    // Foreign key doesn't exist, continue
                }
            });

            Schema::rename('product_images', 'product_media');

            Schema::table('product_media', function (Blueprint $table) {
                // Only add foreign key if it doesn't exist
                if (!$this->foreignKeyExists('product_media', 'product_id')) {
                    $table->foreign('product_id')
                        ->references('id')->on('products')
                        ->onDelete('cascade');
                }
            });
        }

        // Helpful composite index for the admin gallery view: primary sort
        // orders video rows after images (or however the user wants).
        $targetTable = Schema::hasTable('product_media') ? 'product_media' : 'product_images';
        Schema::table($targetTable, function (Blueprint $table) use ($targetTable) {
            // Add new index if it doesn't exist
            if (!$this->indexExists($targetTable, ['product_id', 'media_type'])) {
                $table->index(['product_id', 'media_type']);
            }
        });
    }

    /**
     * Check if a foreign key exists on a table
     */
    protected function foreignKeyExists(string $table, string $column): bool
    {
        try {
            $foreignKeys = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableForeignKeys($table);
            
            foreach ($foreignKeys as $fk) {
                if (in_array($column, $fk->getLocalColumns(), true)) {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            // Doctrine not available
        }
        
        return false;
    }

    /**
     * Check if an index exists on a table
     */
    protected function indexExists(string $table, array $columns): bool
    {
        try {
            $indexes = Schema::getConnection()
                ->getDoctrineSchemaManager()
                ->listTableIndexes($table);
            
            foreach ($indexes as $index) {
                if ($index->getColumns() === $columns) {
                    return true;
                }
            }
        } catch (\Throwable $e) {
            // Doctrine not available
        }
        
        return false;
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('product_media', function (Blueprint $table) {
            try {
                $table->dropIndex(['product_id', 'media_type']);
            } catch (\Throwable $e) {
                // ignore
            }
        });

        Schema::rename('product_media', 'product_images');

        Schema::table('product_images', function (Blueprint $table) {
            $table->dropColumn(['mime_type', 'media_type', 'video_url', 'thumbnail_path']);
            // Re-create the original composite index. The legacy name was
            // 'product_images_product_id_is_primary_index'.
            $table->index(['product_id', 'is_primary'], 'product_images_product_id_is_primary_index');
        });
    }

    /**
     * Best-effort lookup of the auto-generated foreign-key name for a
     * column. Returns the name or null if it cannot be determined.
     */
    protected function getForeignKeyName(string $table, string $column): ?string
    {
        try {
            $sm = Schema::getConnection()->getDoctrineSchemaManager();
            // Doctrine isn't always present (e.g. on SQLite-only test setups).
            // We guard with try/catch and return null on failure.
            $foreignKeys = method_exists($sm, 'listTableForeignKeys')
                ? $sm->listTableForeignKeys($table)
                : [];

            foreach ($foreignKeys as $fk) {
                $localColumns = method_exists($fk, 'getLocalColumns')
                    ? $fk->getLocalColumns()
                    : ($fk->localColumns ?? []);
                if (in_array($column, $localColumns, true)) {
                    return method_exists($fk, 'getName') ? $fk->getName() : ($fk->name ?? null);
                }
            }
        } catch (\Throwable $e) {
            // Doctrine not available or driver doesn't support introspection.
        }

        // Fall back to the conventional Laravel naming scheme.
        return $table . '_' . $column . '_foreign';
    }
};
