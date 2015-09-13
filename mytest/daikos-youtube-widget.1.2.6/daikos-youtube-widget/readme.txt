==== Daiko's YouTube Widget ====
Donate link: http://www.daikos.net/donate
Contributors: Daiko
Tags: youtube, thickbox, plugin, video, widget, sidebar
Requires at least: 2.1
Tested up to: 2.5
Stable tag: 1.2.6


Adds a sidebar widget to display random YouTube videos of your own choice. Uses a ThickBox pop-up player or VideoPlayer widget to play the videos.

== Description ==

Adds a sidebar widget to display a defined number of random YouTube videos of your own choice. Make your own videolist in the widget-control-panel. Syntax: {YouTubeID}@{Title}(Line Brake) without the brackets. Do not add a (Line Brake) after the last video in the list.

The widget also supports RSS-feeds from tag(s) and user(s). NEW in version 1.1.

The widget includes a plugin to activate ThickBox 3.1 developed by Cody Lindley to display videos as a pop-up and uses swfObjects 1.5 by Geoff Stearns. If you by any chance don't want to use the ThickBox player activate the included Daiko's VideoPlayer Widget. The two player options can be mixed. If both are active on a page, Daiko's VideoPlayer Widget will override the ThickBox pop-up player.

There is good support for Conditional Tags, meaning that you can specify where to show the widget. NEW in version 1.2.4 is support for "Post in Category(-ies)" where the point is to display the widget only if a post is in a specific category (or categories). It will also show in the category archive page(s). Specify the list of categories with comma separated category ID(WP<2.5) or name (WP>=2.5).

If you want to use ThickBox and swfObjects on other parts of your blog, the libraries are available as long as Daiko's YouTube Widget and Daiko's ThickBox plugin are activated.

For those of you using ThickBox already, be aware that activating my ThickBox (I use ThickBox v. 3.1) plugin may cause problems due to the script being loaded twice. Until I find an other way to check if ThickBox is already loaded, please disable your current ThickBox scripts before activating my ThickBox plugin. It should be backwards compatible so your scripts should work just as well with Daiko's ThickBox plugin activated.

A core part of ThickBox is the jquery.js library. I use the WP script loader and a noConflict version of ThickBox to prevent conflicts with prototype.js and scriptacolous.js. Please report any other potential script conflicts.

NEW in 1.2.6 is support for norwegian and included pot file for others to translate into other languages. 

Author: Rune Fjellheim

Version: 1.2.6

Author URI: http://www.daikos.net

Copyright: Released under GNU GENERAL PUBLIC LICENSE



== Installation ==


1.	Copy the daikos-youtube-widget folder to your /wp-content/plugins/ folder

2.	Activate the Daiko's YouTube Widget and/or ThickBox on your plugin-page.

3.	Drag the Daiko's YouTube Widget to your sidebar and set a title, and finally your own content (some videos are by default included but will disappear when you add own content).
4.	If you want to override the pop-up player, drag the Daiko's VideoPlayer to your sidebar (wherever you want) and set a title (optional) and the width.

To make your video-list just open the widget-control-panel and add 
your videos with the following syntax:

{YouTubeID}@{Title}(Line Brake)

Without the brackets.

Add comma separated tag(s) and/or user(s) to add rss feeds to your selection of videos from where the displayed videos will be selected.

Daiko's VideoPlayer selects its random display video from the specified videos in the 1st Daiko's YouTube Widget (Daiko's YouTube Widget 1).

IMPORTANT! Do not add a (Line brake) on the last line...

Good Luck!
