<div id="sidebar">
	<?php
		$view = $_GET["view"];
		if ($view == NULL) {$view = "movies";}
		switch ($view)
		{
			case "movies":
				foreach (dbquery("SELECT c00,idMovie FROM movie") as $row)
				{
					echo "<a href=\"?view=movies&action=getmovie&id=" . $row['idMovie'] . "\">" . $row['c00'] . "</a><br>";
				}
				break;
			case "shows":
				foreach (dbquery("SELECT c00,idShow FROM tvshow") as $row)
				{
					echo "<a href=\"?view=shows&action=getshow&id=" . $row['idShow'] . "\">" . $row['c00'] . "</a><br>";
				}
				break;
		}
	?>
</div>
