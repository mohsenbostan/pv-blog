<?php

/** @var \Illuminate\Database\Eloquent\Factory $factory */

use App\Article;
use Faker\Generator as Faker;

$factory->define(Article::class, function (Faker $faker) {
    return [
        'title' => \Illuminate\Support\Str::title($faker->sentence),
        'slug' => \Illuminate\Support\Str::slug($faker->sentence),
        'description' => $faker->text,
        'content' => $faker->realText(180),
        'thumbnail' => 'https://www.iworkglobal.com/wp-content/themes/iWorkGlobal_theme/images/image-default-news.jpg',
        'category_id' => factory(\App\Category::class)->create()->id
    ];
});
