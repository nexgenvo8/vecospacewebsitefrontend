<div class="grp_banner grp_back">
  <h1 class="headline grp" style="padding-top: 45px; line-height:42px;    text-align: left; padding-right: 150px;">
    Productive discussions and networking <br>amongst like minded people.<br>
    <span style="font-size: 26px;font-weight: 700;">Join a Group</span>
    or <span style="font-weight: 700;font-size: 26px;">Create your own Group</span>
  </h1>
  <?php
  $strSearchGroup = isset($_GET['searchgroups']) ? $_GET['searchgroups'] : '';
  ?>

  <form class="grp-search groupspagesearch" id="grpsearch" name="grpsearch" method="get"
    action="<?php echo $fullurl; ?>search-group.html" style="float: left;padding-left: 50px;">
    <input type="text" name="searchgroups" id="searchgroups" value="<?php echo $strSearchGroup; ?>"
      placeholder="Enter interests or groups">
    <button type="button" class="srch" onClick="subsrchfrm();" style="background-color: #f67700;">Search</button>
  </form>

</div>
<div class="grp-fttr">
  <ul class="grp-tab">
    <?php
    $pagetab = isset($pagetab) ? $pagetab : 0;
    ?>

    <li><a href="<?php echo $fullurl; ?>my-groups.html" <?php if ($pagetab == 1) { ?> class="active" <?php } ?>>My
        Groups</a>
    </li>
    <li><a href="#" onClick="$('#groupformdiv').show();$('body').css('overflow','hidden');">Create a New Group</a></li>
    <li><a href="<?php echo $fullurl; ?>discover-groups.html" <?php if ($pagetab == 2) { ?> class="active" <?php } ?>>Discover
        Groups <span> on <?php echo $companNameTitle; ?></span></a></li>
  </ul>
</div>

<script>
  function subsrchfrm() {

    if ($("#searchgroups").val() != '') {
      $("#grpsearch").submit();
    }
  }

  $("input").keypress(function (event) {

    if (event.which == 13) {
      event.preventDefault();

      if ($("#searchgroups").val() != '') {
        $("#grpsearch").submit();
      }
    }
  });

</script>