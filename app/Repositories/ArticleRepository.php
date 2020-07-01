<?php


namespace App\Repositories;


use App\Article;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Str;

class ArticleRepository
{

    /**
     * @return Builder[]|Collection
     */
    public function all()
    {
        return Article::with('category')->orderByDesc('created_at')->get();
    }

    /**
     * @param $slug
     * @return mixed
     */
    public function show($slug)
    {
        return Article::where('slug', $slug)->first();
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
}
