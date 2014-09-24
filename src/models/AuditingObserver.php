<?php

namespace BishopB\Vfl;

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
        $auditors = $model->getAuditors();
        if ($this->needs($auditors, 'InsertUserID')) {
            $model->InsertUserID = Auth::user()->getKey();
        }
        if ($this->needs($auditors, 'DateInserted')) {
            $model->DateInserted = new DateTime();
        }
        if ($this->needs($auditors, 'InsertIPAddress')) {
            $model->InsertIPAddress = \Request::getClientIp();
        }
    }

    /**
     * Register the validation event for updating the model.
     *
     * @param  \Illuminate\Database\Eloquent\Model $model
     * @return boolean
     */
    public function updating(\Illuminate\Database\Eloquent\Model $model)
    {
        $auditors = $model->getAuditors();
        if ($this->needs($auditors, 'UpdateUserID')) {
            $model->UpdateUserID = Auth::user()->getKey();
        }
        if ($this->needs($auditors, 'DateUpdated')) {
            $model->DateUpdated = new DateTime();
        }
        if ($this->needs($auditors, 'UpdateIPAddress')) {
            $model->UpdateIPAddress = \Request::getClientIp();
        }
    }

    // PROTECTED API

    /**
     * Test for the presence of a given auditing column in the attribute data.
     *
     * @param array $auditors The auditing-related attributes in the model.
     * @param string $attribute The attribute to check if we need.
     */
    protected function needs(array $auditors, $attribute)
    {
        return (
            (
                isset($auditors[$attribute]) && // audit column in model &
                empty($this->{$attribute})      // column not already set
            ) ?
            true :
            false
        );
    }
}
