<?php

function muotoile_paivamaara($paivamaara_merkkijono){
	try {
		$date = new DateTime($paivamaara_merkkijono);
	} catch (Exception $e) {
		return $e->getMessage();
	}

	return $date->format('d.m.Y');
}

function muotoile_aika($aika_merkkijono){
	try {
		$date = new DateTime($aika_merkkijono);
	} catch (Exception $e) {
		return $e->getMessage();
	}

	return $date->format('d.m.Y \k\l\o H:i:s');
}

function pilko_rivit($merkkijono){
	//Vesa sanoo googleta rivin vaihto merkki//
	if($merkkijono == ""){
		return array();
	} 
	else {
		$rivit = explode("\r\n", $merkkijono);
		return $rivit;
	}
}

function yhdista_rivit($array){
	//Vesa sanoo googleta rivin vaihto merkki//
	$merkkijono = implode("\r\n", $array);
	return $merkkijono;
}

function sijoittuneiden_maara($osallistujien_maara){
	if ($osallistujien_maara >=1 && $osallistujien_maara <= 3) {
		return 1;
	} elseif ($osallistujien_maara <= 8) {
		return 2;
	} elseif ($osallistujien_maara <= 15) {
		return 3;
	} elseif ($osallistujien_maara <= 24) {
		return 4;
	} elseif ($osallistujien_maara <= 35) {
		return 5;
	} elseif ($osallistujien_maara <= 48) {
		return 6;
	} elseif ($osallistujien_maara <= 63) {
		return 7;
	} elseif ($osallistujien_maara <= 80) {
		return 8;
	} elseif ($osallistujien_maara <= 99) {
		return 9;
	} elseif ($osallistujien_maara <= 100) {
		return 10;
	} elseif ($osallistujien_maara > 100) {
		return ($osallistujien_maara/10);
	}

}

function tulosta_tulokset($tulokset){
	$osallistujien_maara = count($tulokset);
	$sijoittuneiden_maara = sijoittuneiden_maara($osallistujien_maara);

	foreach ($tulokset as $indeksi=>$ratsukko) {
		$sija = $indeksi+1;
		if($sija <= $sijoittuneiden_maara) {
			echo "<b>$sija. $ratsukko</b>";
		} else {
			echo "$sija. $ratsukko";
		}
		echo "<br />";
	}
}
##EOF