<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class UserTest extends TestCase
{
   

    public function testeUser(){
        $request = $this->post(route('UserController@teste', ['provider' => 'insira o dado']));

        $request->assertResponseStatus(422);
        $request->seeJson(['erros' => ['main' => 'Wrong provider']]);

    }
}
