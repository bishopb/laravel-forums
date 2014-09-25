<?php

use Illuminate\Database\Migrations\Migration;

class SeedBaseVanillaTables extends Migration
{
	public function up()
	{
        foreach ($this->getSeedData() as $table => $rows) {
            DB::table($table)->insert($rows);
        }
	}

	public function down()
	{
        foreach (array_reverse(array_keys($this->getSeedData())) as $table) {
            DB::table($table)->delete();
        }
	}

    protected function getSeedData()
    {
        return [
            /* {{{ */ 'GDN_ActivityType' => [[
                'Name' => 'SignIn',
                'ProfileHeadline' => '%1$s signed in.',
                'FullHeadline' => '%1$s signed in.'
            ], [
                'Name' => 'Join',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s joined.',
                'FullHeadline' => '%1$s joined.'
            ], [
                'Name' => 'JoinInvite',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s accepted %4$s invitation for membership.',
                'FullHeadline' => '%1$s accepted %4$s invitation for membership.',
            ], [
                'Name' => 'JoinApproved',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s approved %4$s membership application.',
                'FullHeadline' => '%1$s approved %4$s membership application.',
            ], [
                'Name' => 'JoinCreated',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s created an account for %3$s.',
                'FullHeadline' => '%1$s created an account for %3$s.',
            ], [
                'Name' => 'AboutUpdate',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s updated %6$s profile.',
                'FullHeadline' => '%1$s updated %6$s profile.',
            ], [
                'Name' => 'WallComment',
                'AllowComments' => 1,
                'ShowIcon' => 1,
                'ProfileHeadline' => '%1$s wrote:',
                'FullHeadline' => '%1$s wrote on %4$s %5$s.',
            ], [
                'Name' => 'PictureChange',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s changed %6$s profile picture.',
                'FullHeadline' => '%1$s changed %6$s profile picture.',
            ], [
                'Name' => 'RoleChange',
                'AllowComments' => 1,
                'ProfileHeadline' => '%1$s changed %4$s permissions.',
                'FullHeadline' => '%1$s changed %4$s permissions.',
                'Notify' => 1,
            ], [
                'Name' => 'ActivityComment',
                'ShowIcon' => 1,
                'ProfileHeadline' => '%1$s',
                'FullHeadline' => '%1$s comentd on %4$s %8$s.',
                'RouteCode' => 'activity',
                'Notify' => 1,
            ], [
                'Name' => 'Import',
                'ProfileHeadline' => '%1$s imported data.',
                'FullHeadline' => '%1$s imported data.',
                'Notify' => 1,
            ], [
                'Name' => 'Banned',
                'ProfileHeadline' => '%1$s banned %3$s.',
                'FullHeadline' => '%1$s banned %3$s.',
            ], [
                'Name' => 'Unbanned',
                'ProfileHeadline' => '%1$s un-banned %3$s.',
                'FullHeadline' => '%1$s un-banned %3$s.',
            ], [
                'Name' => 'Applicant',
                'ProfileHeadline' => '%1$s applied for membership.',
                'FullHeadline' => '%1$s applied for membership.',
                'Notify' => 1,
            ], [
                'Name' => 'WallPost',
                'AllowComments' => 1,
                'ShowIcon' => 1,
                'ProfileHeadline' => '%1$s wrote:',
                'FullHeadline' => '%1$s wrote on %2$s %5$s.',
            ], [
                'Name' => 'Default',
            ], [
                'Name' => 'Registration',
            ], [
                'Name' => 'Status',
            ], [
                'Name' => 'Ban',
            ], [
                'Name' => 'ConversationMessage',
                'ProfileHeadline' => '%1$s sent you a %8$s.',
                'FullHeadline' => '%1$s sent you a %8$s.',
                'Notify' => 1,
            ], [
                'Name' => 'AddedToConversation',
                'ProfileHeadline' => '%1$s added %3$s to a %8$s.',
                'FullHeadline' => '%1$s added %3$s to a %8$s.',
                'RouteCode' => 'conversation',
                'Notify' => 1,
            ], [
                'Name' => 'NewDiscussion',
                'ProfileHeadline' => '%1$s started a %8$s.',
                'FullHeadline' => '%1$s started a %8$s.',
                'RouteCode' => 'discussion',
            ], [
                'Name' => 'NewComment',
                'ProfileHeadline' => '%1$s commented on a discussion.',
                'FullHeadline' => '%1$s commented on a discussion.',
                'RouteCode' => 'discussion',
            ], [
                'Name' => 'DiscussionComment',
                'ProfileHeadline' => '%1$s commented on %4$s %8$s.',
                'FullHeadline' => '%1$s commented on %4$s %8$s.',
                'RouteCode' => 'discussion',
                'Notify' => '1',
            ], [
                'Name' => 'DiscussionMention',
                'ProfileHeadline' => '%1$s mentioned %3$s in a %8$s.',
                'FullHeadline' => '%1$s mentioned %3$s in a %8$s.',
                'RouteCode' => 'discussion',
                'Notify' => '1',
            ], [
                'Name' => 'CommentMention',
                'ProfileHeadline' => '%1$s mentioned %3$s in a %8$s.',
                'FullHeadline' => '%1$s mentioned %3$s in a %8$s.',
                'RouteCode' => 'comment',
                'Notify' => '1',
            ], [
                'Name' => 'BookmarkComment',
                'ProfileHeadline' => '%1$s commented on your %8$s.',
                'FullHeadline' => '%1$s commented on your %8$s.',
                'RouteCode' => 'bookmarked discussion',
                'Notify' => '1',
            ], [
                'Name' => 'Discussion',
            ], [
                'Name' => 'Comment',
            ]], /* }}} */
            /* {{{ */'GDN_Category' => [[
                'CategoryID' => -1,
                'Name' => 'Root',
                'UrlCode' => 'root',
                'Description' => 'Root of category tree. Users should never see this.',
            ]], /* }}} */
            /* {{{ */'GDN_User' => [[
                'Name' => \Config::get('mail.from.name'),
                'Password' => Hash::make(str_random(64)),
                'HashMethod' => 'Random',
                'Email' => \Config::get('mail.from.address'),
                'ShowEmail' => false,
            ]] /* }}} */
        ];
    }
}
