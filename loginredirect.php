<?php
include_once('inc.php'); 
include_once('config/session-check.inc.php'); // check user login session




function getBrowser() 
{ 
    $u_agent = $_SERVER['HTTP_USER_AGENT']; 
    $bname = 'Unknown';
    $platform = 'Unknown';
    $version= "";

    //First get the platform?
    if (preg_match('/linux/i', $u_agent)) {
        $platform = 'linux';
    }
    elseif (preg_match('/macintosh|mac os x/i', $u_agent)) {
        $platform = 'mac';
    }
    elseif (preg_match('/windows|win32/i', $u_agent)) {
        $platform = 'windows';
    }elseif (preg_match('/android/i', $u_agent)){
        $platform = 'Android';
    }elseif (preg_match('/iphone/i', $u_agent)){
        $platform = 'iPhone';
    }
    elseif (preg_match('/webos/i', $u_agent)){
        $platform = 'Mobile';
    }


    // Next get the name of the useragent yes seperately and for good reason
    if(preg_match('/MSIE/i',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { 
        $bname = 'Internet Explorer'; 
        $ub = "MSIE"; 
    } 
    elseif(preg_match('/Firefox/i',$u_agent)) 
    { 
        $bname = 'Mozilla Firefox'; 
        $ub = "Firefox"; 
    }
    elseif(preg_match('/OPR/i',$u_agent)) 
    { 
        $bname = 'Opera'; 
        $ub = "Opera"; 
    } 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    { 
        $bname = 'Google Chrome'; 
        $ub = "Chrome"; 
    } 
    elseif(preg_match('/Safari/i',$u_agent)) 
    { 
        $bname = 'Apple Safari'; 
        $ub = "Safari"; 
    } 
    elseif(preg_match('/Netscape/i',$u_agent)) 
    { 
        $bname = 'Netscape'; 
        $ub = "Netscape"; 
    } 
    elseif(preg_match('/mobile/i',$u_agent)) 
    { 
        $bname = 'Handheld Browser'; 
        $ub = "Handheld Browser"; 
    } 

    // finally get the correct version number
    $known = array('Version', $ub, 'other');
    $pattern = '#(?<browser>' . join('|', $known) .
    ')[/ ]+(?<version>[0-9.|a-zA-Z.]*)#';
    if (!preg_match_all($pattern, $u_agent, $matches)) {
        // we have no matching number just continue
    }

    // see how many we have
    $i = count($matches['browser']);
    if ($i != 1) {
        //we will have two since we are not using 'other' argument yet
        //see if version is before or after the name
        if (strripos($u_agent,"Version") < strripos($u_agent,$ub)){
            $version= $matches['version'][0];
        }
        else {
            $version= $matches['version'][1];
        }
    }
    else {
        $version= $matches['version'][0];
    }

    // check if we have a number
    if ($version==null || $version=="") {$version="?";}

    return array(
        'userAgent' => $u_agent,
        'name'      => $bname,
        'version'   => $version,
        'platform'  => $platform,
        'pattern'    => $pattern
    );
} 
 
$ua=getBrowser();
$yourbrowser= $ua['name'] . " " . $ua['version'];

		$ip_address='';
		$ip_address=$_SERVER['REMOTE_ADDR'];
					
					  
					   //$geopluginURL='https://www.geoplugin.net/php.gp?ip='.$ip_address; $addrDetailsArr = unserialize(file_get_contents($geopluginURL)); 
					  
					   //$city = $addrDetailsArr['geoplugin_city'];
					   $city = '';
					    
						// $country = $addrDetailsArr['geoplugin_countryName'];
						 $country = '';
					
					$sql_ins="INSERT INTO "._SESSION_MASTER_TABLE_." SET userId='".$_SESSION["sessUserId"]."', loginIp='".$ip_address."',loginTime=".time().",loginFrom='".$country."', browser='".addslashes($yourbrowser)."' ";
					mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));
					
 

    if($_SESSION['groupjoiningurl']!='')
	{
		header("location:".$_SESSION['groupjoiningurl']."");
		exit();
	}
	else
	{
		if($_SESSION['shareredirecturl']!='')
		{
			header("location:".$_SESSION['shareredirecturl']."");
			exit();
		}
		else
		{
			if($_SESSION['loginredirectpageurl']!='') //2-5-18 Rk.
			{
				header("location:".$_SESSION['loginredirectpageurl']."");
				$_SESSION['loginredirectpageurl']='';
				exit();
			}
			else
			{
				header("location:".$fullurl."");
				exit();
			}
	
		}
	}
?>