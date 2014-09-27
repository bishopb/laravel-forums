<?php

namespace BishopB\Forum;

class ActivityType extends BaseModel
{
    // validation
    protected $rules = [
        'Name'            => 'required|max:20',
        'AllowComments'   => 'boolean',
        'ShowIcon'        => 'boolean',
        'ProfileHeadline' => 'max:255',
        'FullHeadline'    => 'max:255',
        'RouteCode'       => 'max:255',
        'Notify'          => 'boolean',
        'Public'          => 'boolean',
    ];

    // definitions
    protected $table = 'GDN_ActivityType';
    protected $primaryKey = 'ActivityTypeID';

    // relations
    public function activity()
    {
        return $this->belongsTo(
            '\BishopB\Forum\Activity', 'ActivityTypeID', 'ActivityTypeID'
        );
    }
}
