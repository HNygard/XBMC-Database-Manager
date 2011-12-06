<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=ISO-8859-1" /><!-- Change charset if needed, also below, meta charset-->
		<meta name="description" content="XBMC Database Manager" />
		<meta name="keywords" content="XBMC Database Manager" />
		<meta name="author" content="Vicious" />
		<meta charset="ISO-8859-1">
		<link rel="stylesheet" type="text/css" href="style.css" media="screen" />
		<title>XBMC Database Manager</title>
		<script src="includes/jquery-1.7.js"></script>
	</head>
	<body>
		<div id="wrapper">
			<!-- Include PHP files -->
			<?php
				include('includes/variables.php');		#Global variables
				include('includes/header.php');			#Draws header (logo?)
				include('includes/functions.php');		#Includes some database functions (init, query, etc)
				init();									#Calls init function, also opens db connection
				include('includes/nav.php');			#Draws navigation bar
				include('includes/sidebar.php');		#Draws sidebar (list)
				?>
				<!--The following div will be populated when a show/movie is selected-->
				<div id="content">
					<div id="menucontent"></div>
					<h5>XBMC Database Manager</br>Select Movies/TV-Shows or select a Title</h5>
				</div>
				<?php
				include('includes/footer.php');
				dbclose();
			?>
		</div>
</body>
</html>
