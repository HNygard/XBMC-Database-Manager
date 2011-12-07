<?php
		include('../variables/variables.php');
		include('functions.php');
		?>
		<script>
			$('a#contentlink').click(function(event)
			{
				event.preventDefault();
				var link = $(this).attr('href');
				$('#content').load("includes/content.php" + link);
			});
		</script>
		<?php
		init();
		if ($_GET['sortdir'])
		{
			$sortdir = $_GET['sortdir'];
		}
		if ($sortdir == NULL) {$sortdir = "ASC";}
		if ($_GET['view'])
		{
			$view = $_GET['view'];
		}
		if ($view == NULL) {$view = "movies";}
		if ($_GET['sort'])
		{
			$sortby = $_GET['sort'];
		}
		if ($sortby == NULL) {$sortby = "c00";}

		switch ($view)
		{
			case "movies":
				$q = "SELECT c00,idMovie FROM movie ORDER BY $sortby $sortdir";
				foreach (dbquery($q) as $row)
				{
					echo "<li><a href=\"?view=movies&action=getmovie&id=" . $row['idMovie'] . "\" id=\"contentlink\">" . $row['c00'] . "</a></li>";
				}
				break;
			case "shows":
				$q = "SELECT c00,idShow FROM $tvshowtable ORDER BY $sortby $sortdir";
				foreach (dbquery($q) as $row)
				{
					echo "<li><a href=\"?view=shows&action=getshow&id=" . $row['idShow'] . "\" id=\"contentlink\">" . $row['c00'] . "</a></li>";
				}
				break;
		}
		dbclose();
?>
