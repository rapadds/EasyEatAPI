<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class RegisterClientTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testUserCreation()
    {
        $response = $this->json("POST","/api/register/client",array(
            "phoneNumber" => "37612070",
            "password"=>"Fasil123!",
            "c_password"=>"Fasil123!"
        ));

        $response->assertStatus(200)
        ->assertJson(array(
            "phoneNumber" => "37612070"
        ));
    }

    public function testUserAlreadyExist(){
        $response = $this->json("POST","/api/register/client",array(
            "phoneNumber" => "37612070",
            "password"=>"Fasil123!",
            "c_password"=>"Fasil123!"
        ));

        $response->assertStatus(400)
            ->assertJson(array(
                "success" => "false"
            ));
    }
}
