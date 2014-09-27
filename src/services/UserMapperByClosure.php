<?php

namespace BishopB\Forum;

/**
 * Define an arbitrary closure to map users.
 */
class UserMapperByClosure extends AbstractUserMapper
{
    /**
     * Set the function that maps an application user to a vanilla user.
     *
     * The closure should return a \BishopB\Forum\User if mapped.
     */
    public function setClosure(callable $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @return BishopB\Forum\User
     * @throws BishopB\Forum\NoVanillaUserMappedToUser
     */
    public function resolve(\Illuminate\Auth\UserInterface $user = null)
    {
        $user = call_user_func($this->closure, $user);
        if (! $user instanceof User) {
            throw new NoVanillaUserMappedToUser();
        }

        return $user;
    }
}
