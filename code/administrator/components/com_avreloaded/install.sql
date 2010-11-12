-- $Id: install.sql 1060 2008-07-23 03:18:52Z Fritz Elfert $
--

DROP TABLE IF EXISTS `#__avr_player`;
CREATE TABLE `#__avr_player` (
  `id` int(11) NOT NULL auto_increment,
  `version` int(11) NOT NULL DEFAULT 0,
  `minw` int(11) NOT NULL DEFAULT 0,
  `minh` int(11) NOT NULL DEFAULT 0,
  `isjw` int(1) NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL,
  `code` mediumtext NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=38;

DROP TABLE IF EXISTS `#__avr_ripper`;
CREATE TABLE `#__avr_ripper` (
  `id` int(11) NOT NULL auto_increment,
  `version` int(11) NOT NULL DEFAULT 0,
  `flags` int(11) NOT NULL DEFAULT '0',
  `cindex` int(11) NOT NULL DEFAULT '0',
  `name` varchar(25) NOT NULL,
  `url` varchar(255) NOT NULL,
  `regex` varchar(255) NOT NULL,
  `description` varchar(255) NOT NULL DEFAULT '',
  PRIMARY KEY (`id`)
) ENGINE=MyISAM AUTO_INCREMENT=10;

DROP TABLE IF EXISTS `#__avr_tags`;
CREATE TABLE `#__avr_tags` (
  `id` int(11) NOT NULL auto_increment,
  `version` int(11) NOT NULL DEFAULT 0,
  `player_id` int(11) NOT NULL,
  `ripper_id` int(11) NOT NULL default '0',
  `local` int(1) NOT NULL default '0',
  `plist` int(1) NOT NULL default '0',
  `name` varchar(25) NOT NULL,
  `postreplace` varchar(255) NOT NULL default '',
  `sampleregex` varchar(255) NOT NULL default '',
  `description` varchar(255) NOT NULL default '',
  PRIMARY KEY  (`id`),
  KEY `tag` (`name`)
) ENGINE=MyISAM AUTO_INCREMENT=83;

CREATE TABLE IF NOT EXISTS `#__avr_popup` (
  `id` int(11) NOT NULL auto_increment,
  `divid` varchar(255) NOT NULL,
  `code` mediumtext NOT NULL,
  `width` int(11) NOT NULL,
  `height` int(11) NOT NULL,
  `wtime` datetime NOT NULL default '0000-00-00 00:00:00',
  PRIMARY KEY (`id`, `divid`)
) ENGINE=MyISAM AUTO_INCREMENT=83;

--
-- Default distribution data
--
-- MySQL dump 10.11
--
-- Host: localhost    Database: joomla
-- ------------------------------------------------------
-- Server version	5.0.45
/*!40103 SET @OLD_TIME_ZONE=@@TIME_ZONE */;
/*!40103 SET TIME_ZONE='+00:00' */;
/*!40014 SET @OLD_UNIQUE_CHECKS=@@UNIQUE_CHECKS, UNIQUE_CHECKS=0 */;
/*!40014 SET @OLD_FOREIGN_KEY_CHECKS=@@FOREIGN_KEY_CHECKS, FOREIGN_KEY_CHECKS=0 */;
/*!40101 SET @OLD_SQL_MODE=@@SQL_MODE, SQL_MODE='NO_AUTO_VALUE_ON_ZERO,MYSQL323' */;
/*!40111 SET @OLD_SQL_NOTES=@@SQL_NOTES, SQL_NOTES=0 */;

--
-- Dumping data for table `#__avr_player`
--

/*!40000 ALTER TABLE `#__avr_player` DISABLE KEYS */;
INSERT INTO `#__avr_player` VALUES (1,0,0,0,1,'flv','<script type=\"text/javascript\">\nswfobject.embedSWF(\'@RLOC@mediaplayer.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'@FLASHVER@\',@XPINST@,\n{file:\'@MURL@\',width:\'@WIDTH@\',height:\'@HEIGHT@\',@IF(ENABLEJS)@javascriptid:\'p_@DIVID@\',\n@/IF@@IFS(PLTHUMBS)@thumbsinplaylist:\'@PLTHUMBS@\',\n@/IFS@@IF(AUTOSCROLL)@autoscroll:\'@AUTOSCROLL@\',\n@/IF@@IFS(TYPE)@type:\'@TYPE@\',\n@/IFS@@IFS(VOLUME)@volume:\'@VOLUME@\',\n@/IFS@@IFS(CFG)@config:\'@CFG@\',\n@/IFS@@IFS(LINK)@link:\'@LINK@\',\n@/IFS@@IFS(IMG)@image:\'@IMG@\',\n@/IFS@@IFS(LINK)@linkfromdisplay:\'@LINKFROMDISPLAY@\',\n@/IFS@@IFS(LINK)@linktarget:\'@LINKTARGET@\',\n@/IFS@@IFS(REPEAT)@repeat:\'@REPEAT@\',\n@/IFS@@IFS(SHUFFLE)@shuffle:\'@SHUFFLE@\',\n@/IFS@@IFS(RECURL)@recommendations:\'@RECURL@\',\n@/IFS@@IFS(DISPLAYWIDTH)@displaywidth:\'@DISPLAYWIDTH@\',\n@/IFS@@IFS(DISPLAYHEIGHT)@displayheight:\'@DISPLAYHEIGHT@\',\n@/IFS@@IFS(LOGO)@logo:\'@LOGO@\',\n@/IFS@@IFS(CAPTIONS)@captions:\'@CAPTIONS@\',\n@/IFS@@IFS(USECAPTIONS)@usecaptions:\'@USECAPTIONS@\',\n@/IFS@@IFS(SEARCHLINK)@searchlink:\'@SEARCHLINK@\',\n@/IFS@showeq:\'@SHOWEQ@\',searchbar:\'@SEARCHBAR@\',enablejs:\'@ENABLEJS@\',autostart:\'@AUTOSTART@\',showicons:\'@SHOWICONS@\',@IF(!SHOWNAV)@shownavigation:\'@SHOWNAV@\',@/IF@@IF(SHOWNAV)@showstop:\'@SHOWSTOP@\',showdigits:\'@SHOWDIGITS@\',\nshowdownload:\'@SHOWDOWNLOAD@\',@/IF@usefullscreen:\'@USEFULLSCREEN@\',backcolor:\'@PBGCOLOR@\',frontcolor:\'@PFGCOLOR@\',\nlightcolor:\'@PHICOLOR@\',screencolor:\'@PSCCOLOR@\',overstretch:\'@STRETCH@\'}\n,{allowscriptaccess:\'always\',seamlesstabbing:\'true\',allowfullscreen:\'true\',wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},\n{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','JW Media Player');
INSERT INTO `#__avr_player` VALUES (2,0,0,0,0,'wmv','<object classid=\"CLSID:6BF52A52-394A-11d3-B153-00C04F79FAA6\"\n type=\"application/x-oleobject\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\">\n<param name=\"URL\" value=\"@MURL@\" />\n<param name=\"stretchToFit\" value=\"1\" />\n<param name=\"showControls\" value=\"1\" />\n<param name=\"showStatusBar\" value=\"0\" />\n<param name=\"animationAtStart\" value=\"1\" />\n<param name=\"autoStart\" value=\"@AUTOSTART!d@\" />\n<param name=\"enableFullScreenControls\" value=\"@USEFULLSCREEN!d@\" \n/><embed src=\"@MURL@\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\" autoStart=\"@AUTOSTART!d@\" animationAtStart=\"1\" enableFullScreenControls=\"@USEFULLSCREEN!d@\" type=\"application/x-mplayer2\"/></embed></object>','Windows Media Player');
INSERT INTO `#__avr_player` VALUES (3,0,0,0,0,'mov','<object codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\"><param name=\"src\" value=\"@MURL@\" /><param name=\"controller\" value=\"True\" /><param name=\"cache\" value=\"False\" /><param name=\"autoplay\" value=\"@AUTOSTART@\" /><param name=\"kioskmode\" value=\"False\" /><param name=\"scale\" value=\"tofit\" /><embed src=\"@MURL@\" pluginspage=\"http://www.apple.com/quicktime/download/\" scale=\"tofit\" kioskmode=\"False\" qtsrc=\"@MURL@\" cache=\"False\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\" controller=\"True\" type=\"video/quicktime\" autoplay=\"@AUTOSTART@\" /></object>','QuickTime Player');
INSERT INTO `#__avr_player` VALUES (4,0,0,0,0,'rm','<object classid=\"clsid:CFCDAA03-8BE4-11cf-B84B-0020AFBBCCFA\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\"><param name=\"controls\" value=\"ControlPanel\" /><param name=\"autostart\" value=\"@AUTOSTART!d@\" /><param name=\"src\" value=\"@MURL@\" /><embed src=\"@MURL@\" type=\"audio/x-pn-realaudio-plugin\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\" controls=\"ControlPanel\" autostart=\"@AUTOSTART!d@\" /></object>','Real Media Player');
INSERT INTO `#__avr_player` VALUES (5,0,0,0,0,'divx','<object classid=\"CLSID:67DABFBF-D0AB-41fa-9C46-CC0F21721616\"\ncodebase=\"http://download.divx.com/webplayer/stage6/windows/AutoDLDivXWebPlayerInstaller.cab\" \n type=\"application/x-oleobject\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\">\n<param name=\"src\" value=\"@MURL@\" />\n<param name=\"custommode\" value=\"Stage6\" />\n<param name=\"showControls\" value=\"1\" />\n<param name=\"showpostplaybackad\" value=\"false\" />\n<param name=\"allowContextMenu\" value=\"@MENU@\" />\n@IFS(IMG)@<param name=\"previewImage\" value=\"@IMG@\" />\n@/IFS@<param name=\"autoplay\" value=\"@AUTOSTART@\" \n/><embed type=\"video/divx\" src=\"@MURL@\" style=\"width: @WIDTH@px; height: @HEIGHT@px;\" pluginspage=\"http://go.divx.com/plugin/download/\" showpostplaybackad=\"false\" custommode=\"Stage6\" autoplay=\"@AUTOSTART@\" allowContextMenu=\"@MENU@\"@@IFS(IMG)@ previewImage=\"@IMG@\"@/IFS@/></object>','DivX Webplayer');
INSERT INTO `#__avr_player` VALUES (6,0,0,0,0,'6cn','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://6.cn/player.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{vid:\'@CODE@\',flag:\'1\'},{allowfullscreen:\'true\',wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','6Cn.com original player');
INSERT INTO `#__avr_player` VALUES (7,0,0,0,0,'biku','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.biku.com/opus/player.swf?VideoID=@CODE@&embed=true&autoStart=@AUTOSTART@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',menu:\'@MENU@\',bgcolor:\'@BGCOLOR@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Biku.com original player');
INSERT INTO `#__avr_player` VALUES (8,0,0,0,0,'bofunk','<script type=\"text/javascript\">\nswfobject.embedSWF(\'@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{allowfullscreen:\'true\',wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Bofunk.com original player');
INSERT INTO `#__avr_player` VALUES (9,0,0,0,0,'break','<script type=\"text/javascript\">\nswfobject.embedSWF(\'@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Break.com original player');
INSERT INTO `#__avr_player` VALUES (10,0,0,0,0,'clipfish','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.clipfish.de/videoplayer.swf?videoid=@CODE@&r=1\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',allowfullscreen:\'true\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','ClipFish.de original player');
INSERT INTO `#__avr_player` VALUES (11,0,0,0,0,'collegehumor','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.collegehumor.com/moogaloop/moogaloop.swf?clip_id=@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','CollegeHumor original player');
INSERT INTO `#__avr_player` VALUES (12,0,420,340,0,'currenttv','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://current.com/e/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','CurrentTV original player');
INSERT INTO `#__avr_player` VALUES (13,0,0,0,0,'dmotion','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.dailymotion.com/swf/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'8.0.0\',@XPINST@,\n{v3:\'1\',related:\'0\',autoPlay:\'@AUTOSTART!d@\',colors:\'background:DDDDDD;glow:FFFFFF;foreground:333333;special:FFC300;\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',quality:\'high\',allowScriptAccess:\'allways\',allowfullscreen:\'true\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','DailyMotion.com original player');
INSERT INTO `#__avr_player` VALUES (14,0,0,0,0,'vidiac','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.vidiac.com/vidiac.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{name:\'ePlayer\',video:\'@CODE@\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Vidiac.com original player');
INSERT INTO `#__avr_player` VALUES (15,0,0,0,0,'gametrailers','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.gametrailers.com/remote_wrap.php?mid=@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',allowfullscreen:\'true\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','GameTrailers.com original player');
INSERT INTO `#__avr_player` VALUES (16,0,0,0,0,'google','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://video.google.com/googleplayer.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{@IF(AUTOSTART)@autoPlay:\'true\',@/IF@docId:\'@CODE@\',hl:\'@LANG@\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Google Video original player');
INSERT INTO `#__avr_player` VALUES (17,0,0,0,0,'spike','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.spike.com/efp\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{flvBaseClip:\'@CODE@\'},{name:\'efp\',wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Spike.com original player (previously iFilm.com)');
INSERT INTO `#__avr_player` VALUES (18,0,0,0,0,'jumpcut','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.jumpcut.com/media/flash/jump.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{asset_type:\'movie\',asset_id:\'@CODE@\',eb:\'1\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','JumpCut.com original player');
INSERT INTO `#__avr_player` VALUES (19,0,0,0,0,'mega','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://wwwstatic.megavideo.com/tmp_mvplayer.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'8.0.0\',@XPINST@,\n{waitingtime:\'0\',flv:\'@CODE@\',k:\'@RRESA@\',poker:\'0\',v:\'@OCODE@\',rel_again:\'Play again\',rel_other:\'Related videos\',u:\'\',user:\'\',from:\'from:\',views:\'views\',vid_time:\'@RRESB@\',vid_name:\'\',videoname:\'\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',quality:\'high\',allowScriptAccess:\'sameDomain\',allowFullScreen:\'@USEFULLSCREEN@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','MegaVideo.com original player');
INSERT INTO `#__avr_player` VALUES (20,0,0,0,0,'metacafe','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.metacafe.com/fplayer/@CODE@.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{altServerURL:\'http://www.metacafe.com\',playerVars:\'showStats=no|autoPlay=no|videoTitle=\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','MetaCafe.com original player');
INSERT INTO `#__avr_player` VALUES (21,0,0,0,0,'mofile','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://tv.mofile.com/cn/xplayer.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{v:\'@CODE@\',autoplay:\'0\'},{wmode:\'@WMODE@\',allowScriptAccess:\'always\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Mofile.com original player');
INSERT INTO `#__avr_player` VALUES (22,0,0,0,0,'myvideo','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.myvideo.de/movie/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','MyVideo.com original player');
INSERT INTO `#__avr_player` VALUES (23,0,0,0,0,'quxiu','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.quxiu.com/photo/swf/swfobj.swf?id=@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Quixu.com original player');
INSERT INTO `#__avr_player` VALUES (24,0,0,0,0,'revver','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://flash.revver.com/player/1.0/player.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{mediaId:\'@CODE@\',javascriptContext:\'true\',skinURL:\'http://flash.revver.com/player/1.0/skins/Default_Raster.swf\',skinImgURL:\'http://flash.revver.com/player/1.0/skins/night_skin.png\',actionBarSkinURL:\'http://flash.revver.com/player/1.0/skins/DefaultNavBarSkin.swf\',resizeVideo:\'true\'},\n{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Revver.com original player');
INSERT INTO `#__avr_player` VALUES (25,0,0,0,0,'seehaha','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.seehaha.com/flash/playvid2.swf?vidID=@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','SeeHaha.com original player');
INSERT INTO `#__avr_player` VALUES (26,0,0,0,0,'sevenload','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://de.sevenload.com/pl/@CODE@/503x403/swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',allowfullscreen:\'true\',allowscriptaccess:\'always\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'\n},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','SevenLoad.com original player');
INSERT INTO `#__avr_player` VALUES (27,0,0,0,0,'stickam','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.stickam.com/flashVarMediaPlayer/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',allowfullscreen:\'true\',scale:\'noscale\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','StickAm.com original player');
INSERT INTO `#__avr_player` VALUES (28,0,0,0,0,'streetfire','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://videos.streetfire.net/vidiac.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{name:\'ePlayer\',video:\'@CODE@\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','StreetFire original player');
INSERT INTO `#__avr_player` VALUES (29,0,432,285,0,'ted','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.ted.com/swf/videoplayer.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'8.0.0\',@XPINST@,\n{jsonStr:\'@CODE@\',flashID:\'swfVideoPlayer\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',quality:\'high\',allowScriptAccess:\'always\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','TED.com original player');
INSERT INTO `#__avr_player` VALUES (30,0,0,0,0,'ted2','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://static.videoegg.com/ted/flash/loader.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'8.0.0\',@XPINST@,\n{file:\'@CODE@\',autoPlay:\'@AUTOSTART@\',allowFullscreen:\'@USEFULLSCREEN@\',forcePlay:\'false\',logo:\'\',fullscreenURL:\'http://static.videoegg.com/ted/flash/fullscreen.html\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',quality:\'high\',allowScriptAccess:\'always\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','TED.com alternative player');
INSERT INTO `#__avr_player` VALUES (31,0,0,0,0,'tudou','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.tudou.com/v/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Tudou.com original player');
INSERT INTO `#__avr_player` VALUES (32,0,0,0,0,'uume','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.uume.com/v/@CODE@_UUME\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',allowfullscreen:\'true\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Uume.com original player');
INSERT INTO `#__avr_player` VALUES (33,0,0,0,0,'vimeo','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.vimeo.com/moogaloop.swf?clip_id=@CODE@&server=www.vimeo.com&show_title=1&show_byline=1&show_portrait=0&autoplay=@AUTOSTART!d@&fullscreen=@USEFULLSCREEN!d@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',allowfullscreen:\'true\',scale:\'showall\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Vimeo.com original player');
INSERT INTO `#__avr_player` VALUES (34,0,0,0,0,'virb','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.virb.com/external/video/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',salign:\'tl\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Virb.com original player');
INSERT INTO `#__avr_player` VALUES (35,0,0,0,0,'wangyou','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://v.wangyou.com/images/x_player.swf?id=@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\nfalse,{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','WangYou.com original player');
INSERT INTO `#__avr_player` VALUES (36,0,0,0,0,'yahoo','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://d.yimg.com/static.video.yahoo.com/yep/YV_YEP.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{onsite:\'0\',embed:\'1\',id:\'@CODE@\'},{allowfullscreen:\'@USEFULLSCREEN@\',wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Yahoo video original player');
INSERT INTO `#__avr_player` VALUES (37,0,0,0,0,'youtube','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.youtube.com/v/@CODE@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{autoplay:\'@AUTOSTART!d@\',color1:\'@PBGCOLOR@\',color2:\'@PHICOLOR@\',rel:\'@YTREL!d@\',egm:\'@YTEGM!d@\',border:\'@YTBORDER!d@\',loop:\'@YTLOOP!d@\'},{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','YouTube original player');
INSERT INTO `#__avr_player` VALUES (38,0,0,0,0,'jwwmv','<script type=\"text/javascript\">\nnew jeroenwijering.Player($(\'@DIVID@\'),\'@RLOC@wmvplayer.xaml\',\n{file:\'@MURL@\',width:\'@WIDTH@\',height:\'@HEIGHT@\',@IF(ENABLEJS)@javascriptid:\'p_@DIVID@\',\n@/IF@@IFS(PLTHUMBS)@thumbsinplaylist:\'@PLTHUMBS@\',\n@/IFS@@IF(AUTOSCROLL)@autoscroll:\'@AUTOSCROLL@\',\n@/IF@@IFS(TYPE)@type:\'@TYPE@\',\n@/IFS@@IFS(CFG)@config:\'@CFG@\',\n@/IFS@@IFS(LINK)@link:\'@LINK@\',\n@/IFS@@IFS(IMG)@image:\'@IMG@\',\n@/IFS@@IFS(LINK)@linkfromdisplay:\'@LINKFROMDISPLAY@\',\n@/IFS@@IFS(LINK)@linktarget:\'@LINKTARGET@\',\n@/IFS@@IFS(REPEAT)@repeat:\'@REPEAT@\',\n@/IFS@@IFS(SHUFFLE)@shuffle:\'@SHUFFLE@\',\n@/IFS@@IFS(RECURL)@recommendations:\'@RECURL@\',\n@/IFS@@IFS(DISPLAYWIDTH)@displaywidth:\'@DISPLAYWIDTH@\',\n@/IFS@@IFS(DISPLAYHEIGHT)@displayheight:\'@DISPLAYHEIGHT@\',\n@/IFS@@IFS(LOGO)@logo:\'@LOGO@\',\n@/IFS@@IFS(SEARCHLINK)@searchlink:\'@SEARCHLINK@\',\n@/IFS@showeq:\'@SHOWEQ@\',searchbar:\'@SEARCHBAR@\',enablejs:\'@ENABLEJS@\',autostart:\'@AUTOSTART@\',showicons:\'@SHOWICONS@\',@IF(!SHOWNAV)@shownavigation:\'@SHOWNAV@\',@/IF@@IF(SHOWNAV)@showstop:\'@SHOWSTOP@\',showdigits:\'@SHOWDIGITS@\',\nshowdownload:\'@SHOWDOWNLOAD@\',@/IF@usefullscreen:\'@USEFULLSCREEN@\',backcolor:\'@PBGCOLOR@\',frontcolor:\'@PFGCOLOR@\',\nlightcolor:\'@PHICOLOR@\',screencolor:\'@PSCCOLOR@\',overstretch:\'@STRETCH@\'}\n);\n</script>','JW WMV Player (needs MS-SilverLight)');
INSERT INTO `#__avr_player` VALUES (39,0,0,0,0,'swf','<script type=\"text/javascript\">\nswfobject.embedSWF(\'@MURL@\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'@FLASHVER@\',@XPINST@,\nfalse,{allowscriptaccess:\'always\',seamlesstabbing:\'true\',allowfullscreen:\'true\',wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',menu:\'@MENU@\'},\n{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Plain flash embedding (for flash animations)');
INSERT INTO `#__avr_player` VALUES (40,0,0,0,0,'brightcove','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.brightcove.tv/playerswf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{initVideoId:\'@CODE@\',servicesURL:\'http://www.brightcove.tv\',\nviewerSecureGatewayURL:\'https://www.brightcove.tv\',\ncdnURL:\'http://admin.brightcove.com\',autoStart:\'@AUTOSTART@\'},\n{base:\'http://admin.brightcove.com\',\nwmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',allowFullScreen:\'true\',\nallowScriptAccess:\'always\',seamlesstabbing:\'false\',swLiveConnect:\'true\'\n,menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Brightcove.tv original player');
INSERT INTO `#__avr_player` VALUES (41,0,0,0,0,'myshows','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://www.seehaha.com/flash/player.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'9.0.28\',@XPINST@,\n{vidFileName:\'@CODE@\'},\n{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',allowFullScreen:\'@USEFULLSCREEN@\',menu:\'@MENU@\'},{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Myshows.cn (previouslyly seehaha.com)');
INSERT INTO `#__avr_player` VALUES (42,0,0,0,0,'blip','<script type=\"text/javascript\">\nswfobject.embedSWF(\'http://blip.tv/scripts/flash/showplayer.swf\',\'@DIVID@\',\'@WIDTH@\',\'@HEIGHT@\',\'@FLASHVER@\',@XPINST@,\n{file:\'http://blip.tv/rss/flash/@CODE@?referrer=blip.tv&source=1\',enablejs:\'true\',feedurl:\'http://WatchMojo.blip.tv/rss\',\nshowplayerpath:\'showplayerpath=http://blip.tv/scripts/flash/showplayer.swf\'},\n{wmode:\'@WMODE@\',bgcolor:\'@BGCOLOR@\',quality:\'high\',allowScriptAccess:\'sameDomain\',allowFullScreen:\'@USEFULLSCREEN@\',menu:\'@MENU@\'},\n{id:\'p_@DIVID@\',styleclass:\'@AVCSS@\'});\n</script>','Blip.tv original player');
/*!40000 ALTER TABLE `#__avr_player` ENABLE KEYS */;

--
-- Dumping data for table `#__avr_ripper`
--

/*!40000 ALTER TABLE `#__avr_ripper` DISABLE KEYS */;
INSERT INTO `#__avr_ripper` VALUES (1,0,0,0,'6cn','http://6.cn/watch/@CODE@.html','pageMessage.evid\\s*=\\s*\'([^\']+)\'\\s*;','6CN.com');
INSERT INTO `#__avr_ripper` VALUES (2,0,0,0,'bofunk','http://www.bofunk.com/video/@CODE@.html','<input\\stype=\'text\'\\svalue=\'<embed\\ssrc=\"([^\"]+)\"','Bofunk.com');
INSERT INTO `#__avr_ripper` VALUES (3,0,0,0,'break','http://www.break.com/index/@CODE@.html','<param name=\"movie\" value=\"([^\"]+)\">','Break.com');
INSERT INTO `#__avr_ripper` VALUES (4,0,0,0,'dropshots','http://www.dropshots.com/V1.0/Media.getList?appid=dropshots&username=@USER@&min_taken_date=@CODE@&passwordprotection=false&output=xml','<video>(.+)</video>','Dropshots.com');
INSERT INTO `#__avr_ripper` VALUES (5,0,0,0,'mega','http://www.megavideo.com/?v=@CODE@','addVariable\\s*\\(\\s*\"flv\"\\s*,\\s*\"([^\"]+)\"[\\s\\S]*?addVariable\\s*\\(\\s*\"k\"\\s*,\\s*\"([^\"]+)\"[\\s\\S]*?addVariable\\s*\\(\\s*\"vid_time\"\\s*,\\s*\"([^\"]+)\"','MegaVideo.com');
INSERT INTO `#__avr_ripper` VALUES (6,0,0,0,'ted','http://www.ted.com/index.php/talks/view/id/@CODE@','firstRun\\s*=\\s*\"([^\"]+)\"','TED.com');
INSERT INTO `#__avr_ripper` VALUES (7,0,0,0,'ted2','http://www.ted.com/index.php/talks/view/id/@CODE@','paste-->.+&file=([^&]+).*</object>','TED.com (for alternate player)');
INSERT INTO `#__avr_ripper` VALUES (8,0,0,0,'yahoo','http://video.yahoo.com/watch/@CODE@','addVariable\\s*\\(\\s*\"id\"\\s*,\\s*\"([^\"]+)\"','Yahoo Video');
INSERT INTO `#__avr_ripper` VALUES (9,0,0,0,'streetfire','http://videos.streetfire.net/video/@CODE@.htm','_embedCodeID.*video=([\\dabcdef\\-]+)','StreetFire');
INSERT INTO `#__avr_ripper` VALUES (10,0,0,0,'myshows','http://www.myshows.cn/myplayvideo.aspx?vid=@CODE@','vidFileName=([^\"]+)','Myshows.cn (previouslyly seehaha.com)');
INSERT INTO `#__avr_ripper` VALUES (11,0,0,0,'virb','http://www.virb.com/@CODE@','external/video/([^&\"]+)','Virb.com');
INSERT INTO `#__avr_ripper` VALUES (12,0,0,0,'blip','http://www.blip.tv/file/@CODE@','setPostsId\\s*\\(\\s*(\\d+)\\s*\\)','Blip.tv');
INSERT INTO `#__avr_ripper` VALUES (13,0,0,0,'apple','http://www.apple.com/trailers/@CODE@','\'(http:\\/\\/movies\\.apple\\.com\\/.*?\\.mov)\'','Apple.com trailers');
/*!40000 ALTER TABLE `#__avr_ripper` ENABLE KEYS */;

--
-- Dumping data for table `#__avr_tags`
--

/*!40000 ALTER TABLE `#__avr_tags` DISABLE KEYS */;
INSERT INTO `#__avr_tags` VALUES (1,0,1,0,1,1,'flv','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.flv\";}','^(.+)\\.flv$','Local FLV');
INSERT INTO `#__avr_tags` VALUES (2,0,1,0,0,1,'flvremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.flv)$','Generic Remote FLV');
INSERT INTO `#__avr_tags` VALUES (3,0,1,0,1,1,'swf','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.swf\";}','^(.+)\\.swf$','Local SWF Video');
INSERT INTO `#__avr_tags` VALUES (4,0,1,0,0,1,'swfremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.swf)$','Generic Remote SWF Video');
INSERT INTO `#__avr_tags` VALUES (5,0,1,0,1,1,'mp3','a:3:{s:7:\"@WIDTH@\";s:8:\"@AWIDTH@\";s:8:\"@HEIGHT@\";s:9:\"@AHEIGHT@\";s:6:\"@MURL@\";s:16:\"@ALOC@@CODE@.mp3\";}','^(.+)\\.mp3$','Local MP3');
INSERT INTO `#__avr_tags` VALUES (6,0,1,0,0,1,'mp3remote','a:3:{s:7:\"@WIDTH@\";s:8:\"@AWIDTH@\";s:8:\"@HEIGHT@\";s:9:\"@AHEIGHT@\";s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.mp3)$','Generic Remote MP3');
INSERT INTO `#__avr_tags` VALUES (7,0,1,0,1,1,'mp4-flv','a:2:{s:6:\"@TYPE@\";s:3:\"flv\";s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.mp4\";}','^(.+)\\.mp4$','Local MP4 (JW Media Player)');
INSERT INTO `#__avr_tags` VALUES (8,0,1,0,0,1,'mp4-flvremote','a:4:{s:7:\"@WIDTH@\";s:7:\"@WIDTH@\";s:8:\"@HEIGHT@\";s:8:\"@HEIGHT@\";s:6:\"@TYPE@\";s:3:\"flv\";s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.mp4)$','Generic Remote MP4 (JW Media Player)');
INSERT INTO `#__avr_tags` VALUES (9,0,1,0,1,1,'m4v','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.m4v\";}','^(.+)\\.m4v$','Local M4V');
INSERT INTO `#__avr_tags` VALUES (10,0,1,0,0,1,'m4vremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.m4v)$','Generic Remote M4V');
INSERT INTO `#__avr_tags` VALUES (11,0,1,0,1,1,'3gp','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.3gp\";}','^(.+)\\.3gp$','Local 3GP');
INSERT INTO `#__avr_tags` VALUES (12,0,1,0,0,1,'3gpremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.3gp)$','Generic Remote 3GP');
INSERT INTO `#__avr_tags` VALUES (13,0,1,0,1,1,'rbs','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.rbs\";}','^(.+)\\.rbs$','Local RBS');
INSERT INTO `#__avr_tags` VALUES (14,0,1,0,0,1,'rbsremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.rbs)$','Generic Remote RBS');
INSERT INTO `#__avr_tags` VALUES (15,0,1,0,1,0,'auto','a:1:{s:6:\"@MURL@\";s:12:\"@VLOC@@CODE@\";}','^(.+\\.xml)$','Local Playlist');
INSERT INTO `#__avr_tags` VALUES (16,0,1,0,0,0,'autoremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.xml)$','Generic Remote Playlist');
INSERT INTO `#__avr_tags` VALUES (17,0,2,0,1,0,'wmv','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.wmv\";}','^(.+)\\.wmv$','Local WMV');
INSERT INTO `#__avr_tags` VALUES (18,0,2,0,0,0,'wmvremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.wmv)$','Generic Remote WMV');
INSERT INTO `#__avr_tags` VALUES (19,0,2,0,1,0,'wma','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.wma\";}','^(.+)\\.wma$','Local WMA');
INSERT INTO `#__avr_tags` VALUES (20,0,2,0,0,0,'wmaremote','a:3:{s:7:\"@WIDTH@\";s:8:\"@AWIDTH@\";s:8:\"@HEIGHT@\";s:9:\"@AHEIGHT@\";s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.wma)$','Generic Remote WMA');
INSERT INTO `#__avr_tags` VALUES (21,0,2,0,1,0,'avi','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.avi\";}','^(.+)\\.avi$','Local AVI');
INSERT INTO `#__avr_tags` VALUES (22,0,2,0,0,0,'aviremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.avi)$','Generic Remote AVI');
INSERT INTO `#__avr_tags` VALUES (23,0,2,0,1,0,'mpg','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.mpg\";}','^(.+)\\.mpg$','Local MPG');
INSERT INTO `#__avr_tags` VALUES (24,0,2,0,0,0,'mpgremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.mpg)$','Generic Remote MPG');
INSERT INTO `#__avr_tags` VALUES (25,0,2,0,1,0,'mpeg','a:1:{s:6:\"@MURL@\";s:17:\"@VLOC@@CODE@.mpeg\";}','^(.+)\\.mpeg$','Local MPEG');
INSERT INTO `#__avr_tags` VALUES (26,0,2,0,0,0,'mpegremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.mpeg)$','Generic Remote MPEG');
INSERT INTO `#__avr_tags` VALUES (27,0,3,0,1,0,'mov','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.mov\";}','^(.+)\\.mov$','Local MOV (QuickTime)');
INSERT INTO `#__avr_tags` VALUES (28,0,3,0,0,0,'movremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.mov)$','Generic Remote MOV (QuickTime)');
INSERT INTO `#__avr_tags` VALUES (29,0,3,0,1,0,'mp4','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.mp4\";}','^(.+)\\.mp4','Local MP4 (QuickTime)');
INSERT INTO `#__avr_tags` VALUES (30,0,3,0,0,0,'mp4remote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.mp4)$','Generic Remote MP4 (QuickTime)');
INSERT INTO `#__avr_tags` VALUES (31,0,4,0,1,0,'rm','a:1:{s:6:\"@MURL@\";s:15:\"@VLOC@@CODE@.rm\";}','^(.+)\\.rm$','Local RM (RealMedia)');
INSERT INTO `#__avr_tags` VALUES (32,0,4,0,2,0,'rmremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.rm)$','Generic Remote RM (RealMedia)');
INSERT INTO `#__avr_tags` VALUES (33,0,4,0,1,0,'ram','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.ram\";}','^(.+)\\.ram$','Local RAM (RealMedia)');
INSERT INTO `#__avr_tags` VALUES (34,0,4,0,0,0,'ramremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.ram)$','Generic Remote RAM (RealMedia)');
INSERT INTO `#__avr_tags` VALUES (35,0,5,0,1,0,'divx','a:1:{s:6:\"@MURL@\";s:17:\"@VLOC@@CODE@.divx\";}','^(.+)\\.divx','Local DivX');
INSERT INTO `#__avr_tags` VALUES (36,0,5,0,0,0,'divxremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.divx)$','Generic Remote DivX');
INSERT INTO `#__avr_tags` VALUES (37,0,6,1,0,0,'6cn','','http:\\/\\/6\\.cn\\/watch\\/(\\d+)\\.html','6CN.com');
INSERT INTO `#__avr_tags` VALUES (38,0,7,0,0,0,'biku','','http:\\/\\/www\\.biku\\.com\\/opus\\/(\\d+)\\.html','Biku.com');
INSERT INTO `#__avr_tags` VALUES (39,0,8,2,0,0,'bofunk','','http:\\/\\/www.bofunk.com\\/video\\/(\\d+\\/[^\\.]+)\\.html$','Bofunk.com');
INSERT INTO `#__avr_tags` VALUES (40,0,9,3,0,0,'break','','http:\\/\\/www\\.break\\.com\\/index\\/(.*)\\.html$','Break.com');
INSERT INTO `#__avr_tags` VALUES (41,0,10,0,0,0,'clipfish','','http:\\/\\/www\\.clipfish\\.de\\/player\\.php\\?videoid=(.+)','ClipFish.de');
INSERT INTO `#__avr_tags` VALUES (42,0,11,0,0,0,'collegehumor','','http:\\/\\/www\\.collegehumor\\.com\\/video:(\\d+)','College Humor');
INSERT INTO `#__avr_tags` VALUES (43,0,12,0,0,0,'currenttv','','http:\\/\\/current\\.com\\/items\\/(\\d+)_.*','Current-TV');
INSERT INTO `#__avr_tags` VALUES (44,0,13,0,0,0,'dmotion','','http:\\/\\/www\\.dailymotion\\.com\\/.*video\\/([^_]+)_[^\\/]+$','DailyMotion.com');
INSERT INTO `#__avr_tags` VALUES (45,0,1,4,0,0,'dropshots','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','','Dropshots.com');
INSERT INTO `#__avr_tags` VALUES (46,0,14,0,0,0,'freevideoblog','','http:\\/\\/www\\.vidiac\\.com\\/video\\/([\\dabcdef\\-]+)\\.htm$','Vidiac.com (previously FreeVideoBlog)');
INSERT INTO `#__avr_tags` VALUES (47,0,15,0,0,0,'gametrailers','','http:\\/\\/www\\.gametrailers\\.com\\/player\\/(\\d+)\\.html$','GameTrailers');
INSERT INTO `#__avr_tags` VALUES (48,0,16,0,0,0,'google','a:1:{s:6:\"@LANG@\";s:2:\"en\";}','http:\\/\\/video\\.google\\.com\\/videoplay\\?docid=(-{0,1}\\d+)','Google Video (international)');
INSERT INTO `#__avr_tags` VALUES (49,0,16,0,0,0,'google.co.uk','a:1:{s:6:\"@LANG@\";s:5:\"en-GB\";}','http:\\/\\/video\\.google\\.co\\.uk\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (UK)');
INSERT INTO `#__avr_tags` VALUES (50,0,16,0,0,0,'google.com.au','a:1:{s:6:\"@LANG@\";s:5:\"en-AU\";}','http:\\/\\/video\\.google\\.com\\.au\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (Australia)');
INSERT INTO `#__avr_tags` VALUES (51,0,16,0,0,0,'google.de','a:1:{s:6:\"@LANG@\";s:2:\"de\";}','http:\\/\\/video\\.google\\.de\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (Germany)');
INSERT INTO `#__avr_tags` VALUES (52,0,16,0,0,0,'google.es','a:1:{s:6:\"@LANG@\";s:2:\"es\";}','http:\\/\\/video\\.google\\.es\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (Spain)');
INSERT INTO `#__avr_tags` VALUES (53,0,16,0,0,0,'google.fr','a:1:{s:6:\"@LANG@\";s:2:\"fr\";}','http:\\/\\/video\\.google\\.fr\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (France)');
INSERT INTO `#__avr_tags` VALUES (54,0,16,0,0,0,'google.it','a:1:{s:6:\"@LANG@\";s:2:\"it\";}','http:\\/\\/video\\.google\\.it\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (Italy)');
INSERT INTO `#__avr_tags` VALUES (55,0,16,0,0,0,'google.nl','a:1:{s:6:\"@LANG@\";s:2:\"nl\";}','http:\\/\\/video\\.google\\.nl\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (Netherlands)');
INSERT INTO `#__avr_tags` VALUES (56,0,16,0,0,0,'google.pl','a:1:{s:6:\"@LANG@\";s:2:\"pl\";}','http:\\/\\/video\\.google\\.pl\\/videoplay\\?docid=(-{0,1}\\d+)$','Google Video (Poland)');
INSERT INTO `#__avr_tags` VALUES (57,0,17,0,0,0,'ifilm','','','Spike.com (previously iFilm.com)');
INSERT INTO `#__avr_tags` VALUES (58,0,18,0,0,0,'jumpcut','','http:\\/\\/www\\.jumpcut\\.com\\/view\\/{0,1}\\?id=([A-F\\d]+)$','JumpCut.com');
INSERT INTO `#__avr_tags` VALUES (59,0,19,5,0,0,'mega','','http:\\/\\/www\\.megavideo\\.com\\/\\?v=(\\w+)$','MegaVideo.com');
INSERT INTO `#__avr_tags` VALUES (60,0,20,0,0,0,'metacafe','','http:\\/\\/www\\.metacafe\\.com\\/watch\\/(\\d+\\/[a-z_]+)\\/$','Metacafe.com');
INSERT INTO `#__avr_tags` VALUES (61,0,21,0,0,0,'mofile','','http:\\/\\/tv\\.mofile\\.com\\/([^\\/]+)\\/$','Mofile TV');
INSERT INTO `#__avr_tags` VALUES (62,0,22,0,0,0,'myvideo','','http:\\/\\/www\\.myvideo\\.de\\/watch\\/(\\d+)','MyVideo.de');
INSERT INTO `#__avr_tags` VALUES (63,0,23,0,0,0,'quxiu','','http:\\/\\/www\\.quxiu\\.com\\/video\\/play_(\\d+_\\d+)\\.htm$','Quixu.com');
INSERT INTO `#__avr_tags` VALUES (64,0,24,0,0,0,'revver','','http:\\/\\/www\\.revver\\.com\\/video\\/(\\d+)\\/[^\\/]+\\/$','Revver.com (using Flash)');
INSERT INTO `#__avr_tags` VALUES (65,0,25,0,0,0,'seehaha','','http:\\/\\/www\\.seehaha\\.com\\/play\\/(\\d+)$','SeeHaha.com');
INSERT INTO `#__avr_tags` VALUES (66,0,26,0,0,0,'sevenload','','http:\\/\\/de\\.sevenload\\.com\\/videos\\/([^\\/\\-]{1,7})[^\\/\\-]?[\\/\\-][^\\/]+$','SevenLoad.de');
INSERT INTO `#__avr_tags` VALUES (67,0,27,0,0,0,'stickam','','http:\\/\\/www\\.stickam\\.com\\/editMediaComment\\.do\\?method=load&mId=(\\d+)$','StickAm.com');
INSERT INTO `#__avr_tags` VALUES (68,0,28,0,0,0,'streetfire','','http:\\/\\/videos\\.streetfire\\.net\\/video\\/([\\dabcdef-]+)\\.htm$','StreetFire Videos (Old variant)');
INSERT INTO `#__avr_tags` VALUES (69,0,29,6,0,0,'ted','','http:\\/\\/www\\.ted\\.com\\/(?:index\\.php\\/)?talks\\/view\\/id\\/(\\d+)$','TED.com (Original Player)');
INSERT INTO `#__avr_tags` VALUES (70,0,30,7,0,0,'ted2','','http:\\/\\/www\\.ted\\.com\\/index\\.php\\/talks\\/view\\/id\\/(\\d+)$','TED.com (Foreign Player)');
INSERT INTO `#__avr_tags` VALUES (71,0,31,0,0,0,'tudou','','http:\\/\\/www\\.tudou\\.com\\/programs\\/view\\/([^\\/]+)\\/$','Tudou.com');
INSERT INTO `#__avr_tags` VALUES (72,0,32,0,0,0,'uume','','http:\\/\\/www\\.uume\\.com\\/play_([^\\/]+)$','Uume.com');
INSERT INTO `#__avr_tags` VALUES (73,0,33,0,0,0,'vimeo','','http:\\/\\/(?:www\\.)?vimeo\\.com\\/(\\d+)$','Vimeo');
INSERT INTO `#__avr_tags` VALUES (74,0,34,0,0,0,'virb','','','Virb.com');
INSERT INTO `#__avr_tags` VALUES (75,0,1,0,0,0,'wangyou','a:1:{s:6:\"@MURL@\";s:50:\"http://v.wangyou.com/playlistMedia.php%3Fid=@CODE@\";}','http:\\/\\/v\\.wangyou\\.com\\/p([^\\.]+)\\.html','WangYou.com');
INSERT INTO `#__avr_tags` VALUES (76,0,36,8,0,0,'yahoo','','http:\\/\\/video\\.yahoo\\.com\\/watch\\/(\\d+)\\/.*$','Yahoo Video');
INSERT INTO `#__avr_tags` VALUES (77,0,37,0,0,0,'youtube','','http:\\/\\/(?:\\w+\\.)?youtube\\.com\\/watch\\?.*v=([^&]+).*$','YouTube (Original Player)');
INSERT INTO `#__avr_tags` VALUES (78,0,1,0,0,1,'youtubejw','a:2:{s:10:\"@IFS(IMG)@\";s:59:\"image:\'http://i.ytimg.com/vi/@CODE@/default.jpg\',@IFS(IMG)@\";s:6:\"@MURL@\";s:41:\"http://www.youtube.com/watch%3Fv%3D@CODE@\";}','http:\\/\\/(?:\\w+\\.)?youtube\\.com\\/watch\\?.*v=([^&]+).*$','YouTube (JW Media Player)');
INSERT INTO `#__avr_tags` VALUES (81,0,3,0,0,0,'revver-mov','a:1:{s:6:\"@MURL@\";s:50:\"http://media.revver.com/broadcast/@CODE@/video.mov\";}','','Revver.com (using QuickTime)');
INSERT INTO `#__avr_tags` VALUES (82,0,28,9,0,0,'streetfire2','','http:\\/\\/videos\\.streetfire\\.net\\/video\\/([^\\/\\.]+)\\.htm$','StreetFire Videos');
INSERT INTO `#__avr_tags` VALUES (83,0,14,0,0,0,'vidiac','','http:\\/\\/www\\.vidiac\\.com\\/video\\/([\\dabcdef\\-]+)\\.htm$','Vidiac.com (previously FreeVideoBlog)');
INSERT INTO `#__avr_tags` VALUES (84,0,39,0,1,0,'flash','a:1:{s:6:\"@MURL@\";s:16:\"@VLOC@@CODE@.swf\";}','^(.+)\\.swf$','Plain local flash embedding (for flash animations)');
INSERT INTO `#__avr_tags` VALUES (85,0,39,0,0,0,'flashremote','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^(https{0,1}:\\/\\/.*\\.swf)$','Plain remote flash embedding (for flash animations)');
INSERT INTO `#__avr_tags` VALUES (86,0,17,0,0,0,'spike','','^http:\\/\\/www\\.spike\\.com\\/video\\/.*\\/(\\d+)$','Spike.com (previously iFilm.com)');
INSERT INTO `#__avr_tags` VALUES (87,0,40,0,0,0,'bcove','','^http:\\/\\/www\\.brightcove\\.tv\\/title\\.jsp\\?title=(\\d+).*$','Brightcove.tv');
INSERT INTO `#__avr_tags` VALUES (88,0,41,10,0,0,'myshows','','http:\\/\\/www\\.myshows\\.cn\\/myplayvideo\\.aspx\\?vid=(\\d+)','Myshows.cn (previouslyly seehaha.com)');
INSERT INTO `#__avr_tags` VALUES (89,0,34,11,0,0,'virb2','','http:\\/\\/www\\.virb\\.com\\/(.*)$','Virb.com');
INSERT INTO `#__avr_tags` VALUES (90,0,42,12,0,0,'blip','','^http:\\/\\/(?:www\\.)?blip\\.tv\\/file\\/(\\d+).*','Blip.tv');
INSERT INTO `#__avr_tags` VALUES (91,0,1,12,0,0,'blipjw','a:1:{s:6:\"@MURL@\";s:57:\"http://blip.tv/rss/flash/@CODE@?referrer=blip.tv&source=1\";}','^http:\\/\\/(?:www\\.)?blip\\.tv\\/file\\/(\\d+)\\?.*','Blip.tv using JW Media Player');
INSERT INTO `#__avr_tags` VALUES (92,0,3,13,0,0,'apple','a:1:{s:6:\"@MURL@\";s:6:\"@CODE@\";}','^http:\\/\\/www\\.apple\\.com\\/trailers\\/(.*)','Apple.com trailers');
INSERT INTO `#__avr_tags` VALUES (93,0,39,0,0,0,'movieweb','a:1:{s:6:\"@MURL@\";s:32:\"http://www.movieweb.com/v/@CODE@\";}','http:\\/\\/www\\.movieweb\\.com\\/video\\/(\\w+)$','MovieWeb');
/*!40000 ALTER TABLE `#__avr_tags` ENABLE KEYS */;
/*!40103 SET TIME_ZONE=@OLD_TIME_ZONE */;

/*!40101 SET SQL_MODE=@OLD_SQL_MODE */;
/*!40014 SET FOREIGN_KEY_CHECKS=@OLD_FOREIGN_KEY_CHECKS */;
/*!40014 SET UNIQUE_CHECKS=@OLD_UNIQUE_CHECKS */;
/*!40111 SET SQL_NOTES=@OLD_SQL_NOTES */;

