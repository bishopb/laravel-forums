<?php

namespace BishopB\Forum;

class Spammer extends BaseModel
{
    // validation
    protected $rules = [
        'CountSpam'        => 'integer|min:0',
        'CountDeletedSpam' => 'integer|min:0',
    ];

    // definitions
    protected $table = 'GDN_Spammer';
    protected $primaryKey = 'UserID';

    // relationships
    public function user()
    {
        return $this->hasOne('\BishopB\Forum\User', 'UserID', 'UserID');
    }
}
