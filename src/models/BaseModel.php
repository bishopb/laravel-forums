<?php

namespace BishopB\Forum;

/**
 * Common settings amongst all Vanilla models.
 */
class BaseModel extends \Eloquent
{
    // consistent model-level validation
    use \Watson\Validating\ValidatingTrait;

    // that throws exceptions when validation fails: developers are
    // responsible for ensuring models meet the requirements before attempting
    // to persist
    protected $throwValidationExceptions = true;

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
        // if we're using the auditing trait, guard the audit columns
        $reflection = new \ReflectionClass($this);
        if (array_key_exists('BishopB\Forum\AuditingTrait', $reflection->getTraits())) {
            $this->guarded = $this->guarded + $this->getAuditors();
        }

        parent::__construct($attributes);
    }
}
