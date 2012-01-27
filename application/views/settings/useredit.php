<h1><?php echo $col2['0']; ?></h1>

<table border="1" class="edittable">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		echo '<tr><th>'.$col1[1].'</th>';
		echo '<td><input type="text" name="username" id="usr" value="'.$col2[1].'" class="'.$col1[0].'"/></td></tr>';
		echo '<tr><th>'.$col1[2].'</th>';
		echo '<td><input type="text" name="password" id="pass" value="'.$col2[2].'" class="'.$col1[0].'"/></td></tr>';
	?>
</table>
<?php echo '<table border="0" class="edittable"><tr><th>Save settings</th><td><button name="Hostname" id="'.$col1[0].'" onclick="return editcfg(this);">Save</button></td></tr></table>'; ?>
</form>
