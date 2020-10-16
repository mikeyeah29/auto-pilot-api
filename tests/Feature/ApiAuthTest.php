<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\User;

class ApiAuthTest extends TestCase
{
    use RefreshDatabase;

    private function before($verified = false) {
        \Artisan::call('passport:install');
        $user = new User([
            'first_name' => 'Bob',
            'last_name' => 'Bobby',
            'email' => 'bob@bobby.com',
            'password' => bcrypt('abc123')
        ]);

        if($verified) {
            $user->email_verified_at = date("Y-m-d H:i:s");;
        }
        $user->save();
    }

    public function testLoginIncorrectCredentials()
    {
        $this->before(true);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => 'yeah@hmm.com',
            'password' => 'hmmm',
            'remember_me' => false
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Unauthorized'
        ]);
    }

    public function testLoginNotVerified()
    {
        $this->before(false);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => 'bob@bobby.com',
            'password' => 'abc123',
            'remember_me' => false
        ]);

        $response->assertStatus(401);
        $response->assertJson([
            'message' => 'Email address not verified'
        ]);
    }

    public function testLoginVerified()
    {
        $this->before(true);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => 'bob@bobby.com',
            'password' => 'abc123',
            'remember_me' => false
        ]);

        $response->assertStatus(200);
        $response->assertJson([
            'message' => 'ok'
        ]);
    }

    public function testLoginReturnsAccessToken()
    {
        $this->before(true);

        $response = $this->json('POST', '/api/auth/login', [
            'email' => 'bob@bobby.com',
            'password' => 'abc123',
            'remember_me' => false
        ]);

        $response->assertJsonStructure([
            'access_token',
            'token_type',
            'expires_at'
        ]);
    }

    public function testGetLoggedInUser()
    {
        $this->before(true);

        $user = factory(User::class)->create();

        $response = $this->actingAs($user, 'api')
            ->json('GET', '/api/auth/user');

        $response->assertStatus(200);
    }

    public function testLogout()
    {
        $this->get('/api/auth/logout');
        $response = $this->json('GET', '/api/auth/user');
        $response->assertStatus(401);
    }
}
