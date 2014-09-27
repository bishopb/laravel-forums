<?php

namespace BishopB\Forum;

/**
 * Resolves a Vanilla user by matching the id.  So if you have a user with
 * id = 242, then the corresponding Vanilla user has a UserID = 242.
 *
 * If you use this mapper, you are responsible for keeping the Vanilla user
 * models in sync with your application's user models.
 */
class UserMapperById extends AbstractUserMapper
{
    /**
     * @return BishopB\Forum\User
     * @throws BishopB\Forum\NoVanillaUserMappedToUser
     */
    public function resolve(\Illuminate\Auth\UserInterface $user = null)
    {
        if (null !== $user) {
            $user = User::find($user->getKey());
        }

        if (null === $user) {
            throw new NoVanillaUserMappedToUser();
        }

        return $user;
    }
}
