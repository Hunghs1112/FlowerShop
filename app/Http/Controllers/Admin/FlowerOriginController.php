<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\FlowerOrigin;
use App\Services\ImageStorageService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class FlowerOriginController extends Controller
{
    public function __construct(private ImageStorageService $images) {}

    public function index(Request $request)
    {
        $query = FlowerOrigin::query()->orderBy('sort_order');
        if ($request->filled('search')) {
            $search = $request->string('search');
            $query->where(fn ($q) => $q->where('country', 'like', "%{$search}%")
                ->orWhere('flower', 'like', "%{$search}%"));
        }

        return view('admin.flower-origins.index', ['items' => $query->paginate(20)]);
    }

    public function create()
    {
        return view('admin.flower-origins.create');
    }

    public function store(Request $request)
    {
        $data = $this->validated($request);
        $data['slug'] = $data['slug'] ?: Str::slug($data['country'] . '-' . $data['flower']);
        $data['is_active'] = $request->boolean('is_active', true);
        $data['image'] = $this->images->upload($request->file('image'), 'flower-origins');
        FlowerOrigin::create($data);

        return redirect()->route('admin.flower-origins.index')->with('success', 'Đã thêm điểm hoa.');
    }

    public function edit(FlowerOrigin $flowerOrigin)
    {
        return view('admin.flower-origins.edit', ['item' => $flowerOrigin]);
    }

    public function update(Request $request, FlowerOrigin $flowerOrigin)
    {
        $data = $this->validated($request, false);
        $data['slug'] = $data['slug'] ?: Str::slug($data['country'] . '-' . $data['flower']);
        $data['is_active'] = $request->boolean('is_active');
        $oldImage = $flowerOrigin->image;

        if ($request->hasFile('image')) {
            $data['image'] = $this->images->upload($request->file('image'), 'flower-origins', $oldImage);
        }

        $flowerOrigin->update($data);
        return redirect()->route('admin.flower-origins.index')->with('success', 'Đã cập nhật điểm hoa.');
    }

    public function destroy(FlowerOrigin $flowerOrigin)
    {
        $image = $flowerOrigin->image;
        $flowerOrigin->delete();
        if (!str_starts_with($image, 'images/')) {
            $this->images->delete($image);
        }

        return redirect()->route('admin.flower-origins.index')->with('success', 'Đã xóa điểm hoa.');
    }

    private function validated(Request $request, bool $imageRequired = true): array
    {
        return $request->validate([
            'slug' => 'nullable|string|max:100',
            'map_x' => 'required|integer|min:0|max:1000',
            'map_y' => 'required|integer|min:0|max:520',
            'country' => 'required|string|max:100',
            'flower' => 'required|string|max:150',
            'latin' => 'required|string|max:150',
            'region' => 'required|string|max:150',
            'coordinate' => 'required|string|max:100',
            'sort_order' => 'nullable|integer|min:0',
            'is_active' => 'nullable|boolean',
            'image' => ($imageRequired ? 'required|' : 'nullable|') . 'image|mimes:jpeg,png,jpg,gif,webp|max:4096',
        ]);
    }
}
