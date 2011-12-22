<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/custom.js"></script>
<h1>
<?php echo $col2['0'] ?></h1>

<form action="settings/edit" method="post">
<table border="1" class="edittable">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		for ($i = 1; $i < count($col1); $i++)
		{
			echo '<tr>
					<th>
						'.$col1[$i].'
					</th>
					<td>
						<input type="text" name="'.$col1[$i].'" value="'.$col2[$i].'" size="50" />
					</td>
				</tr>';
		}
	?>
</table>
<input type="submit" name="submit" value="Submit" />
<?php echo '<table border="0" class="edittable"><tr><th>Save settings<t></th><td><input type="submit" value="Save" /></td></tr></table>'; ?>
</form>