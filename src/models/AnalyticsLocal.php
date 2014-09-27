<?php

namespace BishopB\Forum;

class AnalyticsLocal extends BaseModel
{
    // validation
    protected $rules = [
        'TimeSlot'   => 'required|max:8|unique:GDN_AnalyticsLocal',
        'Views'      => 'integer',
        'EmbedViews' => 'integer',
    ];

    // definitions
    protected $table = 'GDN_AnalyticsLocal';
    use NoPrimaryKeyTrait;
}
