<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;
use App\Http\Resources\CategoryResource;
use Illuminate\Http\Response;
use Symfony\Component\Console\Output\ConsoleOutput;
use Database\Factories\CategoryFactory;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "status" => Response::$statusTexts[Response::HTTP_OK], 
            "data" => CategoryResource::collection(Category::all())
        ]);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreCategoryRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreCategoryRequest $request)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_CREATED, 
            "message" => Response::$statusTexts[Response::HTTP_CREATED], 
            "data" => new CategoryResource(Category::create($request->validated()))
        ])->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK, 
            "message" => Response::$statusTexts[Response::HTTP_OK], 
            "data" => new CategoryResource(Category::findOrFail($category->id))
        ]);
    }

 

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateCategoryRequest  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK,
            "message"  => "Category updated Successfully",
            "data" => $category->update($request->validated()) ? new CategoryResource($category) : "Resource could not be updated"
        ]);


    
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        return response()->json([
            "error" => false,
            "code" => Response::HTTP_OK,
            "message"  => "Category deleted Successfully",
            "data" => $category->delete() ? null : "Resource could not be deleted"
        ]);
    }
}
