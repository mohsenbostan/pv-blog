<?php

namespace Tests\Unit\API;

use App\Category;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class CategoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     */
    public function categories_list_should_be_accessible()
    {
        $response = $this->get(route('category.all'));

        $response->assertStatus(Response::HTTP_OK);
    }

    /**
     * @test
     */
    public function create_category_should_be_validated()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $response = $this->postJson(route('category.store'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function user_can_create_category()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $response = $this->postJson(route('category.store'), [
            'name' => 'Red'
        ]);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    /**
     * @test
     */
    public function update_category_should_be_validated()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $response = $this->postJson(route('category.update'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    /**
     * @test
     */
    public function user_can_update_category()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $category = factory(Category::class)->create([
            'name' => 'Blue'
        ]);
        
        $response = $this->json('PUT', route('category.update'), [
            'id' => $category->id,
            'name' => 'Red'
        ]);
        $updated_category = Category::find($category->id);
        $response->assertStatus(Response::HTTP_OK);
        $this->assertSame('Red', $updated_category->name);
    }

    /**
     * @test
     */
    public function user_can_delete_category()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $category = factory(Category::class)->create();
        $response = $this->json('DELETE', route('category.delete', [$category->id]));

        $response->assertStatus(Response::HTTP_OK);
    }
}
