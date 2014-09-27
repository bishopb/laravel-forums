<?php

namespace BishopB\Forum;

class Draft extends BaseModel
{
    // validation
    protected $rules = [
        'DiscussionID' => 'exists:GDN_Discussion,DiscussionID',
        'CategoryID'   => 'exists:GDN_Category,CategoryID',
        'Name'         => 'max:100',
        'Tags'         => 'max:255',
        'Closed'       => 'boolean',
        'Announce'     => 'boolean',
        'Sink'         => 'boolean',
        'Body'         => 'required',
        'Format'       => 'max:20',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted',
            'UpdateUserID', 'DateUpdated',
        ];
    }

    // definitions
    protected $table = 'GDN_Draft';
    protected $primaryKey = 'DraftID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }

    // relations
    public function discussion()
    {
        return $this->hasOne(
            '\BishopB\Forum\Discussion', 'DiscussionID', 'DiscussionID'
        );
    }

    public function category()
    {
        return $this->hasOne(
            '\BishopB\Forum\Category', 'CategoryID', 'CategoryID'
        );
    }
}
