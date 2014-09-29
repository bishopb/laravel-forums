<?php

namespace BishopB\Forum;

/**
 * Add the user, date, and IP address during insert and update.
 */
trait AuditingTrait
{
    static public function bootAuditingTrait()
    {
        static::observe(
            new AuditingObserver(\App::make('auth'), \App::make('request'))
        );
    }

    /**
     * Return the columns involved in auditing of this model.
     * This default returns the maximal set: your model may use fewer.
     */
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
            'UpdateUserID', 'DateUpdated', 'UpdateIPAddress',
            'DeleteUserID', 'DateDeleted',
        ];
    }

    public function inserting_user()
    {
        if (in_array('InsertUserID', $this->getAuditors())) {
            return $this->hasOne('\BishopB\Forum\User', 'UserID', 'InsertUserID');
        } else {
            return false;
        }
    }

    public function updating_user()
    {
        if (in_array('UpdateUserID', $this->getAuditors())) {
            return $this->hasOne('\BishopB\Forum\User', 'UserID', 'UpdateUserID');
        } else {
            return false;
        }
    }

    public function deleting_user()
    {
        if (in_array('DeleteUserID', $this->getAuditors())) {
            return $this->hasOne('\BishopB\Forum\User', 'UserID', 'DeleteUserID');
        } else {
            return false;
        }
    }
}
