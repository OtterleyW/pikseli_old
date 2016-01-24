<?php
	require('.yhdista.php');
	require('luokat/Heppa.php');

	function hae_tiedot($id, $db){
		//Perustietojen hakeminen
		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE id = :id');
		$stmt->bindParam(':id', $hevonen_id);
		$hevonen_id = $id;
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
			'id' => $heppa->id,
			'data' => array(
				'nimi' => $heppa->nimi
			)
		);
		if (isset($heppa->isa)) {
			$return['father'] = serialisoitava_suku($heppa->isa);
		}
		if (isset($heppa->ema)) {
			$return['mother'] = serialisoitava_suku($heppa->ema);
		}
		return $return;
	}

	function suku_json($heppa) {
		$data = serialisoitava_suku($heppa);
		$avaimet = array(
			'nimi'
		);
		return json_encode(array(
			'keys' => $avaimet,
			'tree' => $data
		));
	}

	$heppa = hae_tiedot($_GET['id'], $db);

	if ($heppa->id == null) {
		header("HTTP/1.0 404 Not Found");
		die('Heppa ei löytynyt');
	}

	if ($_GET['json']) {
		header('Content-Type: application/json');
		die(suku_json($heppa));
	}

	require('yla.php');
?>

<script>
window.VS_SUKU_JSON = <?= suku_json($heppa) ?>;
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
		<link rel="stylesheet" href="/hukkapuro/sukutaulu/main.css" />
		<script src="/hukkapuro/sukutaulu/bundle.js"></script>
<?
	}
?>

<?php require('ala.php'); ?>
