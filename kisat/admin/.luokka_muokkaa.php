<?php
require('.admin_yleiset.php');
session_start();

require('../.yhdista.php');

$paivita_osallistujat = $db->prepare(<<<SQL
UPDATE luokat 
SET osallistujat=:osallistujat
WHERE rypas_id=:rypas_id AND luokka_indeksi=:luokka_indeksi
SQL
);

$rypas_id= $_POST['rypas_id'];
$luokka_indeksi = $_POST['luokka_indeksi'];

$paivita_osallistujat->bindValue(':osallistujat', $_POST['osallistujat']);
$paivita_osallistujat->bindValue(':rypas_id', $rypas_id);
$paivita_osallistujat->bindValue(':luokka_indeksi', $luokka_indeksi);

$paivita_osallistujat->execute();
$paivitetyt_rivit = $paivita_osallistujat->rowCount();

if($paivitetyt_rivit > 0) {
	$paivita_aika = $db->prepare('UPDATE kutsut SET paivitetty_aika = NOW() WHERE rypas_id=:rypas_id');
	$paivita_aika->bindValue(':rypas_id', $rypas_id);
	$paivita_aika->execute();
}




$_SESSION['paivitetyt_rivit']=$paivitetyt_rivit;
$_SESSION['luokka_indeksi']=$luokka_indeksi;

header('Location: '.$_SERVER['HTTP_REFERER']);
##EOF