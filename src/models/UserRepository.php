<?php

namespace BishopB\Forum;

class UserRepository
{
    /**
     * Get the system user.
     */
    public static function system()
    {
        return User::findOrFail(0);
    }

    /**
     * Create a user with the given attributes and roles.
     * @param array       $attributes
     * @param arrayOfRole $roles
     * @return User
     */
    public static function createWithRoles(array $attributes, array $roles)
    {
        \DB::beginTransaction();
        $user = User::create($attributes);
        foreach ($roles as $role) {
            $user->roles()->save($role);
        }
        \DB::commit();

        return $user;
    }
}
