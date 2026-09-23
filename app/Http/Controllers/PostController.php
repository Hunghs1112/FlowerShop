<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->input('search');

        $posts = Post::published()
            ->when($search, function ($query, $search) {
                $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', '%' . $search . '%')
                      ->orWhere('excerpt', 'like', '%' . $search . '%');
                });
            })
            ->latest('published_at')
            ->paginate(9);

        $bannerKey = 'blog';

        return view('blog.index', compact('posts', 'search', 'bannerKey'));
    }

    public function show(string $slug)
    {
        $post = Post::where('slug', $slug)
            ->published()
            ->firstOrFail();

        $relatedPosts = Post::published()
            ->where('id', '!=', $post->id)
            ->latest('published_at')
            ->limit(3)
            ->get();

        $bannerKey = 'blog';

        return view('blog.show', compact('post', 'relatedPosts', 'bannerKey'));
    }
}
