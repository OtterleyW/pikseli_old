<?php
require 'funktiot.php';

require('.yhdista.php');

$stmt = $db->prepare(<<<SQL
SELECT
  kutsut.*,
  jarjestajat.nimi AS jarjestaja_nimi,
  jarjestajat.vrl AS jarjestaja_vrl,
  jarjestajat.mail AS jarjestaja_mail,
  jarjestajat.talli AS jarjestaja_talli,
  jarjestajat.talli_url AS jarjestaja_url,
  jarjestajat.talli_id AS jarjestaja_talli_id

FROM `kutsut`
INNER JOIN jarjestajat
  ON jarjestajat.id = kutsut.jarjestaja_id
WHERE kutsut.id = :kutsu_id

SQL
);


$stmt->bindParam(':kutsu_id', $kutsu_id);

$kutsu_id = $_GET['id'];
$stmt->execute();

$haettu_kutsu = $stmt->fetch(PDO::FETCH_ASSOC);

if ($haettu_kutsu == false){
	die("Kutsua ei löytynyt");
}

$otsikko = $haettu_kutsu['otsikko'];
$paivitetty_aika = $haettu_kutsu['paivitetty_aika'];
$kilpailu_pvm = $haettu_kutsu['kilpailu_pvm'];
$vip_pvm = $haettu_kutsu['vip_pvm'];
$jarjestaja_id = $haettu_kutsu['jarjestaja_id'];
$saannot = $haettu_kutsu['saannot'];
$osallistuja_max = $haettu_kutsu['osallistuja_max'];
$osallistuminen_mail = $haettu_kutsu['osallistuminen_mail'];
$osallistuminen_otsikko = $haettu_kutsu['osallistuminen_otsikko'];
$jarjestaja_nimi = $haettu_kutsu['jarjestaja_nimi'];
$jarjestaja_vrl = $haettu_kutsu['jarjestaja_vrl'];
$jarjestaja_mail = $haettu_kutsu['jarjestaja_mail'];
$jarjestaja_talli = $haettu_kutsu['jarjestaja_talli'];
$jarjestaja_url = $haettu_kutsu['jarjestaja_url'];
$jarjestaja_talli_id = $haettu_kutsu['jarjestaja_talli_id'];

$stmt = $db->prepare("SELECT * FROM luokat where kutsu_id = :kutsu_id");

$stmt->bindParam(':kutsu_id', $kutsu_id);
$stmt->execute();

$luokat = $stmt->fetchAll(PDO::FETCH_ASSOC);

$tulokset_on_arvottu = false;

if($luokat[0]['tulokset'] != null){
	$tulokset_on_arvottu = true;
}

$hae_pienin_kutsu_id = $db->prepare("SELECT id FROM kutsut WHERE rypas_id=:rypas_id ORDER BY id LIMIT 1");
$hae_pienin_kutsu_id->bindValue(':rypas_id', $haettu_kutsu['rypas_id']);
$hae_pienin_kutsu_id->execute();
$pienin_kutsu_id = $hae_pienin_kutsu_id->fetchColumn();

$hae_suurin_kutsu_id = $db->prepare("SELECT id FROM kutsut WHERE rypas_id=:rypas_id ORDER BY id DESC LIMIT 1");
$hae_suurin_kutsu_id->bindValue(':rypas_id', $haettu_kutsu['rypas_id']);
$hae_suurin_kutsu_id->execute();
$suurin_kutsu_id = $hae_suurin_kutsu_id->fetchColumn();

?>

		
		
		
	<h1><?= $otsikko ?></h1>
	<p><small>Kutsu päivitetty <?= muotoile_aika($paivitetty_aika) ?></small></p>

	<h2>Kilpailun tiedot</h2>
	<p>
		<ul>
			<li>Kilpailupäivä <?= muotoile_paivamaara($kilpailu_pvm) ?>, VIP <?= muotoile_paivamaara($vip_pvm) ?></li>
			<li>Vastuuhenkilö <?= $jarjestaja_nimi ?>, <?= $jarjestaja_vrl ?> (<a href="mailto:<?= $jarjestaja_mail ?>"><?= $jarjestaja_mail ?></a>)</li>
			<li>Järjestävä talli <a href="<?= $jarjestaja_url ?>" target="new"><?= $jarjestaja_talli ?></a> (<?= $jarjestaja_talli_id ?>)</li>
			<li>Tulokset arvotaan lyhyellä arvonnalla</li>
		</ul>

	</p>

	<h2>Säännöt</h2>
	
	<ul>
		<? 
			foreach (pilko_rivit($saannot) as $rivi) {
				echo("<li>".$rivi."<br /></li>");
			}
		 ?>
		</ul>
	

	
		<h2>Osallistuminen</h2>
	
		<ul>
			<li>Osallistuminen sähköpostiin <b><a href="mailto:<?= $osallistuminen_mail ?>"><?= $osallistuminen_mail ?></a></b> otsikolla <b><?= "$osallistuminen_otsikko $kutsu_id" ?></b><br /></li>
			<li>Osallistuminen muodossa:<br />
				Luokka NRO [rivinvaihto]<br />
				Ratsastaja (VRL-tunnus) - Hevosen virallinen nimi VH-tunnus </li>
			<li>Väärin ilmoittautuneet hylätään ilman erillistä ilmoitusta!</li>
		</ul>
	
	
<?
	if($tulokset_on_arvottu){ ?>
		
		<h2>Luokat</h2>


	
		<ol>
			
			<? foreach ($luokat as $luokka) { ?>

			<li><?= $luokka['nimi'] ?> <b>TT</b></li>

			<?
			}
			?>
						

		</ol>

		<h2>Tulokset</h2>
			<p>
			<? 
				echo '<a href="'.$luokat[0]['tulokset'].'" target="_blank">tulokset täällä</a>';	
					  ?>
				</p>

				<p>&nbsp;</p>
<?
} else {
?>
	<h2>Luokat</h2>
	
		<ol>
			
			<? foreach ($luokat as $luokka) { 
			$osallistuja_array = pilko_rivit($luokka['osallistujat']);
			$osallistuja_lkm = count($osallistuja_array);
			?>
			<li><?= $luokka['nimi'] ?> <?=$osallistuja_lkm ?>/<?=$osallistuja_max ?></li>

			<?
			}
			?>
						

		</ol>

	<h2>Osallistujat</h2>


		<? foreach ($luokat as $numero => $luokka) { 
			$osallistuja_array = pilko_rivit($luokka['osallistujat']);
			$osallistuja_lkm = count($osallistuja_array);
		?>
				<h3><?= $numero + 1 ?>. <?= $luokka['nimi'] ?> <?=$osallistuja_lkm ?>/<?=$osallistuja_max ?></h3>

				<p>
					<?
					foreach ($osallistuja_array as $rivi) {
					 	echo($rivi."<br />");
					 } 
					  ?>
				</p>

				<p>&nbsp;</p>
<?
}}
?>

		
		