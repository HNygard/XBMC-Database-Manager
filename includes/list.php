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
			function getUrlVars()
			{
				var vars = {};
				var parts = window.location.href.replace(/[?&]+([^=&]+)=([^&]*)/gi, function(m,key,value)
				{
					vars[key] = value;
				});
				return vars;
			}
		</script>
		<?php
		init();
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
				foreach (dbquery("SELECT c00,idMovie FROM movie ORDER BY " . $sortby) as $row)
				{
					echo "<a href=\"?view=movies&action=getmovie&id=" . $row['idMovie'] . "\" id=\"contentlink\">" . $row['c00'] . "</a><br>";
				}
				break;
			case "shows":
				foreach (dbquery("SELECT c00,idShow FROM " . $tvshowtable . " ORDER BY " . $sortby) as $row)
				{
					echo "<a href=\"?view=shows&action=getshow&id=" . $row['idShow'] . "\" id=\"contentlink\">" . $row['c00'] . "</a><br>";
				}
				break;
		}
		dbclose();
?>
