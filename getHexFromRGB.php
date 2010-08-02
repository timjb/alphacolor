<?php
function getHexFromRGB($rgb) {
	$hex = '';
	foreach($rgb as $i => $c) {
		$chex = dechex($c);
		if(strlen($chex) == 1) {
			$chex = '0' . $chex;
		}
		$hex .= $chex;
	}
	return $hex;
}
?>
