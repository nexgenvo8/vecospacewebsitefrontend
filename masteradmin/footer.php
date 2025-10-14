<?php 
if($PageViewRestrict!='1'){header("location:logout.php");
exit();} else {
?><link href="css/main.css" rel="stylesheet" type="text/css" />
 <div class="popouter" id="outerpop" style=" display:none;"></div>
 <div class="pupmid" id="innerpop" style=" display:none;">
 <div class="popbox" style="width:696px; margin:auto;">
 <div class="boxheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Setting</td>
    <td><a href="#" onclick="closesettingpop();"><img src="images/close_square_black-24.png" border="0"  style="float:right;"/></a></td>
  </tr>
</table>
 </div> 
 <div class="loading" id="msgload" style="display:none;">Please Wait Working...</div>
 <div class="loading" id="wrongloginclick" style="display:none;">Password not changed please try again</div>
 <div class="successmsg" id="successmsg" style="display:none;">Password Changed Successfully</div>
 <table border="0" cellpadding="15" cellspacing="0" class="bordergray txtfileds" >
  <tr>
    <td align="left" valign="top"><form name="profile" method="post" action="">
      <table border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td colspan="2"><strong>Profile</strong></td>
        </tr>
        <tr>
          <td><label>Name </label></td>
          <td><input name="name" type="text" class="formfld" id="name" value="<?php echo stripslashes($profile['name']); ?>" size="35" style="width:200px;" /></td>
        </tr>
        <tr>
          <td>Company  </td>
          <td><input name="company" type="text" class="formfld" id="company" value="<?php echo stripslashes($profile['company']); ?>" size="35" style="width:200px;"/></td>
        </tr>
        <tr>
          <td>Email</td>
          <td><input name="email" type="text" class="formfld" id="email" value="<?php echo stripslashes($profile['email']); ?>" size="35" style="width:200px;"/></td>
        </tr>
        <tr>
          <td height="35">&nbsp;</td>
          <td align="left"><input type="submit" name="Submit22" value="Update Profile" class="bluebutton" />
            <input name="profile" type="hidden" id="profile" value="profile"><input name="pr" type="hidden" id="pr" value="1"></td>
        </tr>
      </table>
        </form>    </td>
    <td align="right" valign="top" style="border-left:1px #333333 solid;"><form name="password" method="post" action="resetpassword.php" target="postfrm"><table border="0" cellpadding="5" cellspacing="0">
        
        <tr>
          <td colspan="2"><strong>Change Password </strong></td>
        </tr>
        <tr>
          <td><label>Old Password </label></td>
          <td><input name="oldpassword" type="password" class="formfld" id="oldpassword" size="35" style="width:200px;"/></td>
        </tr>
        <tr>
          <td>New Password            </td>
          <td><input name="password" type="password" class="formfld" id="password" size="35" style="width:200px;"/></td>
        </tr>
        <tr>
          <td>Confirm Password </td>
          <td><input name="copassword" type="password" class="formfld" id="copassword" size="35" style="width:200px;"/></td>
        </tr>
        <tr>
          <td height="35">&nbsp;</td>
          <td align="left"><input type="submit" name="Submit2" value="Update Password" class="bluebutton" />
            <input name="p1" type="hidden" id="p1" value="p1"></td>
        </tr>
      </table>
    </form></td>
  </tr>
</table>
</div>
 </div>
 
 
 
 <div class="pupmid" id="pageimagebox" style=" display:none;   margin-top:40px;">
 <div class="popbox" style="width:930px; margin:auto;">
 <div class="boxheader"><table width="100%" border="0" cellpadding="0" cellspacing="0">
  <tr>
    <td>Select Image </td>
    <td><a href="#" onclick="closepageimg();"><img src="images/close_square_black-24.png" border="0"  style="float:right;"/></a></td>
  </tr>
</table>
 </div> 
 <div class="loading" id="msgload" style="display:none;">Please Wait Working...</div>
 <div class="loading" id="wrongloginclick" style="display:none;">Password not changed please try again</div>
 <div class="successmsg" id="successmsg" style="display:none;">Password Changed Successfully</div>
  <iframe style="height:480px; width:100%;" frameborder="0" src="pageimg.php" id="pageimgid" name="pageimgid"></iframe> </div>
 </div>
 
 <iframe id="postfrm" name="postfrm" src="" style="display:none;"></iframe><?php }?>