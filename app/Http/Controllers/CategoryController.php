<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

/**
 * @group Categories
 *
 * Manage income/expense categories like "Food", "Salary", etc.
 */
class CategoryController extends Controller
{
    /**
     * Display a listing of the categories.
     * @response 200 {
     *   "message": "Category list",
     *   "data": [
     *     { "id": 1, "name": "Food", "type": "expense", "icon": "🍔" }
     *   ]
     * }
     */
     
    public function index()
    {
        return response()->json([
            'message' => 'Category list',
            'data' => Category::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     * 
     * @bodyParam name string required The name of the category.
     * @bodyParam type string required Either "income" or "expense".
     * @bodyParam icon string optional An emoji or CSS icon.
     * @response 201 {
     *   "message": "Category created",
     *   "data": {
     *     "id": 2,
     *     "name": "Salary",
     *     "type": "income",
     *   }
     * }
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string',
            'type' => 'required|in:income,expense',
            'icon' => 'nullable|string'
        ]);

        $category = Category::create($validated);

        return response()->json([
            'message' => 'Category created',
            'data' => $category
        ], 201);
    }

    /**
     * Display the specified category.
     * @urlParam id integer required The ID of the category.
     * @response 200 {
     *   "message": "Category details",
     *   "data": {
     *     "id": 1,
     *     "name": "Food",
     *     "type": "expense",
     *   }
     * }
     */
    public function show(Category $category)
    {
        return response()->json([
            'message' => 'Category details',
            'data' => $category
        ]);
    }

    /**
     * Update the specified category in storage.
     * @urlParam id integer required The ID of the category.
     * @bodyParam name string optional The category name.
     * @bodyParam type string optional Either "income" or "expense".
     * @bodyParam icon string optional An icon.
     * @response 200 {
     *   "message": "Category updated",
     *   "data": {
     *     "id": 1,
     *     "name": "Food",
     *     "type": "expense",
     *   }
     * }
     */
    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'name' => 'sometimes|string',
            'type' => 'sometimes|in:income,expense',
            'icon' => 'nullable|string'
        ]);

        $category->update($validated);

        return response()->json([
            'message' => 'Category updated',
            'data' => $category->fresh()
        ]);
    }

    /**
     * Remove the specified category from storage.
     * @urlParam id integer required The ID of the category.
     * @response 200 {
     *   "message": "Category deleted",
     *   "data": {
     *     "id": 1,
     *     "name": "Food",
     *     "type": "expense",
     *   }
     * }
     */
    public function destroy(Category $category)
    {
        $category->delete();

        return response()->json([
            'message' => 'Category deleted',
            'data' => $category
        ]);
    }
}
