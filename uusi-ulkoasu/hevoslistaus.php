<? 
	require('../../hukkapuro/.yhdista.php');
	require('../../hukkapuro/luokat/Heppa.php');

	function hae_tiedot($id, $db){
			//Perustietojen hakeminen
			$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE id = :id');
			$stmt->bindParam(':id', $hevonen_id);
			$hevonen_id = $id;
			$stmt->execute();
			$haettu_tiedot = $stmt->fetch(PDO::FETCH_ASSOC);


			//Sukutietojen
			$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE id = :id');
			$stmt->bindParam(':id', $hevonen_id);
			$stmt->execute();
			$haettu_suku = $stmt->fetch(PDO::FETCH_ASSOC);

			//Tämän Heppa-olion luonti
			$tama_heppa = new Heppa($haettu_tiedot, $haettu_suku);
			$tama_heppa->hae_sukupolvet($db, $tama_heppa->suvun_pituus);

			return $tama_heppa;
		}

		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE sukupuoli="ori" AND omistaja = "Otterley Wilson VRL-12757" AND status <> "poistettu" AND status <> "kuollut" AND kaytto <>"pihatto" AND rotu_lyhenne<>"pre" ORDER BY painotus DESC, suvun_pituus, rotu, nimi');
		$stmt->execute();
		$orit = $stmt->fetchAll();

		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE sukupuoli="tamma" AND omistaja = "Otterley Wilson VRL-12757" AND status <> "poistettu" AND status <> "kuollut" AND kaytto <>"pihatto" AND rotu_lyhenne<>"pre" ORDER BY painotus DESC, suvun_pituus, rotu, nimi');
		$stmt->execute();
		$tammat = $stmt->fetchAll();

		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE omistaja = "Otterley Wilson VRL-12757" AND status <> "poistettu"AND status <> "kuollut" AND kaytto ="pihatto" OR rotu_lyhenne="pre" AND  omistaja = "Otterley Wilson VRL-12757" ORDER BY rotu_lyhenne, suvun_pituus');
		$stmt->execute();
		$muut = $stmt->fetchAll();
	?>

<!DOCTYPE html>
<html lang="fi">

	<head>
	  
	  <title>Virtuaalitalli Hukkapuro</title>
	  
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	  <link href='https://fonts.googleapis.com/css?family=Laila' rel='stylesheet' type='text/css'>
	  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.4.0/css/font-awesome.min.css">
	  
	  <link rel="stylesheet" type="text/css" href="hevonentyyli.css">
	  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
	  <script type="text/javascript" src="lightbox.js"></script>
	</head>

	<body>

		<nav class="navbar navbar-default navbar-fixed-top">
		  <div class="container-fluid">
		    <div class="navbar-header">
		      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#myNavbar">
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span>
		        <span class="icon-bar"></span> 
		      </button>
		      <a class="navbar-brand" href="index.php">Hukkapuro</a>
		    </div>
		    <div class="collapse navbar-collapse" id="myNavbar">
		      <ul class="nav navbar-nav">
		        <li class="active"><a href="#">Etusivu</a></li>
		        <li><a href="#">Hevoset</a></li>
		        <li><a href="#">Toiminta</a></li> 
		        <li><a href="#">Tallin esittely</a></li> 
		      </ul>
		      <ul class="nav navbar-nav navbar-right">
		        <li><a href="#"><span class="glyphicon glyphicon-book"></span> Vieraskirja</a></li>
		        <li><a href="#"><span class="glyphicon glyphicon-envelope"></span> Sähköposti</a></li>
		      </ul>
		    </div>
		  </div>
		</nav>

		<div class="layout container">

			<h1>Hukkapuron hevoset</h1>

			<h2>Orit</h2>

			<div class="hevoslistaus row">
			
			<?
				foreach ($orit as $hevonen) {
					$tama_heppa = hae_tiedot($hevonen['id'], $db);
					
					$stmt = $db->prepare('SELECT * FROM hevonen_kuva WHERE hevonen_id = :id AND iso_kuva="true"');
					$stmt->bindParam(':id', $hevonen['id']);
					$stmt->execute();
					$isokuva = $stmt->fetch(PDO::FETCH_ASSOC);

					echo '<div class="varsa col-sm-4"><h4>'.$tama_heppa->nimi .'</h4><br />
					<img src="http://www.salaovi.net/hukkapuro/img/h/'.$isokuva['osoite'].'" class="listauskuva"/></div>';
					}
			?>

			</div>

		    <div class="clearfix visible-lg"></div>
		</div>
	</body>
</html>