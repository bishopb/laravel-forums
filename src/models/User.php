<?php

namespace BishopB\Vfl;

class User extends \Eloquent
{
    protected $fillable = [
        'UserID', 'Name', 'Password', 'HashMethod', 'Photo', 'Title', 'Location', 
        'About', 'Email', 'ShowEmail', 'Gender', 'CountVisits', 'CountInvitations', 
        'CountNotifications', 'InviteUserID', 'DiscoveryText', 'Preferences', 
        'Permissions', 'Attributes', 'DateSetInvitations', 'DateOfBirth', 
        'DateFirstVisit', 'DateLastActive', 'LastIPAddress', 'AllIPAddresses', 
        'DateInserted', 'InsertIPAddress', 'DateUpdated', 'UpdateIPAddress', 
        'HourOffset', 'Score', 'Admin', 'Confirmed', 'Verified', 'Banned', 'Deleted', 
        'Points', 
    ];
    protected $table = 'GDN_User';
    protected $primaryKey = 'UserID';

    public function getDates()
    {
        return [
            'DateSetInvitations', 'DateOfBirth', 'DateFirstVisit',
            'DateLastActive', 'DateInserted', 'DateUpdated'
        ];
    }

    public function roles()
    {
        return $this->belongsToMany(
            '\BishopB\Vfl\Role', 'GDN_UserRole', 'UserID', 'RoleID'
        );
    }
}
