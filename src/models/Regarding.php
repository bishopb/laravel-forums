<?php

namespace BishopB\Forum;

class Regarding extends BaseModel
{
    // validation
    protected $rules = [
        'Type'            => 'required|max:255',
        'ForeignType'     => 'required|max:32',
        'ForeignID'       => 'required|integer',
        // 'OriginalContent' => none,
        'ParentType'      => 'max:32',
        'ParentID'        => 'integer',
        'ForeignURL'      => 'url|max:255',
        // 'Comment'         => none,
        'Reports'         => 'integer',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'InsertUserID', 'DateInserted', ];
    }

    // definitions
    protected $table = 'GDN_Regarding';
    protected $primaryKey = 'RegardingID';

    public function getDates()
    {
        return [ 'DateInserted', ];
    }
}
