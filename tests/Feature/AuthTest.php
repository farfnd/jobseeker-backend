<?php

namespace Tests\Feature;

use App\Models\Candidate;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_successful_login_with_email()
    {
        $candidate = Candidate::factory()->create([
            'email' => 'john@test.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = ['login' => 'john@test.com', 'password' => 'password'];
        $response = $this->postJson('/api/login', $loginData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['token'],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Login successful',
            ]);
    }

    public function test_successful_login_with_phone()
    {
        $candidate = Candidate::factory()->create([
            'email' => 'john@test.com',
            'phone' => '+1 (234) 567 890',
            'password' => bcrypt('password'),
        ]);

        $loginData = ['login' => '+1 (234) 567 890', 'password' => 'password'];
        $response = $this->postJson('/api/login', $loginData);
        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'success',
                'message',
                'data' => ['token'],
            ])
            ->assertJson([
                'success' => true,
                'message' => 'Login successful',
            ]);
    }

    public function test_failed_login()
    {
        $candidate = Candidate::factory()->create([
            'email' => 'email@example.com',
            'password' => bcrypt('password'),
        ]);

        $loginData = ['login' => 'email@example.com', 'password' => bcrypt('password')];
        $response = $this->postJson('/api/login', $loginData);
        $response
            ->assertStatus(401)
            ->assertJsonStructure([
                'success',
                'message',
            ])
            ->assertJson([
                'success' => false,
                'message' => 'Wrong credentials or user does not exist',
            ]);
    }

    public function test_successful_logout()
    {
        $candidate = Candidate::factory()->create();
        $token = $candidate->createToken('testToken')->plainTextToken;

        $response = $this->withHeader('Authorization', 'Bearer ' . $token)->post('/api/logout');
        $response
            ->assertStatus(200)
            ->assertJsonFragment([
                'success' => true,
                'message' => 'Successfully logged out',
            ]);
    }

    public function test_unauthenticated_logout()
    {
        $response = $this->postJson('/api/logout');
        $response
            ->assertStatus(401)
            ->assertJsonFragment([
                'message' => 'Unauthenticated.',
            ]);
    }
}
