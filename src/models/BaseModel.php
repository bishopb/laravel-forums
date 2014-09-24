<?php

namespace BishopB\Vfl;

/**
 * Common settings amongst all Vanilla models.
 */
class BaseModel extends \Eloquent
{
    // consistent model-level validation
    use \Watson\Validating\ValidatingTrait;

    // vanilla handles timestamps differently
    public $timestamps = false;

    // let us mass fill everything by default
    protected $guarded = [];

    /**
     * Create a new Eloquent model instance, ensuring that any auditing
     * columns are guarded.
     *
     * @param  array  $attributes
     * @return void
     */
    public function __construct(array $attributes = array())
    {
        if (is_callable([$this, 'getAuditors'])) {
            $this->guarded = $this->guarded + $this->getAuditors();
        }

        parent::__construct($attributes);
    }
}
