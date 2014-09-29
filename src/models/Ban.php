<?php

namespace BishopB\Forum;

class Ban extends BaseModel
{
    // validation
    protected $rules = [
        'BanType'                   => 'required|in:IPAddress,Name,Email',
        'BanValue'                  => 'required|max:50|unique_with:GDN_Ban,BanType',
        'Notes'                     => 'max:255',
        'CountUsers'                => 'integer|min:0',
        'CountBlockedRegistrations' => 'integer|min:0',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'InsertUserID', 'DateInserted', ];
    }

    // definitions
    protected $table = 'GDN_Ban';
    protected $primaryKey = 'BanID';

    public function getDates()
    {
        return [ 'DateInserted', ];
    }
}
