<?php

namespace BishopB\Forum;

/**
 * Base class for user mappers.  Defines the `current()` method to defer its
 * logic to the `resolve()` method.
 */
abstract class AbstractUserMapper implements UserMapperInterface
{
    /**
     * @return BishopB\Forum\User
     * @throws BishopB\Forum\NoVanillaUserMappedToAuthenticatedUser
     * @throws BishopB\Forum\NoVanillaUserMappedToGuest
     */
    public function current()
    {
        try {
            return $this->resolve(\Auth::user());
        } catch (NoVanillaUserMappedToUser $ex) {
            if (\Auth::user()) {
                throw new NoVanillaUserMappedToAuthenticatedUser();
            } else {
                throw new NoVanillaUserMappedToGuest();
            }
        }
    }
}
