<div id="content">
<?php
	$id = $_GET["id"];
    if ($_POST['Watched'])
    {
		markWatched($id);
    }
	
	if ($_GET["action"] == "getmovie" || $_GET["action"] == "getshow")
	{
		PrintContent($id);
	}
	else
	{
		echo "XBMC Database Manager<br>Select Movies/TV-Shows or select a Title";
	}
?>
</div>
