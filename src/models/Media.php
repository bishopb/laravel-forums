<?php

namespace BishopB\Forum;

class Media extends BaseModel
{
    // validation
    protected $rules = [
        'Name'         => 'required|max:255',
        'Path'         => 'required|max:255',
        'Type'         => 'required|max:128',
        'Size'         => 'integer',
        'ForeignID'    => 'integer',
        'ForeginTable' => 'max:24',
        'ImageWidth'   => 'integer|min:0',
        'ImageHeight'  => 'integer|min:0',
        'ThumbWidth'   => 'integer|min:0',
        'ThumbHeight'  => 'integer|min:0',
        'ThumbPath'    => 'max:255',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [ 'InsertUserID', 'DateInserted', ];
    }

    // definitions
    protected $table = 'GDN_Media';
    protected $primaryKey = 'MediaID';

    public function getDates()
    {
        return [ 'DateInserted', ];
    }
}
