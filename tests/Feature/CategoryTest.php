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


class CategoryTest extends TestCase
{
    use RefreshDatabase;

    protected $admin;
    protected $token;
    protected $server;

    protected $category;

    protected function setUp(): void 
    {
        parent::setUp();

        $this->admin = factory(User::class)->create();

        $this->token = JWTAuth::fromUser($this->admin);

        $this->server = [
            'HTTP_Authorization' => 'Bearer '. $this->token
        ];

        $this->category = factory(Category::class)->create();
    }

    private function data()
    {
        return [
            'name' => 'Test Category',
        ];
    }

    /** @test */
    public function auth_admin_can_create_category()
    {
        $response = $this->post('/api/categories', $this->data(), $this->server);

        $response->assertStatus(201);

        $this->assertCount(2, Category::all());


        $categories = Category::all();
        $category = $categories[1];

        $this->assertEquals('Test Category', $category->name);
    

        $response->assertJson([
            'data' => [
                'name' => $category->name,
                'id' => $category->id
            ],
        ]);
    }

    /** @test */
    public function unauth_admin_cannot_create_category()
    {
        $response = $this->post('/api/categories', $this->data(), array_merge($this->server, ['HTTP_Authorization' => '']));

        $response->assertStatus(500);

        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function auth_admin_can_update_category()
    {
        $response = $this->put('api/categories/' . $this->category->slug, $this->data(), $this->server);

        $response->assertStatus(202);

        $this->assertCount(1, Category::all());


        $this->category = $this->category->fresh();

        $this->assertEquals('Test Category', $this->category->name);


        $response->assertJson([
            'data' => [
                'name' => $this->category->name,
                'id' => $this->category->id
            ],
        ]);
    }

    /** @test */
    public function unauth_admin_cannot_update_category()
    {
        $response = $this->put('/api/categories' . $this->category->slug, $this->data(), array_merge($this->server, ['HTTP_Authorization' => '']));
        
        $response->assertStatus(405);
        
        $this->assertCount(1, Category::all());

        $this->assertNotEquals('Test Category', $this->category->title);
    }

    /** @test */
    public function field_is_required_create_category()
    {
        $response = $this->post('/api/categories', array_merge($this->data(), ['name' => '']), $this->server);
        
        $response->assertSessionHasErrors('name');

        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function field_is_required_update_category()
    {
        $response = $this->put('/api/categories/' . $this->category->slug, array_merge($this->data(), ['name' => '']), $this->server);
        
        $response->assertSessionHasErrors('name');

        $this->assertCount(1, Category::all());
    }

    /** @test */
    public function any_user_can_see_questions_of_this_category()
    {        
        $question = factory(Question::class)->create(['user_id' => $this->admin->id, 'category_id' => $this->category->id]);

        $response = $this->get('/api/categories/' . $this->category->slug);
    
        $response->assertJson([
            'data' => [
                [
                    'title' => $question->title,
                    'body' => $question->body,
                    'created_at' => $question->created_at->diffForHumans(),
                    'user_name' => $question->user->name,
                ]
            ]
        ]);
    }

    /** @test */
    public function auth_admin_can_delete_category()
    {
        $response = $this->delete('api/categories/' . $this->category->slug, array_merge($this->data(), ['name' => '']), $this->server);

        $response->assertStatus(204);

        $this->assertCount(0, Category::all());
    }

    /** @test */
    public function unauth_admin_cannot_delete_category()
    {
        $response = $this->delete('/api/categories/' . $this->category->slug, array_merge($this->server, ['HTTP_Authorization' => '']));
        
        $response->assertStatus(500);
        
        $this->assertCount(1, Category::all());
    }
    
}
