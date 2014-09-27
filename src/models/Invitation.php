<?php

namespace BishopB\Forum;

class Invitation extends BaseModel
{
    // validation
    protected $rules = [
        'Email'          => 'required|email|max:200',
        'Name'           => 'max:50',
        // 'RoleIDs'        => none,
        'Code'           => 'max:50',
        'AcceptedUserID' => 'exists:GDN_User,UserID',
        'DateExpires'    => 'date',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'InsertUserID', 'DateInserted', ];
    }

    // definitions
    protected $table = 'GDN_Invitation';
    protected $primaryKey = 'InvitationID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateExpires', ];
    }

    // relations
    public function accepting_user()
    {
        return $this->hasOne('\BishopB\Forum\User', 'UserID', 'AcceptedUserID');
    }
}
