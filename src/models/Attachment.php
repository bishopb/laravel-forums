<?php

namespace BishopB\Forum;

class Attachment extends BaseModel
{
    // validation
    protected $rules = [
        'Type'           => 'required|max:64',
        'ForeignID'      => 'required|max:50',
        'ForeignUserID'  => 'required|exists:GDN_User,UserID',
        'Source'         => 'required|max:64',
        'SourceID'       => 'required|max:32',
        'SourceURL'      => 'required|url|max:255',
        // 'Attributes'           => none,
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
            'UpdateUserID', 'DateUpdated', 'UpdateIPAddress',
        ];
    }

    // definitions
    protected $table = 'GDN_Attachment';
    protected $primaryKey = 'AttachmentID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }

    // relations
    public function user()
    {
        return $this->hasOne('\BishopB\Forum\User', 'UserID', 'ForeignUserID');
    }
}
