<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        $legacy = json_encode(config('seasonal'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
        $upgraded = $this->content();

        DB::table('pages')
            ->whereIn('slug', ['mua-le-hoi', 'phu-kien-cay-thong'])
            ->where('content', $legacy)
            ->update(['content' => $upgraded, 'updated_at' => now()]);
    }

    public function down(): void
    {
        DB::table('pages')
            ->whereIn('slug', ['mua-le-hoi', 'phu-kien-cay-thong'])
            ->where('content', $this->content())
            ->update([
                'content' => json_encode(config('seasonal'), JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR),
                'updated_at' => now(),
            ]);
    }

    private function content(): string
    {
        $config = $this->read('hub');
        $config['seasons'] = [
            $this->read('autumn'),
            $this->read('halloween'),
            $this->read('danish-tree'),
        ];
        unset($config['orderEndpoint']);

        return json_encode($config, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_THROW_ON_ERROR);
    }

    private function read(string $file): array
    {
        return json_decode(file_get_contents(resource_path("data/seasonal/{$file}.json")), true, flags: JSON_THROW_ON_ERROR);
    }
};
