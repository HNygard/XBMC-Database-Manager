<?php
	include('../variables/variables.php');
	include('functions.php');
	init();
	$view = $_GET['view'];
	$action = $_GET['action'];
	$id = $_GET['id'];
	$q = "SELECT playCount FROM movieview WHERE idMovie = " . $id;
	foreach (dbquery($q) as $temp)
	{
		$watched = $temp['playCount'];
	}
?>
<script>
	function mark()
	{
		var jview = "<?php echo $view;?>";
		var jaction = "<?php echo $action;?>";
		var jid = "<?php echo $id;?>";
		var jwatched = document.getElementById('watchedbutton').value;
		$.ajax({
			url: "includes/watched.php",
			type: "POST",
			data: "view=" + jview + "&id=" + jid + "&watched=" + jwatched,
			success: function(data)
			{
				//Reloads the content after script is finished
				$('#content').load("includes/content.php?view=" + jview + "&action=" + jaction + "&id=" + jid);
			}
		});
	}
</script>

<div id="menucontent">
	<table border="0">
		<tr>
			<td>
				<?php
				switch ($watched)
				{
					case !NULL:
					?>
						<button id="watchedbutton" type="button" onclick="mark()" value="0">Mark as Not Watched</Button>
						<?php
						break;
					case NULL:
					?>
						<button id="watchedbutton" type="button" onclick="mark()" value="1">Mark as Watched</Button>
						<?php
						break;
				}
				?>
			</td>
		</tr>
	</table>	
</div>

<div id="info">
	<?php
	if ($action == "getmovie" || $action == "getshow")
	{
		PrintContent($id);
	}
	else
	{
		echo "XBMC Database Manager<br>Select Movies/TV-Shows or select a Title";
	}
	dbclose();
	?>
</div>
