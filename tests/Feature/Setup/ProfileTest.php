<?php

namespace Tests\Feature\Setup;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Mail;
use App\User;

class ProfileTest extends TestCase
{
    use RefreshDatabase;

    private function before() {
        \Artisan::call('passport:install');
    }
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testSignUpValidatesCorrectly()
    {
        $response = $this->json('POST', '/api/auth/signup', []);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.first_name', ['The first name field is required.']); 
        $response->assertJsonPath('errors.last_name', ['The last name field is required.']); 
        $response->assertJsonPath('errors.email', ['The email field is required.']);
        $response->assertJsonPath('errors.password', ['The password field is required.']); 
    }

    public function testSignUpValidatesConfirmPassword()
    {   
        $response = $this->json('POST', '/api/auth/signup', [
            'first_name' => 'Jeff',
            'last_name' => 'McBob',
            'email' => 'jeff@mcbob.com',
            'phone' => '01234 567890',
            'avatar' => '/img/jeff.png',
            'password' => 'yeah123',
            'password_confirmation' => 'yeah456'
        ]);

        $response->assertStatus(422);
        $response->assertJsonPath('errors.password', ['The password confirmation does not match.']);
    }

    public function testSignUpCreatesUser()
    {
        $this->before();

        // Fake any disk here
        Storage::fake('public');
        $file = UploadedFile::fake()->create('avatar.png');

        $response = $this->json('POST', '/api/auth/signup', [
            'first_name' => 'Jeff',
            'last_name' => 'McBob',
            'email' => 'jeff@mcbob.com',
            'phone' => '01234 567890',
            'avatar' => $file,
            'password' => 'yeah123',
            'password_confirmation' => 'yeah123'
        ]);

        $response->assertStatus(201);

        Storage::disk('public')->assertExists('users/jeff@mcbob.com/avatar.png');

        $user = User::where('email', 'jeff@mcbob.com')->first();

        $this->assertTrue($user->first_name === 'Jeff');
        $this->assertTrue($user->last_name === 'McBob');
        $this->assertStringContainsString('avatar.png', $user->avatar);
        $this->assertTrue($user->phone === '01234 567890');
        $this->assertTrue($user->email_verified_at === null);
    }

    public function testSignUpCreatesUserWithOutOptionalFeilds()
    {
        $this->before();

        $response = $this->json('POST', '/api/auth/signup', [
            'first_name' => 'Jeff',
            'last_name' => 'McBob',
            'email' => 'jeff@mcbob.com',
            'password' => 'yeah123',
            'password_confirmation' => 'yeah123'
        ]);

        $response->assertStatus(201);

        $user = User::where('email', 'jeff@mcbob.com')->first();

        $this->assertTrue($user->first_name === 'Jeff');
        $this->assertTrue($user->last_name === 'McBob');
        $this->assertStringContainsString('placeholders/user.png', $user->avatar);
    }

    // public function testSignUpSendsEmailAndVerificationLinkWorks()
    // {
    //     $this->before();
        
    //     Mail::fake();

    //     $response = $this->json('POST', '/api/auth/signup', [
    //         'first_name' => 'Jeff',
    //         'last_name' => 'McBob',
    //         'email' => 'jeff@mcbob.com',
    //         'password' => 'yeah123',
    //         'password_confirmation' => 'yeah123'
    //     ]);

    //     Mail::assertSent(UserSignedUp::class, function($mail) use($self, $verification_link) {

    //         $mail->build(); // to set the email properties            

    //         // assert verifications link exists...
    //         $self->assertEquals($verification_link, $mail->viewData["verification_link"]);

    //         // click link
    //         $self->visit($mail->viewData["verification_link"]);

    //         // get user
    //         $user = User::where('email', 'jeff@mcbob.com');

    //         // assert the user is verified
    //         $self->assertTrue($user->email_verified_at !== null);

    //     });
    // }
}
