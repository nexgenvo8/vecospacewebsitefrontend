<?php


if (
	(!empty($_SESSION["sessUserId"]) && is_numeric($_SESSION["sessUserId"]) && $_SESSION["sessUserId"] != 0)
	|| !empty($_SESSION["userstype"])
) {
	header("Location: " . $fullurl . "timeline.html");
	exit();
}
?>