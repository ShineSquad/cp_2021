<?php
	// https://shsq.ru/mascot-rest/get_userinfo.php?id=2

	include "db_link.php";

	if ( isset($_GET["id"]) ) {
		$sql = "SELECT * FROM `mdl_mascot` WHERE `user_id`=".$_GET["id"];

		$res = mysqli_query($db_link, $sql);
		$row = mysqli_fetch_assoc($res);

		echo json_encode($row);
	} else {
		echo "error";
	}
?>
