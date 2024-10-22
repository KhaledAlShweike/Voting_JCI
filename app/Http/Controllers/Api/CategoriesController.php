<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Categories;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class CategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $limit = $request->query('limit', null);
        $query = Categories::latest();

        if ($limit && is_numeric($limit)) {
            $query->limit($limit);
        }

        $categories = $query->get();

        if ($categories->isEmpty()) {
            return response()->json(['message' => 'No categories found'], 404);
        }

        return response()->json($categories);
    }



    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }


        $category = Categories::create([
            'name' => $request->name,
        ]);

        return response()->json(['message' => 'Category created successfully!', 'category' => $category], 201);
    }



    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,  $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
        ]);
        if ($validator->fails()) {
            return response()->json(['message' => 'Validation failed', 'errors' => $validator->errors()], 422);
        }
        $categories = Categories::find($id);
        Log::info('1');
        Log::info('2');

        $categories->update([
            'name' => $request->name
        ]);
        Log::info('3');

        return response()->json(['message' => 'Category updated succekhjgjhssfully!', 'category' => $categories]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        $category = Categories::find($id);

        if (!$category) {
            return response()->json(['message' => 'category not found'], 404);
        }
        $category->delete();


        return response()->json(['message' => 'Category deleted successfully!']);
    }
}
