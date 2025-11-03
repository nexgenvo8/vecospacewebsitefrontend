<?php
include_once('inc.php');

$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];


$sqlUser = "";
$sqlUser = "select * from " . _USERS_MASTER_TABLE_ . " where userId IN (SELECT userId from " . _USER_SETTINGS_MASTER_TABLE_ . " WHERE pendingContactRequest=1) and activeYN='Y'  and userId!=106  ";
//$sqlUser="select * from "._USERS_MASTER_TABLE_." where email='r.pahat786@gmail.com' and activeYN='Y'  and userId!=106  ";
$resUser = getRecords(_USERS_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlUser);
if ($resUser) {
  include_once('mail.php');
  while ($rowUser = mysqli_fetch_array($resUser)) {


    $sqlLogin = "";
    $sqlLogin = "select * from " . _CONTACT_MASTER_TABLE_ . " where userId='" . $rowUser['userId'] . "' and status=0 order by id desc limit 0,1";
    $resLogin = getRecords(_CONTACT_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
    if ($resLogin) {
      while ($rowLogin = mysqli_fetch_array($resLogin)) {

        $a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowLogin["contactId"] . "";
        $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
        $userres = mysqli_fetch_array($b);

        $friendnameurl = $userres['userurl'];
        if ($userres["profilePhoto"] != '') {
          $userphoto = $userres["profilePhoto"];
        } else {
          $userphoto = 'user-placeholder.jpg';
        }

        $firstName = $userres["firstName"];
        $lastName = $userres["lastName"];

        $mycountryName = $userres["countryName"];
        $mystateName = $userres["cityName"];
        $mylocationName = $userres["locationName"];
        $mycompanyName = $userres["companyName"];
        $myjobTitle = $userres["jobTitle"];

        $dateAdded = $rowLogin["dateAdded"];
        $emailsentdate = $rowLogin["emailsentdate"];

        $email = $userres["email"];

        $userId = $userres["userId"];

        if ($dateAdded != '' && $emailsentdate == 0) {

          $today = date("Y-m-d", $dateAdded);
          if (date('Y-m-d', strtotime(' -2 day')) == $today) {

            $mailBodyContent1 = '';
            $mailBodyContent1 .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sgtlogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
                        
                      
					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">
					  
					 
					  <div style="font-size:14px; margin-bottom:16px;"><strong>' . $firstName . '&#39;s</strong> invitation to ' . $companNameTitle . ' is waiting for your response.</div>
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($userId) . '/' . $friendnameurl . '.html"><img src="' . $fullurl . 'uploads/' . $userphoto . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName . ' ' . $lastName . '</strong></div>';
            if ($jobTitle != '' && $companyName != '') {
              $mailBodyContent1 .= '<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>';
            }
            if ($mystateName != '' && $mycountryName != '') {
              $mailBodyContent1 .= '<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $mystateName . ', ' . $mycountryName . '</div>';
            }
            $mailBodyContent1 .= '</div><div style="text-align:center; margin-top:10px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'contacts.html" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">Add as a Connection</a></td>
    </tr>
</tbody></table>
</div>
					  </div>
                         
                         </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">
                      
                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> - 
                            
                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> - 
                            
                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> - 
                            
                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div> 
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


            $subject = "Pending connection request";

            send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent1);

            $sql_ins = "update " . _CONTACT_MASTER_TABLE_ . " set emailsentdate='" . time() . "' where id= " . $rowLogin["id"] . "";
            mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


          }

        }

        if ($dateAdded != '' && $emailsentdate != 0) {

          $today = date("Y-m-d", $emailsentdate);
          if (date('Y-m-d', strtotime(' -2 day')) == $today) {


            $mailBodyContent = '';
            $mailBodyContent .= '<div bgcolor="#E9E9E9" style="background:#e9e9e9;margin:0;padding:0 10px;font-family:"Open Sans",Arial,Helvetica,sans-serif;font-size:15px;line-height:24px;border-bottom:10px solid #33a9d7">
<table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" height="100%" style="background-color:#e9e9e9;border-collapse:collapse;margin:0;padding:0">
    <tbody>
    <tr>
        <td align="center" valign="top">
            <table align="center" border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse:collapse;max-width:550px">
                <tbody>
                <tr>
                    <td align="center" valign="top" style="width:100%;padding:20px 0">
                        <a href="' . $fullurl . '" target="_blank" >
                            <img src="' . $fullurl . 'images/sgtlogo.png" alt="' . $companNameTitle . '" width="100%" border="0" align="center" style="display:inline-block;text-align:center;max-width:140px">                        </a>                    </td>
                </tr>
                <tr>
                  <td align="center" width="100%" style="background:#fff;color:#484848;padding:40px;border-radius:4px;    border-bottom: #33a9d7 solid 5px;">
                        
                      
					  <div style="background-color:#f6f9fb; padding:20px; text-align:center;">
					  
					 
					  <div style="font-size:14px; margin-bottom:16px;"><strong>' . $firstName . '&#39;s</strong> invitation to ' . $companNameTitle . ' is waiting for your response.</div>
					    <div style="text-align:center;"><div style="
    width: 80px;
    height: 80px;
    overflow: hidden;margin:auto;
    margin-bottom:12px;
    border-radius: 100%;
    border: 3px #e9e9e9 solid; margin:auto;
"><a href="' . $fullurl . 'profile/' . encodeStr($userId) . '/' . $friendnameurl . '.html"><img src="' . $fullurl . 'uploads/' . $userphoto . '" style="
    width: 100%;
"></a></div>
<div style="text-align:center; margin-bottom:5px; margin-top:5px;"><strong>' . $firstName . ' ' . $lastName . '</strong></div>';
            if ($jobTitle != '' && $companyName != '') {
              $mailBodyContent .= '<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $jobTitle . ' at ' . $companyName . '</div>';
            }
            if ($mystateName != '' && $mycountryName != '') {
              $mailBodyContent .= '<div style="text-align:center; margin-bottom:2px; font-size:11px; color:#666666;">' . $mystateName . ', ' . $mycountryName . '</div>';
            }
            $mailBodyContent .= '</div><div style="text-align:center; margin-top:10px;"><table border="0" align="center" cellpadding="5" cellspacing="0">
  <tbody><tr>
    <td colspan="2" align="center"><a href="' . $fullurl . 'contacts.html" style="display:inline-block;text-decoration:none;padding:15px 25px;font-weight:600;font-size:18px;margin:0 0 30px;color:#fff;background:#0abe51;border-radius:5px;margin-bottom: 0px;" target="_blank">Add as a Connection</a></td>
    </tr>
</tbody></table>
</div>
					  </div>
                         
                         </td>
                </tr>
                <tr>
                    <td align="center" style="padding:40px;margin:0">
                       <div style="text-align:center; font-size:12px; margin-bottom:20px;">
                      
                       <a href="' . $fullurl . 'privacy.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Privacy</a> - 
                            
                          <a href="' . $fullurl . 'terms.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">Terms</a> - 
                            
                        <a href="' . $fullurl . 'about.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">About</a> - 
                            
                          <a href="' . $fullurl . 'faq.html" target="_blank" style="color:#1a94c3; text-decoration:none; color:#616161;">FAQ</a>                       </div> 
<p style="margin:0;padding:0;font-family:"Open Sans",Arial,Helvetica,sans-serif;line-height:24px;color:#616161;font-size:14px;text-align:center">
                             Powered by <a href="' . $fullurl . '" style="color:#1a94c3; text-decoration:none;">' . $domainname . '</a></p>                    </td>
                </tr>
                </tbody>
            </table>
        </td>
    </tr>
    </tbody>
</table>


</div>';


            $subject = "Pending connection request";


            send_template_mail(_FROM_EMAIL_TEMPLATE_ID_, $email, $subject, $mailBodyContent);

            $sql_ins = "update " . _CONTACT_MASTER_TABLE_ . " set emailsentdate='" . time() . "' where id= " . $rowLogin["id"] . "";
            mysqli_query($conn, $sql_ins) or die(mysqli_error($conn));


          }

        }

      }
    }
  }

}
?>