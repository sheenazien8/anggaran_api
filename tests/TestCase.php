<?php

use Test\AttachTokenTest;

abstract class TestCase extends Laravel\Lumen\Testing\TestCase
{
    use AttachTokenTest;
    /**
     * Creates the application.
     *
     * @return \Laravel\Lumen\Application
     */
    public function createApplication()
    {
        return require __DIR__.'/../bootstrap/app.php';
    }
    protected function headers($user = null)
    {
        $headers = ['Accept' => 'application/json'];

        if (!is_null($user)) {
            $token = $this->loginAs($user)->token;
            $headers['Authorization'] = 'Bearer '.$token;
        }

        return $headers;
    }
}
