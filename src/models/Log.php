<?php

namespace BishopB\Forum;

class Log extends BaseModel
{
    // validation
    protected $rules = [
        'Operation'        => 'required|in:Delete,Edit,Spam,Moderate,Pending,Ban,Error',
        'RecordType'       => 'required|in:Discussion,Comment,User,Registration,Activity,ActivityComment,Configuration,Group',
        'TransactionLogID' => 'integer',
        'RecordID'         => 'integer',
        'RecordUserID'     => 'exists:GDN_User,UserID',
        'RecordDate'       => 'required|date',
        'RecordIPAddress'  => 'ip|max:15',
        'OtherUserIDs'     => 'max:255',
        'ParentRecordID'   => 'integer',
        'CategoryID'       => 'exists:GDN_Category,CategoryID',
        'Data'             => none,
        'CountGroup'       => 'integer',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
            'DateUpdated',
        ];
    }

    // definitions
    protected $table = 'GDN_Log';
    protected $primaryKey = 'LogID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', 'RecordDate', ];
    }

    // relations
    public function record_user()
    {
        return $this->hasOne('\BishopB\Forum\User', 'UserID', 'RecordUserID');
    }

    public function category()
    {
        return $this->hasOne('\BishopB\Forum\Category', 'CategoryID', 'CategoryID');
    }
}
