<?php
	require('.yhdista.php');
	require('luokat/Heppa.php');
	require('yla.php');
?>
<div id="vs-sukutaulu-root"></div>

<?php
	// Koita ladata webpack-dev-serverin kautta localhostilla tiedostot,
	// muutoin mene vain sukutaulu-kansion sisällöllä.
	$whitelist = array('127.0.0.1', '::1');
	if (
		in_array($_SERVER['REMOTE_ADDR'], $whitelist) &&
		($socket = @fsockopen('127.0.0.1', 3000, $errno, $errstr, 0.1))
	) {
		fclose($socket);
?>
		<script src="http://localhost:3000/static/bundle.js"></script>
<?
	} else {
?>
		<link rel="stylesheet" href="sukutaulu/main.css" />
		<script src="sukutaulu/bundle.js"></script>
<?
	}
?>

<?php require('ala.php'); ?>
