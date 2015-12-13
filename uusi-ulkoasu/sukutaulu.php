<?php
	require('.yhdista.php');
	require('luokat/Heppa.php');
	require('yla.php');
?>

<?php
	function hae_tiedot($url, $db){
		//Perustietojen hakeminen
		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE url = :url');
		$stmt->bindParam(':url', $hevonen_url);
		$hevonen_url = $url;
		$stmt->execute();
		$haettu_tiedot = $stmt->fetch(PDO::FETCH_ASSOC);


		//Sukutietojen
		$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE id = :id');
		$stmt->bindParam(':id', $haettu_tiedot['id']);
		$stmt->execute();
		$haettu_suku = $stmt->fetch(PDO::FETCH_ASSOC);

		//Tämän Heppa-olion luonti
		$tama_heppa = new Heppa($haettu_tiedot, $haettu_suku);
		$tama_heppa->hae_sukupolvet($db, $tama_heppa->suvun_pituus);

		return $tama_heppa;
	}

	function serialisoitava_suku($heppa) {
		$return = array(
			'name' => $heppa->nimi,
			'url' => $heppa->url
		);
		if (isset($heppa->isa)) {
			$return['father'] = serialisoitava_suku($heppa->isa);
		}
		if (isset($heppa->ema)) {
			$return['mother'] = serialisoitava_suku($heppa->ema);
		}
		return $return;
	}

	$heppa = hae_tiedot('monte-rosa-thrill', $db);
?>

<script>
window.VS_SUKU_JSON = <?= json_encode(serialisoitava_suku($heppa)) ?>;
</script>

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
