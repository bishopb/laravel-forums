<?php
namespace BishopB\Forum;

class ConversationMessage extends BaseModel
{
    // validation
    protected $rules = [
        'ConversationID'  => 'required|exists:GDN_Conversation,ConversationID',
        // 'Body'            => none,
        'Format'          => 'max:20',
    ];

    // auditing
    use AuditingTrait;
    public function getAuditors()
    {
        return [
            'InsertUserID', 'DateInserted', 'InsertIPAddress',
        ];
    }

    // definitions
    protected $table = 'GDN_ConversationMessage';
    protected $primaryKey = 'MessageID';

    public function getDates()
    {
        return [ 'DateInserted', ];
    }

    // relations
    public function conversation()
    {
        return $this->belongsTo(
            '\BishopB\Forum\Conversation', 'ConversationID', 'ConversationID'
        );
    }
}
