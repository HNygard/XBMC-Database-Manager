<script type="text/javascript" src="<?php echo base_url();?>shadowbox/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
</script>
<?php
	$arturl = base_url().'thumbs/Fanart/'.$hash.'.tbn';
	echo '<div id="backdrop">';
	if ( @file_get_contents($arturl,0,NULL,0,1) )
	{
		echo '<a rel="shadowbox" href="'.$arturl.'"><img class="fanart" src="'.$arturl.'" /></a>';
	}
	else
	{
		echo '<img class="fanart" src="/img/na.jpg" />';
	}
	echo '</div>';
?>

