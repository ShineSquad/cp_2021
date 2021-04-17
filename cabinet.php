<?php
	include "secret/db_link.php";
?>

<form method="POST">
	<select name="user">
		<option selected disabled>user select</option>
		<?php
			$sql = "SELECT `username`, `id`
					FROM `mdl_user` 
					WHERE 
						`mdl_user`.`username` NOT IN ('admin', 'guest')";

			$res = mysqli_query($db_link, $sql);

			while ($row = mysqli_fetch_assoc($res)) {
				?>
					<option value="<?=$row['id']?>"><?=$row["username"];?></option>
				<?php
			}
		?>
	</select>
	<input type="submit" name="go" value="go">
</form>
<h3>Stats history:</h3>
<table>
	<tr>
		<th>ename</th>
		<th>xp</th>
		<th>ts</th>
	</tr>
	<?php
		if ( isset($_POST["go"]) ) {
			$sql = "SELECT `eventname`, `xp`, `time`
					FROM `mdl_block_xp_log`
					WHERE `userid` = " . $_POST["user"];

			$res = mysqli_query($db_link, $sql);
			while ($row = mysqli_fetch_assoc($res)) {
				?>
					<tr>
						<td><?=$row["eventname"];?></td>
						<td><?=$row["xp"];?></td>
						<td><?=$row["time"];?></td>
					</tr>
				<?php
			}
		}
	?>
</table>
<h3>Stats total:</h3>
<table>
	<tr>
		<th>xp</th>
		<th>level</th>
	</tr>
	<?php
		if ( isset($_POST["go"]) ) {
			$sql = "SELECT `xp`, `lvl`
					FROM `mdl_block_xp`
					WHERE `userid` = " . $_POST["user"];

			$res = mysqli_query($db_link, $sql);
			while ($row = mysqli_fetch_assoc($res)) {
				?>
					<td><?=$row["xp"];?></td>
					<td><?=$row["lvl"];?></td>
				<?php
			}
		}
	?>
</table>
	