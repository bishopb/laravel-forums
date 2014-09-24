<?php

namespace BishopB\Vfl;

/**
 * Seed the initial Vanilla data.
 * Should follow immediately after migrating the Vanilla schema.
 */
class VanillaSeeder extends \Seeder
{
	public function run()
	{
        $this->seed_activity_type_table();
        $this->seed_category_table();
	}

    // protected API
    protected function seed_activity_type()
    {
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'SignIn',
            'ProfileHeadline' => '%1$s signed in.',
            'FullHeadline' => '%1$s signed in.'
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Join',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s joined.',
            'FullHeadline' => '%1$s joined.'
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'JoinInvite',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s accepted %4$s invitation for membership.',
            'FullHeadline' => '%1$s accepted %4$s invitation for membership.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'JoinApproved',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s approved %4$s membership application.',
            'FullHeadline' => '%1$s approved %4$s membership application.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'JoinCreated',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s created an account for %3$s.',
            'FullHeadline' => '%1$s created an account for %3$s.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'AboutUpdate',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s updated %6$s profile.',
            'FullHeadline' => '%1$s updated %6$s profile.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'WallComment',
            'AllowComments' => 1,
            'ShowIcon' => 1,
            'ProfileHeadline' => '%1$s wrote:',
            'FullHeadline' => '%1$s wrote on %4$s %5$s.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'PictureChange',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s changed %6$s profile picture.',
            'FullHeadline' => '%1$s changed %6$s profile picture.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'RoleChange',
            'AllowComments' => 1,
            'ProfileHeadline' => '%1$s changed %4$s permissions.',
            'FullHeadline' => '%1$s changed %4$s permissions.',
            'Notify' => 1,
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'ActivityComment',
            'ShowIcon' => 1,
            'ProfileHeadline' => '%1$s',
            'FullHeadline' => '%1$s comentd on %4$s %8$s.',
            'RouteCode' => 'activity',
            'Notify' => 1,
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Import',
            'ProfileHeadline' => '%1$s imported data.',
            'FullHeadline' => '%1$s imported data.',
            'Notify' => 1,
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Banned',
            'ProfileHeadline' => '%1$s banned %3$s.',
            'FullHeadline' => '%1$s banned %3$s.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Unbanned',
            'ProfileHeadline' => '%1$s un-banned %3$s.',
            'FullHeadline' => '%1$s un-banned %3$s.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Applicant',
            'ProfileHeadline' => '%1$s applied for membership.',
            'FullHeadline' => '%1$s applied for membership.',
            'Notify' => 1,
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'WallPost',
            'AllowComments' => 1,
            'ShowIcon' => 1,
            'ProfileHeadline' => '%1$s wrote:',
            'FullHeadline' => '%1$s wrote on %2$s %5$s.',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Default',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Registration',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Status',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Ban',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'ConversationMessage',
            'ProfileHeadline' => '%1$s sent you a %8$s.',
            'FullHeadline' => '%1$s sent you a %8$s.',
            'Notify' => 1,
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'AddedToConversation',
            'ProfileHeadline' => '%1$s added %3$s to a %8$s.',
            'FullHeadline' => '%1$s added %3$s to a %8$s.',
            'RouteCode' => 'conversation',
            'Notify' => 1,
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'NewDiscussion',
            'ProfileHeadline' => '%1$s started a %8$s.',
            'FullHeadline' => '%1$s started a %8$s.',
            'RouteCode' => 'discussion',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'NewComment',
            'ProfileHeadline' => '%1$s commented on a discussion.',
            'FullHeadline' => '%1$s commented on a discussion.',
            'RouteCode' => 'discussion',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'DiscussionComment',
            'ProfileHeadline' => '%1$s commented on %4$s %8$s.',
            'FullHeadline' => '%1$s commented on %4$s %8$s.',
            'RouteCode' => 'discussion',
            'Notify' => '1',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'DiscussionMention',
            'ProfileHeadline' => '%1$s mentioned %3$s in a %8$s.',
            'FullHeadline' => '%1$s mentioned %3$s in a %8$s.',
            'RouteCode' => 'discussion',
            'Notify' => '1',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'CommentMention',
            'ProfileHeadline' => '%1$s mentioned %3$s in a %8$s.',
            'FullHeadline' => '%1$s mentioned %3$s in a %8$s.',
            'RouteCode' => 'comment',
            'Notify' => '1',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'BookmarkComment',
            'ProfileHeadline' => '%1$s commented on your %8$s.',
            'FullHeadline' => '%1$s commented on your %8$s.',
            'RouteCode' => 'bookmarked discussion',
            'Notify' => '1',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Discussion',
        ]);
        \BishopB\Vfl\ActivityType::create([
            'Name' => 'Comment',
        ]);
    }

    protected function seed_category_table()
    {
        $now = new \DateTime();
        \BishopB\Vfl\Category::create([
            'CategoryID' => -1, 'Name' => 'Root', 'UrlCode' => 'root',
            'Description' => 'Root of category tree. Users should never see this.',
            'DateInserted' => $now, 'DateUpdated' => $now,
        ]);
    }
}
