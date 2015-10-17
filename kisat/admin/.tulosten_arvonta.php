<?
require('.admin_yleiset.php');
require('../.yhdista.php');
require('../funktiot.php');

header('content-type: text/html;charset=utf-8');

$rypas_id = $_POST['rypas_id'];

$hae_luokat = $db->prepare('SELECT * FROM luokat WHERE rypas_id = :rypas_id');
$hae_luokat->bindValue(':rypas_id', $rypas_id);
$hae_luokat->execute();

$luokat = $hae_luokat->fetchAll(PDO::FETCH_ASSOC);

foreach ($luokat as $luokka) {
	if($luokka['tulokset'] != null) {
		die("Tulokset on jo arvottu! Luokka id: {$luokka['id']} ja rypäs id: {$rypas_id} ");
	}
}
$tallenna_tulokset = $db->prepare('UPDATE luokat SET tulokset = :tulokset WHERE id=:luokka_id');
$tallenna_tulokset->bindParam(':tulokset', $tulokset);
$tallenna_tulokset->bindParam(':luokka_id', $luokka_id);

try {
	$db->beginTransaction();
	foreach ($luokat as $luokka) {
		$luokka_id = $luokka['id'];

		$osallistujat_array = pilko_rivit($luokka['osallistujat']);
		shuffle($osallistujat_array);
		$tulokset = yhdista_rivit($osallistujat_array);

		$tallenna_tulokset->execute();
	}
	$paivita_aika = $db->prepare('UPDATE kutsut SET paivitetty_aika = NOW() WHERE rypas_id=:rypas_id');
	$paivita_aika->bindValue(':rypas_id', $rypas_id);
	$paivita_aika->execute();
	$db->commit();
}
catch (Exception $e) {
	echo("pyöritään takaisin!");
	$db->rollBack();
	throw $e;
	
}
?>
<!DOCTYPE html>
<html>
<head>
</head>
<body>
<h1>Tulosten arvonta onnistui!</h1>

<p>
	<a href="../kutsu.php">Näytä lista kutsuista</a><br />
	<a href="kutsu_uusi.php">Luo uusi kutsu</a><br />
	<a href="kutsu_muokkaa.php">Muokkaa tuloksettomia kutsuja</a>
</p>
</body>
</html>

