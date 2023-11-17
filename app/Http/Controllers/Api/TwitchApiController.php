<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Services\Auth\TwitchAuth;
use Illuminate\Http\Request;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\RelatedTo;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;


class TwitchApiController extends Controller
{


    public function __construct(
        protected TwitchAuth $twitchAuth,
    )
    {
    }

    function validateToken(Request $request)
    {
        $authString = $request->header('Authorization');
        $rawToken = substr($authString, strlen("Bearer "));
//        $rawToken = $request->get('jwt');
        $user = $this->twitchAuth->authFromJwt($rawToken);
        return [
            'user' => $user,
//            'status' => 'OK'
        ];
    }

    function testUser() {
        return [
            'user' => \Auth::user()
        ];
    }
}
