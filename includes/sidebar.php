<div id="sidebar" class="listan">
	<?php $view = $_GET["view"]; ?>
	<div id="menu">
	<table border="0">
		<tr>
				<td>
					<select name="sorting" SIZE="1" class="sortby">
						<?php
						switch ($view)
						{
							case "movies":
								?>
								<option value="c00" id="alph">Alphanumerical</option>
								<option value="c07" id="year">Year</option>
								<?php
								break;
							case "shows":
								?>
								<option value="c00" id="alph">Alphanumerical</option>
								<option value="c05" id="year">First aired</option>
								<?php
								break;
						}
						?>
					</select>
				</td>
				<td>
					<!--<input type="submit" name="sort" class="button" id="refresh" value="Sort" />  -->
					<input type="button" onclick="sort()" value="Sort" />
					<script>
						function sort()
						{
							var jview = "<?php echo $_GET['view']; ?>";
							var jsort = $('select.sortby option:selected').val();
							$('#test').load("includes/list.php?view=" + jview + "&sort=" + jsort);
						}
					</script>
				</td>
		</tr>
	</table>
	</div>

	<div id="test">
		<!--Placeholder for listing-->
	</div>
	
<!--	<div id="list" class="titlelist">
	<?php
		$view = $_GET["view"];
		if ($_POST['sorting'])
		{
			$sortby = $_POST['sorting'];
		}
		echo "VIEW: " . $view . " Sort: " . $sortby . "<br>";
		if ($view == NULL) {$view = "movies";}
		switch ($view)
		{
			case "movies":
				foreach (dbquery("SELECT c00,idMovie FROM movie ORDER BY " . $sortby) as $row)
				{
					echo "<a href=\"?view=movies&action=getmovie&id=" . $row['idMovie'] . "\">" . $row['c00'] . "</a><br>";
				}
				break;
			case "shows":
				foreach (dbquery("SELECT c00,idShow FROM tvshow ORDER BY c00") as $row)
				{
					echo "<a href=\"?view=shows&action=getshow&id=" . $row['idShow'] . "\" class=\"contentlink\">" . $row['c00'] . "</a><br>";
				}
				break;
		}
	?>
	</div>-->
</div>
