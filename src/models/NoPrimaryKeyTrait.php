<?php

namespace BishopB\Vfl;

/**
 * Use this trait to signal a model has no primary key.
 */
trait NoPrimaryKeyTrait
{
    protected $primaryKey = null;
    public $incrementing = false;
}
