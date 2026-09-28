<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MysteryBoxContentService;
use Illuminate\Http\Request;

class MysteryBoxContentController extends Controller
{
    public function edit(MysteryBoxContentService $contentService)
    {
        return view('admin.mystery-box-content.edit', [
            'content' => $contentService->get(),
        ]);
    }

    public function update(Request $request, MysteryBoxContentService $contentService)
    {
        $defaults = $contentService->defaults();
        $rules = [];

        foreach ($defaults as $key => $value) {
            if (!in_array($key, ['step_labels', 'styles', 'colors', 'preferences', 'budgets', 'surprise_levels'], true)) {
                $rules[$key] = 'required|string|max:3000';
            }
        }

        $validated = $request->validate($rules + [
            'step_labels_text' => 'required|string|max:1000',
            'styles_text' => 'required|string|max:1000',
            'colors_text' => 'required|string|max:1000',
            'preferences_text' => 'required|string|max:1000',
            'budgets_text' => 'required|string|max:2000',
            'surprise_levels_text' => 'required|string|max:1000',
        ]);

        $content = array_intersect_key($validated, $defaults);
        $content['step_labels'] = $contentService->textList($validated['step_labels_text']);
        $content['styles'] = $contentService->textList($validated['styles_text']);
        $content['colors'] = $contentService->textList($validated['colors_text']);
        $content['preferences'] = $contentService->textList($validated['preferences_text']);
        $content['budgets'] = $contentService->budgetList($validated['budgets_text']);
        $content['surprise_levels'] = $contentService->textList($validated['surprise_levels_text']);

        if (count($content['step_labels']) !== 7 || !$content['styles'] || !$content['colors'] || !$content['preferences'] || !$content['budgets'] || !$content['surprise_levels']) {
            return back()->withInput()->withErrors([
                'content' => 'Vui lòng nhập đủ 7 bước và ít nhất một lựa chọn cho mỗi nhóm.',
            ]);
        }

        $contentService->save($content);

        return redirect()->route('admin.mystery-box-content.edit')->with('success', 'Đã cập nhật nội dung Mystery Box.');
    }
}
