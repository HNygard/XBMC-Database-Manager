<div id="sidebar">
	<div id="menu">
	<table border="0">
		<tr>
			<th>Sorting:</th>
			<form method="post"> 
				<td>
					<select name="sorting" SIZE="1">
						<option value="c00" selected="selected">Alphanumerical</option>
						<option value="c07">Year</option>
					</select>
				</td>
				<td>
					<!--<button type="submit">Sort</Button>-->
				</td>
			</form>
		</tr>
	</table>
	</div>
	
	<div id="list">
	<?php
		$view = $_GET["view"];
		$sortby = $_POST['sorting'];
		echo "VIEW: " . $view . " Sort: " . $sortby;
		if ($view == NULL) {$view = "movies";}
		switch ($view)
		{
			case "movies":
				foreach (dbquery("SELECT c00,idMovie FROM movie ORDER BY " . $_POST['sorting']) as $row)
				{
					echo "<a href=\"?view=movies&action=getmovie&id=" . $row['idMovie'] . "\">" . $row['c00'] . "</a><br>";
				}
				break;
			case "shows":
				foreach (dbquery("SELECT c00,idShow FROM tvshow ORDER BY c00") as $row)
				{
					echo "<a href=\"?view=shows&action=getshow&id=" . $row['idShow'] . "\">" . $row['c00'] . "</a><br>";
				}
				break;
		}
	?>
	</div>
</div>
