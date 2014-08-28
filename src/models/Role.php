<?php

namespace BishopB\Vfl;

class Role extends \Eloquent
{
    protected $fillable = [
        'RoleID', 'Name', 'Description', 'Sort', 'Deletable', 'CanSession', 'PersonalInfo'
    ];
    protected $table = 'GDN_Role';
    protected $primaryKey = 'RoleID';

    public function users()
    {
        return $this->belongsToMany('\BishopB\Vfl\User', 'GDN_UserRole', 'RoleID', 'UserID');
    }
}
