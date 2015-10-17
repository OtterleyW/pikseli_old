<?php
require('.admin_yleiset.php');
session_start();
?>
<!DOCTYPE html>
<html>
<head>
	<meta charset="UTF-8">
	<title>Osallistujien lisäys ja muokkaus</title>

	<style>
	* {
		box-sizing: border-box;
	}
	form {
		margin: 0 auto;
		width: 50%;
	}
	input, textarea, select {
		display: block;
		width: 100%;
		max-width: 100%;
		padding: 5px;
		margin: 1rem 0;
	}
	input[type="submit"] {
		width: 100%;
	}
	.success-box {
		width: 100%;
		background-color: hsla(88, 100%, 30%, 1);
	}
	.success {
		text-align: center;
		padding: 1rem;
	}
	</style>
</head>
<body>

<?
require('../.yhdista.php');
require('../funktiot.php');


$rypas_id = $_GET['rypas_id'];

$rypas_haku = $db->prepare('SELECT * FROM kutsut WHERE rypas_id = :rypas_id LIMIT 1');
$rypas_haku->bindValue(':rypas_id', $rypas_id);
$rypas_haku->execute();

$rypas = $rypas_haku->fetch(PDO::FETCH_ASSOC);

$otsikko = $rypas['otsikko'];
$vip_pvm = $rypas['vip_pvm'];
$jarjestaja_id=$rypas['jarjestaja_id'];
$max_osallistuja =$rypas['osallistuja_max'];

$kutsujen_maarahaku =  $db->prepare('SELECT COUNT(*) FROM kutsut WHERE rypas_id = :rypas_id');
$kutsujen_maarahaku->bindValue(':rypas_id', $rypas_id);
$kutsujen_maarahaku->execute();

$kutsujen_maara = $kutsujen_maarahaku->fetchColumn();

$luokat_haku = $db->prepare('SELECT * FROM luokat WHERE kutsu_id = :kutsu_id');
$luokat_haku->bindValue(':kutsu_id', $rypas['id']);
$luokat_haku->execute();

$luokat = $luokat_haku->fetchAll(PDO::FETCH_ASSOC);




?>



<a href="">Päivitä sivu</a>

<h1>Ryppään tiedot</h1>
<ul>
	<li><b>Nimi:</b> <?= $otsikko ?></li>
	<li><b>VIP:</b> <?= muotoile_paivamaara($vip_pvm)?></li>
	<li><b>Järjestäjä:</b> <?= $jarjestaja_id ?></li>
	<li><b>Kutsujen määrä:</b> <?= $kutsujen_maara ?></li>
</ul>





<?php foreach ($luokat as $luokka) { 
			$osallistuja_array = pilko_rivit($luokka['osallistujat']);
			$osallistuja_lkm = count($osallistuja_array);
?>

<form action=".luokka_muokkaa.php" method="post">
<fieldset>
<legend><?= ($luokka['luokka_indeksi']+1)." ".$luokka['nimi']." ".$osallistuja_lkm."/".$max_osallistuja?></legend>
<textarea name="osallistujat" rows="10" placeholder="osallistujat"><?= $luokka['osallistujat'] ?></textarea>

<input type="hidden" name="rypas_id" value="<?= $rypas_id ?>">
<input type="hidden" name="luokka_indeksi" value="<?= $luokka['luokka_indeksi'] ?>">
<input type="submit" value="Päivitä osallistujat">

<? if(isset($_SESSION['luokka_indeksi']) && $luokka['luokka_indeksi']==$_SESSION['luokka_indeksi']):?>
<div class="success-box">
<div class="success">
	Tietojen syöttäminen tietokantaan onnistui!<br />
	<?= $_SESSION['paivitetyt_rivit'] ?> riviä päivitetty
</div>
</div>
<? endif ?>

</fieldset>
</form>

<?php } ?>

<br /><br /><br />

<form action=".tulosten_arvonta.php" method="post">
<input type="hidden" name="rypas_id" value="<?= $rypas_id ?>">
<input type="submit" value="Arvo tulokset">
</form>


<? 
unset($_SESSION['paivitetyt_rivit']);
unset($_SESSION['luokka_indeksi']);
?>

</body>
</html>