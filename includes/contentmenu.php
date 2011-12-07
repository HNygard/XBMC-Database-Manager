<script>
	$('a#menulink').click(function(event)
	{
		event.preventDefault();
		var link = $(this).attr('href');
		$('#content').load("includes/content.php" + link);
	});
</script>

<div id="tabs">
	<ul>
		<?php
		$view = $_GET['view'];
		$page = $_GET['page'];
		$id = $_GET['id'];
		$action = $_GET['action'];
		switch ($_GET['page'])
		{
			case "info":
				echo "<li id=\"current\"><a href=\"?view=$view&action=$action&page=info&id=$id\" id=\"menulink\">Info</a></li>";
				echo "<li><a href=\"?view=$view&action=$action&page=edit&id=$id\" id=\"menulink\">Edit</a></li>";
				echo "<li><a href=\"?view=$view&action=$action&page=fanart&id=$id\" id=\"menulink\">Fan art</a></li>";
				break;
			case "edit":
				echo "<li><a href=\"?view=$view&action=$action&page=info&id=$id\" id=\"menulink\">Info</a></li>";
				echo "<li id=\"current\"><a href=\"?view=$view&action=$action&page=edit&id=$id\" id=\"menulink\">Edit</a></li>";
				echo "<li><a href=\"?view=$view&action=$action&page=fanart&id=$id\" id=\"menulink\">Fan art</a></li>";
				break;
			case "fanart":
				echo "<li><a href=\"?view=$view&action=$action&page=info&id=$id\" id=\"menulink\">Info</a></li>";
				echo "<li><a href=\"?view=$view&action=$action&page=edit&id=$id\" id=\"menulink\">Edit</a></li>";
				echo "<li id=\"current\"><a href=\"?view=$view&action=$action&page=fanart&id=$id\" id=\"menulink\">Fan art</a></li>";
				break;
			default:
				echo "<li id=\"current\"><a href=\"?view=$view&action=$action&page=info&id=$id\" id=\"menulink\">Info</a></li>";
				echo "<li><a href=\"?view=$view&action=$action&page=edit&id=$id\" id=\"menulink\">Edit</a></li>";
				echo "<li><a href=\"?view=$view&action=$action&page=fanart&id=$id\" id=\"menulink\">Fan art</a></li>";
				break;
		}
		?>
	</ul>
</div>	
