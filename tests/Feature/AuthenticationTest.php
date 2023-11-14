<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthenticationTest extends TestCase
{
    use RefreshDatabase;

    private $validRegisterBody = [
        'name' => 'John Doe',
        'email' => 'john@example.com',
        'password' => 'password',
        'password_confirmation' => 'password',
    ];

    private function createUser()
    {
        return User::factory()->create();
    }

    public function testUserCanRegisterWithCorrectCredentials()
    {
        $response = $this->postJson('/api/v1/auth/register', $this->validRegisterBody);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type',
            ]);

        $this->assertDatabaseHas('users', [
            'name'  => 'John Doe',
            'email' => 'john@example.com',
        ]);
    }

    public function testUserCannotRegisterWithNotMatchPassword()
    {
        $response = $this->postJson('/api/v1/auth/register', array_replace(
            $this->validRegisterBody,
            ['password_confirmation' => 'different_password']
        ));

        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors',
        ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function testUserCannotRegisterWithInvalidEmail()
    {
        $response = $this->postJson('/api/v1/auth/register',  array_replace(
            $this->validRegisterBody,
            ['email' => 'johnexample.com'],
        ));

        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors',
        ]);

        $this->assertDatabaseCount('users', 0);
    }

    public function testUserCannotRegisterWithRegisteredEmail()
    {
        $this->postJson('/api/v1/auth/register', $this->validRegisterBody);

        $response = $this->postJson('/api/v1/auth/register', $this->validRegisterBody);

        $response->assertStatus(422)
        ->assertJsonStructure([
            'message',
            'errors',
        ]);

        $this->assertDatabaseCount('users', 1);
    }

    public function testUserCanLoginWithCorrectCredentials()
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'password',
        ]);

        $response->assertStatus(201)
            ->assertJsonStructure([
                'access_token',
                'token_type',
            ]);
    }

    public function testUserCannotLoginWithIncorrectCredentials()
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => 'wrong_password',
        ]);

        $response->assertStatus(422);
    }

    public function testUserCannotLoginWithEmptyPassword()
    {
        $user = $this->createUser();

        $response = $this->postJson('/api/v1/auth/login', [
            'email'    => $user->email,
            'password' => '',
        ]);

        $response->assertStatus(422);
    }
}
