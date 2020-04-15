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


class QuestionTest extends TestCase
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


        $this->category = factory(Category::class)->create();

        $this->question = factory(Question::class)->create(['user_id' => $this->user->id, 'category_id' => $this->category->id]);
    }

    private function data()
    {
        return [
            'title' => 'Test Question',
            'body' => 'This is a new question.',
            'category_id' => '3'
        ];
    }

    /** @test */
    public function auth_user_can_create_question()
    {
        $response = $this->post('/api/questions', $this->data(), $this->server);

        $response->assertStatus(201);

        $this->assertCount(2, Question::all());

        $questions = Question::all();
        $question = $questions[1];

        $this->assertEquals('Test Question', $question->title);
        $this->assertEquals('This is a new question.', $question->body);
        $this->assertEquals('3', $question->category_id);
    }

    /** @test */
    public function unauth_user_cannot_create_question()
    {
        $response = $this->post('/api/questions', $this->data(), array_merge($this->server, ['HTTP_Authorization' => '']));

        $response->assertStatus(500);

        $this->assertCount(1, Question::all());
    }

    /** @test */
    public function auth_user_can_update_question()
    {
        $response = $this->put('api/questions/' . $this->question->slug, $this->data(), $this->server);

        $response->assertStatus(202);

        $this->assertCount(1, Question::all());
    }

    /** @test */
    public function unauth_user_cannot_update_question()
    {
        $response = $this->put('/api/questions' . $this->question->slug, $this->data(), array_merge($this->server, ['HTTP_Authorization' => '']));
        
        $response->assertStatus(404);

    }

    /** @test */
    public function field_is_required_create_question()
    {
        collect(['title', 'body', 'category_id'])->each(function($field) {
            $response = $this->post('/api/questions', array_merge($this->data(), [$field => '']), $this->server);
            
            $response->assertSessionHasErrors($field);

            $this->assertCount(1, Question::all());
        });
    }

    /** @test */
    public function field_is_required_update_question()
    {
        collect(['title', 'body', 'category_id'])->each(function($field) {
            $response = $this->put('/api/questions/' . $this->question->slug, array_merge($this->data(), [$field => '']), $this->server);
            
            $response->assertSessionHasErrors($field);

            $this->assertCount(1, Question::all());
        });
    }
}
