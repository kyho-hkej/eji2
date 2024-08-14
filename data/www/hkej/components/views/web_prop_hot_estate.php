<ul>
<?php 
$i=0;
foreach($estates as $estate) {
	echo '<li><a href="/property/details/estate/'.$estate['estateNameChi'].'">'.$estate['estateNameChi'].'</a></li>';
	$i++;
}
?>
</ul>