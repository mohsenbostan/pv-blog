<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::with('articles')->orderByDesc('created_at')->get();
        return response()->json($categories, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        Category::create([
            'name' => $request->name
        ]);

        return \response()->json([
            'message' => 'category created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        Category::find($request->id)->update([
            'name' => $request->name
        ]);

        return \response()->json([
            'message' => 'category updated successfully'
        ], Response::HTTP_OK);
    }
}
