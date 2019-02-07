<?php

declare(strict_types=1);

namespace App\Core\Passport;

use Adaojunior\Passport\SocialGrantException;
use Adaojunior\Passport\SocialUserResolverInterface;
use App\Models\LinkedSocialAccount;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Contracts\Auth\Authenticatable;
use Laravel\Socialite\Contracts\User as UserContract;
use Laravel\Socialite\Facades\Socialite;

class SocialUserResolver implements SocialUserResolverInterface
{
    /**
     * Resolves user by given network and access token.
     *
     * @param string $provider
     * @param string $accessToken
     * @return \Illuminate\Contracts\Auth\Authenticatable
     */
    public function resolve($provider, $accessToken, $accessTokenSecret = null): Authenticatable
    {
        if (empty(LinkedSocialAccount::toProviderEnum($provider))) {
            throw SocialGrantException::invalidNetwork();
        }

        try {
            $providerUser = Socialite::driver($provider)->userFromToken($accessToken);
        } catch (\Throwable $e) {
            throw SocialGrantException::invalidAccessToken();
        }

        return $this->retrieveUser(
            $provider,
            $providerUser
        );
    }

    protected function retrieveUser(string $provider, UserContract $providerUser): Authenticatable
    {
        $type = LinkedSocialAccount::toProviderEnum($provider);

        $associated = LinkedSocialAccount::with('user')->where([
            'provider' => $type,
            'provider_id' => $providerUser->getId(),
        ])->first();

        if (!empty($associated) && !empty($associated->user)) {
            return $associated->user;
        }

        /** @var User $user */
        $user = empty($email = $providerUser->getEmail())
            ? User::create($this->mapToUserAttribute($providerUser))
            : User::firstOrCreate(compact('email'), $this->mapToUserAttribute($providerUser));

        $user->linkedSocialAccounts()
            ->create([
                'provider' => $type,
                'provider_id' => $providerUser->getId(),
            ]);

        if ($user->wasRecentlyCreated) {
            event(new Registered($user));
        }

        return $user;
    }

    protected function mapToUserAttribute(UserContract $providerUser): array
    {
        return [
            'name' => $providerUser->getName() ?? $providerUser->getNickname() ?? '',
        ];
    }
}
