<?php

namespace BishopB\Forum;

class ActivityComment extends BaseModel
{
    // validation
    protected $rules = [
        'ActivityID'      => 'required|exists:GDN_Activity,ActivityID',
        'Body'            => 'required',
        'Format'          => 'required|max:20',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'InsertUserID', 'DateInserted', 'InsertIPAddress', ];
    }

    // defintions
    protected $table = 'GDN_ActivityComment';
    protected $primaryKey = 'ActivityCommentID';

    public function getDates()
    {
        return [ 'DateInserted', ];
    }

    // relations
    public function activity()
    {
        return $this->belongsTo(
            '\BishopB\Forum\Activity', 'ActivityID', 'ActivityID'
        );
    }
}
