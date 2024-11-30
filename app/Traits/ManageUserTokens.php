<?php

namespace App\Traits;

trait ManageUserTokens
{

    protected function createToken($user)
    {
        $user->tokens()->delete();
        return $user->createToken(
            $user->getAuthTokenName(),
            ['*'],
            $user->getAuthTokenExpectedExpirationDate()
        );
    }

}
