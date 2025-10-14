<?php
include_once('inc.php');
include_once('config/session-check.inc.php'); // check user login session
$startpage = $_REQUEST['startpage'];
$endpage = $_REQUEST['endpage'];
$pageid = $_REQUEST['pageid'];

$whereStr = '';
if ($_REQUEST['view'] == 1) {
  $whereStr = ' and postType=2';
}
if ($_REQUEST['view'] == 2) {
  $whereStr = ' and postType=3';
}


$n = 0;
$selectFields = [];
$whereFields = [];
$whereVals = [];

$sqlLogin = "";
$sqlLogin = "select * from " . _TIMELINE_MASTER_TABLE_ . " where userId='" . $_SESSION['sessUserId'] . "' and postId!=0  " . $whereStr . "   order by dateAdded desc limit " . $startpage . "," . $endpage . " ";
$resLogin = getRecords(_TIMELINE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlLogin);
if ($resLogin) {
  while ($row = mysqli_fetch_array($resLogin)) {


    $aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
    $res5 = mysqli_query($conn, $aa);
    $totalpostlike = mysqli_num_rows($res5);

    $aa = "SELECT * from " . _COMMENT_MASTER_TABLE_ . " WHERE postId= " . $row["postId"] . " and postType= " . $row["postType"] . "";
    $res5 = mysqli_query($conn, $aa);
    $totalpostcomment = mysqli_num_rows($res5);



    $a = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $row["userId"] . "";
    $b = mysqli_query($conn, $a) or die(mysqli_error($conn));
    $userres = mysqli_fetch_array($b);



    $jobTitle = $userres["jobTitle"];
    $companyName = $userres["companyName"];

    $friendnameurl = $userres['userurl'];

    if ($userres["profilePhoto"] != '') {
      $userphoto = $userres["profilePhoto"];
    } else {
      $userphoto = 'user-placeholder.jpg';
    }








    if ($row["postType"] == 1 || $row["postType"] == 2 || $row["postType"] == 3) {

      $sql_inss = "SELECT * from " . _SHAREANDUPDATES_TABLE_ . " WHERE id= " . $row["postId"] . "";
      $resresults = mysqli_query($conn, $sql_inss) or die(mysqli_error($conn));
      $rowResults = mysqli_fetch_array($resresults);



      ?>

      <div class="timlist" id="<?php echo $rowResults['id']; ?>">
        <div class="hedr">
          <div class="prfl_img"> <a
              href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
                src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a> </div>
          <div class="hdr_right"><a
              href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
              <?php echo stripslashes(trim($userres["lastName"])); ?></a>
            <?php if ($row["postType"] == 3) { ?>
              <span class="timelinecontantsubline"> posted an article</span>
            <?php } ?>
            <label class="time"><?php echo $jobTitle; ?>
              <?php if ($companyName != '') {
                echo 'at ' . $companyName;
              } ?>
            </label>
            <label class="time"><?php echo makedatetime($row["dateAdded"]); ?></label>
          </div>
          <?php if ($userres['userId'] == $_SESSION['sessUserId']) { ?>
            <?php if ($row["postType"] == 1 || $row["postType"] == 2) { ?>
              <div class="errow-drop"> <span class="errow"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                <ul class="erow-list">
                  <li> <a href="common_action.php?dltid=<?php echo encodeStr($rowResults['id']); ?>&action=dlt"
                      target="actionfrm">Remove</a> </li>
                </ul>
              </div>
            <?php } ?>
            <?php if ($row["postType"] == 3) { ?>
              <div class="errow-drop"> <span class="errow"><i class="fa fa-chevron-down" aria-hidden="true"></i></span>
                <ul class="erow-list">
                  <li><a
                      href="<?php echo $fullurl; ?>edit-article.html?editid=<?php echo encodeStr($rowResults['id']); ?>&action=edit">Edit</a>
                  </li>
                  <li><a onclick="alertpopupmain('<?php echo encodeStr($rowResults['id']); ?>','deletearticlepost');">Remove</a>
                  </li>
                </ul>
              </div>
            <?php } ?>
          <?php } ?>
        </div>
        <div class="txtarea">
          <div style=" margin-bottom:10px;">
            <?php if ($row["postType"] == 1 || $row["postType"] == 2) { ?>
              <?php echo stripslashes(nl2br(trim($rowResults["postText"]))); ?>
            <?php } ?>
            <?php if ($row["postType"] == 3) {

              ?>
              <div style="font-size:15px; font-weight:bold; margin-bottom:5px;"><a
                  href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>"><?php echo stripslashes(trim($rowResults["postTitle"])); ?></a>
              </div>
              <div class="timelinelistingcontant">
                <?php echo substr(strip_tags(stripslashes(trim($rowResults["postText"]))), 0, 250); ?>...<a
                  href="<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>">read more</a>
              </div>
            <?php } ?>
          </div>
          <?php

          $a = "";
          $a = "select * from " . _IMAGE_MASTER_TABLE_ . " where postId=" . $row['postId'] . "";
          $b = getRecords(_IMAGE_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $a);
          if ($b) {
            $numrows = mysqli_num_rows($b);
            $width = '100%';

            while ($rowimg = mysqli_fetch_array($b)) {
              ?>
              <img src="<?php echo $fullurl; ?>uploads/<?php echo $rowimg['imageName']; ?>"
                style="position:inline-block; cursor:pointer;" onclick="imagepopupmain('<?php echo $rowimg['id']; ?>');">
            <?php }
          }


          ?>
          <div class="timeline-img"> </div>
        </div>
        <ul class="tmln_fttr">
          <li id="post<?php echo $row["postId"]; ?><?php echo $row["postType"]; ?>"
            onclick="postlike(<?php echo $row["postId"]; ?>,<?php echo $row["postType"]; ?>,<?php if ($totalpostlike != '') {
                    echo $totalpostlike;
                  } else {
                    echo '0';
                  } ?>);">
            <a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
                <?php if ($totalpostlike != '') {
                  echo $totalpostlike;
                } else {
                  echo '0';
                } ?>
              </span></a></li>
          <li id="commentdisplaybox<?php echo $row['postId']; ?><?php echo $row['postType']; ?>" class="triggerBtn"><a><i
                class="fa fa-commenting" aria-hidden="true"></i> Comment <span>
                <?php if ($totalpostcomment != '') {
                  echo $totalpostcomment;
                } else {
                  echo '0';
                } ?>
              </span></a></li>
          <li><a
              onclick="opensharebox('<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['postId']); ?>','<?php echo stripslashes(trim($rowResults["postTitle"])); ?>');"><i
                class="fa fa-share" aria-hidden="true"></i> Share <span>0</span></a></li>
          <?php $arrayCount = '';
          if ($rowResults['viewStatus'] != '') {
            $tagArray = explode(",", $rowResults['viewStatus']);
            $arrayCount = count($tagArray);
            if ($arrayCount == 0 || $arrayCount == '') {
            } else { ?>
              <li class="views"><?php echo $arrayCount;
              if ($arrayCount > 1) {
                echo ' views';
              } else {
                echo ' view';
              } ?></li><?php }
          } ?>
        </ul>
        <div class="commnts-cont">
          <ul class="cmmnt-list" id="postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>">
            Loading...
          </ul>
          <script>
            $('#postcomment<?php echo $row['postId']; ?><?php echo $row['postType']; ?>').load('post-comment.php?postId=<?php echo $row['postId']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=5');
          </script>
          <div class="comnt-write">
            <div class="write-cmnt-pic"> <img
                src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>"> </div>
            <div class="cmnt-inpt">
              <form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post"
                target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
                <input type="text" class="commentrowboxclass" id="commentbox" name="commentbox"
                  placeholder="Type your comment">
                <input name="postId" id="postId" type="hidden" value="<?php echo encodeStr($row['postId']); ?>">
                <input name="limit" id="limit" type="hidden" value="5">
                <input name="action" id="action" type="hidden" value="postcomment">
                <input name="parentId" id="parentId" type="hidden" value="0">
                <input name="postType" id="postType" type="hidden" value="<?php echo $row['postType']; ?>">
                <input name="pageType" id="pageType" type="hidden" value="timeline">
                <input name="userId" id="userId" type="hidden" value="<?php echo encodeStr($userres['userId']); ?>">
                <button type="submit">Post</button>
              </form>
            </div>
          </div>
        </div>
      </div>
      <?php
      //$n++;	

    }




    if ($row["postType"] == 4 && $row["groupId"] != 0 && $userres['userId'] != $_SESSION["sessUserId"]) {


      $aa = "SELECT * from " . _LIKE_MASTER_TABLE_ . " WHERE postId= " . $row["groupId"] . " and postType= " . $row["postType"] . "";
      $res5 = mysqli_query($conn, $aa);
      $totalpostlike = mysqli_num_rows($res5);

      $sql_group = "SELECT * from " . _GROUP_MASTER_TABLE_ . " WHERE id= " . $row["groupId"] . "";
      $resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
      $rowGroupName = mysqli_fetch_array($resgroup);
      if ($rowGroupName["groupType"] == 0) {
        if ($rowGroupName["groupThumb"] != '') {
          $groupThumb = $rowGroupName["groupThumb"];
        } else {
          $groupThumb = 'group.png';
        }

        ?>
        <div class="timlist" id="387">
          <div class="hedr">
            <div class="prfl_img"> <a
                href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
                  src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a> </div>
            <div class="hdr_right"><a
                href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
                <?php echo stripslashes(trim($userres["lastName"])); ?></a><span class="timelinecontantsubline"> created a
                group</span>
              <label class="time"><?php echo $jobTitle; ?>
                <?php if ($companyName != '') {
                  echo '- ' . $companyName;
                } ?>
              </label>
              <label class="time"><?php echo makedatetime($row["dateAdded"]); ?></label>
            </div>
          </div>
          <div class="txtarea">
            <div style=" margin-bottom:10px;">
              <div style="font-size:15px; font-weight:bold; margin-bottom:5px;">
                <ul class="cht_mmbr_list" style="height:auto;    border-radius: 4px;">
                  <li
                    style="border-bottom: 1px #ccc solid;  padding: 16px;  border: 0px; padding-bottom:30px;    background-color: #f2f2f2; margin-bottom:7px;"
                    class="active">
                    <div class="frfl-img" style="float:none; border-bottom:px #CCCCCC solid;"> <a
                        href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroupName['id']); ?>"><img
                          src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($groupThumb)); ?>"></a> <strong
                        style="width:88%; font-size:16px;"><a
                          href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroupName['id']); ?>"
                          style="display:block; margin-top:-1px; font-size:16px;"><?php echo stripslashes(trim($rowGroupName["groupName"])); ?></a></strong>
                      <span
                        style="color:#666666; margin-top: 2px; font-weight:normal;"><?php echo substr(strip_tags(stripslashes(trim($rowGroupName["groupDetails"]))), 0, 100); ?>...</span>

                      <?php
                      $mytotalgroups = 0;
                      $totalm = "SELECT * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroupName['id'] . " and status=1";
                      $retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
                      $mytotalgroups = mysqli_num_rows($retotalm);

                      if ($mytotalgroups > 0) {
                        ?>

                        <div class="share_with" style=" margin-top:10px; position:relative;">
                          <ul class="grp-mmbr_list groupontimeline">
                            <?php

                            $selectFields = [];
                            $whereFields = [];
                            $whereVals = [];

                            $sqlGroupMembers = "";
                            $sqlGroupMembers = "select * from " . _GROUP_MEMBER_MASTER_TABLE_ . " WHERE groupId= " . $rowGroupName['id'] . " and status=1 order by rand() desc LIMIT 0,4 ";
                            $resGroupMembers = getRecords(_GROUP_MEMBER_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
                            if ($resGroupMembers) {
                              while ($rowgroupmembers = mysqli_fetch_array($resGroupMembers)) {

                                $groupmembernameurl = '';
                                $usergroupmemberphoto = '';
                                $aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowgroupmembers["userId"] . "";
                                $bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
                                $usergroupmembers = mysqli_fetch_array($bb);

                                $groupmembernameurl = $usergroupmembers['userurl'];

                                if ($usergroupmembers["profilePhoto"] != '') {
                                  $usergroupmemberphoto = $usergroupmembers["profilePhoto"];
                                } else {
                                  $usergroupmemberphoto = 'user-placeholder.jpg';
                                }

                                ?>
                                <li><a
                                    href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($usergroupmembers['userId']); ?>/<?php echo $groupmembernameurl; ?>.html"><img
                                      title="<?php echo stripslashes(trim($usergroupmembers["firstName"])); ?> <?php echo stripslashes(trim($usergroupmembers["lastName"])); ?>"
                                      alt="<?php echo stripslashes(trim($usergroupmembers["firstName"])); ?> <?php echo stripslashes(trim($usergroupmembers["lastName"])); ?>"
                                      src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($usergroupmemberphoto)); ?>"></a>
                                </li>
                                <?php
                              }
                            }
                            ?>
                          </ul>
                          <div style="position:absolute; right:0px; top:10px; font-size:12px; color:#999999;">
                            <?php echo $mytotalgroups;
                            if ($mytotalgroups > 1) {
                              echo ' members joined this group';
                            } else {
                              echo ' member joined this group';
                            } ?>
                          </div>
                        </div>
                      <?php } ?>

                      <div class="share_with"
                        style="position:absolute; right:0px;    top: 6px;width: initial; margin:0px; padding:0px; border:0px;">


                        <div><?php
                        //$n=0;
                        unset($selectFields);
                        unset($whereFields);
                        unset($whereVals);

                        $sqlCheck = "";
                        $sqlCheck = mysqli_query(
                          $conn,
                          "SELECT * FROM " . _GROUP_MEMBER_MASTER_TABLE_ . " 
     WHERE userId = " . (int) $_SESSION["sessUserId"] . " 
     AND groupId = " . (int) $rowGroupName['id']
                        ) or die(mysqli_error($conn));

                        if (mysqli_num_rows($sqlCheck) == 0) {
                          ?>
                            <a
                              href="<?php echo $fullurl; ?>groups-detail.html?groupId=<?php echo encodeStr($rowGroupName['id']); ?>">
                              <button type="submit">Join Now</button>
                            </a>
                            <?php
                        } ?>
                        </div>

                      </div>

                    </div>
                  </li>
                </ul>
              </div>
            </div>
          </div>
          <!--<ul class="tmln_fttr">
    <li id="post<?php echo $row["groupId"]; ?><?php echo $row["postType"]; ?>" onclick="postlike(<?php echo $row["groupId"]; ?>,<?php echo $row["postType"]; ?>,<?php if ($totalpostlike != '') {
                  echo $totalpostlike;
                } else {
                  echo '0';
                } ?>);"><a><i class="fa fa-thumbs-up" aria-hidden="true"></i> Like <span>
      <?php if ($totalpostlike != '') {
            echo $totalpostlike;
          } else {
            echo '0';
          } ?>
      </span></a></li>
    <li id="commentdisplaybox<?php echo $row['groupId']; ?><?php echo $row['postType']; ?>"><a><i class="fa fa-commenting" aria-hidden="true" ></i> Comment <span>
      <?php if ($totalpostcomment != '') {
            echo $totalpostcomment;
          } else {
            echo '0';
          } ?>
      </span></a></li>
    <li><a onclick="opensharebox('<?php echo $fullurl; ?>view-article.html?postId=<?php echo encodeStr($row['groupId']); ?>','<?php echo stripslashes(trim($rowResults["postTitle"])); ?>');"><i class="fa fa-share" aria-hidden="true"></i> Share <span>0</span></a></li>
  </ul>
  <div class="commnts-cont">
    <ul class="cmmnt-list"  id="postcomment<?php echo $row['groupId']; ?><?php echo $row['postType']; ?>">
      Loading...
    </ul>
    <script>
      $('#postcomment<?php echo $row['groupId']; ?><?php echo $row['postType']; ?>').load('post-comment.php?postId=<?php echo $row['groupId']; ?>&postType=<?php echo $row['postType']; ?>&parentId=0&limit=5');
      </script>
    <div class="comnt-write">
      <div class="write-cmnt-pic"> <img src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($myprofilePhoto)); ?>"> </div>
      <div class="cmnt-inpt">
        <form class="edit-layer" enctype="multipart/form-data" name="frmposthome" id="frmposthome" method="post" target="actionfrm" action="<?php echo $fullurl; ?>common_action.php">
          <input type="text" class="commentrowboxclass" id="commentbox" name="commentbox" placeholder="Type your comment">
          <input name="postId" id="postId"  type="hidden" value="<?php echo encodeStr($row['groupId']); ?>">
          <input name="limit" id="limit"  type="hidden" value="5">
          <input name="action" id="action"  type="hidden" value="postcomment">
          <input name="parentId" id="parentId"  type="hidden" value="0">
          <input name="postType" id="postType"  type="hidden" value="<?php echo $row['postType']; ?>">
          <input name="pageType" id="pageType"  type="hidden" value="timeline">
          <input name="userId" id="userId"  type="hidden" value="<?php echo encodeStr($userres['userId']); ?>">
          <button type="submit">Post</button>
        </form>
      </div>
    </div>
  </div>-->
        </div>
        <?php
      }
    }


    if ($row["postType"] == 5) {



      $sql_group = "SELECT * from " . _EVENT_MASTER_TABLE_ . " WHERE id= " . $row["postId"] . "";
      $resgroup = mysqli_query($conn, $sql_group) or die(mysqli_error($conn));
      $rowEvents = mysqli_fetch_array($resgroup);

      if ($rowEvents["eventThumb"] != '') {
        $eventphoto = $rowEvents["eventThumb"];
      } else {
        $eventphoto = 'events-placeholder.jpg';
      }
      if ($rowEvents["eventBanner"] != '') {
        $eventBgphoto = $rowEvents["eventBanner"];
      } else {
        $eventBgphoto = 'events-bg-placeholder.jpg';
      }

      ?>
      <div class="timlist" id="387">
        <div class="hedr">
          <div class="prfl_img"> <a
              href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><img
                src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($userphoto)); ?>"></a> </div>
          <div class="hdr_right"><a
              href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($userres['userId']); ?>/<?php echo $friendnameurl; ?>.html"><?php echo stripslashes(trim($userres["firstName"])); ?>
              <?php echo stripslashes(trim($userres["lastName"])); ?></a><span class="timelinecontantsubline"> post an
              event</span>
            <label class="time"><?php echo $jobTitle; ?>
              <?php if ($companyName != '') {
                echo '- ' . $companyName;
              } ?>
            </label>
            <label class="time"><?php echo makedatetime($row["dateAdded"]); ?></label>
          </div>
        </div>
        <div class="txtarea">
          <div style=" margin-bottom:10px;">
            <div class="evnt-show-info">
              <div class="img"><a
                  href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
                  style="display:block; margin-top:-1px; font-size:16px;"><img
                    src="<?php echo $fullurl; ?>uploads/<?php echo $eventBgphoto; ?>"> <span class="evnt-prfl-img"><img
                      src="<?php echo $fullurl; ?>uploads/<?php echo $eventphoto; ?>"></span></a></div>


            </div>
            <div style="font-size:15px; font-weight:bold; margin-bottom:5px;">
              <ul class="cht_mmbr_list" style="height:auto;    border-radius: 4px;">
                <li
                  style="border-bottom: 1px #ccc solid;  padding: 16px;  border: 0px; padding-bottom:0px;    background-color: #f2f2f2; margin-bottom:7px;"
                  class="going">

                  <div class="frfl-img" style="float:none; border-bottom:px #CCCCCC solid;">

                    <strong style="width:100%; font-size:16px;"><a
                        href="<?php echo $fullurl; ?>events-detail.html?eventId=<?php echo encodeStr($rowEvents['id']); ?>"
                        style="display:block; margin-top:-1px; font-size:16px;"><?php echo stripslashes(str_replace('�', '&ndash;', $rowEvents["eventName"])); ?></a></strong>
                    <span
                      style="color:#666666; margin-top: 2px; font-weight:normal;"><?php $strstrtdate = strtotime($rowEvents["eventDate"]);
                      echo date("j M", $strstrtdate); ?>
                      - <?php $strenddate = strtotime($rowEvents["eventTillDate"]);
                      echo date("j M Y", $strenddate); ?>
                      <?php echo stripslashes(strip_tags($rowEvents["eventVenue"])); ?>
                      <?php echo stripslashes($rowEvents["eventCountryAddress"]); ?></span>

                    <?php
                    $mytotalgroups = 0;
                    $totalm = "select id from " . _EVENT_GUEST_MASTER_TABLE_ . " where  eventId= " . $rowEvents["id"] . " and status=1";
                    $retotalm = mysqli_query($conn, $totalm) or die(mysqli_error($conn));
                    $mytotalgroups = mysqli_num_rows($retotalm);
                    ?>

                    <div class="share_with" style=" margin-top:10px;    min-height: 35px; position:relative;">
                      <ul class="grp-mmbr_list groupontimeline">
                        <?php

                        $selectFields = [];
                        $whereFields = [];
                        $whereVals = [];

                        $sqlGroupMembers = "";
                        $sqlGroupMembers = "select * from " . _EVENT_GUEST_MASTER_TABLE_ . " WHERE  eventId= " . $rowEvents["id"] . " and status=1 order by id desc LIMIT 0,6";
                        $resGroupMembers = getRecords(_EVENT_GUEST_MASTER_TABLE_, $selectFields, $whereFields, $whereVals, _Y_, $sqlGroupMembers);
                        if ($resGroupMembers) {
                          while ($rowgroupmembers = mysqli_fetch_array($resGroupMembers)) {

                            $groupmembernameurl = '';
                            $usergroupmemberphoto = '';
                            $aa = "SELECT * from " . _USERS_MASTER_TABLE_ . " WHERE userId= " . $rowgroupmembers["userId"] . "";
                            $bb = mysqli_query($conn, $aa) or die(mysqli_error($conn));
                            $usergroupmembers = mysqli_fetch_array($bb);

                            $groupmembernameurl = $usergroupmembers['userurl'];

                            if ($usergroupmembers["profilePhoto"] != '') {
                              $usergroupmemberphoto = $usergroupmembers["profilePhoto"];
                            } else {
                              $usergroupmemberphoto = 'user-placeholder.jpg';
                            }

                            ?>
                            <li><a
                                href="<?php echo $fullurl; ?>profile/<?php echo encodeStr($usergroupmembers['userId']); ?>/<?php echo $groupmembernameurl; ?>.html"><img
                                  title="<?php echo stripslashes(trim($usergroupmembers["firstName"])); ?> <?php echo stripslashes(trim($usergroupmembers["lastName"])); ?>"
                                  alt="<?php echo stripslashes(trim($usergroupmembers["firstName"])); ?> <?php echo stripslashes(trim($usergroupmembers["lastName"])); ?>"
                                  src="<?php echo $fullurl; ?>uploads/<?php echo stripslashes(trim($usergroupmemberphoto)); ?>"></a>
                            </li>
                            <?php
                          }
                        }
                        ?>
                      </ul>
                      <div style="position:absolute; right:0px; top:10px; font-size:12px; color:#999999;">
                        <?php echo $mytotalgroups;
                        if ($mytotalgroups > 1) {
                          echo ' ' . $companNameTitle . ' members are going to be there.';
                        } else {
                          echo ' ' . $companNameTitle . ' member is going to be there.';
                        } ?>
                      </div>
                    </div>



                  </div>
                </li>
              </ul>
            </div>
          </div>
        </div>
      </div>
      <?php
    }

    $n++;
  }

}
?>
<div id="loadtimeline<?php echo $endpage; ?>">
  <?php if ($n > 19) { ?>
    <a onClick="loadtimelineactivity('<?php echo $endpage; ?>','<?php echo $endpage + 1; ?>','<?php echo $endpage + 20; ?>','<?php if ($_REQUEST['view'] == '') {
               echo '0';
             } else {
               echo $_REQUEST['view'];
             } ?>');"
      class="load-more">Load More Posts</a>
  <?php } ?>
</div>
<script>
  $(document).on("click", ".triggerBtn", function () {
    var inputField = $(this).closest('div').find('.commentrowboxclass').focus();

  });
</script>