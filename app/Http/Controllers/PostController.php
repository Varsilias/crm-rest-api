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
     * @return \Illuminate\Http\JsonResponse.
     */
    public function index()
    {
        // return new PostCollection((Post::with('category')->paginate(10)));
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "status" => Response::$statusTexts[Response::HTTP_OK], 
            "data" => (new PostCollection((Post::where('user_id', auth()->user()->id)->with('category')->paginate(10))))
        ]);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StorePostRequest  $request
     * @return \Illuminate\Http\JsonResponse.
     */
    public function store(StorePostRequest $request)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_CREATED, 
            "message" => Response::$statusTexts[Response::HTTP_CREATED], 
            "data" => new PostResource(Post::create(array_merge($request->validated(), ['user_id' =>  auth()->user()->id])))
        ], Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse.
     */
    public function show(Post $post)
    {
        $post = Post::where("id", $post->id)->where("user_id", auth()->user()->id)->first();

        if (!$post) {
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_NOT_FOUND, 
                "status" => Response::$statusTexts[Response::HTTP_NOT_FOUND],
                'message' => 'No Post with this ID',
            ], Response::HTTP_NOT_FOUND);
        }
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "message" => Response::$statusTexts[Response::HTTP_OK], 
            "data" => new PostResource($post)
        ]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdatePostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\JsonResponse.
     */
    public function update(UpdatePostRequest $request, Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_FORBIDDEN, 
                "status" => Response::$statusTexts[Response::HTTP_FORBIDDEN],
                'message' => 'Cannot modify this resource',
            ], Response::HTTP_FORBIDDEN);
        }
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
     * @return \Illuminate\Http\JsonResponse.
     */
    public function destroy(Post $post)
    {
        if ($post->user_id !== auth()->user()->id) {
            return response()->json([
                "error" => true,
                "code" => Response::HTTP_FORBIDDEN, 
                "status" => Response::$statusTexts[Response::HTTP_FORBIDDEN],
                'message' => 'Cannot modify this resource',
            ], Response::HTTP_FORBIDDEN);
        }
        
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK,
            "message"  => "Post deleted Successfully",
            "data" => $post->delete() ? null : "Resource could not be deleted"
        ]);
    }
}
