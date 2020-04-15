<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use JWTAuth;
use Tymon\JWTAuth\Exceptions\JWTException;

use App\User;
use App\Category;
use App\Question;
use App\Reply;

class ReplyTest extends TestCase
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

        $this->reply = factory(Reply::class)->create(['user_id' => $this->user->id, 'question_id' => $this->question->id]);
    }

    private function data()
    {
        return [
            'body' => 'Test Reply',
        ];
    }

    /** @test */
    public function auth_user_can_create_reply()
    {
        $response = $this->post('/api/questions/' . $this->question->slug . '/replies', $this->data(), $this->server);

        $response->assertStatus(201);

        $this->assertCount(2, Reply::all());


        $replies = Reply::all();
        $reply = $replies[1];

        $this->assertEquals('Test Reply', $reply->body);
    

        $response->assertJson([
            'data' => [
                'id' => $reply->id,
                'body' => $reply->body,
                'question_name' => $reply->question->name,
                'question_id' => $reply->question->id,
                'user_name' => $reply->user->name,
                'user_id' => $reply->user_id,
                'created_at' => $reply->created_at->diffForHumans(),
            ],
        ]);
    }

    /** @test */
    public function unauth_user_cannot_create_reply()
    {
        $response = $this->post('/api/questions/' . $this->question->slug . '/replies', $this->data(), array_merge($this->server, ['HTTP_Authorization' => '']));

        $response->assertStatus(500);

        $this->assertCount(1, Reply::all());
    }

    /** @test */
    public function auth_user_can_update_reply()
    {
        $response = $this->put('/api/questions/' . $this->question->slug . '/replies/' . $this->reply->id, $this->data(), $this->server);

        $response->assertStatus(202);

        $this->assertCount(1, Reply::all());


        $this->reply = $this->reply->fresh();

        $this->assertEquals('Test Reply', $this->reply->body);


        $response->assertJson([
            'data' => [
                'id' => $this->reply->id,
                'body' => $this->reply->body,
                'question_name' => $this->reply->question->name,
                'question_id' => $this->reply->question->id,
                'user_name' => $this->reply->user->name,
                'user_id' => $this->reply->user_id,
                'created_at' => $this->reply->created_at->diffForHumans(),
            ],
        ]);
    }

    /** @test */
    public function unauth_user_cannot_update_reply()
    {
        $response = $this->put('/api/questions/' . $this->question->slug . '/replies/' . $this->reply->id, $this->data(), array_merge($this->server, ['HTTP_Authorization' => '']));
        
        $response->assertStatus(500);
        
        $this->assertCount(1, Reply::all());

        $this->assertNotEquals('Test Reply', $this->reply->body);
    }

    /** @test */
    public function auth_user_can_delete_reply()
    {
        $response = $this->delete('/api/questions/' . $this->question->slug . '/replies/' . $this->reply->id, array_merge($this->data(), ['body' => '']), $this->server);

        $response->assertStatus(204);

        $this->assertCount(0, Reply::all());
    }

    /** @test */
    public function unauth_admin_cannot_delete_category()
    {
        $response = $this->delete('/api/questions/' . $this->question->slug . '/replies/' . $this->reply->id, array_merge($this->server, ['HTTP_Authorization' => '']));
        
        $response->assertStatus(500);
        
        $this->assertCount(1, Reply::all());
    }
}