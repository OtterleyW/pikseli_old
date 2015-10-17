<?
require('yla.php');

if (isset($_GET["id"])) {
	include '.cup_kutsu_nayta.php';
} else {
	include '.kutsu_index.php';
}

require('ala.php');
?>
