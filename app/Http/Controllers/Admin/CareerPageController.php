<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Inquiry;
use App\Models\Page;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\View\View;

class CareerPageController extends Controller
{
    public function __construct(protected ImageStorageService $images) {}

    public function edit(): View
    {
        $page = Page::where('slug', 'tuyen-dung')->firstOrFail();
        $content = json_decode($page->content, true, flags: JSON_THROW_ON_ERROR);
        $content['coverLines'] = array_values(array_filter(
            $content['coverLines'] ?? [],
            fn (array $line) => ($line['k'] ?? '') !== 'CHUYÊN ĐỀ'
        ));

        return view('admin.career.edit', compact('page', 'content'));
    }

    public function update(Request $request)
    {
        $page = Page::where('slug', 'tuyen-dung')->firstOrFail();
        $validated = $request->validate([
            'content' => 'required|array',
            'content.masthead' => 'required|string|max:100',
            'content.issue' => 'required|string|max:255',
            'content.issueNo' => 'required|string|max:50',
            'content.coverImg' => 'required|string|max:1000',
            'content.coverLines' => 'required|array|size:2',
            'content.coverLines.*.k' => 'required|string|max:100',
            'content.coverLines.*.v' => 'required|string|max:255',
            'content.tocKicker' => 'required|string|max:100',
            'content.title' => 'required|string|max:255',
            'content.lead' => 'required|string|max:1000',
            'content.letter' => 'required|string|max:5000',
            'content.signature' => 'required|string|max:255',
            'content.jobLayout' => 'required|in:accordion,article',
            'content.accKicker' => 'nullable|string|max:100',
            'content.accTitle' => 'nullable|string|max:255',
            'content.listLimit' => 'nullable|integer|min:1|max:20',
            'content.letterFold' => 'nullable|integer|min:80|max:600',
            'content.foldHeight' => 'nullable|integer|min:80|max:600',
            'content.subLead' => 'required|string|max:1000',
            'content.email' => 'required|email|max:255',
            'content.zalo' => 'required|string|max:30',
            'content.fanpage' => 'required|url|max:1000',
            'content.website' => 'required|url|max:1000',
            'content.jobs' => 'required|array|size:4',
            'content.jobs.*.kicker' => 'required|string|max:100',
            'content.jobs.*.title' => 'required|string|max:255',
            'content.jobs.*.standfirst' => 'required|string|max:500',
            'content.jobs.*.quote' => 'nullable|string|max:1000',
            'content.jobs.*.img' => 'required|string|max:1000',
            'content.jobs.*.imgAlt' => 'nullable|string|max:255',
            'content.jobs.*.count' => 'required|integer|min:0|max:99',
            'content.jobs.*.status' => 'required|in:open,soon,closed',
            'content.jobs.*.type' => 'required|string|max:255',
            'content.jobs.*.desc' => 'required|string|max:5000',
            'content.jobs.*.req' => 'required|string|max:5000',
            'content.jobs.*.perks' => 'required|string|max:5000',
            'content.steps' => 'required|array|size:4',
            'content.steps.*.code' => 'required|string|max:100',
            'content.steps.*.title' => 'required|string|max:255',
            'content.steps.*.text' => 'required|string|max:1000',
            'cover_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'job_images' => 'nullable|array|max:4',
            'job_images.*' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:4096',
            'is_active' => 'nullable|boolean',
        ]);

        $content = $validated['content'];
        if ($request->hasFile('cover_image')) {
            $content['coverImg'] = '/'.$this->images->upload($request->file('cover_image'), 'images/pages/careers', ltrim($content['coverImg'], '/'), 'career-cover');
        }
        foreach ($request->file('job_images', []) as $index => $image) {
            if (! isset($content['jobs'][$index])) {
                continue;
            }
            $content['jobs'][$index]['img'] = '/'.$this->images->upload($image, 'images/pages/careers', ltrim($content['jobs'][$index]['img'], '/'), 'career-job');
        }

        $page->update([
            'content' => json_encode($content, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            'is_active' => $request->boolean('is_active'),
        ]);

        $message = 'Đã cập nhật trang tuyển dụng.';

        return $request->expectsJson()
            ? response()->json(['success' => true, 'message' => $message])
            : back()->with('success', $message);
    }

    public function applications(Request $request): View
    {
        $query = Inquiry::where('type', 'career_application');
        if ($status = $request->input('status')) {
            $query->where('status', $status);
        }

        return view('admin.career.applications', [
            'applications' => $query->latest()->paginate(30),
        ]);
    }
}
