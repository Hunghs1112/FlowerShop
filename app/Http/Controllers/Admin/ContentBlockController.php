<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContentBlock;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

/**
 * ContentBlockController
 * 
 * Quản lý content blocks qua admin UI với tab interface và auto-save.
 */
class ContentBlockController extends Controller
{
    /**
     * Hiển thị danh sách content blocks theo groups.
     * 
     * @return \Illuminate\View\View
     */
    public function index(Request $request)
    {
        // Lấy tất cả blocks
        $blocks = ContentBlock::orderBy('group')->orderBy('order')->orderBy('key')->get();
        
        // Chỉ hiển thị các nhóm nội dung, ẩn các phần chức năng
        $groups = ContentBlock::getGroups();
        $groups = $groups->filter(fn($group) => in_array($group, ['home_hero', 'home_sections']));
        
        // Group labels để hiển thị tab
        $groupLabels = [
            'home_hero' => 'Trang Chủ - Hero',
            'home_sections' => 'Trang Chủ - Sections',
        ];
        
        return view('admin.content-blocks.index', compact(
            'blocks',
            'groups',
            'groupLabels'
        ));
    }
    
    /**
     * Cập nhật content block (AJAX).
     * 
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'key' => 'required|string|exists:content_blocks,key',
            'value' => 'nullable|string|max:65535',
        ]);
        
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Dữ liệu không hợp lệ',
                'errors' => $validator->errors(),
            ], 422);
        }
        
        try {
            $block = ContentBlock::where('key', $request->key)->firstOrFail();
            $block->value = $request->value;
            $block->save();
            
            // Xóa cache
            ContentBlock::forgetCache($request->key);
            
            return response()->json([
                'success' => true,
                'message' => 'Đã lưu thành công',
                'data' => [
                    'key' => $block->key,
                    'value' => $block->value,
                    'updated_at' => $block->updated_at->format('d/m/Y H:i:s'),
                ],
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Có lỗi xảy ra: ' . $e->getMessage(),
            ], 500);
        }
    }
}