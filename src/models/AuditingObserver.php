<?php

namespace BishopB\Forum;

/**
 * Implement auditing actions.
 */
class AuditingObserver
{
    public function __construct(
        \Illuminate\Auth\AuthManager $auth, \Illuminate\Http\Request $request
    )
    {
        $this->auth    = $auth;
        $this->request = $request;
    }

    /**
     * Register the creating event for creating the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function creating(\Illuminate\Database\Eloquent\Model $model)
    {
        if ($this->needs($model, 'InsertUserID')) {
            $model->InsertUserID = $this->auth->user()->getKey();
            if ($this->needs($model, 'UpdateUserID')) {
                $model->UpdateUserID = $model->InsertUserID;
            }
        }
        if ($this->needs($model, 'DateInserted')) {
            $model->DateInserted = date('Y-m-d H:i:s');
            if ($this->needs($model, 'DateUpdated')) {
                $model->DateUpdated = $model->DateInserted;
            }
        }
        if ($this->needs($model, 'InsertIPAddress')) {
            $model->InsertIPAddress = $this->request->getClientIp();
            if ($this->needs($model, 'UpdateIPAddress')) {
                $model->UpdateIPAddress = $model->InsertIPAddress;
            }
        }
    }

    /**
     * Register the updating event for updating the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function updating(\Illuminate\Database\Eloquent\Model $model)
    {
        if ($this->needs($model, 'UpdateUserID')) {
            $model->UpdateUserID = $this->auth->user()->getKey();
        }
        if ($this->needs($model, 'DateUpdated')) {
            $model->DateUpdated = date('Y-m-d H:i:s');
        }
        if ($this->needs($model, 'UpdateIPAddress')) {
            $model->UpdateIPAddress = $this->request->getClientIp();
        }
    }

    /**
     * Register the deleting event for deleting the model.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     */
    public function deleting(\Illuminate\Database\Eloquent\Model $model)
    {
        if ($this->needs($model, 'DeleteUserID')) {
            $model->DeleteUserID = $this->auth->user()->getKey();
        }
        if ($this->needs($model, 'DateDeleted')) {
            $model->DateDeleted = date('Y-m-d H:i:s');
        }
    }

    // PROTECTED API

    /**
     * Test whether a particular auditing attribute is needed.
     *
     * @param \Illuminate\Database\Eloquent\Model $model
     * @param string $attribute
     */
    protected function needs(\Illuminate\Database\Eloquent\Model $model, $attribute)
    {
        return (
            (
                in_array($attribute, $model->getAuditors()) && // audit column in model &
                ! $model->getAttribute($attribute)             // column not already set
            ) ?
            true :
            false
        );
    }
}
