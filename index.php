<!DOCTYPE html>
<html>

<head>
<meta charset=utf-8>
<title>Teiltransparente Hintergrundfarben in allen Browsern (fast) ohne PNG-Dateien &ndash; CSS-Generator</title>
<meta name=description content="CSS-Generator für einfarbige, halbtransparente Hintergründe, die in allen Browsern funktionieren">
<meta name=author content="Tim Baumann">
<meta name=language content=de>
<link rel=stylesheet href=css/style.css>
<link rel=stylesheet href=css/mooRainbow.css>
<link rel="shortcut icon" href=img/favicon.png>

<body>
<div id=wrapper>

<div id=title class=halftransparent>
	<h1>Teiltransparente Hintergrundfarben in allen Browsern (fast) ohne PNG-Dateien &ndash; CSS-Generator</h1>
</div>
<div id=explanation class=halftransparent>
	Dieser CSS-Generator erzeugt den Code um Elementen eine halbdurchsichtige Hintergrundfarbe zu verpassen. Die Methode, die in allen Browsern funktioniert, hat Peter Kröner, deren Erfinder, in <a href=http://www.peterkroener.de/teiltransparente-hintergrundfarben-in-allen-browsern-fast-ohne-png-dateien/>einem Blogeintrag</a> beschrieben. Das ganze funktioniert mit halbtransparenten 1-Pixel-PNGs, die als Data-URL modernen Browsern verabreicht werden, und der MS-proprietären CSS-Eigenschaft filter für den Internet Exploder. Leider ist das Ganze etwas umständlich. Deshalb dieser Generator. Einfach das Feld Farbe mit einem Hex- oder rgb()-Wert befüllen und in das Feld Alpha-Wert eine Zahl zwischen 0 (= voll transparent) und 1 (= voll opak) eingeben. Nach dem Klick auf "CSS generieren" wird der einbaufertige Code ausgegeben. Dieser enthält einen CSS-Hack, damit der IE7 nicht sowohl PNG als auch den Filter anzeigt. Du kannst dieses Problem natürlich auch mit Conditional Comments lösen. 
</div>
<div id=input class=halftransparent>
	<h2>Eingabe</h2>
	<form action="index.php" method="get">
		<label>Farbe: <input type=text id=color name=color value="<?php echo $_GET['color']; ?>"></label>
		<label>Alpha-Wert: <input type=text name=alpha id=alpha value="<?php echo $_GET['alpha']; ?>"></label>
		<input type=submit name=submit id=submit value="CSS generieren">
	</form>
</div>
<div id=output class=halftransparent>
	<h2>Ausgabe</h2>
	<p id=code>

<?php
if(isset($_GET['color']) && $_GET['color'] != '' && isset($_GET['alpha']) && $_GET['alpha'] != '') {
	$color = $_GET['color'];
	$alpha = $_GET['alpha'];
	
	require_once('getRGBFromString.php');
	require_once('getHexFromRGB.php');
	require_once('get1pxAlphaPNG.php');
	
	$rgb = getRGBFromString($color);
	if($rgb) {
		$alphargbhex = (dechex((int) ($alpha * 255))) . getHexFromRGB($rgb);
		if(strlen($alphargbhex) == 7) {
			$alphargbhex = "0" . $alphargbhex;
		}
		$imgdata = base64_encode(get1pxAlphaPNG($rgb, $alpha));
		$css = "background: transparent url('data:image/png;base64," . $imgdata . "') repeat;\n*filter: progid:DXImageTransform.Microsoft.gradient(startColorstr=#" . $alphargbhex . ", endColorstr=#" . $alphargbhex . ") /* won't validate, CSS hack, a method for alpha color backgrounds, http://tinyurl.com/ly6rj2 */;";

		echo '<code>' . nl2br($css) . '</code>';
	}
	else {
		echo 'Hat irgendwie ned geklappt :-(. Versuch was anderes.';
	}
}
else {
	echo 'Zuerst Eingabe';
}
?>

	</p>
</div>

</div><!-- close wrapper -->

<div id=imgsrc>
	Bokeh background by  <a href=http://www.flickr.com/photos/calebkimbrough/4151252608/in/set-72157622915120782/>calebkimbrough</a>
</div>

<script src=js/mootools.js></script>
<script src=js/mooRainbow.js></script>
<script>
window.addEvent('domready', function() {
	var mooRainbow = new MooRainbow($('color'), {
		imgPath: 'img/',
		onChange: function(color) {
			$('color').set('value', color.hex);
		}
	});
});
</script>
