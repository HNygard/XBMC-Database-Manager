<div id="content">
<?php
	$id = $_GET["id"];
    if ($_POST['Watched'])
    {
      markAsWatched($id);
    }

	if ($_GET["action"] == "getmovie" || $_GET["action"] == "getshow")
	{
		PrintInfo($id);
	}
	else
	{
		echo "XBMC Database Manager<br>Select Movies/TV-Shows or select a Title";
	}
?>
</div>
