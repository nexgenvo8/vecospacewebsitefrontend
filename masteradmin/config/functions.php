<?php
openConn(); // opening database connection
$ha="select timeZone from "._USERS_MASTER_TABLE_." where userId='".$_SESSION['sessUserId']."'";
$hb=mysql_query($ha) or die(mysql_error()); 
$timezoneget=mysql_fetch_array($hb);
date_default_timezone_set("".$timezoneget["timeZone"]."");

function openConn()
{
	//Connect to database
	
	$dataCon=mysql_connect (_DATABASE_HOST_, _DATABASE_USERNAME_, _DATABASE_PASSWORD_)or die("Could not connect: ".mysql_error());
	mysql_select_db(_DATABASE_NAME_) or die(mysql_error());
}

function closeConn()
{
	mysql_close();
}


function insertDB($tableName,$insertArray,$valArray,$isQuery,$sqlQuery)
{
	$strInsert="";
	$strVal="";
	$strQuery="";


	if(strtolower($isQuery)=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($insertArray))
		{
			$errorMsg="Fields array incorrect";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($valArray))
		{
			$errorMsg="Val array incorrect";
			echo $errorMsg;
			exit();
		}

		if(countArray($insertArray)!=countArray($valArray))
		{
			$errorMsg="Fields and Val Fields does not match";
			notifyqueryerror(__LINE__,implode(",",$insertArray)."=====".implode(",",$valArray),mysql_error(),mysql_errno(),__FILE__,"insert fields");
			echo $errorMsg;
			exit();
		}
		
		
		for($i=0;$i<=countArray($insertArray)-1;$i++)
		{
			if(trim($strInsert)=="")
			{
				$strInsert=$insertArray[$i];
			}
			else
			{
				$strInsert=$strInsert.",".$insertArray[$i];
			}
		}
		
		for($i=0;$i<=count($valArray)-1;$i++)
		{
			if(trim($strVal)=="")
			{
				$strVal="'".$valArray[$i]."'";
			}
			else
			{
				$strVal=$strVal.",'".$valArray[$i]."'";
			}
		}
		
		$strQuery="Insert into ".$tableName."(".$strInsert.") values (".$strVal.")";
	}
	
	
//	echo $strQuery;
	//exit();
	
	if(trim($strQuery)!="")
	{	
		//$res=mysql_query($strQuery) or die(" insertDB : ".mysql_error());
		$res=mysql_query($strQuery) or notifyqueryerror(__LINE__,$strQuery,mysql_error(),mysql_errno(),__FILE__,"insert");
		if($res)
		{
//			echo " kk ".mysql_insert_id();
			//exit();
			$lastId=0;
			$lastId=mysql_insert_id();
			//echo " <br> tt ".$lastId;
			return $lastId;
		}
		else
		{
			return -1;
		}
	}
	else
	{
		$errorMsg="Insert query Error";
		echo $errorMsg;
		exit();
	}
}




function updateDB($tableName,$insertArray,$valArray,$whereArray,$wherevalArray,$isQuery,$sqlQuery)
{
	$strInsert="";
	$strVal="";
	$strQuery="";


	if($isQuery=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($insertArray))
		{
			$errorMsg="Fields array incorrect";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($valArray))
		{
			$errorMsg="Val array incorrect";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($whereArray))
		{
			$errorMsg="Where Fields incorrect array";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($wherevalArray))
		{
			$errorMsg="Where Val array incorrect";
			echo $errorMsg;
			exit();
		}

		if(countArray($insertArray)!=countArray($valArray))
		{
			$errorMsg="Fields and Val Fields does not match";
			notifyqueryerror(__LINE__,implode(",",$insertArray)."=====".implode(",",$valArray),mysql_error(),mysql_errno(),__FILE__,"update fields");
			echo $errorMsg;
			exit();
		}
		
		

		if(countArray($whereArray)!=countArray($wherevalArray))
		{
			$errorMsg="Where Fields and Val Fields does not match";
			echo $errorMsg;
			exit();
		}
		
		
		for($i=0;$i<=countArray($insertArray)-1;$i++)
		{
			if(trim($strInsert)=="")
			{
				$strInsert=$insertArray[$i]."='".$valArray[$i]."'";
			}
			else
			{
				$strInsert=$strInsert.",".$insertArray[$i]."='".$valArray[$i]."'";
			}
		}
		
		for($i=0;$i<=countArray($whereArray)-1;$i++)
		{
			if(trim($strWhere)=="")
			{
				$strWhere=$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
			else
			{
				$strWhere=$strWhere." and ".$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
		}
		
		if(trim($strWhere)!='')
		{
			$strWhere=" where ".$strWhere."";
		}
		
		$strQuery="Update ".$tableName." set ".$strInsert." ".$strWhere."";
	}
	
	
	////echo $strQuery;
	////exit();
	
	if(trim($strQuery)!="")
	{	
		//$res=mysql_query($strQuery) or die(" updateDB : ".mysql_error());
		$res=mysql_query($strQuery) or notifyqueryerror(__LINE__,$strQuery,mysql_error(),mysql_errno(),__FILE__,"update");
		if(!$res===false)
		{
			return 1;
		}
		else
		{
			return -1;
		}
	}
	else
	{
		$errorMsg="Update query error";
		echo $errorMsg;
		exit();
	}
}




function deleteDB($tableName,$whereArray,$wherevalArray,$isQuery,$sqlQuery)
{
	$strInsert="";
	$strVal="";
	$strQuery="";


	if($isQuery=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($whereArray))
		{
			$errorMsg="Where Fields incorrect array";
			echo $errorMsg;
			exit();
		}
	
		if(!isArray($wherevalArray))
		{
			$errorMsg="Where Val Fields array incorrect";
			echo $errorMsg;
			exit();
		}

		if(countArray($whereArray)!=countArray($wherevalArray))
		{
			$errorMsg="Where Fields and Val Fields does not match";
			echo $errorMsg;
			exit();
		}
		
		
		for($i=0;$i<=countArray($whereArray)-1;$i++)
		{
			if(trim($strWhere)=="")
			{
				$strWhere=$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
			else
			{
				$strWhere=$strWhere." and ".$whereArray[$i]."='".$wherevalArray[$i]."'";
			}
		}
		
		
		if(trim($strWhere)!='')
		{
			$strWhere=" where ".$strWhere."";
		}
		
		$strQuery="Delete from ".$tableName."  ".$strWhere."";
	}
	
	
	//echo $strQuery;
	//exit();
	
	if(trim($strQuery)!="")
	{	
		//$res=mysql_query($strQuery) or die(" deleteDB  : ".mysql_error());
		$res=mysql_query($strQuery) or notifyqueryerror(__LINE__,$strQuery,mysql_error(),mysql_errno(),__FILE__,"delete");
		if($res)
		{
			return true;
		}
		else
		{
			return false;
		}
	}
	else
	{
		$errorMsg="Error in query";
		echo $errorMsg;
		exit();
	}
	

}


function getRecords($tableName,$fieldArray,$whereArray,$valsArray,$isQuery,$sqlQuery,$orderBy='',$orderSort='',$limit='',$newOffset='')
{
	$strSelect="";
	$strWhere="";
	$strVal="";
	$strQuery="";


	if($isQuery=="yes")
	{
		$strQuery=$sqlQuery;
	}
	else
	{
		if(!isArray($fieldArray))
		{
			$errorMsg="Fields array not set for get records";
			echo $errorMsg;
			exit();
		}


		if(isArray($whereArray) && isArray($valsArray))
		{	
			if(count($whereArray)!=count($valsArray))
			{
				$errorMsg="Where Fields array and Where vals array does not match";
				echo $errorMsg;
				exit();
			}
		}			
		
		for($i=0;$i<=count($fieldArray)-1;$i++)
		{
			if(trim($strSelect)=="")
			{
				$strSelect=$fieldArray[$i];
			}
			else
			{
				$strSelect=$strSelect.",".$fieldArray[$i];
			}
		}
		
		for($i=0;$i<=count($whereArray)-1;$i++)
		{
			if(trim($strWhere)=="")
			{
				$strWhere=" where ".$whereArray[$i]."='".$valsArray[$i]."'";
			}
			else
			{
				$strWhere=$strWhere." and ".$whereArray[$i]."='".$valsArray[$i]."'";
			}
		}
		
		$strOrder='';
		
		if(trim($orderBy)!='' && trim($orderSort)!='')
		{
			$strOrder=" order by ".$orderBy." ".$orderSort;
		}
		
		$strLimit='';
		
		if(trim($limit)!='' && trim($newOffset)!='' && is_numeric($limit) && is_numeric($newOffset))
		{
			$strLimit=" LIMIT ".$newOffset.",".$limit;
		}
		
		
		
		$strQuery="Select ".$strSelect." from ".$tableName."  ".$strWhere." ".$strOrder."  ".$strLimit;
		
	}
	
	
	////echo "<br>".$strQuery;
	//exit();
	
	if(trim($strQuery)!="")
	{	
		//$res=mysql_query($strQuery) or die(" getRecords : ".mysql_error());////." -- ".$strQuery
		//$res=mysql_query($strQuery) or notifyqueryerror(__LINE__,$strQuery,mysql_error(),mysql_errno(),__FILE__,"select");
		$res=mysql_query($strQuery) or error_found(mysql_errno());
		
		if(!$res===false && mysql_num_rows($res)>0)
		{
			return $res;
		}
		else
		{
			return false;
		}
	}
	else
	{
		$errorMsg="Query not set for get records";
		echo $errorMsg;
		exit();
	}
}

function getRowsNum($recordSet)
{
	if($recordSet)	
		return mysqli_num_rows($recordSet);
	else
		return 0;
}

function getTableRecordCount($tableName)
{
	$rowCount=0;
	
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$strSql="";
	$strSql="Select * from ".$tableName;
	
	$resRecords=getRecords($tableName,$selectFields,$whereFields,$whereVals,_Y_,$strSql);
	
	if($resRecords)
	{
		$rowCount=mysql_num_rows($resRecords);
	}
	
	return $rowCount;
}

function notifyqueryerror($lineno,$querytxt,$errormsg,$errorcode,$filename,$querytype)
{
		$fullUrl="http://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
		$mailBodyContent='';
		$mailBodyContent='<div><table width="100%" border="0" cellspacing="0" cellpadding="0"><tr><td>Line #</td><td>'.$lineno.'</td></tr><tr><td>Query</td>
		<td>'.$querytxt.'</td></tr><tr><td>Error</td><td>'.$errormsg.'</td></tr><tr><td>Error Code</td><td>'.$errorcode.'</td></tr><tr><td>File Name</td><td>'.$filename.'</td></tr><tr><td>Query Type</td><td>'.$querytype.'</td></tr><td>Full URL</td><td>'.$fullUrl.'</td></tr></table></div>';
						
		
		$headers = "From: no_reply@scgindia.in\r\n";
		$headers .= "MIME-Version: 1.0\r\n";
		$headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";         
		
		$mailSent=@mail("r.pahat786@gmail.com",CONST_SITE_FOLDER_NAME." - Development Testing - Query Error",$mailBodyContent,$headers);
}


function makeContentUrl($contentText)
{
	$url='-';
	
	if(trim($contentText)!='')
		$url=strtolower(trim(preg_replace("/[\s-]+/", "-", preg_replace( "/[^a-zA-Z0-9\-]/", '-', $contentText)),"-"));
	
	return $url;
}
function generateRandom ($length = 4)
{
  // start with a blank password
  $uniqnum = "";
  // define possible characters
  $possiblenum = "0123456789"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 
    // pick a random character from the possible ones
    $char = substr($possiblenum, mt_rand(0, strlen($possiblenum)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($uniqnum, $char)) { 
      $uniqnum .= $char;
      $i++;
    }
  }
  // done!
  return $uniqnum;
}
function generateRandomAlphabate ($length = 4)
{
  // start with a blank password
  $uniqnum = "";
  // define possible characters
  $possiblenum = "ABCDEFGHIJKLMNOPQRSTUVWXYZ"; 
  // set up a counter
  $i = 0; 
  // add random characters to $password until $length is reached
  while ($i < $length) { 
    // pick a random character from the possible ones
    $char = substr($possiblenum, mt_rand(0, strlen($possiblenum)-1), 1);
    // we don't want this character if it's already in the password
    if (!strstr($uniqnum, $char)) { 
      $uniqnum .= $char;
      $i++;
    }
  }
  // done!
  return $uniqnum;
}
function generateuniqueid($length = 8)
{
	$d=date ("d");
	$m=date ("m");
	$y=date ("Y");
	$t=time();
	$dmt=$d+$m+$y+$t;    
	$ran= rand(0,10000000);
	$dmtran= $dmt+$ran;
	$un=  uniqid();
	$dmtun = $dmt.$un;
	$mdun = md5($dmtran.$un);
	$sort=substr($mdun, $length);
	return $mdun;
}
function getTables()
{
	$table= new database();
	$table=mysql_list_tables($table->database);
	return $table;
}
function uploadImage($tempPath, $destPath)
{
	if($tempPath!="" && $destPath!="")
	{
		move_uploaded_file($tempPath,$destPath) or die("The picture can not be uploaded. Please try again?"); 
		return true;
	}
	else
	{
		return false;
	}
}
function normalclean($str)
{
	$str = @trim($str);
	//$str=preg_replace( '/\s+/', ' ',($str));
	//if(get_magic_quotes_gpc())
	//{
		$str = stripslashes($str);
	//}
	return mysql_real_escape_string($str);
}
function sanitizetoinsert($str)
{
	$str = @trim($str);
	$str=preg_replace( '/\s+/', ' ',($str));
	if(get_magic_quotes_gpc())
	{
		$str = stripslashes($str);
	}
	return mysql_real_escape_string(strip_tags($str));
}
function isPost()
{
	if(trim(strtolower($_SERVER['REQUEST_METHOD']))=="post")
	{
		return true;
	}
	else
	{
		return false;
	}
}
function inStr ($needle, $haystack) 
{ 
  $needlechars = strlen($needle); //gets the number of characters in our needle 
  $i = 0; 
  for($i=0; $i < strlen($haystack); $i++) //creates a loop for the number of characters in our haystack 
  { 
    if(substr($haystack, $i, $needlechars) == $needle) //checks to see if the needle is in this segment of the haystack 
    { 
      return true; //if it is return true 
    } 
  } 
  return false; //if not, return false 
}  
function getUniqueNumber()
{
	$numReturn=0;
	
	$randNum=rand(0,9999);
	
	$numReturn=$randNum.date("YmdHis");
	
	return $numReturn;
}
function isValidURL($url) 
{ 
 return preg_match('|^http(s)?://[a-z0-9-]+(.[a-z0-9-]+)*(:[0-9]+)?(/.*)?$|i', $url); 
}
function generatePassword ($length = 8)
{
  // start with a blank password
  $password = "";
  // define possible characters
  $possible = "012UVX3789bcmn456jkpqvArstwxByzCDcEFGHJdhIKLMNOPfgQRSTYZ"; 
    
  // set up a counter
  $i = 0; 
    
  // add random characters to $password until $length is reached
  while ($i < $length) { 
    // pick a random character from the possible ones
    $char = substr($possible, mt_rand(0, strlen($possible)-1), 1);
        
    // we don't want this character if it's already in the password
    if (!strstr($password, $char)) { 
      $password .= $char;
      $i++;
    }
  }
  // done!
  return $password;
}
function getLocalTime()
{
	$hour = gmdate("H");
	$minute = gmdate("i");
	$seconds = gmdate("s");
	$day = gmdate("d");
	$month = gmdate("m");
	$year = gmdate("Y");
	// This is the offset from the server time to Bangladesh time.
	$hour = $hour + 5;
	$minute = $minute + 30;
	return date("h:i:s", mktime ($hour,$minute,$seconds,$month,$day,$year));
}

function isValidEmailFunc($email){
    if(!preg_match("/^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)*(\.[a-z]{2,3})$/i", $email)){
 		$isEmailValid='n';
		return $isEmailValid;
	}
	else
	{
		$isEmailValid='y';
		return $isEmailValid;
	}
}
function isValidPasswordFunc($password)
{
    if(!preg_match("/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,}$/i", $password))
	{
 		$isPasswordValid='n';
		return $isPasswordValid;
	}
	else
	{
		$isPasswordValid='y';
		return $isPasswordValid;
	}
}
function countArray($arrayVar)
{
	if(!is_array($arrayVar))
	{
		return 0;
	}
	else
	{
		return count($arrayVar);
	}
	
}
function isArray($arrayVar)
{
	if(!is_array($arrayVar))
	{
		return false;
	}
	else
	{
		return true;
	}
}
function getFormatedDate($format,$date) // $date has to be in YYYY-MM-DD format
{
	if($date!="")
	{
		$dateArray=split("-",$date);
		if($format!="")
			return date($format,strtotime($date));
		else
			return date("F d, Y",mktime(0,0,0,$dateArray[1],$dateArray[2],$dateArray[0]));
	}
	else
		return date("F d, Y",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}
function getServerCurrentTime($format)
{
	//date_default_timezone_set('UTC');
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("H:i:s",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}
function getServerCurrentDate($format)
{
	//date_default_timezone_set('UTC');
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("Y-m-d",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}
function getCurrentTime($format)
{
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("H:i:s",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}
function getCurrentDate($format)
{
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("Y-m-d",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}
function getCurrentDateTime($format)
{
	if($format!="")
		return date($format,mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
	else
		return date("Y-m-d H:i:s",mktime(date("H")+5,date("i")+30,date("s"),date("m"),date("d"),date("Y")));
}
function validEmail($email)
{
   $isValid = true;
   $atIndex = strrpos($email, "@");
   if (is_bool($atIndex) && !$atIndex)
   {
      $isValid = false;
	  $_SESSION["errorMessage"]="@ missing";
   }
   else
   {
      $domain = substr($email, $atIndex+1);
      $local = substr($email, 0, $atIndex);
      $localLen = strlen($local);
      $domainLen = strlen($domain);
      if ($localLen < 1 || $localLen > 64)
      {
         // local part length exceeded
         $isValid = false;
		 $_SESSION["errorMessage"]="local part length exceeded";
      }
      else if ($domainLen < 1 || $domainLen > 255)
      {
         // domain part length exceeded
         $isValid = false;
		 $_SESSION["errorMessage"]="domain part length exceeded";
      }
      else if ($local[0] == '.' || $local[$localLen-1] == '.')
      {
         // local part starts or ends with '.'
         $isValid = false;
		 $_SESSION["errorMessage"]="local part starts or ends with '.'";
      }
      else if (preg_match('/\\.\\./', $local))
      {
         // local part has two consecutive dots
         $isValid = false;
		 $_SESSION["errorMessage"]="local part has two consecutive dots";
      }
      else if (!preg_match('/^[A-Za-z0-9\\-\\.]+$/', $domain))
      {
         // character not valid in domain part
         $isValid = false;
		 $_SESSION["errorMessage"]="character not valid in domain part";
      }
      else if (preg_match('/\\.\\./', $domain))
      {
         // domain part has two consecutive dots
         $isValid = false;
		 $_SESSION["errorMessage"]="domain part has two consecutive dots";
      }
      else if
(!preg_match('/^(\\\\.|[A-Za-z0-9!#%&`_=\\/$\'*+?^{}|~.-])+$/',
                 str_replace("\\\\","",$local)))
      {
         // character not valid in local part unless 
         // local part is quoted
         if (!preg_match('/^"(\\\\"|[^"])+"$/',
             str_replace("\\\\","",$local)))
         {
            $isValid = false;
			$_SESSION["errorMessage"]="character not valid in local part";
        }
      }
      if ($isValid && !(checkdnsrr($domain,"MX") || checkdnsrr($domain,"A")))
      {
         // domain not found in DNS
         $isValid = false;
		 $_SESSION["errorMessage"]="domain not found in DNS";
      }
   }
   return $isValid;
}
function sanitizedboutput($str){
	return stripslashes($str);
}
function cleanInput($input) {
  $search = array(
    '@<script[^>]*?>.*?</script>@si',   // Strip out javascript
    '@<[\/\!]*?[^<>]*?>@si',            // Strip out HTML tags
    '@<style[^>]*?>.*?</style>@siU',    // Strip style tags properly
    '@<![\s\S]*?--[ \t\n\r]*>@'         // Strip multi-line comments
  );
    $output = preg_replace($search, '', $input);
    return $output;
}
function clean($input) 
{
    if (is_array($input)) {
        foreach($input as $var=>$val) {
            $output[$var] = clean($val);
        }
    }
    else {
        if (get_magic_quotes_gpc()) {
            $input = stripslashes($input);
        }
		
		$input = @trim($input);
		$input=preg_replace( '/\s+/', ' ',($input));
        $input  = cleanInput($input);
        $output = mysql_real_escape_string(str_replace(">","",str_replace("<","",str_replace('"',"",str_replace("'","",str_replace("=","",str_replace("(","",str_replace(")","",str_replace("/","",str_replace("?","",str_replace("%","",$input)))))))))));
    }
    return $output;
}

function getSingleDbValue($fieldName,$tableName,$qrCondition)
{
	$fieldVal='';
	unset($selectFields);
	unset($whereFields);
	unset($whereVals);
	
	$strFIeldVal="";
	$strFIeldVal="SELECT $fieldName FROM $tableName $qrCondition ";
	$resFIeldVal=getRecords(_TTT_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$strFIeldVal);
	if($resFIeldVal)
	{
		$rowFIeldVal=mysql_fetch_array($resFIeldVal);
		$fieldVal=$rowFIeldVal[0];	
	}
	return $fieldVal;
}














function image_fix_orientation($filename) {
    $exif = exif_read_data($filename);
    if (!empty($exif['Orientation'])) {
        $image = imagecreatefromjpeg($filename);
        switch ($exif['Orientation']) {
            case 3:
                $image = imagerotate($image, 180, 0);
                break;

            case 6:
                $image = imagerotate($image, -90, 0);
                break;

            case 8:
                $image = imagerotate($image, 90, 0);
                break;
        }

        imagejpeg($image, $filename, 90);
    }
}





function generate_image_thumbnail($source_image_path, $thumbnail_image_path, $thumbnail_image_width, $source_image_height)
{
    list($source_image_width, $source_image_height, $source_image_type) = getimagesize($source_image_path);
    switch ($source_image_type) {
        case IMAGETYPE_GIF:
            $source_gd_image = imagecreatefromgif($source_image_path);
            break;
        case IMAGETYPE_JPEG:
            $source_gd_image = imagecreatefromjpeg($source_image_path);
            break;
        case IMAGETYPE_PNG:
            $source_gd_image = imagecreatefrompng($source_image_path);
            break;
    }
    if ($source_gd_image === false) {
        return false;
    }
    $source_aspect_ratio = $source_image_width / $source_image_height;
    $thumbnail_aspect_ratio = $thumbnail_image_width / $thumbnail_image_height;
    if ($source_image_width <= $thumbnail_image_width && $source_image_height <= $thumbnail_image_height) {
        $thumbnail_image_width = $source_image_width;
        $thumbnail_image_height = $source_image_height;
    } elseif ($thumbnail_aspect_ratio > $source_aspect_ratio) {
        $thumbnail_image_width = (int) ($thumbnail_image_height * $source_aspect_ratio);
        $thumbnail_image_height = $thumbnail_image_height;
    } else {
        $thumbnail_image_width = $thumbnail_image_width;
        $thumbnail_image_height = (int) ($thumbnail_image_width / $source_aspect_ratio);
    }
    $thumbnail_gd_image = imagecreatetruecolor($thumbnail_image_width, $thumbnail_image_height);
    imagecopyresampled($thumbnail_gd_image, $source_gd_image, 0, 0, 0, 0, $thumbnail_image_width, $thumbnail_image_height, $source_image_width, $source_image_height);

    $img_disp = imagecreatetruecolor($thumbnail_image_width,$thumbnail_image_width);
    $backcolor = imagecolorallocate($img_disp,0,0,0);
    imagefill($img_disp,0,0,$backcolor);

        imagecopy($img_disp, $thumbnail_gd_image, (imagesx($img_disp)/2)-(imagesx($thumbnail_gd_image)/2), (imagesy($img_disp)/2)-(imagesy($thumbnail_gd_image)/2), 0, 0, imagesx($thumbnail_gd_image), imagesy($thumbnail_gd_image));

    imagejpeg($img_disp, $thumbnail_image_path, 90);
    imagedestroy($source_gd_image);
    imagedestroy($thumbnail_gd_image);
    imagedestroy($img_disp);
    return true;
}


 function makeThumbnails($updir, $img, $id,$MaxWe=100,$MaxHe=150){
    $arr_image_details = getimagesize($img); 
    $width = $arr_image_details[0];
    $height = $arr_image_details[1];

    $percent = 100;
    if($width > $MaxWe) $percent = floor(($MaxWe * 100) / $width);

    if(floor(($height * $percent)/100)>$MaxHe)  
    $percent = (($MaxHe * 100) / $height);

    if($width > $height) {
        $newWidth=$MaxWe;
        $newHeight=round(($height*$percent)/100);
    }else{
        $newWidth=round(($width*$percent)/100);
        $newHeight=$MaxHe;
    }

    if ($arr_image_details[2] == 1) {
        $imgt = "ImageGIF";
        $imgcreatefrom = "ImageCreateFromGIF";
    }
    if ($arr_image_details[2] == 2) {
        $imgt = "ImageJPEG";
        $imgcreatefrom = "ImageCreateFromJPEG";
    }
    if ($arr_image_details[2] == 3) {
        $imgt = "ImagePNG";
        $imgcreatefrom = "ImageCreateFromPNG";
    }


    if ($imgt) {
        $old_image = $imgcreatefrom($img);
        $new_image = imagecreatetruecolor($newWidth, $newHeight);
        imagecopyresized($new_image, $old_image, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);

       $imgt($new_image, $updir);
        return;    
    }
}

 










function makedatetime($ptime)
{
    $etime = time() - $ptime;

    if ($etime < 1)
    {
        return '0 seconds';
    }

    $a = array( 365 * 24 * 60 * 60  =>  'year',
                 30 * 24 * 60 * 60  =>  'month',
                      24 * 60 * 60  =>  'day',
                           60 * 60  =>  'hour',
                                60  =>  'minute',
                                 1  =>  'second'
                );
    $a_plural = array( 'year'   => 'years',
                       'month'  => 'months',
                       'day'    => 'days',
                       'hour'   => 'hours',
                       'minute' => 'minutes',
                       'second' => 'seconds'
                );

    foreach ($a as $secs => $str)
    {
        $d = $etime / $secs;
        if ($d >= 1)
        {
            $r = round($d);
            return $r . ' ' . ($r > 1 ? $a_plural[$str] : $str) . ' ago';
        }
    }
}


function findExtension ($filename)
{
   $filename = strtolower($filename) ;
   $exts = explode(".", $filename) ;
   $n = count($exts)-1;
   $exts = $exts[$n];
   return $exts;
}


function showsmily($str)
{
  $siteurl='http://scgindia.in/konectt/php/';
  
  $str=str_replace(':)','<img src="'.$siteurl.'images/emoji/happy.png">',$str);
  $str=str_replace('):','<img src="'.$siteurl.'images/emoji/unhappy.png">',$str);
  $str=str_replace(';)','<img src="'.$siteurl.'images/emoji/surprised.png">',$str);
  
  $str=str_replace(':win:','<img src="'.$siteurl.'images/emoji/wink.png">',$str);
  $str=str_replace(':tno:','<img src="'.$siteurl.'images/emoji/tongue-out.png">',$str); 
  $str=str_replace(':sus:','<img src="'.$siteurl.'images/emoji/suspicious.png">',$str); 
  $str=str_replace(':smi:','<img src="'.$siteurl.'images/emoji/smiling.png">',$str); 
  $str=str_replace(':sml:','<img src="'.$siteurl.'images/emoji/smile.png">',$str); 
  $str=str_replace(':srt:','<img src="'.$siteurl.'images/emoji/smart.png">',$str); 
  $str=str_replace(':set:','<img src="'.$siteurl.'images/emoji/secret.png">',$str); 
  $str=str_replace(':sd:','<img src="'.$siteurl.'images/emoji/sad.png">',$str); 
  $str=str_replace(':qit:','<img src="'.$siteurl.'images/emoji/quiet.png">',$str); 
  $str=str_replace(':nnj:','<img src="'.$siteurl.'images/emoji/ninja.png">',$str); 
  $str=str_replace(':nrd:','<img src="'.$siteurl.'images/emoji/nerd.png">',$str); 
  $str=str_replace(':md:','<img src="'.$siteurl.'images/emoji/mad.png">',$str); 
  $str=str_replace(':kis:','<img src="'.$siteurl.'images/emoji/kissing.png">',$str); 
  $str=str_replace(':lov:','<img src="'.$siteurl.'images/emoji/in-love.png">',$str); 
  $str=str_replace(':ill:','<img src="'.$siteurl.'images/emoji/ill.png">',$str); 
  $str=str_replace(':hp4:','<img src="'.$siteurl.'images/emoji/happy-4.png">',$str); 
  $str=str_replace(':hp3:','<img src="'.$siteurl.'images/emoji/happy-3.png">',$str); 
  $str=str_replace(':hp2:','<img src="'.$siteurl.'images/emoji/happy-2.png">',$str); 
  $str=str_replace(':hp1:','<img src="'.$siteurl.'images/emoji/happy-1.png">',$str);  
  $str=str_replace(':emt:','<img src="'.$siteurl.'images/emoji/emoticons.png">',$str); 
  $str=str_replace(':emb:','<img src="'.$siteurl.'images/emoji/embarrassed.png">',$str); 
  $str=str_replace(':cr:','<img src="'.$siteurl.'images/emoji/crying.png">',$str); 
  $str=str_replace(':con:','<img src="'.$siteurl.'images/emoji/confused.png">',$str); 
  $str=str_replace(':bo:','<img src="'.$siteurl.'images/emoji/bored.png">',$str); 
  $str=str_replace(':brd:','<img src="'.$siteurl.'images/emoji/bored-2.png">',$str); 
  $str=str_replace(':br1:','<img src="'.$siteurl.'images/emoji/bored-1.png">',$str); 
  $str=str_replace(':ang:','<img src="'.$siteurl.'images/emoji/angry.png">',$str); 
  $str=str_replace(':ned:','<img src="'.$siteurl.'images/emoji/mad.png">',$str); 
  
 return $str;
}

function GetRecordList($select,$tablename,$where,$limit,$page,$targetpage){ 

if(is_numeric($page) && $page!=''){

$page=$page;

} else {

$page=1;

}

if(is_numeric($limit) && $limit!=''){

$limit=$limit;

} else {

$limit=25;

} 

$query = "SELECT COUNT(*) as num FROM ".$tablename."  ".$where."";

$total_pages = mysql_fetch_array(mysql_query($query));

$total_pages = $total_pages[num];

$stages = 3;

$page = mysql_escape_string($page);

if($page){

$start = ($page - 1) * $limit; 

}else{

$start = 0;	

}	 

$query1 = "SELECT ".$select." FROM ".$tablename."  ".$where." LIMIT $start,  ".$limit."";

$result=mysql_query($query1) or die(mysql_error());



 

//--------------paging--------------------



if ($page == 0){$page = 1;}

$prev = $page - 1;	

$next = $page + 1;		

$lastpage = ceil($total_pages/$limit);	

$LastPagem1 = $lastpage - 1;

$paginate = '';

if($lastpage > 1)

{	

$paginate .= "<div class='paginate'>";

if ($page > 1){

$paginate.= "<a href='".$targetpage."page=$prev'>Previous</a>";

}else{

$paginate.= "<span class='disabled'>Previous</span>";	}



if ($lastpage < 7 + ($stages * 2))

{

for ($counter = 1; $counter <= $lastpage; $counter++)

{

if ($counter == $page){

$paginate.= "<span class='current'>$counter</span>";

}else{

$paginate.= "<a href='".$targetpage."page=$counter'>$counter</a>";}

}

}

elseif($lastpage > 5 + ($stages * 2))

{

if($page < 1 + ($stages * 2))

{

for ($counter = 1; $counter < 4 + ($stages * 2); $counter++)

{

if ($counter == $page){

$paginate.= "<span class='current'>$counter</span>";

}else{

$paginate.= "<a href='".$targetpage."page=$counter'>$counter</a>";}

}

$paginate.= "...";

$paginate.= "<a href='".$targetpage."page=$LastPagem1'>$LastPagem1</a>";

$paginate.= "<a href='".$targetpage."page=$lastpage'>$lastpage</a>";

}

elseif($lastpage - ($stages * 2) > $page && $page > ($stages * 2))

{

$paginate.= "<a href='".$targetpage."page=1'>1</a>";

$paginate.= "<a href='".$targetpage."page=2'>2</a>";

$paginate.= "...";

for ($counter = $page - $stages; $counter <= $page + $stages; $counter++)

{

if ($counter == $page){

$paginate.= "<span class='current'>$counter</span>";

}else{

$paginate.= "<a href='".$targetpage."page=$counter'>$counter</a>";}

}

$paginate.= "...";

$paginate.= "<a href='".$targetpage."page=$LastPagem1'>$LastPagem1</a>";

$paginate.= "<a href='".$targetpage."page=$lastpage'>$lastpage</a>";

}

else

{

$paginate.= "<a href='".$targetpage."page=1'>1</a>";

$paginate.= "<a href='".$targetpage."page=2'>2</a>";

$paginate.= "...";

for ($counter = $lastpage - (2 + ($stages * 2)); $counter <= $lastpage; $counter++)

{

if ($counter == $page){

$paginate.= "<span class='current'>$counter</span>";

}else{

$paginate.= "<a href='".$targetpage."page=$counter'>$counter</a>";}

}

}

} if ($page < $counter - 1){

$paginate.= "<a href='".$targetpage."page=$next'>Next</a>";

}else{

$paginate.= "<span class='disabled'>Next</span>";

}

$paginate.= "</div>";

}











return array($result,$total_pages,$paginate); 

}

?>