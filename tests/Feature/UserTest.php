<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use App\Question;
use App\Category;
use Carbon\Carbon;

class UserTest extends TestCase
{
    use RefreshDatabase;

    protected $user;
    protected $token;
    protected $server;

    protected $category;
    protected $question;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->user = factory(User::class)->create();

        $this->token = JWTAuth::fromUser($this->user);

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];
    }

    /** @test */
    public function guest_can_signup()
    {
        //just like setup + use assert count
    }

    /** @test */
    public function user_can_login()
    {
        //just like setup + use assert count
    }

    /** @test */
    public function auth_user_can_update_profile()
    {
        //just like setup + use assert count
    }

    /** @test */
    public function auth_user_can_update_see_his_profile()
    {
        //just like setup + use assert count
    }

    /** @test */
    public function field_is_required_signup_user()
    {

    }

    /** @test */
    public function field_is_required_edit_profile()
    {

    }

    /** @test */
    public function valid_email_field_is_required_signup_user()
    {

    }

    /** @test */
    public function valid_email_field_is_required_edit_profile()
    {

    }

    /** @test */
    public function valid_birthday_field_is_required_signup_user()
    {

    }

    /** @test */
    public function valid_birthday_field_is_required_edit_profile()
    {

    }

    /** @test */
    public function auth_user_can_delete_profile()
    {
        //just like setup + use assert count
    }
}
