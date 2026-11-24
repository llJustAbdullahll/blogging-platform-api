<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCategoryReqeust;
use App\Http\Requests\UpdateCategoryReqeust;
use App\Http\Resources\CategoryResource;
use App\Models\Category;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class CategoryController extends Controller
{
    // Display a listing of the resource.
    public function index(): AnonymousResourceCollection
    {
        $categories = Category::all();

        return CategoryResource::collection($categories);
    }

    // Store a newly created resource in storage.
    public function store(StoreCategoryReqeust $request): CategoryResource
    {

        $category = Category::create($request->validated());

        return new CategoryResource($category);
    }

    // Display the specified resource.
    public function show($id): CategoryResource
    {
        $category = Category::findOrFail($id);

        return new CategoryResource($category);
    }

    // Update the specified resource in storage.
    public function update(UpdateCategoryReqeust $request, $id): CategoryResource
    {
        $category = Category::findOrFail($id);

        $category->update($request->validated());

        return new CategoryResource($category);
    }

    // Remove the specified resource from storage.
    public function destroy($id): JsonResponse
    {
        $category = Category::findOrFail($id);

        $category->delete();

        return response()->json(null, 204);
    }
}
