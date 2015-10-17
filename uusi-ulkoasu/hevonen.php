<? 
	require('../../hukkapuro/.yhdista.php');
	require('../../hukkapuro/luokat/Heppa.php');

	if (!isset($_GET['url'])){
	echo 'Hevosta ei löytynyt!<br /> Takaisin <a href="hevoset.php">hevoslistaukseen</a>';
	die();
	}

		//Perustietojen hakeminen
		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE url = :url');
		$stmt->bindParam(':url', $hevonen_url);
		$hevonen_url = $_GET['url'];
		$stmt->execute();
		$haettu_tiedot = $stmt->fetch(PDO::FETCH_ASSOC);
		$hevonen_id = $haettu_tiedot['id'];

		
		//Sukutietojen
		$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE id = :id');
		$stmt->bindParam(':id', $hevonen_id);
		$stmt->execute();
		$haettu_suku = $stmt->fetch(PDO::FETCH_ASSOC);
		
		//Tämän Heppa-olin luonti
		$tama_heppa = new Heppa($haettu_tiedot, $haettu_suku);
		$tama_heppa->hae_sukupolvet($db, $tama_heppa->suvun_pituus);
		
		//Vanhemien hakeminen
		$isa = $tama_heppa->isa;
		$ema = $tama_heppa->ema;

		//Ison kuvan hakeminen
		$stmt = $db->prepare('SELECT * FROM hevonen_kuva WHERE hevonen_id = :id AND iso_kuva="true"');
		$stmt->bindParam(':id', $hevonen_id);
		$stmt->execute();
		$isokuva = $stmt->fetch(PDO::FETCH_ASSOC);

		//Muiden kuvien hakeminen
		$stmt = $db->prepare('SELECT * FROM hevonen_kuva WHERE hevonen_id = :id AND iso_kuva="false"');
		$stmt->bindParam(':id', $hevonen_id);
		$stmt->execute();
		$kuvat = $stmt->fetchAll();

		//Kuvaajien hakeminen
		$stmt = $db->prepare('SELECT DISTINCT kuvaaja_id, hevonen_kuvaaja.url, hevonen_kuvaaja.nimi FROM hevonen_kuva INNER JOIN hevonen_kuvaaja ON hevonen_kuva.kuvaaja_id=hevonen_kuvaaja.id WHERE hevonen_id = :id');
		$stmt->bindParam(':id', $hevonen_id);
		$stmt->execute();
		$kuvaajat = $stmt->fetchAll();

		//Päivämäärän muotoilu
		function muotoile_paivamaara($paivamaara_merkkijono){
		try {
			$date = new DateTime($paivamaara_merkkijono);
		} catch (Exception $e) {
			return $e->getMessage();
		}

		return $date->format('d.m.Y');
		}
	?>

<!DOCTYPE html>
<html lang="fi">

	<head>
	  
	  <title><?= $tama_heppa->nimi ?> - virtuaalitalli Hukkapuro</title>
	  
	  <meta charset="utf-8">
	  <meta name="viewport" content="width=device-width, initial-scale=1">
	  
	  <link rel="stylesheet" href="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">
	  <link href='https://fonts.googleapis.com/css?family=Laila' rel='stylesheet' type='text/css'>
	  <link href='https://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
	  
	  <link rel="stylesheet" type="text/css" href="hevonentyyli.css">
	  
	  <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.3/jquery.min.js"></script>
	  <script src="http://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script>
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

			<h1><?=$tama_heppa->nimi?></h1>
			<span class="virtuaalihevonen">tämä on virtuaalihevonen - this is a sim-game horse</span>

			<div class="perustiedot container">
				<div class="tietoboksi row">
					<div class="kuva">
						<img src="../../img/h/blackette.jpg" />
					</div>

					<div class="perustietolaatikko">
						<div class="perustieto">
							<span class="tieto">Virallinen nimi:</span> 
							<span class="vastaus"><?=$tama_heppa->nimi ?>, <i>"<?=$tama_heppa->lempinimi?>"</i></span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">VH-tunnus:</span> 
							<span class="vastaus"><a href="http://www.virtuaalihevoset.net/?hevoset/hevosrekisteri/hevonen.html?vh=<?=$tama_heppa->vhtunnus?>" target"_blank"><?=$tama_heppa->vhtunnus?></a></span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Rotu, sukupuoli:</span> 
							<span class="vastaus">Heppa, ori</span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Syntynyt, ikä:</span> 
							<span class="vastaus">25.10.2015, 10v. </span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Väri, säkäkorkeus:</span> 
							<span class="vastaus">Rautias, 172cm</span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Kasvattaja:</span> 
							<span class="vastaus">Heppas kasvattamo</span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Omistaja:</span> 
							<span class="vastaus">Hepan omistaja</span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Painotuslaji:</span> 
							<span class="vastaus">Heppailu</span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Koulutustaso:</span> 
							<span class="vastaus">HepA, 160cm</span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Saavutukset:</span> 
							<span class="vastaus">Superheppa -palkinto</span>
						</div>
					</div>
				</div>

			
			<div class="luonne container">
				<p>Mich on varsinainen hurmuri, jolta löytyy machomiehen elkeiden lisäksi myös herkempikin puoli. Ihmisten seurassa aina sävyisästi käyttäytyvä ori on helppo käsitellä lähes tilanteessa kuin tilanteessa. Ainoastaan eläinlääkärin vierailut saavat orin yrittämään konnankoukkuja, mutta silloinkin napakka käsittelijä saa orin sietämään ikävämpiäkin toimenpiteitä. Kun ihmisiä ei ole tiellä, löytyy Michistä myös se tulinen ori, joka näyttää kilpailijoille taivaanmerkit, ja joka hurmaa tammoja kuin viimeistä päivää. Niinpä Michin tarha- ja laidunkavereita valitessa saakin olla tarkkana, eikä pidä hämääntyä orin herrasmiesmäisestä käytöksestä ihmisten kanssa.</p>

				<p>Ratsastettaessa Mich on kärsivällinen ja rauhallinen. Orin selkään voi päästää jopa aloittelevan ratsastajan, sillä ori tuskin hermostuu hieman huojuvasta istunnasta tai epävarmoista avuista. Sen sijaan Mich osaa kyllä luistaa työnteosta ja ori tekeekin vain ja ainoastaan sen, mitä siltä vaaditaan, eikä mitään ylimääräistä. Niinpä Michin selkään onkin laitettava kokenut, osaava ja jämäkkä ratsastaja, jotta orista saa tuotua esiin kaiken sen potentiaalin.</p>

				<p>Esteillä Mich on täysi vitsi. Maahantuojan sanoin ori on ” esteillä kömpelö ja kolauttelee puomeja ihan sävelmään saakka”. Ori ei innostu esteistä millään tavalla, eikä sillä tunnu olevan kauheasti motivaatiota hypätä, joten mielenvirkistyksesi Michin kanssa soveltuu ennemmin maastoseikkailu kuin puomi- tai estetyöskentely. Maastossa Mich on rauhallinen ja varma tosin vieraita asioita ori saattaa aluksi hieman kytätä. Reippaan ratsastajan kanssa näistäkin hirvityksistä päästään kuitenkin yleensä sujuvasti ohi.</p>

				<p>Kilpailuissa Mich on elementissään ja yhtäkkiä orilta löytyykin omaa tahtoa liikkua eteenpäin ja esitellä taitojaan. Niinpä ratsastajan tehtäväksi radalla jääkin hillitä orin intoa ja rauhoittaa orin menoa, mikä tuntuu melko päinvastaiselta siihen, millainen Mich on kotioloissa. Showmiehen elkeistä huolimatta on Mich helppo käsitellä myös kilpailupaikalla, eikä ongelmia ole myöskään lastaamisen tai kuljettamisen kanssa.</p>
			</div>

			<div class="sukutaulu container">

			<h2>Sukutaulu ja jälkeläiset</h2>
			
				
<?php


function tayta_sukulaisrivit($heppa, &$koko_suku, $polvi_str) {
	$rivi = &$koko_suku[count($koko_suku) - 1];
	$rivi[] = array($heppa, $polvi_str);
	if (isset($heppa->isa)) {
		tayta_sukulaisrivit($heppa->isa, $koko_suku, $polvi_str . "i");
	}
	if (isset($heppa->ema)) {
		$koko_suku[] = array();
		tayta_sukulaisrivit($heppa->ema, $koko_suku, $polvi_str . "e");
	}
}

$koko_suku = array(array());
tayta_sukulaisrivit($tama_heppa->isa, $koko_suku, "i");
$koko_suku[] = array();
tayta_sukulaisrivit($tama_heppa->ema, $koko_suku, "e");

//Hevosen tietojen muotoilu sukutaulua varten
function lisaa_sukulainen($heppa, $rowspan){
	if(!isset($heppa->id)){
		return 'tuntematon';
	}
	
	$str = '<span class="hepannimi">'.$heppa->nimi.'</span>';

	if($heppa->url != ""){
		$str = '<span class="hepannimi"><a href="'.$heppa->url.'" target="_blank">'.$heppa->nimi.'</a></span>';
	}

	if($heppa->status != "" && $heppa->status != "kuollut" ){
		$str = $str." <small>(".$heppa->status.")</small>";
	}


	if($rowspan >2){
		if($heppa->rotu_lyhenne != ""){
			$str = $str."<br /><small>".$heppa->rotu_lyhenne."-".$heppa->sukupuoli.", ".$heppa->saka."cm, ".$heppa->vari."</small>";
		}
	}

	if($heppa->meriitit != ""){
		$str = $str."<br /><small>".$heppa->meriitit.'</small>';
	}
	return $str;
}
?>
						
<table class="suku">

<?php foreach($koko_suku as $suku_rivi): ?>

	<tr>

	<?php foreach($suku_rivi as $i => $heppa_info): ?>
		<?php
			$heppa = $heppa_info[0];
			$polvi_str = $heppa_info[1];
			$rowspan = pow(2, (count($suku_rivi) - $i - 1));
		?>

		<td rowspan="<?= $rowspan ?>"><b><?= $polvi_str . "." ?></b> <?= lisaa_sukulainen($heppa, $rowspan) ?></td>

	<?php endforeach; ?>

	</tr>

<?php endforeach; ?>

</table>
			</div>

			<div class="varsat container">
				<div class="row">
					<div class="col-sm-3">
						<h3>Varsan nimi</h3>
						s. 1.1.2015<br />
						e. Heppastiina<br />
						om. Hertta Heppailija
					</div>
					<div class="col-sm-3">
						<h3>Varsan nimi</h3>
						s. 1.1.2015<br />
						e. Heppastiina<br />
						om. Hertta Heppailija
					</div>
					<div class="col-sm-3">
						<h3>Varsan nimi</h3>
						s. 1.1.2015<br />
						e. Heppastiina<br />
						om. Hertta Heppailija
					</div>
					<div class="col-sm-3">
						<h3>Varsan nimi</h3>
						s. 1.1.2015<br />
						e. Heppastiina<br />
						om. Hertta Heppailija
					</div>
				</div>
			</div>

			<div class="kilpailut container">

			<h2>Kilpailut ja saavutukset</h2>
				<div class="row">
					<div class="col-md-10">
						Kilpailut
					</div>
					<div class="col-md-2">
						Saavutukset
					</div>
				</div>
			</div>

			<div class="paivakirja container">

			<h2>Päiväkirja</h2>
				<div class="row">
					<div class="col-md-12">
					Heppalille kuuluu hyvää
					</div>
				</div>
			</div>


		    <div class="clearfix visible-lg"></div>
		</div>

	</body>
</html>
