<?php
	$db_host = "85.208.208.61";
	$db_user = "moodle";
	$db_pass = "X6k0cr6xNe7p";
	$db_name = "moodle";

	$db_link = mysqli_connect($db_host, $db_user, $db_pass, $db_name);

	if (!$db_link) {echo "error";}
?>