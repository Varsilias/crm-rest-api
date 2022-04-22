<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Http\Response;
use App\Http\Resources\PostResource;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Http\Resources\PostCollection;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        // return new PostCollection((Post::with('category')->paginate(10)));
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "status" => Response::$statusTexts[Response::HTTP_OK], 
            "data" => (new PostCollection((Post::with('category')->paginate(10))))
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StorePostRequest $request)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_CREATED, 
            "message" => Response::$statusTexts[Response::HTTP_CREATED], 
            "data" => new PostResource(Post::create($request->validated()))
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "message" => Response::$statusTexts[Response::HTTP_OK], 
            "data" => new PostResource(Post::findOrFail($post->id))
        ]);
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK,
            "message"  => "Post updated Successfully",
            "data" => $post->update($request->validated()) ? new PostResource($post) : "Resource could not be updated"
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK,
            "message"  => "Post deleted Successfully",
            "data" => $post->delete() ? null : "Resource could not be deleted"
        ]);
    }
}
