<?php

namespace BishopB\Vfl;

class Activity extends BaseModel
{
    // validation
    protected $rules = [
        'ActivityTypeID'  => 'required|exists:GDN_ActivityType,ActivityTypeID',
        'NotifyUserID'    => 'exists:GDN_User,UserID',
        'ActivityUserID'  => 'exists:GDN_User,UserID',
        'RegardingUserID' => 'exists:GDN_User,UserID',
        'Photo'           => 'max:255',
        'HeadlineFormat'  => 'max:255',
        // 'Story'           => none,
        'Format'          => 'max:10',
        'Route'           => 'max:255',
        'RecordType'      => 'max:20',
        'RecordID'        => 'integer',
        'Notified'        => 'boolean',
        'Emailed'         => 'boolean',
        // 'Data'            => none,
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
    protected $table = 'GDN_Activity';
    protected $primaryKey = 'ActivityID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }

    // relations
    public function type()
    {
        return $this->hasOne(
            '\BishopB\Vfl\ActivityType', 'ActivityTypeID', 'ActivityTypeID'
        );
    }

    public function comments()
    {
        return $this->hasMany(
            '\BishopB\Vfl\ActivityComment', 'ActivityID', 'ActivityID'
        );
    }

    public function user()
    {
        return $this->hasOne('\BishopB\Vfl\User', 'UserID', 'ActivityUserID');
    }

    public function user_to_notify()
    {
        return $this->hasOne('\BishopB\Vfl\User', 'UserID', 'NotifyUserID');
    }

    public function user_regarding()
    {
        return $this->hasOne('\BishopB\Vfl\User', 'UserID', 'RegardingUserID');
    }
}
