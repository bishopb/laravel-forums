<?php

namespace BishopB\Forum;

/**
 * Use this trait to signal a model has no primary key.
 */
trait NoPrimaryKeyTrait
{
    protected $primaryKey = null;
    public $incrementing = false;
}
