<?php
	// https://shsq.ru/mascot-rest/set_food.php?id=2&inc=1

	include "db_link.php";

	if ( isset($_GET["id"]) && isset($_GET["inc"])) {
		$sql = "SELECT `foods` FROM `mdl_mascot` WHERE `user_id`=".$_GET["id"];
		$row = mysqli_fetch_assoc(mysqli_query($db_link, $sql));

		$val = ( intval($row["foods"])+intval($_GET["inc"]) < 0 )
			? 0
			: intval($row["foods"])+intval($_GET["inc"]);

		$sql = "UPDATE `mdl_mascot`
				SET `foods`=$val
				WHERE `user_id`=".$_GET["id"];

		mysqli_query($db_link, $sql);

		$sql = "SELECT `foods` FROM `mdl_mascot` WHERE `user_id`=".$_GET["id"];
		$row = mysqli_fetch_assoc(mysqli_query($db_link, $sql));

		echo $row["foods"];
	} else {
		echo "error";
	}
?>