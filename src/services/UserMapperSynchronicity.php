<?php

namespace BishopB\Forum;

/**
 * Let's you synchronize Vanilla's user table with your application's user
 * table, through a set of public callbacks.
 */
class UserMapperSynchronicity extends UserMapperByClosure
{
    /**
     * @var int
     * Vanilla users should have an ID this much greater than their application
     * counterpart.
     */
    public $auth_user_offset = 100;

    /**
     * @var callable
     * Closure to call to create a guest account. If not set, or if doesn't return
     * a \BishopB\Forum\User, then an \BishopB\Forum\NoVanillaUserMappedToGuest
     * exception will raise.
     */
    public $create_guest_account = null;

    /**
     * @var callable
     * Closure to call to create a user account. If not set, or if doesn't return
     * a \BishopB\Forum\User, then an \BishopB\Forum\NoVanillaUserMappedToUser
     * exception will raise.  Will be given the vanilla user ID expected and the
     * application user object.
     */
    public $create_account_for = null;

    /**
     * @var callable
     * Closure to call to update a user account. First argument will be the
     * application user, the second the corresponding vanilla user.
     */
    public $update_account_for = null;


    public function __construct()
    {
        $this->setClosure([$this, 'dispatcher']);
    }

    public function dispatcher(\Illuminate\Auth\UserInterface $user = null)
    {
        // map the user ID: 1 is guest, otherwise add 100
        $vUID = (null === $user ? 1 : ($user->getKey() + $this->auth_user_offset));

        // lookup the vanilla user with that ID
        $vUser = User::find($vUID);

        // not there, create
        if (null === $vUser) {
            if (null === $user) {
                if (is_callable($this->create_guest_account)) {
                    $vUser = call_user_func($this->create_guest_account);
                }
                if (! $vUser instanceof User) {
                    throw new NoVanillaUserMappedToGuest();
                }
            } else {
                if (is_callable($this->create_account_for)) {
                    $vUser = call_user_func($this->create_account_for, $vUID, $user);
                }
                if (! $vUser instanceof User) {
                    throw new NoVanillaUserMappedToUser();
                }
            }

        // update authenticated user data
        } else if (null !== $user && is_callable($this->update_account_for)) {
            call_user_func($this->update_account_for, $user, $vUser);
        }

        return $vUser;
    }
}
