<script type="text/javascript" src="<?php echo base_url();?>shadowbox/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
</script>

<table border="1">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		for ($i = 0; $i < count($actor); $i++)
		{
			$thumburl = base_url().'thumbs/'.substr($thumb[$i],0,1).'/'.$thumb[$i].'.tbn';
			echo '<div id="actor">';
			if ( @file_get_contents($thumburl,0,NULL,0,1) )
			{
				echo '<a rel="shadowbox" href="'.$thumburl.'"><img class="actorthumb" src="'.$thumburl.'" /></a>';
			}
			else
			{
				echo '<img class="actorthumb" src="/img/na.jpg" />';
			}
			echo '<p><b><i>'.$role[$i].'</i></b></p>';
			echo '<p><b>'.$actor[$i].'</b></p></div>';
		}
	?>
</table>

