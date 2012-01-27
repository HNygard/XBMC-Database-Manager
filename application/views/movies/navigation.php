			<div id="navigation">
				<a href="movies" id="current">Movies</a>
				<a href="shows">TV-Shows</a>
				<a href="music">Music</a>
			</div>
			<script>
				$(document).ready(function()
				{
					$('#contentnav').load("movies/getcontentmenu");
				});
			</script>
			<div id="sidebar" class="roundcorners">
