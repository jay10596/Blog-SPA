<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use Carbon\Carbon;
use Hash;


class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $server;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = factory(User::class)->create(['birthday' => '05/10/1996']);

        $this->token = JWTAuth::fromUser($this->user);

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];

    }

    private function signupData()
    {
        return [
            'name' => 'User',
            'birthday' => '05/10/1996',
            'email' => 'user@test.com',
            'password' => 'password'  
        ];
    }

    private function loginData()
    {
        return [
            'email' => $this->user->email,
            'password' => 'password'
        ];
    }

    /** @test */
    public function guest_can_signup()
    {
        $response = $this->post('/api/auth/signup', $this->signupData());

        $response->assertStatus(200);

        $this->assertCount(2, User::all());
    }

    /** @test */
    public function user_can_login()
    {
        $response = $this->post('/api/auth/login', $this->loginData());
        
        $response->assertStatus(200);

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function auth_user_can_update_profile()
    {
        $response = $this->put('/api/users/' . $this->user->id, $this->signupData(), $this->server);

        $response->assertStatus(202);

        $this->assertCount(1, User::all());


        $this->user = $this->user->fresh();

        $this->assertEquals('User', $this->user->name);
        $this->assertEquals('05/10/1996', $this->user->birthday->format('m/d/Y'));
        $this->assertEquals('user@test.com', $this->user->email);
        $this->assertTrue(Hash::check('password', $this->user->password));


        $response->assertJson([
            'data' => [
                'name' => $this->user->name,
                'birthday' => $this->user->birthday->format('m/d/Y'),
                'email' => $this->user->email
            ],
        ]);
    }

    /** @test */
    public function any_user_can_see_his_profile_and_questions()
    {
        $response = $this->get('/api/users/' . $this->user->id, $this->server);

        $response->assertStatus(200);
    }

    /** @test */
    public function field_is_required_signup_user()
    {
        collect(['name', 'birthday', 'email', 'password'])->each(function($field) {
            $response = $this->post('/api/auth/signup', array_merge($this->signupData(), [$field => '']));
            
            $response->assertSessionHasErrors($field);

            $this->assertCount(1, User::all());
        });
    }

    /** @test */
    public function field_is_required_edit_profile()
    {
        collect(['name', 'birthday', 'email', 'password'])->each(function($field) {
            $response = $this->put('/api/users/' . $this->user->id, array_merge($this->signupData(), [$field => '']), $this->server);
            
            $response->assertSessionHasErrors($field);

            $this->assertCount(1, User::all());
        });
    }

    /** @test */
    public function valid_email_field_is_required_signup_user()
    {
        $response = $this->post('/api/auth/signup', array_merge($this->signupData(), ['email' => '']));
            
        $response->assertSessionHasErrors('email');

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function valid_email_field_is_required_edit_profile()
    {
        $response = $this->put('/api/users/' . $this->user->id, array_merge($this->signupData(), ['email' => 'notanemail']), $this->server);
            
        $response->assertSessionHasErrors('email');

        $this->assertCount(1, User::all());
    }

    /** @test */
    public function valid_birthday_field_is_required()
    {
        $this->assertInstanceOf(Carbon::class, $this->user->birthday);

        $this->assertEquals('05.10.1996', $this->user->birthday->format('m.d.Y'));
    }

    /** @test */
    public function auth_user_can_delete_profile()
    {
        $response = $this->delete('/api/users/' . $this->user->id, [], $this->server);
        
        $response->assertStatus(204);
        
        $this->assertCount(0, User::all());
    }

    /** @test */
    public function unauth_user_cannot_delete_profile()
    {
    
        $response = $this->delete('/api/users/' . $this->user->id, [], array_merge($this->server, ['HTTP_Authorization' => '']));
        
        $response->assertStatus(500);
        
        $this->assertCount(1, User::all());
    
    }
}
