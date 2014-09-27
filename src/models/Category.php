<?php

namespace BishopB\Forum;

/**
 * TODO: Implement Nested Set add, move, remove operations.
 */
class Category extends BaseModel
{
    // validation
    protected $rules = [
        'ParentCategoryID'       => 'integer|min:-1',
        'TreeLeft'               => 'integer|min:0',
        'TreeRight'              => 'integer|min:0',
        'Depth'                  => 'integer|min:0',
        'CountDiscussions'       => 'integer|min:0',
        'CountComments'          => 'integer|min:0',
        'DateMarkedRead'         => 'date',
        'AllowDiscussions'       => 'boolean',
        'Archived'               => 'boolean',
        'Name'                   => 'required|max:255',
        'UrlCode'                => 'max:255',
        'Description'            => 'max:500',
        'Sort'                   => 'integer',
        'CssClass'               => 'max:50',
        'Photo'                  => 'max:255',
        'PermissionCategoryID'   => 'integer|min:-1|exists:GDN_Permission,PermissionID',
        'PointsCategoryID'       => 'integer',
        'HideAllDiscussions'     => 'boolean',
        'DisplayAs'              => 'in:Categories,Discussions,Default',
        'LastCommentID'          => 'exists:GDN_Comment,CommentID',
        'LastDiscussionID'       => 'exists:GDN_Discussion,DiscussionID',
        'LastDateInserted'       => 'date',
        'AllowedDiscussionTypes' => 'max:255',
        'DefaultDiscussionType'  => 'max:10',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'UpdateUserID', 'DateUpdated',
        ];
    }

    // definitions
    protected $table = 'GDN_Category';
    protected $primaryKey = 'CategoryID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }

    // relations
    public function last_comment()
    {
        return $this->hasOne(
            '\BishopB\Forum\Comment', 'CommentID', 'LastCommentID'
        );
    }

    public function last_discussion()
    {
        return $this->hasOne(
            '\BishopB\Forum\Discussion', 'DiscussionID', 'LastDiscussionID'
        );
    }
}
