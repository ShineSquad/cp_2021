<?php
	// https://shsq.ru/mascot-rest/set_game.php?id=2&inc=1

	include "db_link.php";

	if ( isset($_GET["id"]) && isset($_GET["inc"])) {
		$sql = "SELECT `games` FROM `mdl_mascot` WHERE `user_id`=".$_GET["id"];
		$row = mysqli_fetch_assoc(mysqli_query($db_link, $sql));

		$val = ( intval($row["games"])+intval($_GET["inc"]) < 0 )
			? 0
			: intval($row["games"])+intval($_GET["inc"]);

		$sql = "UPDATE `mdl_mascot`
				SET `games`=$val
				WHERE `user_id`=".$_GET["id"];

		mysqli_query($db_link, $sql);

		$sql = "SELECT `games` FROM `mdl_mascot` WHERE `user_id`=".$_GET["id"];
		$row = mysqli_fetch_assoc(mysqli_query($db_link, $sql));

		echo $row["games"];
	} else {
		echo "error";
	}
?>