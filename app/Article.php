<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Rennokki\QueryCache\Traits\QueryCacheable;

class Article extends Model
{
    use QueryCacheable;

    protected $guarded = [];

    /**
     * Set the base cache tags that will be present
     * on all queries.
     *
     * @return array
     */
    protected function getCacheBaseTags(): array
    {
        return [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
