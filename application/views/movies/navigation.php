			<div id="nav">
				<div id="tabs">
					<ul>
						<li id="current"><a href="movies">Movies</a></li>
						<li><a href="shows">TV-Shows</a></li>
						<li><a href="music">Music</a></li>
					</ul>
				</div>
			</div>
			<div id="contentnav">
				<div id="tabs">
					<ul>
						<script>
							$(document).ready(function()
							{
								$('#contentnav').load("movies/getcontentmenu");
							});
						</script>
					</ul>
				</div>
			</div>
			<div id="sidebar">
