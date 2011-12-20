<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/custom.js"></script>
<h1><?php echo $col2['0'] ?></h1>
<table border="1" id="editrows">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		$col2[3] = $col2[3] ? 'Yes' : 'No';
		for ($i = 0; $i < count($col1); $i++)
		{
			echo "<tr id=\"$col1[$i]\"><th>$col1[$i]</th><td id=\"datacol\">$col2[$i]</td><td>$col3[$i]</td></tr>";
		}
	?>
</table>
