<? 
	require 'funktiot.php';
?>


<h1>Lista kaikista kilpailuista</h1>

<? 
require('.yhdista.php');

$stmt = $db->query("SELECT * FROM kutsut");

$kutsut = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<ul>
<?
foreach ($kutsut as $kutsu) {
?>
	<li>
		<?= muotoile_paivamaara($kutsu['kilpailu_pvm']) . " / " . muotoile_paivamaara($kutsu['vip_pvm']) . " - " ?> 	
		<a href="?id=<?= $kutsu['id'] ?>"><?= $kutsu['otsikko']?></a> 
	</li>

<?
}	?>

</ul>

<p>Listasta löytyy kaikki 25.1.2015 jälkeen Hukkapurossa järjestetyt kilpailut</p>

