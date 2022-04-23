<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Http\Response;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class CategoryTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function test_categories_index_returns_data_with_200_status_code()
    {
        $response = $this->get('/api/v1/categories');
        // dd($response);
        $response->assertStatus(200)->assertJson([            
            "error" => false,
            "code" => 200, 
            "status" => "OK",
        ]);
    }

    public function test_categories_store_creates_a_new_resource()
    {
        $response = $this->postJson('/api/v1/categories', ['name' => 'Sally']);
 
        $response
            ->assertStatus(201)
            ->assertJson([
                "error" => false,
                "code" => Response::HTTP_CREATED, 
                "message" => Response::$statusTexts[Response::HTTP_CREATED], 
                "data" => [
                    "name" => "Sally",
                ]
            ]);
    }
}
