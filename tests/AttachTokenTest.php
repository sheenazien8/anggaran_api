<?php
namespace Test;

use App\Models\User;
use Firebase\JWT\JWT;

trait AttachTokenTest
{
    /**
     * Get token
     * @var String
     */
    public $token;
    /**
     * Create a new token.
     *
     * @param  \App\Models\User   $user
     * @return string
     */
    protected function loginAs(User $user) {
        $payload = [
            'iss' => "lumen-jwt", // Issuer of the token
            'sub' => $user->id, // Subject of the token
            'iat' => time(), // Time when JWT was issued.
            'exp' => time() + 60*60 // Expiration time
        ];

        // As you can see we are passing `JWT_SECRET` as the second parameter that will
        // be used to decode the token in the future.
        $this->token = JWT::encode($payload, env('JWT_SECRET'));
        return $this;
    }
}
