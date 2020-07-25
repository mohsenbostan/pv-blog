<?php


namespace App\Repositories;


use App\Article;
use App\Comment;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ArticleRepository
{

    /**
     * @return LengthAwarePaginator
     */
    public function all()
    {
        return Article::cacheFor(now()->addMinutes(10))->with(['category', 'comments'])->orderByDesc('created_at')->paginate(8);
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        return Article::with('category')->where('slug', $slug)->first();
    }

    /**
     * @param $article_data
     * @return Article
     */
    public function create($article_data)
    {
        return Article::create([
            'title' => Str::title($article_data['title']),
            'slug' => Str::slug($article_data['title']),
            'description' => $article_data['description'],
            'content' => $article_data['content'],
            'category_id' => $article_data['category'],
        ]);
    }

    /**
     * @param $article_data
     * @return Article
     */
    public function update($article_data)
    {
        return Article::find($article_data['id'])->update([
            'title' => Str::title($article_data['title']),
            'slug' => Str::slug($article_data['title']),
            'description' => $article_data['description'],
            'content' => $article_data['content'],
            'category_id' => $article_data['category'],
        ]);
    }

    /**
     * @param $ids
     */
    public function delete($ids): void
    {
        Article::destroy($ids);
    }

    /**
     * @param $id
     * @param Request $request
     */
    public function saveComment($id, Request $request): void
    {
        Article::query()->find($id)->comments()->create([
            'content' => $request->input('content'),
            'user_id' => auth()->user()->id,
        ]);
    }

    /**
     * @param $id
     * @param $data
     */
    public function updateComment($id, $data): void
    {
        Comment::query()->find($id)->update([
            'content' => $data['content'],
        ]);
    }

    /**
     * @param $id
     */
    public function deleteComment($id): void
    {
        Comment::query()->find($id)->delete();
    }
}
