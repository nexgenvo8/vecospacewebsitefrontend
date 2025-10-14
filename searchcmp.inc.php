<?php
include_once('inc.php');

// Ensure $strSearchVar is always defined to avoid "Undefined variable" warning
$strSearchVar = '';

// If search param exists, clean it
if (isset($_GET['searchcompanies']) && $_GET['searchcompanies'] !== '') {
  $strSearchVar = clean($_GET['searchcompanies']);
}

// Ensure $fullurl exists (fallback to empty string if not set)
$fullurl_safe = isset($fullurl) ? $fullurl : '';
?>
<div class="grp_banner compnybnr">
  <form style="margin-right: 18px;margin-top: 190px;" name="searchcompaniesfrm" id="searchcompaniesfrm"
    class="grp-search single" action="<?php echo htmlspecialchars($fullurl_safe, ENT_QUOTES); ?>search-companies.html"
    method="get">
    <input type="text" name="searchcompanies" id="searchcompanies" placeholder="Company Name, Like DeBoxglobal etc."
      value="<?php echo htmlspecialchars($strSearchVar, ENT_QUOTES); ?>">
    <button type="button" class="srch" onClick="subsrchfrm();">Search</button>
  </form>
</div>

<script>
  function subsrchfrm() {
    if ($("#searchcompanies").val() != '') {
      $("#searchcompaniesfrm").submit();
    }
  }

  $("input").keypress(function (event) {
    if (event.which == 13) {
      event.preventDefault();
      if ($("#searchcompanies").val() != '') {
        $("#searchcompaniesfrm").submit();
      }
    }
  });
</script>