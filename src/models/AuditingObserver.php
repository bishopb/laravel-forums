<?php

namespace BishopB\Forum;

/**
 * Implement auditing actions.
 */
class AuditingObserver
{
    /**
     * Register the validation event for creating the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return boolean
     */
    public function creating(\Illuminate\Database\Eloquent\Model $model)
    {
        // insert specific...
        if ($this->needs($model, 'InsertUserID')) {
            $model->InsertUserID = \Auth::user()->getKey();
        }
        if ($this->needs($model, 'DateInserted')) {
            $model->DateInserted = $this->getNow();
        }
        if ($this->needs($model, 'InsertIPAddress')) {
            $model->InsertIPAddress = \Request::getClientIp();
        }

        // ... now fill in the update too with identical values
        $this->updating($model);
    }

    /**
     * Register the validation event for updating the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return boolean
     */
    public function updating(\Illuminate\Database\Eloquent\Model $model)
    {
        if ($this->needs($model, 'UpdateUserID')) {
            $model->UpdateUserID = \Auth::user()->getKey();
        }
        if ($this->needs($model, 'DateUpdated')) {
            $model->DateUpdated = $this->getNow();
        }
        if ($this->needs($model, 'UpdateIPAddress')) {
            $model->UpdateIPAddress = \Request::getClientIp();
        }
    }

    // PROTECTED API

    /**
     * Test for the presence of a given auditing column in the attribute data.
     *
     * @param array $model
     * @param string $attribute
     */
    protected function needs(\Eloquent $model, $attribute)
    {
        return (
            (
                in_array($attribute, $model->getAuditors()) && // audit column in model &
                empty($model->getAttribute($attribute))        // column not already set
            ) ?
            true :
            false
        );
    }

    /**
     * Get the current time.
     */
    protected function getNow()
    {
        static $now = null;
        if (null === $now) {
            $now = new \DateTime();
        }

        return $now;
    }
}
