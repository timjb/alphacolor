<?php
function getRGBFromString($color) {
	$rgb = false;
	if(stristr($color, 'rgb(')) {
		$color = str_ireplace('rgb(', '', $color);
		$color = str_ireplace(')', '', $color);
		$rgb = explode(',', $color);
		foreach($rgb as $i => $c) {
			$c = trim($c);
			$rgb[$i] = (int) $c;
		}
	}
	else {
		if($color[0] == '#') {
			$color = substr($color, 1);
		}
		if(strlen($color) == 6) {
			$rgbhex = array($color[0].$color[1], $color[2].$color[3], $color[4].$color[5]);
		}
		else if(strlen($color) == 3)
		{
			$rgbhex = array($color[0].$color[0], $color[1].$color[1], $color[2].$color[2]);
		}
		if(isset($rgbhex)) {
			$rgb = array();
			foreach($rgbhex as $i => $c) {
				$rgb[$i] = hexdec($c);
			}
		}
	}
	// hat alles geklappt?
	if(!(count($rgb) == 3 && $rgb[0] >= 0 && $rgb[0] <= 255 && $rgb[1] >= 0 && $rgb[1] <= 255 && $rgb[2] >= 0 && $rgb[2] <= 255)) {
		$rgb = false;
	}
	return $rgb;
}
?>
