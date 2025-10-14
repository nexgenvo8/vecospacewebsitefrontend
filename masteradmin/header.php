<?php 
if($PageViewRestrict!='1'){header("location:logout.php");
exit();} else {
?><div id="header">
 <div style="padding:0px 10px;">
   <table width="100%" border="0" cellpadding="0" cellspacing="0"  >
     <tr>
       <td width="50%" align="left" valign="middle" style="font-size:14px;"><img src="../images/logo.png" style="height:50px;"></td>
       <td width="50%" align="right"><table border="0" cellpadding="0" cellspacing="0">
         <tr>
           <td align="right" style="padding-right:20px;"><strong>Welcome <?php echo $profile['name']; ?></strong>&nbsp;|&nbsp;<a href="logout.php" style="color:#137fa9;">Logout</a></td>
           <td align="right"><a href="#" onclick="opensettingpop();"><img src="images/editor_setting_gear_-24.png" width="24" height="24" border="0" /></a></td>
         </tr>
       </table></td>
     </tr>
   </table>
   </div>
 </div><?php }?>