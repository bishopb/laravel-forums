<?php

namespace BishopB\Vfl;

/**
 * Define an arbitrary closure to map users.
 */
class UserMapperByClosure extends AbstractUserMapper
{
    /**
     * Set the function that maps an application user to a vanilla user.
     *
     * The closure should return a \BishopB\Vfl\User if mapped.
     */
    public function setClosure(callable $closure)
    {
        $this->closure = $closure;
    }

    /**
     * @return BishopB\Vfl\User
     * @throws BishopB\Vfl\NoVanillaUserMappedToUser
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
