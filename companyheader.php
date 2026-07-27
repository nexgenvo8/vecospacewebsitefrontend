<div class="comp-head">
  <div class="comp-logo">
    <?php if ($createdby == $_SESSION["sessUserId"]) { ?>
      <form class="edit" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
        target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
        <span><i class="fa fa-pencil" aria-hidden="true"></i>
          <input name="companyprofilephoto" id="companyprofilephoto" type="file"
            onChange="$('#commonloader').show();$('#frmposthome').submit();"
            style="left:0px; top:0px; width:100%; height:100%;opacity: 0; filter: alpha(opacity=0); ">
          <input type="hidden" id="postId" name="postId" value="<?php echo $_REQUEST["companyId"]; ?>">
          <input type="hidden" id="action" name="action" value="cmpprofilephoto">
          <input type="hidden" id="companylogoimageOld" name="companylogoimageOld"
            value="<?php echo stripslashes(trim($companyPhoto)); ?>">
        </span>
      </form><?php } ?>

    <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($companyPhoto)); ?>">


  </div>
  <div class="comp-heading"><?php echo stripslashes($empCompanyName); ?>
    <span><?php if ($createdby == $_SESSION["sessUserId"]) {
      if ($companyStatus == 0) { ?>   <?php } else { ?>
          <div style="color:#FF0000; margin-left:10px;float: none;" class="deactivategrp">Under reviewing</div>
        <?php }
    } ?>
    </span>
    <div class="indstry">
      <?php
      if (!isset($industrySubTypeName)) {
        $industrySubTypeName = '';
      }
      ?>
      <?php echo stripslashes($industryTypeName); ?>
      <?php if (trim($industrySubTypeName) != '') {
        echo $industrySubTypeName;
      } ?>

      - <span id="companyfollowers"></span>
    </div>

    <div class="managed-by">
      <div class="follow-comp-btn">
        <?php
        if ($_SESSION["sessUserId"] != '' && $_SESSION["sessUserId"] != 0) {
          if ($createdby != $_SESSION["sessUserId"]) {
            $apc = "select id from " . _COMPANY_FOLLOWERS_TABLE_ . " where  companyId= " . decodeStr($_REQUEST['companyId']) . " and userId=" . $_SESSION["sessUserId"] . " ";
            $bpc = mysqli_query($conn, $apc) or die(mysqli_error($conn));
            if (mysqli_num_rows($bpc) > 0) { ?>
              <a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo trim($_REQUEST["companyId"]); ?>&status=2"
                class="btn"><i class="fa fa-minus" aria-hidden="true"></i> Unfollow this company
              </a>
            <?php } else { ?><a
                href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo trim($_REQUEST["companyId"]); ?>&status=1"
                class="btn"><i class="fa fa-plus" aria-hidden="true"></i> Follow this company
              </a>
            <?php }
          }
        }
        ?>
      </div>
    </div>
  </div>


</div>

<ul class="cntr_tab">
  <li><a href="<?php echo $fullurl; ?>company-profile.html?companyId=<?php echo $_REQUEST['companyId']; ?>" <?php if ($p == 1) { ?>class="active" <?php } ?>>About us</a></li>
  <li><a href="<?php echo $fullurl; ?>company-updates.html?companyId=<?php echo $_REQUEST['companyId']; ?>" <?php if ($p == 2) { ?>class="active" <?php } ?>>Updates</a></li>
  <li><a href="<?php echo $fullurl; ?>employees.html?companyId=<?php echo $_REQUEST['companyId']; ?>" <?php if ($p == 3) { ?>class="active" <?php } ?>>Employees
      <?php if ($totalEmployeesTotals > 0) { ?>(<?php echo $totalEmployeesTotals; ?>)<?php } ?></a></li>
  <li><a href="<?php echo $fullurl; ?>company-jobs.html?companyId=<?php echo $_REQUEST['companyId']; ?>" <?php if ($p == 4) { ?>class="active" <?php } ?>>Jobs</a></li>
</ul>