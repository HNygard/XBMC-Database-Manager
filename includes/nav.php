<div id="nav">
	<div id="tabs">
	<ul>
	<?php
		switch ($_GET['view'])
		{
			case "movies":
				echo "<li id=\"current\"><a href=\"?view=movies\">Movies</a></li>";
				echo "<li><a href=\"?view=shows\">TV-Shows</a></li>";
				echo "<li><a href=\"?view=music\">Music</a></li>";
				break;
			case "shows":
				echo "<li><a href=\"?view=movies\">Movies</a></li>";
				echo "<li id=\"current\"><a href=\"?view=shows\">TV-Shows</a></li>";
				echo "<li><a href=\"?view=music\">Music</a></li>";
				break;			
			case "music":
				echo "<li><a href=\"?view=movies\">Movies</a></li>";
				echo "<li><a href=\"?view=shows\">TV-Shows</a></li>";
				echo "<li id=\"current\"><a href=\"?view=music\">Music</a></li>";
				break;			
			default:
				echo "<li><a href=\"?view=movies\">Movies</a></li>";
				echo "<li><a href=\"?view=shows\">TV-Shows</a></li>";
				echo "<li><a href=\"?view=music\">Music</a></li>";
				break;			
		}
	?>
	</ul>
	</div>
</div>
<div id="contentnav">
	<div id="tabs">
	<ul>
		<!--Placeholder for content navigation -->
	</ul>
	</div>
</div>
