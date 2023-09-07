<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Fluent\AssertableJson;
use Tests\TestCase;
use App\Models\User;

class ApiTest extends TestCase
{

    public function testRegister()
    {
        $response = $this->postJson('/api/register', [
            'name'  =>  $name = 'Test',
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
            'confirm_password'  =>  $confirm_password = '123456789',
            'country'  =>  $country = 'España',
        ]);
        \Log::info('Test: /api/register', [$response->getContent()]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.name', 'Test')
            ->assertJsonPath('data.token', fn (string $token) => strlen($token) >= 10)
            ->assertJson([
                'message' => 'User created successfully',
            ]);
    }

    public function testLogin()
    {
        $response = $this->postJson('/api/login', [
            'email'  =>  $email = time().'test@example.com',
            'password'  =>  $password = '123456789',
        ]);
        \Log::info('Test: /api/login', [$response->getContent()]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.name', 'Test')
            ->assertJsonPath('data.token', fn (string $token) => strlen($token) >= 10)
            ->assertJson([
                'message' => 'User signed in',
            ]);;
    }

    public function testApiAlbum()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/api/album/302127');
        \Log::info('Test: /api/album/302127', [$response->getContent()]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', fn (int $id) => $id > 0)
            ->assertJson([
                'data' => true,
                'success' => true,
                'message' => 'Albums by id - An album object',
            ]);
    }

    public function testApiArtist()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/api/artist/27');

        \Log::info('Test: /api/artist/27', [$response->getContent()]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.id', fn (int $id) => $id > 0)
            ->assertJson([
                'data' => true,
                'success' => true,
                'message' => 'Artist by id - An artist object',
            ]);
    }

    public function testApiSearch()
    {
        $user = User::factory()->create();
        $response = $this->actingAs($user)
                         ->withSession(['banned' => false])
                         ->get('/api/search?q=eminem');

        \Log::info('Test: /api/search?q=eminem', [$response->getContent()]);
        $response
            ->assertStatus(200)
            ->assertJsonPath('data.data.0.id', fn (int $id) => $id > 0)
            ->assertJson([
                'data' => true,
                'success' => true,
                'message' => 'Search tracks',
            ]);
    }

}
