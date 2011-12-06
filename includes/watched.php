<?php
	include('../variables/variables.php');
	include('functions.php');
	init();
	
	$id=$_POST['id'];
	$watched=$_POST['watched'];
	$view=$_POST['view'];

	$table = ($view == "shows" ) ? $tvshowtable : "movieview";
	$idType = ($view == "shows" ) ? "idShow" : "idMovie"; 

	switch ($watched)
	{
		case 1:
			$q = "UPDATE $table SET playCount = 1 WHERE $idType = $id AND playCount IS NULL";
			echo $q;
			break;
		case 0:
			$q = "UPDATE $table SET playCount = NULL WHERE $idType = $id AND playCount IS NOT NULL";
			echo $q;
			break;
	}
	dbquery($q);
	dbclose();
?>
