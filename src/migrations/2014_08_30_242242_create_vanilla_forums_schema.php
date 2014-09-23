<?php

/**
 * Create the Vanilla schema.
 *
 * Requires a MySQL connection.
 */
class CreateVanillaForumsSchema extends \Illuminate\Database\Migrations\Migration
{
	public function up()
	{
        /* {{{ */ Schema::create('GDN_Activity', function (Blueprint $t) {
            $t->increments('ActivityID');

            $t->integer   ('ActivityTypeID');
            $t->integer   ('NotifyUserID')                   ->default(0);
            $t->integer   ('ActivityUserID')     ->nullable()->default(null);
            $t->integer   ('RegardingUserID')    ->nullable()->default(null);
            $t->string    ('Photo', 255)         ->nullable()->default(null);
            $t->string    ('HeadlineFormat', 255)->nullable()->default(null);
            $t->text      ('Story')              ->nullable();
            $t->string    ('Format', 10)         ->nullable()->default(null);
            $t->string    ('Route', 255)         ->nullable()->default(null);
            $t->string    ('RecordType', 20)     ->nullable()->default(null);
            $t->integer   ('RecordID')           ->nullable()->default(null);
            $t->integer   ('InsertUserID')       ->nullable()->default(null);
            $t->date      ('DateInserted');
            $t->string    ('InsertIPAddress', 15)->nullable()->default(null);
            $t->date      ('DateUpdated')        ->nullable()->default(null);
            $t->integer   ('Notified')                       ->default(0);
            $t->integer   ('Emailed')                        ->default(0);
            $t->text      ('Data');

            $t->index     (['NotifyUserID', 'Notified']);
            $t->index     (['NotifyUserID', 'DateUpdated']);
            $t->index     (['NotifyUserID', 'ActivityUserID', 'DateUpdated']);
            $t->index     ('DateUpdated');

            $t->foreign   ('InsertUserID')->references(FIXME)->on(FIXME);
        }); /* }}} */
        /* {{{ */ Schema::create('GDN_ActivityComment', function (Blueprint $t) {
            $t->increments('ActivityCommentID');

            $t->integer   ('ActivityID');
            $t->text      ('Body');
            $t->string    ('Format', 20);
            $t->integer   ('InsertUserID');
            $t->date      ('DateInserted');
            $t->string    ('InsertIPAddress', 15)->nullable()->default(null);

            $t->foreign   ('ActivityID')->references('ActivityID')->on('GDN_Activity');
        }); /* }}} */
        /* {{{ */ Schema::create('GDN_ActivityType', function (Blueprint $t) {
            $t->increments('ActivityTypeID');
            $t->string    ('Name', 20);
            $t->integer   ('AllowComments')                   ->default(0);
            $t->integer   ('ShowIcon')                        ->default(0);
            $t->string    ('ProfileHeadline', 255)->nullable()->default(null);
            $t->string    ('FullHeadline', 255)   ->nullable()->default(null);
            $t->string    ('RouteCode', 255)      ->nullable()->default(null);
            $t->integer   ('Notify')                          ->default(0);
            $t->integer   ('Public')                          ->default(1);
        }); /* }}} */
        /* {{{ */ Schema::create('GDN_AnalyticsLocal', function (Blueprint $t) {
            $t->string ('TimeSlot', 8);
            $t->integer('Views')     ->nullable()->default(null);
            $t->integer('EmbedViews')->nullable()->default(null);

            $t->unique ('TimeSlot');
        }); /* }}} */
        /* {{{ */ Schema::create('GDN_Attachment', function (Blueprint $t) {
            $t->increments('AttachmentID');
            $t->string    ('Type', 64);
            $t->string    ('ForeignID', 50);
            $t->integer   ('ForeignUserID');
            $t->string    ('Source', 64);
            $t->string    ('SourceID', 32);
            $t->string    ('SourceURL', 255);
            $t->text      ('Attributes');
            $t->date      ('DateInserted');
            $t->integer   ('InsertUserID');
            $t->string    ('InsertIPAddress', 64);
            $t->date      ('DateUpdated')        ->nullable()->default(null);
            $t->integer   ('UpdateUserID')       ->nullable()->default(null);
            $t->string    ('UpdateIPAddress', 15)->nullable()->default(null);

            $t->index     ('ForeignID');
            $t->foreign   ('ForeignUserID')->references(FIXME)->on(FIXME);
            $t->foreign   ('InsertUserID')->references(FIXME)->on(FIXME);
        }); /* }}} */
        /* {{{ */ Schema::create('GDN_Ban', function (Blueprint $t) {
            $t->increments('BanID');
            $t->enum      ('BanType', ['IPAddress', 'Name', 'Email');
            $t->string    ('BanValue', 50);
            $t->string    ('Notes', 255)               ->nullable()->default(null);
            $t->integer   ('CountUsers')                           ->default(0);
            $t->integer   ('CountBlockedRegistrations')            ->default(0);
            $t->integer   ('InsertUserID');
            $t->date      ('DateInserted');

            $t->unique    (['BanType', 'BanValue']);
        }); /* }}} */
        /* {{{ */ Schema::create('GDN_Category', function (Blueprint $t) {
            $t->increments('CategoryID');

            $t->integer   ('ParentCategoryID')           ->nullable()->default(null);
            $t->integer   ('TreeLeft')                   ->nullable()->default(null);
            $t->integer   ('TreeRight')                  ->nullable()->default(null);
            $t->integer   ('Depth')                      ->nullable()->default(null);
            $t->integer   ('CountDiscussions')                       ->default(0);
            $t->integer   ('CountComments')                          ->default(0);
            $t->date      ('DateMarkedRead')             ->nullable()->default(null);
            $t->integer   ('AllowDiscussions')                       ->default(1);
            $t->integer   ('Archived')                               ->default(0);
            $t->string    ('Name', 255);
            $t->string    ('UrlCode', 255)               ->nullable()->default(null);
            $t->string    ('Description', 500)           ->nullable()->default(null);
            $t->integer   ('Sort')                       ->nullable()->default(null);
            $t->string    ('CssClass', 50)               ->nullable()->default(null);
            $t->string    ('Photo', 255)                 ->nullable()->default(null);
            $t->integer   ('PermissionCategoryID')                   ->default(-1);
            $t->integer   ('PointsCategoryID')                       ->default(0);
            $t->integer   ('HideAllDiscussions')                     ->default(0);
            $t->enum      (
                'DisplayAs',
                ['Categories', 'Discussions', 'Default']
            )                                                        ->default('Default');
            $t->integer   ('InsertUserID');
            $t->integer   ('UpdateUserID')               ->nullable()->default(null);
            $t->date      ('DateInserted');
            $t->date      ('DateUpdated');
            $t->integer   ('LastCommentID')              ->nullable()->default(null);
            $t->integer   ('LastDiscussionID')           ->nullable()->default(null);
            $t->date      ('LastDateInserted')           ->nullable()->default(null);
            $t->string    ('AllowedDiscussionTypes', 255)->nullable()->default(null);
            $t->string    ('DefaultDiscussionType', 10)  ->nullable()->default(null);

            $t->foreign   ('InsertUserID')->references(FIXME)->on(FIXME);
        }); /* }}} */

INSERT INTO `GDN_Category` VALUES (-1,NULL,1,4,NULL,0,0,NULL,1,0,'Root','root','Root of category tree. Users should never see this.',NULL,NULL,NULL,-1,0,0,'Default',1,1,'2014-09-23 01:07:09','2014-09-23 01:07:09',NULL,NULL,NULL,NULL,NULL),(1,-1,2,3,NULL,1,1,NULL,1,0,'General','general','General discussions',NULL,NULL,NULL,-1,0,0,'Default',1,1,'2014-09-23 01:07:09','2014-09-23 01:07:09',1,1,NULL,NULL,NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Comment` (
  `CommentID` int(11) NOT NULL AUTO_INCREMENT,
  `DiscussionID` int(11) NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `DeleteUserID` int(11) DEFAULT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime DEFAULT NULL,
  `DateDeleted` datetime DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Flag` tinyint(4) NOT NULL DEFAULT '0',
  `Score` float DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`CommentID`),
  KEY `IX_Comment_1` (`DiscussionID`,`DateInserted`),
  KEY `IX_Comment_DateInserted` (`DateInserted`),
  KEY `FK_Comment_InsertUserID` (`InsertUserID`),
  FULLTEXT KEY `TX_Comment` (`Body`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_Comment` VALUES (1,1,2,NULL,NULL,'This is the first comment on your site and it&rsquo;s an important one.\n\nDon&rsquo;t see your must-have feature? We keep Vanilla nice and simple by default. Use <b>addons</b> to get the special sauce your community needs.\n\nNot sure which addons to enable? Our favorites are Button Bar and Tagging. They&rsquo;re almost always a great start.','Html','2014-09-23 01:07:09',NULL,NULL,NULL,NULL,0,NULL,NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Conversation` (
  `ConversationID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ForeignID` varchar(40) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Subject` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Contributors` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FirstMessageID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime DEFAULT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CountMessages` int(11) NOT NULL DEFAULT '0',
  `CountParticipants` int(11) NOT NULL DEFAULT '0',
  `LastMessageID` int(11) DEFAULT NULL,
  `RegardingID` int(11) DEFAULT NULL,
  PRIMARY KEY (`ConversationID`),
  KEY `IX_Conversation_Type` (`Type`),
  KEY `IX_Conversation_RegardingID` (`RegardingID`),
  KEY `FK_Conversation_FirstMessageID` (`FirstMessageID`),
  KEY `FK_Conversation_InsertUserID` (`InsertUserID`),
  KEY `FK_Conversation_DateInserted` (`DateInserted`),
  KEY `FK_Conversation_UpdateUserID` (`UpdateUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_ConversationMessage` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `ConversationID` int(11) NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`MessageID`),
  KEY `FK_ConversationMessage_ConversationID` (`ConversationID`),
  KEY `FK_ConversationMessage_InsertUserID` (`InsertUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Discussion` (
  `DiscussionID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ForeignID` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CategoryID` int(11) NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `FirstCommentID` int(11) DEFAULT NULL,
  `LastCommentID` int(11) DEFAULT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` text COLLATE utf8_unicode_ci,
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `CountBookmarks` int(11) DEFAULT NULL,
  `CountViews` int(11) NOT NULL DEFAULT '1',
  `Closed` tinyint(4) NOT NULL DEFAULT '0',
  `Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Sink` tinyint(4) NOT NULL DEFAULT '0',
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateLastComment` datetime DEFAULT NULL,
  `LastCommentUserID` int(11) DEFAULT NULL,
  `Score` float DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  `RegardingID` int(11) DEFAULT NULL,
  PRIMARY KEY (`DiscussionID`),
  KEY `IX_Discussion_Type` (`Type`),
  KEY `IX_Discussion_ForeignID` (`ForeignID`),
  KEY `IX_Discussion_DateInserted` (`DateInserted`),
  KEY `IX_Discussion_DateLastComment` (`DateLastComment`),
  KEY `IX_Discussion_RegardingID` (`RegardingID`),
  KEY `IX_Discussion_CategoryPages` (`CategoryID`,`DateLastComment`),
  KEY `IX_Discussion_CategoryInserted` (`CategoryID`,`DateInserted`),
  KEY `FK_Discussion_InsertUserID` (`InsertUserID`),
  FULLTEXT KEY `TX_Discussion` (`Name`,`Body`)
) ENGINE=MyISAM AUTO_INCREMENT=2 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_Discussion` VALUES (1,NULL,'stub',1,2,NULL,NULL,1,'BAM! You&rsquo;ve got a sweet forum','There&rsquo;s nothing sweeter than a fresh new forum, ready to welcome your community. A Vanilla Forum has all the bits and pieces you need to build an awesome discussion platform customized to your needs. Here&rsquo;s a few tips:\n<ul>\n   <li>Use the <a href=\"/dashboard/settings/gettingstarted\">Getting Started</a> list in the Dashboard to configure your site.</li>\n   <li>Don&rsquo;t use too many categories. We recommend 3-8. Keep it simple!</li>\n   <li>&ldquo;Announce&rdquo; a discussion (click the gear) to stick to the top of the list, and &ldquo;Close&rdquo; it to stop further comments.</li>\n   <li>Use &ldquo;Sink&rdquo; to take attention away from a discussion. New comments will no longer bring it back to the top of the list.</li>\n   <li>Bookmark a discussion (click the star) to get notifications for new comments. You can edit notification settings from your profile.</li>\n</ul>\nGo ahead and edit or delete this discussion, then spread the word to get this place cooking. Cheers!','Html',NULL,1,NULL,1,0,0,0,'2014-09-23 01:07:09',NULL,NULL,NULL,'2014-09-23 01:07:09',2,NULL,NULL,NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Draft` (
  `DraftID` int(11) NOT NULL AUTO_INCREMENT,
  `DiscussionID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `UpdateUserID` int(11) NOT NULL,
  `Name` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Tags` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Closed` tinyint(4) NOT NULL DEFAULT '0',
  `Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Sink` tinyint(4) NOT NULL DEFAULT '0',
  `Body` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`DraftID`),
  KEY `FK_Draft_DiscussionID` (`DiscussionID`),
  KEY `FK_Draft_CategoryID` (`CategoryID`),
  KEY `FK_Draft_InsertUserID` (`InsertUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Invitation` (
  `InvitationID` int(11) NOT NULL AUTO_INCREMENT,
  `Email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RoleIDs` text COLLATE utf8_unicode_ci,
  `Code` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `AcceptedUserID` int(11) DEFAULT NULL,
  `DateExpires` datetime DEFAULT NULL,
  PRIMARY KEY (`InvitationID`),
  UNIQUE KEY `UX_Invitation` (`Code`),
  KEY `IX_Invitation_Email` (`Email`),
  KEY `IX_Invitation_userdate` (`InsertUserID`,`DateInserted`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Log` (
  `LogID` int(11) NOT NULL AUTO_INCREMENT,
  `Operation` enum('Delete','Edit','Spam','Moderate','Pending','Ban','Error') COLLATE utf8_unicode_ci NOT NULL,
  `RecordType` enum('Discussion','Comment','User','Registration','Activity','ActivityComment','Configuration','Group') COLLATE utf8_unicode_ci NOT NULL,
  `TransactionLogID` int(11) DEFAULT NULL,
  `RecordID` int(11) DEFAULT NULL,
  `RecordUserID` int(11) DEFAULT NULL,
  `RecordDate` datetime NOT NULL,
  `RecordIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `OtherUserIDs` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `ParentRecordID` int(11) DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `Data` mediumtext COLLATE utf8_unicode_ci,
  `CountGroup` int(11) DEFAULT NULL,
  PRIMARY KEY (`LogID`),
  KEY `IX_Log_Operation` (`Operation`),
  KEY `IX_Log_RecordType` (`RecordType`),
  KEY `IX_Log_RecordID` (`RecordID`),
  KEY `IX_Log_RecordIPAddress` (`RecordIPAddress`),
  KEY `IX_Log_ParentRecordID` (`ParentRecordID`),
  KEY `FK_Log_CategoryID` (`CategoryID`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_Log` VALUES (1,'Edit','Configuration',NULL,NULL,NULL,'2014-09-23 01:07:09',NULL,1,'2014-09-23 01:07:09','192.168.242.1','',NULL,NULL,NULL,'a:1:{s:4:\"_New\";a:7:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:8:\"2.2.16.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:7:\"vanilla\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:9:\"Vanilla 2\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:10:\"WK6XWGC2H6\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:1:{s:11:\"SupportName\";s:9:\"Vanilla 2\";}s:14:\"InputFormatter\";s:4:\"Html\";s:7:\"Version\";s:8:\"2.2.16.1\";s:11:\"RewriteUrls\";b:0;s:16:\"CanProcessImages\";b:1;s:12:\"SystemUserID\";s:1:\"2\";s:9:\"Installed\";b:1;}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:8:\"2.2.16.1\";}}}',NULL),(2,'Edit','Configuration',NULL,NULL,NULL,'2014-09-23 01:07:15',NULL,1,'2014-09-23 01:07:15','192.168.242.1','',NULL,NULL,NULL,'a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:8:\"2.2.16.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:7:\"vanilla\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:9:\"Vanilla 2\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:10:\"WK6XWGC2H6\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:1:{s:11:\"SupportName\";s:9:\"Vanilla 2\";}s:14:\"InputFormatter\";s:4:\"Html\";s:7:\"Version\";s:8:\"2.2.16.1\";s:11:\"RewriteUrls\";b:0;s:16:\"CanProcessImages\";b:1;s:12:\"SystemUserID\";s:1:\"2\";s:9:\"Installed\";b:1;}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:8:\"2.2.16.1\";}s:4:\"_New\";a:8:{s:13:\"Conversations\";a:1:{s:7:\"Version\";s:8:\"2.2.16.1\";}s:8:\"Database\";a:4:{s:4:\"Name\";s:7:\"vanilla\";s:4:\"Host\";s:9:\"localhost\";s:4:\"User\";s:4:\"root\";s:8:\"Password\";s:0:\"\";}s:19:\"EnabledApplications\";a:2:{s:13:\"Conversations\";s:13:\"conversations\";s:7:\"Vanilla\";s:7:\"vanilla\";}s:14:\"EnabledPlugins\";a:2:{s:14:\"GettingStarted\";s:14:\"GettingStarted\";s:8:\"HtmLawed\";s:8:\"HtmLawed\";}s:6:\"Garden\";a:10:{s:5:\"Title\";s:9:\"Vanilla 2\";s:6:\"Cookie\";a:2:{s:4:\"Salt\";s:10:\"WK6XWGC2H6\";s:6:\"Domain\";s:0:\"\";}s:12:\"Registration\";a:1:{s:12:\"ConfirmEmail\";b:1;}s:5:\"Email\";a:1:{s:11:\"SupportName\";s:9:\"Vanilla 2\";}s:14:\"InputFormatter\";s:4:\"Html\";s:7:\"Version\";s:8:\"2.2.16.1\";s:11:\"RewriteUrls\";b:0;s:16:\"CanProcessImages\";b:1;s:12:\"SystemUserID\";s:1:\"2\";s:9:\"Installed\";b:1;}s:7:\"Plugins\";a:1:{s:14:\"GettingStarted\";a:1:{s:9:\"Dashboard\";s:1:\"1\";}}s:6:\"Routes\";a:1:{s:17:\"DefaultController\";s:11:\"discussions\";}s:7:\"Vanilla\";a:1:{s:7:\"Version\";s:8:\"2.2.16.1\";}}}',NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Media` (
  `MediaID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Path` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Type` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Size` int(11) NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `ForeignID` int(11) DEFAULT NULL,
  `ForeignTable` varchar(24) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ImageWidth` smallint(5) unsigned DEFAULT NULL,
  `ImageHeight` smallint(5) unsigned DEFAULT NULL,
  `ThumbWidth` smallint(5) unsigned DEFAULT NULL,
  `ThumbHeight` smallint(5) unsigned DEFAULT NULL,
  `ThumbPath` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  PRIMARY KEY (`MediaID`),
  KEY `IX_Media_Foreign` (`ForeignID`,`ForeignTable`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Message` (
  `MessageID` int(11) NOT NULL AUTO_INCREMENT,
  `Content` text COLLATE utf8_unicode_ci NOT NULL,
  `Format` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AllowDismiss` tinyint(4) NOT NULL DEFAULT '1',
  `Enabled` tinyint(4) NOT NULL DEFAULT '1',
  `Application` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Controller` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Method` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CategoryID` int(11) DEFAULT NULL,
  `IncludeSubcategories` tinyint(4) NOT NULL DEFAULT '0',
  `AssetTarget` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `CssClass` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  PRIMARY KEY (`MessageID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Permission` (
  `PermissionID` int(11) NOT NULL AUTO_INCREMENT,
  `RoleID` int(11) NOT NULL DEFAULT '0',
  `JunctionTable` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `JunctionColumn` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `JunctionID` int(11) DEFAULT NULL,
  `Garden.Email.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Settings.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Settings.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Messages.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.SignIn.Allow` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Users.Approve` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Activity.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Activity.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Profiles.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Profiles.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Curation.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.Moderation.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.PersonalInfo.View` tinyint(4) NOT NULL DEFAULT '0',
  `Garden.AdvancedNotifications.Allow` tinyint(4) NOT NULL DEFAULT '0',
  `Conversations.Moderation.Manage` tinyint(4) NOT NULL DEFAULT '0',
  `Conversations.Conversations.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Approval.Require` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Me` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.View` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Announce` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Sink` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Close` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Discussions.Delete` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Add` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Edit` tinyint(4) NOT NULL DEFAULT '0',
  `Vanilla.Comments.Delete` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`PermissionID`),
  KEY `FK_Permission_RoleID` (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=14 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_Permission` VALUES (1,0,NULL,NULL,NULL,3,2,2,2,3,2,2,2,2,2,3,3,3,0,2,0,2,2,3,2,3,0,0,0,0,0,0,0,0,0,0),(2,2,NULL,NULL,NULL,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0),(3,3,NULL,NULL,NULL,1,0,0,0,1,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0,0),(4,4,NULL,NULL,NULL,1,0,0,0,1,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,0,0,0,0),(5,8,NULL,NULL,NULL,1,0,0,0,1,0,0,0,0,0,1,1,1,0,0,0,0,0,1,0,1,1,1,0,0,0,0,0,1,0,0),(6,32,NULL,NULL,NULL,1,0,0,0,1,0,0,0,0,0,1,1,1,1,1,0,0,0,1,0,1,1,1,1,1,1,1,1,1,1,1),(7,16,NULL,NULL,NULL,1,1,0,0,1,1,1,1,1,1,1,1,1,1,1,0,1,0,1,0,1,1,1,1,1,1,1,1,1,1,1),(8,0,'Category','PermissionCategoryID',NULL,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,3,3,2,2,2,2,2,3,2,2),(9,2,'Category','PermissionCategoryID',-1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0),(10,4,'Category','PermissionCategoryID',-1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,0,0,0,0,0,0,0,0,0),(11,8,'Category','PermissionCategoryID',-1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,0,0,0,0,0,1,0,0),(12,32,'Category','PermissionCategoryID',-1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1),(13,16,'Category','PermissionCategoryID',-1,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,0,1,1,1,1,1,1,1,1,1,1);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Regarding` (
  `RegardingID` int(11) NOT NULL AUTO_INCREMENT,
  `Type` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `ForeignType` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignID` int(11) NOT NULL,
  `OriginalContent` text COLLATE utf8_unicode_ci,
  `ParentType` varchar(32) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ParentID` int(11) DEFAULT NULL,
  `ForeignURL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Comment` text COLLATE utf8_unicode_ci NOT NULL,
  `Reports` int(11) DEFAULT NULL,
  PRIMARY KEY (`RegardingID`),
  KEY `FK_Regarding_Type` (`Type`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Role` (
  `RoleID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(100) COLLATE utf8_unicode_ci NOT NULL,
  `Description` varchar(500) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Sort` int(11) DEFAULT NULL,
  `Deletable` tinyint(4) NOT NULL DEFAULT '1',
  `CanSession` tinyint(4) NOT NULL DEFAULT '1',
  `PersonalInfo` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`RoleID`)
) ENGINE=InnoDB AUTO_INCREMENT=33 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_Role` VALUES (2,'Guest','Guests can only view content. Anyone browsing the site who is not signed in is considered to be a \"Guest\".',1,0,0,0),(3,'Unconfirmed','Users must confirm their emails before becoming full members. They get assigned to this role.',2,0,1,0),(4,'Applicant','Users who have applied for membership, but have not yet been accepted. They have the same permissions as guests.',3,0,1,0),(8,'Member','Members can participate in discussions.',4,1,1,0),(16,'Administrator','Administrators have permission to do anything.',6,1,1,0),(32,'Moderator','Moderators have permission to edit most content.',5,1,1,0);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Session` (
  `SessionID` char(32) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` int(11) NOT NULL DEFAULT '0',
  `DateInserted` datetime NOT NULL,
  `DateUpdated` datetime NOT NULL,
  `TransientKey` varchar(12) COLLATE utf8_unicode_ci NOT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`SessionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Spammer` (
  `UserID` int(11) NOT NULL,
  `CountSpam` smallint(5) unsigned NOT NULL DEFAULT '0',
  `CountDeletedSpam` smallint(5) unsigned NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_Tag` (
  `TagID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `FullName` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Type` varchar(20) COLLATE utf8_unicode_ci NOT NULL DEFAULT '',
  `ParentTagID` int(11) DEFAULT NULL,
  `InsertUserID` int(11) DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `CategoryID` int(11) NOT NULL DEFAULT '-1',
  `CountDiscussions` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`TagID`),
  UNIQUE KEY `UX_Tag` (`Name`,`CategoryID`),
  KEY `IX_Tag_FullName` (`FullName`),
  KEY `IX_Tag_Type` (`Type`),
  KEY `FK_Tag_ParentTagID` (`ParentTagID`),
  KEY `FK_Tag_InsertUserID` (`InsertUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_TagDiscussion` (
  `TagID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `DateInserted` datetime DEFAULT NULL,
  PRIMARY KEY (`TagID`,`DiscussionID`),
  KEY `IX_TagDiscussion_CategoryID` (`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_User` (
  `UserID` int(11) NOT NULL AUTO_INCREMENT,
  `Name` varchar(50) COLLATE utf8_unicode_ci NOT NULL,
  `Password` varbinary(100) NOT NULL,
  `HashMethod` varchar(10) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Photo` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Title` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Location` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `About` text COLLATE utf8_unicode_ci,
  `Email` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `ShowEmail` tinyint(4) NOT NULL DEFAULT '0',
  `Gender` enum('u','m','f') COLLATE utf8_unicode_ci NOT NULL DEFAULT 'u',
  `CountVisits` int(11) NOT NULL DEFAULT '0',
  `CountInvitations` int(11) NOT NULL DEFAULT '0',
  `CountNotifications` int(11) DEFAULT NULL,
  `InviteUserID` int(11) DEFAULT NULL,
  `DiscoveryText` text COLLATE utf8_unicode_ci,
  `Preferences` text COLLATE utf8_unicode_ci,
  `Permissions` text COLLATE utf8_unicode_ci,
  `Attributes` text COLLATE utf8_unicode_ci,
  `DateSetInvitations` datetime DEFAULT NULL,
  `DateOfBirth` datetime DEFAULT NULL,
  `DateFirstVisit` datetime DEFAULT NULL,
  `DateLastActive` datetime DEFAULT NULL,
  `LastIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AllIPAddresses` varchar(100) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdateIPAddress` varchar(15) COLLATE utf8_unicode_ci DEFAULT NULL,
  `HourOffset` int(11) NOT NULL DEFAULT '0',
  `Score` float DEFAULT NULL,
  `Admin` tinyint(4) NOT NULL DEFAULT '0',
  `Confirmed` tinyint(4) NOT NULL DEFAULT '1',
  `Verified` tinyint(4) NOT NULL DEFAULT '0',
  `Banned` tinyint(4) NOT NULL DEFAULT '0',
  `Deleted` tinyint(4) NOT NULL DEFAULT '0',
  `Points` int(11) NOT NULL DEFAULT '0',
  `CountUnreadConversations` int(11) DEFAULT NULL,
  `CountDiscussions` int(11) DEFAULT NULL,
  `CountUnreadDiscussions` int(11) DEFAULT NULL,
  `CountComments` int(11) DEFAULT NULL,
  `CountDrafts` int(11) DEFAULT NULL,
  `CountBookmarks` int(11) DEFAULT NULL,
  PRIMARY KEY (`UserID`),
  KEY `FK_User_Name` (`Name`),
  KEY `IX_User_Email` (`Email`),
  KEY `IX_User_DateLastActive` (`DateLastActive`),
  KEY `IX_User_DateInserted` (`DateInserted`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_User` VALUES (1,'bettini','$2a$08$8RjSjB0MDOV5ef5OxF1RWetcOL4LukJYi6FQBdgW5CvXtA9iJdDVe','Vanilla',NULL,NULL,NULL,NULL,'bettini@3cisd.com',0,'u',0,0,NULL,NULL,NULL,NULL,'a:14:{i:0;s:17:\"Garden.Email.View\";i:1;s:22:\"Garden.Settings.Manage\";i:2;s:19:\"Garden.SignIn.Allow\";i:3;s:16:\"Garden.Users.Add\";i:4;s:17:\"Garden.Users.Edit\";i:5;s:19:\"Garden.Users.Delete\";i:6;s:20:\"Garden.Users.Approve\";i:7;s:22:\"Garden.Activity.Delete\";i:8;s:20:\"Garden.Activity.View\";i:9;s:20:\"Garden.Profiles.View\";i:10;s:20:\"Garden.Profiles.Edit\";i:11;s:22:\"Garden.Curation.Manage\";i:12;s:24:\"Garden.Moderation.Manage\";i:13;s:34:\"Garden.AdvancedNotifications.Allow\";}','a:1:{s:12:\"TransientKey\";s:12:\"IWDB6UL9ZQZD\";}',NULL,'1975-09-16 00:00:00','2014-09-23 01:07:08','2014-09-23 01:07:08','192.168.242.1','192.168.242.1','2014-09-23 01:07:08','192.168.242.1','2014-09-23 01:07:08',NULL,-4,NULL,1,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL),(2,'System','HWWVLCT6WYM431MYQFSL','Random','http://centos-a.guests/applications/dashboard/design/images/usericon.png',NULL,NULL,NULL,'system@domain.com',0,'u',0,0,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,NULL,'2014-09-23 01:07:09',NULL,NULL,NULL,0,NULL,2,1,0,0,0,0,NULL,NULL,NULL,NULL,NULL,NULL);
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserAuthentication` (
  `ForeignUserKey` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `ProviderKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `UserID` int(11) NOT NULL,
  PRIMARY KEY (`ForeignUserKey`,`ProviderKey`),
  KEY `FK_UserAuthentication_UserID` (`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserAuthenticationNonce` (
  `Nonce` varchar(200) COLLATE utf8_unicode_ci NOT NULL,
  `Token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  PRIMARY KEY (`Nonce`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserAuthenticationProvider` (
  `AuthenticationKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `AuthenticationSchemeAlias` varchar(32) COLLATE utf8_unicode_ci NOT NULL,
  `Name` varchar(50) COLLATE utf8_unicode_ci DEFAULT NULL,
  `URL` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AssociationSecret` text COLLATE utf8_unicode_ci,
  `AssociationHashMethod` varchar(20) COLLATE utf8_unicode_ci DEFAULT NULL,
  `AuthenticateUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `RegisterUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SignInUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `SignOutUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `PasswordUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `ProfileUrl` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  `Active` tinyint(4) NOT NULL DEFAULT '1',
  `IsDefault` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`AuthenticationKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserAuthenticationToken` (
  `Token` varchar(128) COLLATE utf8_unicode_ci NOT NULL,
  `ProviderKey` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `ForeignUserKey` varchar(255) COLLATE utf8_unicode_ci DEFAULT NULL,
  `TokenSecret` varchar(64) COLLATE utf8_unicode_ci NOT NULL,
  `TokenType` enum('request','access') COLLATE utf8_unicode_ci NOT NULL,
  `Authorized` tinyint(4) NOT NULL,
  `Timestamp` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
  `Lifetime` int(11) NOT NULL,
  PRIMARY KEY (`Token`,`ProviderKey`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserCategory` (
  `UserID` int(11) NOT NULL,
  `CategoryID` int(11) NOT NULL,
  `DateMarkedRead` datetime DEFAULT NULL,
  `Unfollow` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`CategoryID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserComment` (
  `UserID` int(11) NOT NULL,
  `CommentID` int(11) NOT NULL,
  `Score` float DEFAULT NULL,
  `DateLastViewed` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`,`CommentID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserConversation` (
  `UserID` int(11) NOT NULL,
  `ConversationID` int(11) NOT NULL,
  `CountReadMessages` int(11) NOT NULL DEFAULT '0',
  `LastMessageID` int(11) DEFAULT NULL,
  `DateLastViewed` datetime DEFAULT NULL,
  `DateCleared` datetime DEFAULT NULL,
  `Bookmarked` tinyint(4) NOT NULL DEFAULT '0',
  `Deleted` tinyint(4) NOT NULL DEFAULT '0',
  `DateConversationUpdated` datetime DEFAULT NULL,
  PRIMARY KEY (`UserID`,`ConversationID`),
  KEY `IX_UserConversation_Inbox` (`UserID`,`Deleted`,`DateConversationUpdated`),
  KEY `FK_UserConversation_ConversationID` (`ConversationID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserDiscussion` (
  `UserID` int(11) NOT NULL,
  `DiscussionID` int(11) NOT NULL,
  `Score` float DEFAULT NULL,
  `CountComments` int(11) NOT NULL DEFAULT '0',
  `DateLastViewed` datetime DEFAULT NULL,
  `Dismissed` tinyint(4) NOT NULL DEFAULT '0',
  `Bookmarked` tinyint(4) NOT NULL DEFAULT '0',
  `Participated` tinyint(4) NOT NULL DEFAULT '0',
  PRIMARY KEY (`UserID`,`DiscussionID`),
  KEY `FK_UserDiscussion_DiscussionID` (`DiscussionID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserMerge` (
  `MergeID` int(11) NOT NULL AUTO_INCREMENT,
  `OldUserID` int(11) NOT NULL,
  `NewUserID` int(11) NOT NULL,
  `DateInserted` datetime NOT NULL,
  `InsertUserID` int(11) NOT NULL,
  `DateUpdated` datetime DEFAULT NULL,
  `UpdateUserID` int(11) DEFAULT NULL,
  `Attributes` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`MergeID`),
  KEY `FK_UserMerge_OldUserID` (`OldUserID`),
  KEY `FK_UserMerge_NewUserID` (`NewUserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserMergeItem` (
  `MergeID` int(11) NOT NULL,
  `Table` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `Column` varchar(30) COLLATE utf8_unicode_ci NOT NULL,
  `RecordID` int(11) NOT NULL,
  `OldUserID` int(11) NOT NULL,
  `NewUserID` int(11) NOT NULL,
  KEY `FK_UserMergeItem_MergeID` (`MergeID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserMeta` (
  `UserID` int(11) NOT NULL,
  `Name` varchar(255) COLLATE utf8_unicode_ci NOT NULL,
  `Value` text COLLATE utf8_unicode_ci,
  PRIMARY KEY (`UserID`,`Name`),
  KEY `IX_UserMeta_Name` (`Name`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserPoints` (
  `SlotType` enum('d','w','m','y','a') COLLATE utf8_unicode_ci NOT NULL,
  `TimeSlot` datetime NOT NULL,
  `Source` varchar(10) COLLATE utf8_unicode_ci NOT NULL DEFAULT 'Total',
  `CategoryID` int(11) NOT NULL DEFAULT '0',
  `UserID` int(11) NOT NULL,
  `Points` int(11) NOT NULL DEFAULT '0',
  PRIMARY KEY (`SlotType`,`TimeSlot`,`Source`,`CategoryID`,`UserID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
/*!40101 SET @saved_cs_client     = @@character_set_client */;
/*!40101 SET character_set_client = utf8 */;
CREATE TABLE `GDN_UserRole` (
  `UserID` int(11) NOT NULL,
  `RoleID` int(11) NOT NULL,
  PRIMARY KEY (`UserID`,`RoleID`),
  KEY `IX_UserRole_RoleID` (`RoleID`)
) ENGINE=InnoDB DEFAULT CHARSET=utf8 COLLATE=utf8_unicode_ci;
/*!40101 SET character_set_client = @saved_cs_client */;
INSERT INTO `GDN_UserRole` VALUES (0,2),(1,16);
	}

	public function down()
	{
        $setup = new \BishopB\Vfl\VanillaSetup();
        $setup->uninstall();
	}
}
