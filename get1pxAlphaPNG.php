<?php
function get1pxAlphaPNG($rgb, $alpha) {
	$img = imagecreatetruecolor(1, 1);
	
	// Make the img alpha
	imagealphablending($img, false);
	imagesavealpha($img, true);
	
	$imgcolor = imagecolorallocatealpha($img, $rgb[0], $rgb[1], $rgb[2], (127 - ((int) ($alpha * 127))));
	imagesetpixel($img, 0, 0, $imgcolor);
	
	ob_start();
	imagepng($img);
	$imgdata = ob_get_contents();
	ob_end_clean();
	
	imagedestroy($img);
	
	return $imgdata;
}
?>
