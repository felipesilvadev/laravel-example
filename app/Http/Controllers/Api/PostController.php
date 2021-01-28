<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\User;
use Illuminate\Http\Request;

class PostController extends Controller
{
    public function index(User $user_id)
    {
        $posts = $user_id->posts()->get();

        return response()->json(['user' => $user_id, 'posts' => $posts]);
    }

    public function show(Post $post)
    {
        $author = $post->author()->first();
        $categories = $post->categories()->get();

        return response()->json(['post' => $post, 'author' => $author, 'categories' => $categories]);
    }

    public function store(Request $request)
    {
        $post = Post::create($request->all());

        return response()->json($post, 201);
    }
}
