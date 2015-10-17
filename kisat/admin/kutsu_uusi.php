<?php
require('.admin_yleiset.php');
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
	<title>Kilpailut</title>

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

<?php
require('../funktiot.php');

require('../.yhdista.php');

$jarjestaja_idt = array();

$rivit = $db->query("SELECT * FROM jarjestajat");

foreach ($rivit as $row) {
	$jarjestaja_idt[] = array('nimi' => $row['talli'], 'id' => $row['id']);
}


if (isset($_POST["otsikko"])) {

$kutsu_insert = $db->prepare(<<<SQL

INSERT INTO kutsut
(id, rypas_id, otsikko, kilpailu_pvm, vip_pvm, jarjestaja_id, saannot, osallistuja_max, osallistuminen_mail, osallistuminen_otsikko)
VALUES
(:kutsu_id, :rypas_id, :otsikko, :kilpailu_pvm, :vip_pvm, :jarjestaja_id, :saannot, :osallistuja_max, :osallistuminen_mail, :osallistuminen_otsikko)

SQL
);

$luokka_insert = $db->prepare(<<<SQL
INSERT INTO luokat
(kutsu_id, rypas_id, luokka_indeksi, nimi, osallistujat)

VALUES
(:kutsu_id, :rypas_id, :luokka_indeksi, :nimi, :osallistujat)
SQL
);


$kutsu_insert->bindParam(':kutsu_id', $kutsu_id);
$kutsu_insert->bindParam(':rypas_id', $rypas_id);
$kutsu_insert->bindParam(':otsikko', $otsikko);
$kutsu_insert->bindParam(':kilpailu_pvm', $kilpailu_pvm);
$kutsu_insert->bindParam(':vip_pvm', $vip_pvm);
$kutsu_insert->bindParam(':jarjestaja_id', $jarjestaja_id);
$kutsu_insert->bindParam(':saannot', $saannot);
$kutsu_insert->bindParam(':osallistuja_max', $osallistuja_max);
$kutsu_insert->bindParam(':osallistuminen_mail', $osallistuminen_mail);
$kutsu_insert->bindParam(':osallistuminen_otsikko', $osallistuminen_otsikko);

$luokka_insert->bindParam(':kutsu_id', $kutsu_id);
$luokka_insert->bindParam(':rypas_id', $rypas_id);
$luokka_insert->bindParam(':luokka_indeksi', $luokka_indeksi);
$luokka_insert->bindParam(':nimi', $luokka_nimi);
$luokka_insert->bindValue(':osallistujat', "");

$rypas_id = $db->query('SELECT (rypas_id+1) FROM kutsut ORDER BY rypas_id DESC LIMIT 1')->fetchColumn();
$kutsu_id = $db->query('SELECT (id+1) FROM kutsut ORDER BY id DESC LIMIT 1')->fetchColumn();
if ($kutsu_id < 1) {
	$kutsu_id = 1;
}
$otsikko = $_POST["otsikko"];
$kilpailu_pvm = $_POST["kilpailu_pvm"];
$vip_pvm = $_POST["vip_pvm"];
$jarjestaja_id = $_POST["jarjestaja_id"];
$saannot = $_POST["saannot"];
$osallistuja_max = $_POST["osallistuja_max"];
$osallistuminen_mail = $_POST["osallistuminen_mail"];
$osallistuminen_otsikko = $_POST["osallistuminen_otsikko"];
$kutsu_maara = intval($_POST["kutsu_maara"]);

$luokat = pilko_rivit($_POST["luokat"]);

try {
	$db->beginTransaction();

	for ($i=0; $i < $kutsu_maara ; $i++) { 
			$kutsu_insert->execute();

			foreach ($luokat as $luokka_indeksi => $luokka_nimi) {
				$luokka_insert->execute();
			}
			
			$kutsu_id++;
			$date = date_create($kilpailu_pvm);
			date_add($date, date_interval_create_from_date_string('1 days'));
			$kilpailu_pvm = date_format($date, 'Y-m-d');
	}
	$db->commit();
}
catch (Exception $e) {
	echo("pyöritään takaisin!");
	$db->rollBack();
	throw $e;
	
}



?>

<div class="success-box">
<div class="success">
	Tietojen syöttäminen tietokantaan onnistui!
</div>
</div>

<?php

}
?>

<a href="">Päivitä tämä sivu</a>

<form action="kutsu_uusi.php" method="post">

	<label for="kutsu_maara">Kutsujen määrä</label> <input name="kutsu_maara" id="kutsu_maara" type="text" placeholder="kutsujen lukumäärä" required>
	<label for="kutsun_otsikko">Kutsun otsikko</label> <input name="otsikko" id="otsikko" type="text" placeholder="kisan otsikko" required>
	<label for="kisa_pvm">Kilpailun pvm</label> <input type="date" name="kilpailu_pvm" id="kilpailu_pvm" placeholder="kilpailun pvm" required>
	<label for="vip_pvm">VIP</label> <input type="date" name="vip_pvm" id="vip_pvm" placeholder="vip pvm" required>
	<label for="osallistuja_max">Osallistujia max.</label> <input type="text" name="osallistuja_max" id="osallistuja_max" placeholder="osallistuja max" required>
	<label for="osallistuminen_mail">Osallistumisen maili</label> <input type="text" name="osallistuminen_mail" id="osallistuminen_mail" placeholder="osallistuminen mail" required>
	<label for="osallistuminen_otsikko">Osallistumisen otsikko</label> <input type="text" name="osallistuminen_otsikko" id="osallistuminen_otsikko" placeholder="osallistuminen otsikko" required>

<label for="jarjestaja">Järjstäjä</label> <select name="jarjestaja_id" id="jarjestaja_id" required>
<option disabled selected>Valitse järjestäjä</option>
	
<?php 
	foreach ($jarjestaja_idt as $jarjestaja) {
?>
	<option value="<?= $jarjestaja['id'] ?>"><?= $jarjestaja['nimi'] ?></option>
<?php
	}
?>

</select>

	<label for="saannot">Säännot</label> <textarea name="saannot" id="saannot" rows="10" placeholder="säännöt" required></textarea>
	<label for="luokat">Luokat</label> <textarea name="luokat" id="luokat" rows="10" placeholder="luokat" required></textarea>

	<input type="submit" value="lähetä">
</form>


</body>
</html>