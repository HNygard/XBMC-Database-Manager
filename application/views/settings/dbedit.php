<h1><?php echo $col2['0']; ?></h1>

<table border="1" class="edittable">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		for ($i = 1; $i < count($col1); $i++)
		{
			echo '<tr><th>'.$col1[$i].'</th>';
			if ($col1[$i] != 'Database driver')
			{
				echo '<td><input type="text" name="'.$col1[$i].'" id="'.$col1[$i].'" value="'.$col2[$i].'" class="'.$col1[0].'"/></td></tr>';
			}
			else
			{
				echo '<td>
						<select>
							<option name="'.$col1[$i].'" id="'.$col1[$i].'" value="'.$col2[$i].'" class="'.$col1[0].'">'.$col2[$i].'</option>
							<option name="'.$col1[$i].'" id="'.$col1[$i].'" value="mysql" class="'.$col1[0].'">mysql</option>
							<option name="'.$col1[$i].'" id="'.$col1[$i].'" value="mysqli" class="'.$col1[0].'">mysqli</option>
							<option name="'.$col1[$i].'" id="'.$col1[$i].'" value="postgre" class="'.$col1[0].'">postgre</option>
							<option name="'.$col1[$i].'" id="'.$col1[$i].'" value="mssql" class="'.$col1[0].'">mssql</option>
						</select>
					</td></tr>';
			}						
		}
	?>
</table>
<?php echo '<table border="0" class="edittable"><tr><th>Save settings</th><td><button name="Hostname" id="'.$col1[0].'" onclick="return editcfg(this);">Save</button></td></tr></table>'; ?>
</form>
