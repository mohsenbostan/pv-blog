<?php

namespace Tests\Unit\API;

use App\Article;
use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class ArticleTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function articles_list_should_be_accessible()
    {
        $response = $this->get(route('article.all'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function single_article_should_be_accessible()
    {
        $article = factory(Article::class)->create();
        $response = $this->get(route('article.show', [$article->slug]));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function create_article_should_be_validated()
    {
        Sanctum::actingAs(factory(User::class)->create());

        $response = $this->postJson(route('article.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function user_can_create_new_article()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $category = factory(Category::class)->create();

        $response = $this->postJson(route('article.store'), [
            'title' => 'Test Title',
            'description' => 'Test Description',
            'content' => 'Test Content',
            'category' => $category->id,
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function update_article_should_be_validated()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $response = $this->json('PUT', route('article.update'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function user_can_update_an_article()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $article = factory(Article::class)->create([
            'title' => 'My Title'
        ]);
        $response = $this->json('PUT', route('article.update'), [
            'id' => $article->id,
            'title' => 'New Title',
            'description' => $article->description,
            'content' => $article->content,
            'category' => $article->category->id,
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function user_can_delete_article()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $article = factory(Article::class)->create();
        $response = $this->json('DELETE', route('article.delete', [$article->id]));
        $response->assertStatus(Response::HTTP_OK);
    }

    /** @test */
    function logged_in_user_can_add_comment_to_article()
    {
        $user = factory(User::class)->create();
        $article = factory(Article::class)->create();

        $response = $this->actingAs($user)->postJson(route('article.saveComment', [$article->id]), [
            'content' => 'My Content',
        ]);

        $comment = $article->comments[0];

        $this->assertSame('My Content', $comment->content);
        $response->assertStatus(Response::HTTP_CREATED);
    }
}
