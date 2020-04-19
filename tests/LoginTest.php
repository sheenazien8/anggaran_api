<?php

use Laravel\Lumen\Testing\DatabaseMigrations;
use Laravel\Lumen\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    /**
     * Test Login
     *
     * @return void
     */
    public function testUserLogin(): void
    {
        $data = [
            'email' => 'novella.littel@gmail.com',
            'password' => 12345678
        ];

        $response = $this->post('/auth/login', $data);
        $this->seeStatusCode(200)
                    ->seeJsonStructure([
                        'token'
                    ]);
    }
}
