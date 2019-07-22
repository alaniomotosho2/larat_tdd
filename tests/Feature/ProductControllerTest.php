<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

use Faker\Factory;

use App\Http\Resources\ProductCollections;






class ProductControllerTest extends TestCase
{

    use RefreshDatabase;
    /**
     @test
     */
    public function can_create_a_product()
    {
        //$response = $this->get('/');

        //N>B faker is used to create fake names and stuff
        $faker = Factory::create();

        $response = $this->actingAs($this->create('User',[],false),'api')->json('POST','/api/products',[
            'name' => $name = $faker->company,
            'slug' => str_slug($name),
            'price' => $price = random_int(10,100),
            ]);

        \Log::info(1,[$response->getContent()]);

        $response->assertJsonStructure([
            'id','name','slug','price','created_at'
            ])

        ->assertJson([
            'name' => $name,
            'slug' => str_slug($name),
            'price' => $price
            ])

        ->assertStatus(201);

        $this->assertDatabaseHas('products',[
            'name' => $name,
            'slug' => str_slug($name),
            'price' => $price
            ]);
    }


    /**
     @test
     */
    public function will_fail_with_a_404_if_product_is_not_found(){
        $response = $this->actingAs($this->create('User',[],false),'api')->json('GET','api/products/-1'); 
        //in the above, we purosely used nonexistent < id >
        $response->assertStatus(404);
    }

   /**
     @test
     */
    public function can_show_a_product(){
        $product = $this->create('Product');

        $response = $this->actingAs($this->create('User',[],false),'api')->json('GET',"api/products/$product->id");

        $response->assertStatus(200)
        ->assertExactJson([
            'id' => $product->id,
            'name' => $product->name,
            'slug' => $product->slug,
            'price' => $product->price,
            'created_at' => $product->created_at,
            ]);
    }


    /**
     @test
     */
    public function will_fail_with_404_if_product_we_want_to_update_is_not_found(){
          $response = $this->actingAs($this->create('User',[],false),'api')->json('PUT','api/products/-1'); 
        //in the above, we purosely used nonexistent < id >
        $response->assertStatus(404);
    }

    /**
     @test
     */
     public function can_update_a_product(){
        $product =  $this->create('Product');
        // this above imply that to update aproduct we need to have a product so
        // we created one<
        $response = $this->actingAs($this->create('User',[],false),'api')->json('PUT',"api/products/$product->id",[
            'name' => $product->name .'_updated',
            'slug' => str_slug($product->name .'_updated'),
            'price' => $product->price + 10
            ]);

        $response->assertStatus(200)
        ->assertExactJson([
            'id' => $product->id,
            'name' => $product->name.'_updated',
            'slug' => str_slug($product->name.'_updated'),
            'price' => $product->price + 10,
            'created_at' => $product->created_at
            ]);

        $this->assertDatabaseHas('products',[
            'id' => $product->id,
            'name' => $product->name.'_updated',
            'slug' => str_slug($product->name.'_updated'),
            'price' => $product->price + 10,
            'created_at' => $product->created_at,
            'updated_at' => $product->updated_at

            ]);
     }


     /**
     @test
     */
    public function will_fail_with_404_if_product_we_want_to_delete_is_not_found(){
          $response = $this->actingAs($this->create('User',[],false),'api')->json('DELETE','api/products/-1'); 
        //in the above, we purosely used nonexistent < id >
        $response->assertStatus(404);
    }

    /**
     @test
     */
    public function can_delete_a_product(){
        $product = $this->create('Product');
    $response = $this->actingAs($this->create('User',[],false),'api')->json('DELETE',"api/products/$product->id");

    $response->assertStatus(204)
    ->assertSee(null);

    $this->assertDatabaseMissing('products',['id' => $product->id]);

    }

    /**
     @test
     */
     public function can_return_a_collection_of_paginated_products(){
         $product1 = $this->create('Product');
         $product2 = $this->create('Product');
         $product3 = $this->create('Product');

         $response = $this->actingAs($this->create('User',[],false),'api')->json('GET','api/products');

         $response->assertStatus(200)
         ->assertJsonStructure([
            'data' =>[
            '*'=>['id','name','slug','price','created_at']
                    ],
                    
            'links' =>['first','last','prev','next'],
            'meta' =>[
                'current_page','last_page','from','to','path','per_page','total'
                    ]
            ]);

        \Log::info($response->getContent());
     }


}
