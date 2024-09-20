<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use App\Models\Posts;
use App\Models\Comment;
use App\Models\LikePost;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\ValidationException;

class PostController extends Controller
{
    public function index()
    {
        $post = Posts::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'posts' => $post,
        ], 200);
    }

    public function store(PostRequest $request)
    {
        $validatedData = $request->validated();

        if ($request->hasFile('gambar'))
        {
            $imagePath = $request->file('gambar')->store('post_images', 'public');
            $validatedData['gambar'] = $imagePath;
        } else {
            $validatedData['gambar'] = null;
        }

        $post = auth()->user()->posts()->create($validatedData);

        return response([
            'status' => 'success',
            'message' => 'Post created successfully',
            'post' => $post
        ], 201);
    }

    public function likePost($post_id)
    {
        $post = Posts::find($post_id);

        if (!$post)
        {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        $existingLike = LikePost::where('user_id', auth()->id())
                                -> where('post_id', $post_id)
                                ->first();

        if ($existingLike) {
            $existingLike->delete();
            return response()->json([
                'message' => 'Post unliked successfully',
                'liked' => false,
            ], 200);
        } else {
            LikePost::create([
                'user_id' => auth()->id(),
                'post_id' => $post_id,
            ]);
            return response()->json([
                'message' => 'Post liked successfully',
                'liked' => true,
            ], 200);
        }
    }

    public function comment(Request $request, $post_id)
    {
        try {
            $validatedData = $request->validate([
                'body' => 'required|string',
                'gambar' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);
        } catch (ValidationException $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Validation failed',
                'error' => $e->errors(),
            ], 422);
        }

        $post = Posts::find($post_id);
        if (!$post) {
            return response()->json([
                'status' => 'error',
                'message' => 'Post not found',
            ], 404);
        }

        if ($request->hasFile('gambar'))
        {
            $imagePath = $request->file('gambar')->store('post_images', 'public');
            $validatedData['gambar'] = $imagePath;
        } else {
            $validatedData['gambar'] = null;
        }

        $comment = Comment::create([
            'user_id' => auth()->id(),
            'post_id' => $post_id,
            'body' => $validatedData['body'] ?? null,
            'gambar' => $validatedData['gambar'],
        ]);

        return response([
            'status' => 'success',
            'message' => 'Comment created successfully',
            'comment' => $comment
        ], 201);
    }

    public function getComments($post_id)
    {
        try {
            $comments = Comment::with('post')->with('user')->wherePostId($post_id)->latest()->get();

            if ($comments->isEmpty()) {
                return response()->json([
                    'message' => 'No comments found for this post',
                ], 404);
            }

            return response()->json([
                'commments' => $comments
            ], 200);

        } catch (Exception $e) {
            Log::error('Error retrieving comments: ' . $e->getComments());

            return response()->json([
                'error' => 'Error retrieving comments',
                'message' => 'An error occurred while fetching comments',
            ], 500);
        }
    }
}
