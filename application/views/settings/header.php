<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
	<head>
		<meta http-equiv="content-type" content="text/html; charset=UTF-8" /><!-- Change charset if needed, also below, meta charset-->
		<meta name="description" content="XBMC Database Manager" />
		<meta name="keywords" content="XBMC Database Manager" />
		<meta name="author" content="Vicious" />
		<meta charset="UTF-8">
		<link rel="stylesheet" href='<?php echo base_url();?>css/style.css' type="text/css" media="screen, projection" />
		<title><?php if (isset($title)){echo $title . " - ";} ?>XBMC Database Manager</title>
		<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.js"></script>
		<script type="text/javascript" src="<?php echo base_url();?>js/custom.js"></script>
	</head>
	<body>
		<div id="settings">
			<div id="header">
				<a href="<?=base_url()?>"><img src="<?php echo base_url();?>img/header.png" /></a>
				<div id="user">
				<?php
					if($this->session->userdata('logged_in'))
					{
						$session_user = $this->session->userdata('logged_in');
						echo "Logged in as: $session_user ";
						echo "<a href=\"" . base_url() . "/main/logout\"><button>Logout</button></a>";
					}
					else
					{
					?>
					<?php
					}
				?>
				</div>
			</div>
			<div id="nav">
				<div id="tabs">
					<ul>
						<li><a href="movies">Movies</a></li>
						<li><a href="shows">TV-Shows</a></li>
						<li><a href="music">Music</a></li>
						<?php
							echo '<li id="current"><a href="'. base_url() .'settings">Settings</a></li>'
						?>
				</div>
			</div>
		
