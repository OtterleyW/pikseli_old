<?
require('yla.php');

if (isset($_GET["id"])) {
	include '.kutsup_nayta.php';
} else {
	include '.kutsu_index.php';
}

require('ala.php');
?>
