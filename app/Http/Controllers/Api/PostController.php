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
    // Get All Post Forum
    public function index()
    {
        $post = Posts::with('user')->latest()->get();

        return response()->json([
            'status' => 'success',
            'posts' => $post,
        ], 200);
    }

    // Add Post Forum
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

    // Like Post Forum
    public function likePost($post_id)
    {
        // Find the Post
        $post = Posts::find($post_id);

        if (!$post)
        {
            return response()->json([
                'message' => 'Post not found',
            ], 404);
        }

        // Check if the user has already liked the post
        $existingLike = LikePost::where('user_id', auth()->id())
                                -> where('post_id', $post_id)
                                ->first();

        if ($existingLike) {
            // Unlike the Post
            $existingLike->delete();
            return response()->json([
                'message' => 'Post unliked successfully',
                'liked' => false,
            ], 200);
        } else {
            // Like the Post
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

    // Comment Post Forum
    public function comment(Request $request, $post_id)
    {
        // Validate the request data
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

        // Find the Post
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
        // try {
        //     $comments = Comment::with('post')->with('user')->wherePostId($post_id)->latest()->get();

        //         return response()->json([
        //             'comments' => $comments
        //         ], 200);

        // } catch (ValidationException $e) {
        //     return response()->json([
        //         'error' => 'Error retrieving comments',
        //         'message' => $e->getMessage()
        //     ], 500);
        // }

        try {
            $comments = Comment::with('post')->with('user')->wherePostId($post_id)->latest()->get();
            // $comments = Comment::with('post', 'user')->where('post_id', $post_id)->latest()->get();

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
