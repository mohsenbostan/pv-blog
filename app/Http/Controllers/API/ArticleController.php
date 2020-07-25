<?php

namespace App\Http\Controllers\API;

use App\Article;
use App\Http\Controllers\Controller;
use App\Repositories\ArticleRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Symfony\Component\HttpFoundation\Response;

class ArticleController extends Controller
{
    public function index()
    {
        $articles = resolve(ArticleRepository::class)->all();

        return response()->json($articles, Response::HTTP_OK);
    }

    public function show($slug)
    {
        $article = resolve(ArticleRepository::class)->show($slug);

        return \response()->json($article, Response::HTTP_OK);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|unique:articles',
            'description' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);

        $article = resolve(ArticleRepository::class)->create($request->only(['title', 'description', 'content', 'category']));

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->storePublicly('public/thumbnails');
            $article->thumbnail = Storage::url($thumbnail);
            $article->save();
        }

        return \response()->json([
            'message' => 'article created successfully'
        ], Response::HTTP_CREATED);
    }

    public function update(Request $request)
    {
        $request->validate([
            'id' => 'required',
            'title' => 'required',
            'description' => 'required',
            'content' => 'required',
            'category' => 'required',
        ]);

        $article = resolve(ArticleRepository::class)->update($request->only(['id', 'title', 'description', 'content', 'category']));

        if ($request->hasFile('thumbnail')) {
            $thumbnail = $request->file('thumbnail')->storePublicly('public/thumbnails');
            $article->thumbnail = Storage::url($thumbnail);
            $article->save();
        }

        return \response()->json([
            'message' => 'article updated successfully'
        ], Response::HTTP_OK);
    }

    public function destroy($ids)
    {
        resolve(ArticleRepository::class)->delete($ids);

        return \response()->json([
            'message' => 'article(s) deleted successfully'
        ], Response::HTTP_OK);
    }

    public function saveComment(Request $request, $id)
    {
        $request->validate([
            'content' => 'required',
        ]);

        resolve(ArticleRepository::class)->saveComment($id, $request);

        return \response()->json([
            'message' => 'comment added successfully!'
        ], Response::HTTP_CREATED);
    }

    public function updateComment(Request $request, $id)
    {
        $data = $request->validate([
            'content' => 'required',
        ]);

        resolve(ArticleRepository::class)->updateComment($id, $data);

        return \response()->json([
            'message' => 'comment updated successfully!'
        ], Response::HTTP_OK);
    }

    public function deleteComment($id)
    {

        resolve(ArticleRepository::class)->deleteComment($id);

        return \response()->json([
            'message' => 'comment deleted successfully!'
        ], Response::HTTP_OK);
    }

}
