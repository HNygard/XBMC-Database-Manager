<script type="text/javascript" src="<?php echo base_url();?>shadowbox/shadowbox.js"></script>
<script type="text/javascript">
	Shadowbox.init();
</script>
<?php
if(isset($thumb))
{
	$thumburl = base_url().'thumbs/'.substr($thumb,0,1).'/'.$thumb.'.tbn';
	if ( @file_get_contents($thumburl,0,NULL,0,1) )
	{
		$imginfo = getimagesize($thumburl);
		if(($imginfo[0]/$imginfo[1])>2)			//Image is twice as wide as it is high
		{
			echo '<a rel="shadowbox" title="Banner" href="'.$thumburl.'"><img class="banner" src="'.$thumburl.'" /></a>';
		}
		else
		{
			echo '<a rel="shadowbox" title="Poster" href="'.$thumburl.'"><img class="thumb" src="'.$thumburl.'" /></a>';
		}
	}
	else
	{
		echo '<img class="thumb" src="/img/na.jpg" />';
	}
//	echo '<img id="thumb" src="/thumbs/'.substr($thumb,0,1).'/'.$thumb.'.tbn" />';
}
?>

<h1><?php echo $col2['0'] ?></h1>
<table border="1">
	<!--Loops throuch arrays containing info, printing to a table-->
	<?php
		for ($i = 1; $i < count($col1); $i++)
		{
			echo "<p><b>$col1[$i]</b> $col2[$i]</p>";
		}
	?>
</table>
