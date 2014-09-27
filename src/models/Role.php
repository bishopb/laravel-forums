<?php

namespace BishopB\Forum;

class Role extends BaseModel
{
    // validation
    protected $rules = [
        'Name'         => 'required|max:100',
        'Description'  => 'max:500',
        'Sort'         => 'integer',
        'Deletable'    => 'boolean',
        'CanSession'   => 'boolean',
        'PersonalInfo' => 'boolean',
    ];

    // definitions
    protected $table = 'GDN_Role';
    protected $primaryKey = 'RoleID';

    // relationships
    public function permissions()
    {
        return $this->hasMany('\BishopB\Forum\Permission', 'RoleID', 'RoleID');
    }
}
