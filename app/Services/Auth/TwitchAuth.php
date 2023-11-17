<?php

namespace App\Services\Auth;

use App\Exceptions\InvalidJwtTokenException;
use App\Models\User;
use Lcobucci\JWT\Configuration;
use Lcobucci\JWT\Signer\Hmac\Sha256;
use Lcobucci\JWT\Signer\Key\InMemory;
use Lcobucci\JWT\Token\InvalidTokenStructure;
use Lcobucci\JWT\UnencryptedToken;
use Lcobucci\JWT\Validation\Constraint\SignedWith;
use Lcobucci\JWT\Validation\Validator;

class TwitchAuth
{
    private function authWithUser(User $user): User
    {
        \Auth::login($user, true);

        return $user;
    }
    /**
     * @throws InvalidJwtTokenException
     */
    public function authFromJwt(string $jwtToken): ?User
    {
        $key = InMemory::base64Encoded(config('services.twitch.extension_key'));
        $signer = new Sha256();

        $configuration = Configuration::forSymmetricSigner(
            $signer,
            $key,
        );

        $validator = new Validator();

        try {
            $token = $configuration->parser()->parse($jwtToken);
        } catch (InvalidTokenStructure) {
            return null;
        }
        assert($token instanceof UnencryptedToken);

        $valid = $validator->validate($token, new SignedWith($signer, $key));
        if (!$valid)
            throw new InvalidJwtTokenException('the provided jwt token is invalid');

        $userId = $token->claims()->get('user_id');
        if (!$userId)
            throw new \Exception('cannot authenticate without user id');

        $existingUser = User::whereTwitchId($userId)->first();

        if ($existingUser)
            return $this->authWithUser($existingUser);

        return null;
    }
}
