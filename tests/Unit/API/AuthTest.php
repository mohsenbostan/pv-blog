<?php

namespace Tests\Unit\API;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Laravel\Sanctum\Sanctum;
use Symfony\Component\HttpFoundation\Response;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_register_should_be_validated()
    {
        $response = $this->json('POST', route('auth.register'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_register_should_create_user()
    {
        $user = [
            'name' => 'Ali',
            'email' => 'ali@gmail.com',
            'password' => 'password',
        ];
        $response = $this->json('POST', route('auth.register'), $user);

        $response->assertStatus(Response::HTTP_CREATED);
    }

    public function test_login_should_be_validated()
    {
        $response = $this->json('POST', route('auth.login'), []);

        $response->assertStatus(Response::HTTP_UNPROCESSABLE_ENTITY);
    }

    public function test_user_can_login()
    {
        $user = factory(User::class)->create();
        $response = $this->json('POST', route('auth.login'), [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_logged_in_user_can_logout()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $response = $this->json('POST', route('auth.logout'), []);

        $response->assertStatus(Response::HTTP_OK);
    }

    public function test_logged_in_user_can_see_details()
    {
        Sanctum::actingAs(factory(User::class)->create());
        $user = factory(User::class)->create();
        $response = $this->actingAs($user)->get(route('auth.user'));

        $data = json_decode($response->getContent(), true);

        $response->assertStatus(Response::HTTP_OK);
        $this->assertEquals($user->email, $data['email']);
    }
}
