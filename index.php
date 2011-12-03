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
		<!--<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.3.0/jquery.min.js"></script>
		<script type="text/javascript">
			$('#choose').change(function(event) {
				$('#update').html('This is ' + $('#choose').val() + ' and other info');
			}); 
		</script>-->
	</head>
	<body>
		<div id="wrapper">
			<!-- Include PHP files -->
			<?php
				include('includes/header.php');
				include('includes/functions.php');
				dbopen();
				include('includes/nav.php');
				include('includes/sidebar.php');
				include('includes/content.php');
				include('includes/footer.php');
				dbclose();
			?>
		</div>
</body>
</html>
