<?php

namespace BishopB\Forum;

/**
 * User mapper that simply creates a guest user when needed.
 */
class UserMapperAllGuestAccess extends UserMapperSynchronicity
{
    public function __construct()
    {
        parent::__construct();

        $this->create_guest_account = function () {
            return UserRepository::createWithRoles(
                [
                    'UserID' => 1,
                    'Name' => 'Anonymous',
                    'Password' => str_random(64),
                    'HashMethod' => 'random',
                ],
                [ RoleRepository::member() ]
            );
        };
    }
}
