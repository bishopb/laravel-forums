<?php

namespace BishopB\Forum;

class Tag extends BaseModel
{
    // validation
    protected $rules = [
        'Name'             => 'required|max:255',
        'FullName'         => 'required|max:255',
        'Type'             => 'max:20',
        'ParentTagID'      => 'exists:GDN_Tag,TagID',
        'CategoryID'       => 'exists:GDN_Category,CategoryID|unique_with:GDN_Tag,Name',
        'CountDiscussions' => 'integer|min:0',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'InsertUserID', 'DateInserted', ];
    }

    // definitions
    protected $table = 'GDN_Tag';
    protected $primaryKey = 'TagID';

    public function getDates()
    {
        return [ 'DateInserted', ];
    }

    // relationships
    public function parent_tag()
    {
        return $this->hasOne('\BishopB\Forum\Tag', 'TagID', 'ParentTagID');
    }

    public function category()
    {
        return $this->hasOne(
            '\BishopB\Forum\Category', 'CategoryID', 'CategoryID'
        );
    }
}
