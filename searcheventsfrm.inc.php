<form name="searcheventsfrm" id="searcheventsfrm" method="get" action="<?php echo $fullurl; ?>search-events.html">
	<input style="width:500px;" maxlength="50" type="text" name="searchevents" id="searchevents"
		value="<?php echo isset($strSearchEvent) ? htmlspecialchars($strSearchEvent) : ''; ?>"
		placeholder="Search events, location" class="topc">
	<button type="button" class="srch" onClick="subsrchfrm();">Search</button>
</form>

<script>
	function subsrchfrm() {
		if ($("#searchevents").val() != '') {
			$("#searcheventsfrm").submit();
		}
	}

	$("input").keypress(function (event) {
		if (event.which == 13) {
			event.preventDefault();
			if ($("#searchevents").val() != '') {
				$("#searcheventsfrm").submit();
			}
		}
	});
</script>