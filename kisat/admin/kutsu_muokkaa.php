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
		width: 50%;
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


$rypas_idt = array();
$rivit = $db->query("SELECT DISTINCT rypas_id, otsikko FROM kutsut WHERE id IN (
   SELECT DISTINCT kutsu_id FROM luokat WHERE tulokset IS NULL
)");

foreach ($rivit as $row) {
	$rypas_idt[] = array('nimi' => $row['otsikko'], 'id' => $row['rypas_id']);
}


?>

<a href="">Päivitä sivu</a>
<form action=".osallistujat_muokkaa.php" method="get">
<select name="rypas_id" id="rypas_id" required>
<option disabled selected>Valitse rypäs</option>
	
<?php 
	foreach ($rypas_idt as $rypas) {
?>
	<option value="<?= $rypas['id'] ?>"><?= $rypas['id']." ".$rypas['nimi'] ?></option>
<?php
	}
?>

</select>
<input type="submit" value="Muokkaa ryppään osallistujia">
</form>




</body>
</html>