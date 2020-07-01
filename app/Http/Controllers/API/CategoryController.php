<?php

namespace App\Http\Controllers\API;

use App\Category;
use App\Http\Controllers\Controller;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = resolve(CategoryRepository::class)->all();
        return response()->json($categories, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        resolve(CategoryRepository::class)->create($request->name);

        return \response()->json([
            'message' => 'category created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories'
        ]);

        resolve(CategoryRepository::class)->update($request->id, $request->name);

        return \response()->json([
            'message' => 'category updated successfully'
        ], Response::HTTP_OK);
    }

    public function destroy($ids)
    {
        resolve(CategoryRepository::class)->delete($ids);

        return \response()->json([
            'message' => 'category(ies) deleted successfully'
        ], Response::HTTP_OK);
    }


}
