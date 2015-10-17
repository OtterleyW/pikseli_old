<?php
require('.admin_yleiset.php');

require('../funktiot.php');

header('Content-Type: text/plain;charset=utf-8');

function varmista($pitaisi_olla_true, $virheviesti) {
	if (!$pitaisi_olla_true) {
		die("Varmistus epäonnistui: $virheviesti");
	}
}

function varmista_sijoittuneet($range, $sijoittuneita_pitaa_olla) {
	$eka = $range[0];
	$vika = $range[count($range) - 1];
	foreach ($range as $osallistujien_maara) {
		$sijoittuneita = sijoittuneiden_maara($osallistujien_maara);
		varmista($sijoittuneita == $sijoittuneita_pitaa_olla, "Kun osallistujia $eka - $vika, piti sijoittuneita olla <$sijoittuneita_pitaa_olla>, mutta oli <$sijoittuneita>. Epäonnistuminen tapahtui, kun osallistujien määrä oli $osallistujien_maara");
	}
}

echo ">>>> sijoittuneiden_maara testit:\n\n";

varmista_sijoittuneet(range(1, 3), 1);
varmista_sijoittuneet(range(4, 8), 2);
varmista_sijoittuneet(range(9, 15), 3);
varmista_sijoittuneet(range(16, 24), 4);
varmista_sijoittuneet(range(25, 35), 5);
varmista_sijoittuneet(range(36, 48), 6);
varmista_sijoittuneet(range(49, 63), 7);
varmista_sijoittuneet(range(64, 80), 8);
varmista_sijoittuneet(range(81, 99), 9);
varmista_sijoittuneet(range(100, 100), 10);

echo "==== Kaikki onnistui!";

## EOF