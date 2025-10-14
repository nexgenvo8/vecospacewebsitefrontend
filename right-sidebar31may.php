<div class="hm_right_sec">
 
    <div class="cntct_bday">
      <h4>Groups</h4>
	   <?php
		$n=0;
		$selectFields =[];
		$whereFields =[];
		$whereVals =[];
		
		$sqlGroupRight="";
		$sqlGroupRight="select * from "._GROUP_MASTER_TABLE_." WHERE groupType=0 order by rand() desc LIMIT 0,4 ";
		$resGroupRight=getRecords(_GROUP_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroupRight); 	
		if($resGroupRight)
		{
			while($rowgroup=mysqli_fetch_array($resGroupRight))
			{
			
				$sql_group="SELECT * from "._GROUP_MASTER_TABLE_." WHERE id= ".$rowgroup["id"]."";
				$resgroup=mysqli_query($conn, $sql_group) or die(mysqli_error($conn)); 
				$row=mysqli_fetch_array($resgroup);				
				
				if($row["groupThumb"]!='')
				{
				$groupThumb=$row["groupThumb"];
				} else {
				$groupThumb='group.png';
				}	
				
				$totalgroupmembers=0;
				$sqlGroupTotal="";
				$sqlGroupTotal="select * from "._GROUP_MEMBER_MASTER_TABLE_." where groupId='".$rowgroup["id"]."' ";
				$resGroupTotal=getRecords(_GROUP_MEMBER_MASTER_TABLE_,$selectFields,$whereFields,$whereVals,_Y_,$sqlGroupTotal); 	
				if($resGroupTotal)
				{
					$totalgroupmembers=mysqli_num_rows($resGroupTotal);
				}	
				
		  ?>
      <div class="knct_mmbr_list">
        <div class="knct_mmbr_img"><a href="<?php echo $fullurl;?>groups-detail.html?groupId=<?php echo encodeStr($rowgroup['id']);?>"><img src="<?php echo $fullurl;?>uploads/<?php echo stripslashes(trim($groupThumb));?>"></a></div>
        <div class="knct_mmbr_right_dtail">
		<a href="<?php echo $fullurl;?>groups-detail.html?groupId=<?php echo encodeStr($rowgroup['id']);?>" class="reco-name"><?php echo stripslashes(trim($row["groupName"]));?></a>
          <div class="clipped-text"><?php echo substr(strip_tags(stripslashes(trim($row["groupDetails"]))),0,50);?></div>
          
        </div>
        <span class="dlt_rcmndtion"><?php echo $totalgroupmembers;?></span>
      </div>
	  <?php
	$n++;	}
}
?>
      <a href="<?php echo $fullurl;?>groups.html" class="more">More Groups</a>
     
    </div>
 
    <ul class="rondom_news">
    <h4>News</h4>
      <li><a href="#">How Google Grows...</a>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </p>
      </li>
      <li><a href="#">How Google Grows...</a>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </p>
      </li>
      <li><a href="#">How Google Grows...</a>
      <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text </p>
      </li>
      <li><a href="#">More Articles</a></li>
    </ul>

  </div>