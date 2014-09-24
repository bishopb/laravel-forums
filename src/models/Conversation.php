<?php

namespace BishopB\Vfl;

class Conversation extends BaseModel
{
    // validation
    protected $rules = [
        'Type'              => 'max:10',
        'ForeignID'         => 'max:40',
        'Subject'           => 'max:100',
        'Contributors'      => 'required|max:255',
        'FirstMessageID'    => 'exists:GDN_ConversationMessage,MessageID',
        'CountMessages'     => 'integer|min:0',
        'CountParticipants' => 'integer|min:0',
        'LastMessageID'     => 'exists:GDN_ConversationMessage,MessageID',
        'RegardingID'       => 'exists:GDN_Regarding,RegardingID',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
            'UpdateUserID', 'DateUpdated', 'UpdateIPAddress',
        ];
    }

    // definitions
    protected $table = 'GDN_Conversation';
    protected $primaryKey = 'ConversationID';

    public function getDates()
    {
        return [ 'DateInserted', 'DateUpdated', ];
    }

    // relations
    public function messages()
    {
        return $this->hasMany(
            '\BishopB\Vfl\ConversationMessage', 'ConversationID', 'ConversationID'
        );
    }

    public function first_message()
    {
        return $this->hasOne(
            '\BishopB\Vfl\ConversationMessage', 'MessageID', 'FirstMessageID'
        );
    }

    public function last_message()
    {
        return $this->hasOne(
            '\BishopB\Vfl\ConversationMessage', 'MessageID', 'LastMessageID'
        );
    }

    public function regarding()
    {
        return $this->hasOne(
            '\BishopB\Vfl\Regarding', 'RegardingID', 'RegardingID'
        );
    }
}
