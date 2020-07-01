<?php


namespace App\Repositories;


use App\Category;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;

class CategoryRepository
{

    /**
     * @return Builder[]|Collection
     */
    public function all()
    {
        return Category::with('articles')->orderByDesc('created_at')->get();
    }

    /**
     * @param $name
     */
    public function create($name): void
    {
        Category::create([
            'name' => $name
        ]);
    }

    /**
     * @param $id
     * @param $name
     */
    public function update($id, $name): void
    {
        Category::find($id)->update([
            'name' => $name
        ]);
    }

    /**
     * @param $ids
     */
    public function delete($ids): void
    {
        Category::destroy($ids);
    }
}
