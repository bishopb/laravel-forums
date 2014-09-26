<?php

namespace BishopB\Vfl;

class User extends BaseModel
{
    // validation
    protected $rules = [
        'Name'                     => 'required|max:50',
        'Password'                 => 'required|max:100',
        'HashMethod'               => 'max:10',
        'Photo'                    => 'max:255',
        'Title'                    => 'max:100',
        'Location'                 => 'max:100',
        // 'About'                    => none,
        'Email'                    => 'email|max:200',
        'ShowEmail'                => 'boolean',
        'Gender'                   => 'in:u,m,f',
        'CountVisits'              => 'integer|min:0',
        'CountInvitations'         => 'integer|min:0',
        'CountNotifications'       => 'integer|min:0',
        'InviteUserID'             => 'exists:GDN_User,UserID',
        // 'DiscoveryText'            => none,
        // 'Preferences'              => none,
        // 'Permissions'              => none,
        // 'Attributes'               => none,
        'DateSetInvitations'       => 'date',
        'DateOfBirth'              => 'date',
        'DateFirstVisit'           => 'date',
        'DateLastActive'           => 'date',
        'LastIPAddress'            => 'ip|max:15',
        'AllIPAddresses'           => 'max:100',
        'HourOffset'               => 'integer',
        'Score'                    => 'numeric',
        'Admin'                    => 'boolean',
        'Confirmed'                => 'boolean',
        'Verified'                 => 'boolean',
        'Banned'                   => 'boolean',
        'Deleted'                  => 'boolean',
        'Points'                   => 'integer|min:0',
        'CountUnreadConversations' => 'integer|min:0',
        'CountDiscussions'         => 'integer|min:0',
        'CountUnreadDiscussions'   => 'integer|min:0',
        'CountComments'            => 'integer|min:0',
        'CountDrafts'              => 'integer|min:0',
        'CountBookmarks'           => 'integer|min:0',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'DateInserted', 'InsertIPAddress',
            'DateUpdated', 'UpdateIPAddress',
        ];
    }

    // definitions
    protected $table = 'GDN_User';
    protected $primaryKey = 'UserID';

    public function getDates()
    {
        return [
            'DateSetInvitations', 'DateOfBirth', 'DateFirstVisit',
            'DateLastActive', 'DateInserted', 'DateUpdated'
        ];
    }

    // relationships
    public function roles()
    {
        return $this->belongsToMany(
            '\BishopB\Vfl\Role', 'GDN_UserRole', 'UserID', 'RoleID'
        );
    }

    // custom
    /**
     * Manfacture a user with a particular role(s).
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
