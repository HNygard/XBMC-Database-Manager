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
							$('#listing').load("includes/list.php?view=" + jview + "&sort=" + jsort);
						}
					</script>
				</td>
		</tr>
	</table>
	</div>

	<div id="listing">
		<!--Placeholder for listing-->
		<script>
			$(document).ready( function()
			{
				var jview = "<?php echo $_GET['view']; ?>";
				var jsort = $('select.sortby option:selected').val();
				$('#listing').load("includes/list.php?view=" + jview + "&sort=" + jsort);
			});
		</script>
	</div>
</div>
