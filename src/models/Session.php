<?php

namespace BishopB\Forum;

class Session extends BaseModel
{
    // validation
    protected $rules = [
        'SessionID'    => 'required|max:32',
        'UserID'       => 'exists:GDN_User,UserID',
        'TransientKey' => 'required|max:12',
        // 'Attributes'   => none,
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }

    // definitions
    protected $table = 'GDN_Session';
    protected $primaryKey = 'SessionID';
    public $incrementing = false;

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }
}
