<script>
	$(document).ready(function() {
		var jview = "<?php echo $_GET['view'];?>";
		var jpage = "<?php echo $_GET['page'];?>";
		var jaction = "<?php echo $_GET['action'];?>";
		var jid = "<?php echo $_GET['id'];?>";
		$('#contentnav').load("includes/contentmenu.php?view="+jview+"&action="+jaction+"&page="+jpage+"&id="+jid);
	});

	function mark()
	{
		var jview = "<?php echo $_GET['view'];?>";
		var jpage = "<?php echo $_GET['page'];?>";
		var jaction = "<?php echo $_GET['action'];?>";
		var jid = "<?php echo $_GET['id'];?>";
		var jwatched = document.getElementById('watchedbutton').value;
		$.ajax({
			url: "includes/watched.php",
			type: "POST",
			data: "view=" + jview + "&id=" + jid + "&watched=" + jwatched,
			success: function(data)
			{
				//Reloads the content after script is finished
				$('#content').load("includes/content.php?view=" + jview + "&action=" + jaction + "&page=" + jpage + "&id=" + jid);
			}
		});
	}
</script>

<?php
	include('../variables/variables.php');
	include('functions.php');
	init();
	$view = $_GET['view'];
	$action = $_GET['action'];
	$page = $_GET['page'];
	$id = $_GET['id'];
	
	switch ($page)
	{
		case "info":
			if ($action == "getmovie" || $action == "getshow")
			{
				PrintContent($id);
			}
			else
			{
				echo "XBMC Database Manager<br>Select Movies/TV-Shows or select a Title";
			}
			break;
		case "options":
			PrintOptions($id);
			break;
	}
	dbclose();
?>


<!--<div id="menucontent">
	<table border="0">
		<tr>
			<td>
			</td>
		</tr>
	</table>	
</div>-->

