<?php

namespace BishopB\Forum;

/**
 * Vanilla defines a finite set of roles. Provide a convenient way to pull
 * those defined roles by name.
 */
class RoleRepository
{
    public static function guest()
    {
        return Role::findOrFail(2);
    }

    public static function unconfirmed()
    {
        return Role::findOrFail(3);
    }

    public static function applicant()
    {
        return Role::findOrFail(4);
    }

    public static function member()
    {
        return Role::findOrFail(8);
    }

    public static function administrator()
    {
        return Role::findOrFail(16);
    }

    public static function moderator()
    {
        return Role::findOrFail(32);
    }
}
