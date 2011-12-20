<script type="text/javascript" src="<?php echo base_url();?>js/jquery-1.7.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/custom.js"></script>
<h1><?php echo $col2['0'] ?></h1>
<table border="1">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		for ($i = 1; $i < count($col1); $i++)
		{
			echo "<tr><th><p>$col1[$i]</p></th><td>$col2[$i]</td></tr>";
		}
	?>
</table>
