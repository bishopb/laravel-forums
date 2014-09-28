<?php

use Illuminate\Database\Migrations\Migration;

class SeedBaseVanillaTables extends Migration
{
    /**
     * Add the seeded data.
     */
	public function up()
	{
        // we will have some crazy ID values, cajole MySQL into accepting them
        $grammar = Schema::getConnection()->getSchemaGrammar();
        if ($grammar instanceof \Illuminate\Database\Schema\Grammars\MySqlGrammar) {
            DB::statement('SET SESSION SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";');
        }

        // do the seeding
        DB::beginTransaction();
        foreach ($this->getSeedData() as $table => $rows) {
            // Note: each row may have different columns: can't use bulk insert
            foreach ($rows as $row) {
                $this->insertRow($table, $row);
            }
        }
        DB::commit();
	}

    /**
     * Remove the seeded data.
     */
	public function down()
	{
        foreach (array_reverse(array_keys($this->getSeedData())) as $table) {
            DB::table($table)->delete();
        }
	}

    /**
     * Insert a row of data into a table.
     */
    protected function insertRow($table, array $row)
    {
        // permissions table has columns named like `foo.bar.baz`
        // seriously, you can't make this stuff up.
        if ('GDN_Permission' == $table) {
            $sql = sprintf(
                'INSERT INTO %s (%s) VALUES (%s)',
                "`$table`",
                implode(',', array_map(
                    function ($column) {
                        return "`$column`";
                    },
                    array_keys($row)
                )),
                implode(',', array_map(
                    function ($value) {
                        return '"' . $value . '"';
                    },
                    array_values($row)
                ))
            );
            DB::statement($sql);
        } else {
            DB::table($table)->insert($row);
        }
    }

    /**
     * Give me the seed data.
     */
    protected function getSeedData()
    {
        $systemUserId = 0;
        $dateInserted = date('Y-m-d H:i:s');
        $theIpAddress = \Request::getClientIp();
        $systemName   = \Config::get('mail.from.name', false);
        $systemEmail  = \Config::get('mail.from.address', false);

        // if we don't have settings from the app, fall back to what Vanilla does
        if (empty($systemName)) {
            $systemName = \Config::get('forum:mail.from.name', 'System');
        }
        if (empty($systemEmail)) {
            $systemEmail = \Config::get('forum:mail.from.address', 'system@domain.com');
        }

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
                'TreeLeft' => 1,
                'TreeRight' => 4,
                'Name' => 'Root',
                'UrlCode' => 'root',
                'Description' => 'Root of category tree. Users should never see this.',
                'InsertUserID' => $systemUserId,
                'UpdateUserID' => $systemUserId,
                'DateInserted' => $dateInserted,
                'DateUpdated' => $dateInserted,
            ],[
                'CategoryID' => 1,
                'TreeLeft' => 2,
                'TreeRight' => 3,
                'Name' => 'General discussions',
                'UrlCode' => 'general',
                'Description' => 'Assorted discussions on topics of general interest.',
                'InsertUserID' => $systemUserId,
                'UpdateUserID' => $systemUserId,
                'DateInserted' => $dateInserted,
                'DateUpdated' => $dateInserted,
            ]], /* }}} */
            /* {{{ */'GDN_Role' => [[
                'RoleID' => 2,
                'Name' => 'Guest',
                'Description' => 'Guests can only view content. Anyone browsing the site who is not signed in is considered to be a "Guest".',
                'Sort' => 1,
            ], [
                'RoleID' => 3,
                'Name' => 'Unconfirmed',
                'Description' => 'Users must confirm their emails before becoming full members. They get assigned to this role.',
                'Sort' => 2,
                'CanSession' => 1,
            ], [
                'RoleID' => 4,
                'Name' => 'Applicant',
                'Description' => 'Users who have applied for membership, but have not yet been accepted. They have the same permissions as guests.',
                'Sort' => 3,
                'CanSession' => 1,
            ], [
                'RoleID' => 8,
                'Name' => 'Member',
                'Description' => 'Members can participate in discussions.',
                'Sort' => 4,
                'Deletable' => 1,
                'CanSession' => 1,
            ], [
                'RoleID' => 16,
                'Name' => 'Administrator',
                'Description' => 'Administrators have permission to do anything.',
                'Sort' => 6,
                'Deletable' => 1,
                'CanSession' => 1,
            ], [
                'RoleID' => 32,
                'Name' => 'Moderator',
                'Description' => 'Moderators have permission to edit most content.',
                'Sort' => 5,
                'CanSession' => 1,
            ]], /* }}} */
            /* {{{ */'GDN_Permission' => [[
                'PermissionID' => 1,
                'Garden.Email.View' => 3,
                'Garden.Settings.Manage' => 2,
                'Garden.Settings.View' => 2,
                'Garden.Messages.Manage' => 2,
                'Garden.SignIn.Allow' => 3,
                'Garden.Users.Add' => 2,
                'Garden.Users.Edit' => 2,
                'Garden.Users.Delete' => 2,
                'Garden.Users.Approve' => 2,
                'Garden.Activity.Delete' => 2,
                'Garden.Activity.View' => 3,
                'Garden.Profiles.View' => 3,
                'Garden.Profiles.Edit' => 3,
                'Garden.Moderation.Manage' => 2,
                'Garden.AdvancedNotifications.Allow' => 2,
                'Conversations.Moderation.Manage' => 2,
                'Conversations.Conversations.Add' => 3,
                'Vanilla.Approval.Require' => 2,
                'Vanilla.Comments.Me' => 3,
            ],[
                'PermissionID' => 2,
                'RoleID' => 2,
                'Garden.Activity.View' => 1,
                'Garden.Profiles.View' => 1,
                'Vanilla.Comments.Me' => 1,
                'Vanilla.Discussions.View' => 1,
            ],[
                'PermissionID' => 3,
                'RoleID' => 3,
                'Garden.Email.View' => 1,
                'Garden.SignIn.Allow' => 1,
                'Garden.Activity.View' => 1,
                'Garden.Profiles.View' => 1,
                'Vanilla.Comments.Me' => 1,
            ],[
                'PermissionID' => 4,
                'RoleID' => 4,
                'Garden.Email.View' => 1,
                'Garden.SignIn.Allow' => 1,
                'Garden.Activity.View' => 1,
                'Garden.Profiles.View' => 1,
                'Vanilla.Comments.Me' => 1,
                'Vanilla.Discussions.View' => 1,
            ],[
                'PermissionID' => 5,
                'RoleID' => 8,
                'Garden.Email.View' => 1,
                'Garden.SignIn.Allow' => 1,
                'Garden.Activity.View' => 1,
                'Garden.Profiles.View' => 1,
                'Garden.Profiles.Edit' => 1,
                'Conversations.Conversations.Add' => 1,
                'Vanilla.Comments.Me' => 1,
                'Vanilla.Discussions.View' => 1,
                'Vanilla.Discussions.Add' => 1,
                'Vanilla.Comments.Add' => 1,
            ],[
                'PermissionID' => 6,
                'RoleID' => 32,
                'Garden.Email.View' => 1,
                'Garden.SignIn.Allow' => 1,
                'Garden.Activity.View' => 1,
                'Garden.Profiles.View' => 1,
                'Garden.Profiles.Edit' => 1,
                'Garden.Curation.Manage' => 1,
                'Garden.Moderation.Manage' => 1,
                'Conversations.Conversations.Add' => 1,
                'Vanilla.Comments.Me' => 1,
                'Vanilla.Discussions.View' => 1,
                'Vanilla.Discussions.Add' => 1,
                'Vanilla.Discussions.Edit' => 1,
                'Vanilla.Discussions.Announce' => 1,
                'Vanilla.Discussions.Sink' => 1,
                'Vanilla.Discussions.Close' => 1,
                'Vanilla.Discussions.Delete' => 1,
                'Vanilla.Comments.Add' => 1,
                'Vanilla.Comments.Edit' => 1,
                'Vanilla.Comments.Delete' => 1,
            ],[
                'PermissionID' => 7,
                'RoleID' => 16,
                'Garden.Email.View' => 1,
                'Garden.Settings.Manage' => 1,
                'Garden.SignIn.Allow' => 1,
                'Garden.Users.Add' => 1,
                'Garden.Users.Edit' => 1,
                'Garden.Users.Delete' => 1,
                'Garden.Users.Approve' => 1,
                'Garden.Activity.Delete' => 1,
                'Garden.Activity.View' => 1,
                'Garden.Profiles.View' => 1,
                'Garden.Profiles.Edit' => 1,
                'Garden.Curation.Manage' => 1,
                'Garden.Moderation.Manage' => 1,
                'Garden.AdvancedNotifications.Allow' => 1,
                'Conversations.Conversations.Add' => 1,
                'Vanilla.Comments.Me' => 1,
                'Vanilla.Discussions.View' => 1,
                'Vanilla.Discussions.Add' => 1,
                'Vanilla.Discussions.Edit' => 1,
                'Vanilla.Discussions.Announce' => 1,
                'Vanilla.Discussions.Sink' => 1,
                'Vanilla.Discussions.Close' => 1,
                'Vanilla.Discussions.Delete' => 1,
                'Vanilla.Comments.Add' => 1,
                'Vanilla.Comments.Edit' => 1,
                'Vanilla.Comments.Delete' => 1,
            ],[
                'PermissionID' => 8,
                'JunctionTable' => 'Category',
                'JunctionColumn' => 'PermissionCategoryID',
                'Vanilla.Discussions.View' => 3,
                'Vanilla.Discussions.Add' => 3,
                'Vanilla.Discussions.Edit' => 2,
                'Vanilla.Discussions.Announce' => 2,
                'Vanilla.Discussions.Sink' => 2,
                'Vanilla.Discussions.Close' => 2,
                'Vanilla.Discussions.Delete' => 2,
                'Vanilla.Comments.Add' => 3,
                'Vanilla.Comments.Edit' => 2,
                'Vanilla.Comments.Delete' => 2,
            ],[
                'PermissionID' => 9,
                'RoleID' => 2,
                'JunctionTable' => 'Category',
                'JunctionColumn' => 'PermissionCategoryID',
                'JunctionID' => -1,
                'Vanilla.Discussions.View' => 1,
            ],[
                'PermissionID' => 10,
                'RoleID' => 4,
                'JunctionTable' => 'Category',
                'JunctionColumn' => 'PermissionCategoryID',
                'JunctionID' => -1,
                'Vanilla.Discussions.View' => 1,
            ],[
                'PermissionID' => 11,
                'RoleID' => 8,
                'JunctionTable' => 'Category',
                'JunctionColumn' => 'PermissionCategoryID',
                'JunctionID' => -1,
                'Vanilla.Discussions.View' => 1,
                'Vanilla.Discussions.Add' => 1,
                'Vanilla.Comments.Add' => 1,
            ],[
                'PermissionID' => 12,
                'RoleID' => 32,
                'JunctionTable' => 'Category',
                'JunctionColumn' => 'PermissionCategoryID',
                'JunctionID' => -1,
                'Vanilla.Discussions.View' => 1,
                'Vanilla.Discussions.Add' => 1,
                'Vanilla.Discussions.Edit' => 1,
                'Vanilla.Discussions.Announce' => 1,
                'Vanilla.Discussions.Sink' => 1,
                'Vanilla.Discussions.Close' => 1,
                'Vanilla.Discussions.Delete' => 1,
                'Vanilla.Comments.Add' => 1,
                'Vanilla.Comments.Edit' => 1,
                'Vanilla.Comments.Delete' => 1,
            ],[
                'PermissionID' => 13,
                'RoleID' => 16,
                'JunctionTable' => 'Category',
                'JunctionColumn' => 'PermissionCategoryID',
                'JunctionID' => -1,
                'Vanilla.Discussions.View' => 1,
                'Vanilla.Discussions.Add' => 1,
                'Vanilla.Discussions.Edit' => 1,
                'Vanilla.Discussions.Announce' => 1,
                'Vanilla.Discussions.Sink' => 1,
                'Vanilla.Discussions.Close' => 1,
                'Vanilla.Discussions.Delete' => 1,
                'Vanilla.Comments.Add' => 1,
                'Vanilla.Comments.Edit' => 1,
                'Vanilla.Comments.Delete' => 1,
            ]],/* }}} */
            /* {{{ */'GDN_User' => [[
                'UserID' => $systemUserId,
                'Name' => $systemName,
                'Password' => str_random(64),
                'HashMethod' => 'Random',
                'Email' => $systemEmail,
                'ShowEmail' => true,
                'DateInserted' => $dateInserted,
                'InsertIPAddress' => $theIpAddress,
                'DateUpdated' => $dateInserted,
                'UpdateIPAddress' => $theIpAddress,
            ]], /* }}} */
        ];
    }
}
