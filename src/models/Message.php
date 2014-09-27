<?php

namespace BishopB\Forum;

class Message extends BaseModel
{
    // validation
    protected $rules = [
        'Content'              => 'required',
        'Format'               => 'max:20',
        'AllowDismiss'         => 'boolean',
        'Enabled'              => 'boolean',
        'Application'          => 'max:255',
        'Controller'           => 'max:255',
        'Method'               => 'max:255',
        'Category'             => 'exists:GDN_Category,CategoryID',
        'IncludeSubcategories' => 'boolean',
        'AssetTarget'          => 'max:20',
        'CssClass'             => 'max:20',
        'Sort'                 => 'integer',
    ];

    // definitions
    protected $table = 'GDN_Message';
    protected $primaryKey = 'MessageID';

    // relations
    public function category()
    {
        return $this->hasOne(
            '\BishopB\Forum\Category', 'CategoryID', 'CategoryID'
        );
    }
}
