<script>
	//Loads the list when the document has finished loading, puts the list <div id="listing">
	$(document).ready( function()
	{
		var jview = "<?php echo $_GET['view'];?>";
		var jsort = $('select.sortby option:selected').val();
		$('#listing').load("includes/list.php?view=" + jview + "&sort=" + jsort);
	});
	//Function called by sort button. Reloads the list in <div id="listing">
	function sort()
	{
		var jview = "<?php echo $_GET['view']; ?>";
		var jsortby = $('select.sortby option:selected').val();
		var jsortdir = $('select.sortdir option:selected').val();
		$('#listing').load("includes/list.php?view=" + jview + "&sort=" + jsortby + "&sortdir=" + jsortdir);
	}
</script>

<?php $view = $_GET["view"];?>

<div id="sidebar">
	<div id="menulist">
		<table border="0">
			<tr>
				<?php
				switch ($view)
				{
					case "movies":
						?>
						<td>
							<select name="sortby" SIZE="1" class="sortby">		
								<option value="c00" id="title">Title</option>
								<option value="c07" id="year">Year</option>
								<option value="idMovie" id="year">Added</option>
							</select>
						</td>
						<td>
							<select name="sortdir" SIZE="1" class="sortdir">		
								<option value="ASC" id="asc">Ascending</option>
								<option value="DESC" id="des">Descending</option>
							</select>
						</td>
						<td>
							<input type="button" onclick="sort()" value="Refresh"/>
						</td>
						<?php
						break;
					case "shows":
						?>
						<td>
							<select name="sortby" SIZE="1" class="sortby">		
								<option value="c00" id="title">Title</option>
								<option value="c05" id="year">First aired</option>
								<option value="idShow" id="year">Added</option>
							</select>
						</td>
						<td>
							<select name="sortdir" SIZE="1" class="sortdir">		
								<option value="ASC" id="asc">Ascending</option>
								<option value="DESC" id="desc">Descending</option>
							</select>
						</td>
						<td>
							<input type="button" onclick="sort()" value="Refresh"/>
						</td>
						<?php
						break;
				}
				?>
			</tr>
		</table>
	</div>
	<div id="listing">
		<!--Placeholder for movie/show list-->
	</div>
</div>
