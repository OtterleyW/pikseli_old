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

			<h1><?=$tama_heppa->nimi?></h1>
			
			<? 
				if($tama_heppa->meriitit !=""){
					echo '<span class="meriitit"><i class="fa fa-trophy fa-lg"></i> '.$tama_heppa->meriitit.'</span><br />';
				}
			?>
			
			

			<div class="perustiedot">
				<div class="tietoboksi row">
					<div class="kuva">
						<a href="http://www.salaovi.net/hukkapuro/img/h/<?=$isokuva['osoite']?>" rel="lightbox"><img src="http://www.salaovi.net/hukkapuro/img/h/<?=$isokuva['osoite']?>" class="hevoskuva"></a> 
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
							<span class="vastaus"><?=$tama_heppa->rotu?>, <?=$tama_heppa->sukupuoli?></span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Syntynyt, ikä:</span> 
							<span class="vastaus"><? echo muotoile_paivamaara($tama_heppa->syntymaaika); if($tama_heppa->ika!=0){echo ", ".$tama_heppa->ika."v.";}?></span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Väri, säkäkorkeus:</span> 
							<span class="vastaus"><?=$tama_heppa->vari?>, <?=$tama_heppa->saka?> cm </span>
						</div>
				
						<div class="perustieto">
							<span class="tieto"><? if($tama_heppa->suvun_pituus=="0"){echo'Maahantuoja';} else{echo'Kasvattaja';}?>:</span> 
							<span class="vastaus"><? if($tama_heppa->kasvattaja_url != ""){
									echo '<a href="'.$tama_heppa->kasvattaja_url.'" target="_blank">'.$tama_heppa->kasvattaja.'</a></span>';}
									else {
									echo $tama_heppa->kasvattaja;
									}?>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Omistaja:</span> 
							<span class="vastaus"><a href="mailto:<?=$tama_heppa->omistaja_url?>"><?=$tama_heppa->omistaja?></a></span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Painotuslaji:</span> 
							<span class="vastaus"><?=$tama_heppa->painotus?></span>
						</div>
				
						<div class="perustieto">
							<span class="tieto">Koulutustaso:</span> 
							<span class="vastaus"><?=$tama_heppa->koulutustaso?></span>
						</div>
					</div>
				</div>

			<div class="virtuaalihevonen">tämä on virtuaalihevonen - this is a sim-game horse</div>
			<div class="luonne">
				<?
					$tama_heppa->luonne = preg_replace('/\n/', '</p><p>',$tama_heppa->luonne);
					$tama_heppa->luonne = "<p>{$tama_heppa->luonne}</p>";

					echo $tama_heppa->luonne;
				?>
			</div>

			<hr />

			<div class="kuvagalleria">
				<?
					foreach($kuvat as $kuva){
						echo '<div class="galleriakuva"><a href="http://www.salaovi.net/hukkapuro/img/h/'.$kuva['osoite'].'" rel="lightbox"><img src="http://www.salaovi.net/hukkapuro/img/h/'.$kuva['osoite'].'"/></a></div>';
					}

				?>
			</div>

			<div class="copyteksti">Kuvat &copy;
			<?	
				foreach ($kuvaajat as $kuvaaja) {
					if($kuvaaja['url'] != "kuvaajan url"){echo '<a href="'.$kuvaaja['url'].'" target="_blank">'.$kuvaaja['nimi'].'</a>, ';}
					else{echo $kuvaaja['nimi'];}
				}
			?>
			</div>  


			<div class="sukutaulu">

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

				<?
					if($tama_heppa->sukuselvitys !=""){
					$tama_heppa->sukuselvitys = preg_replace('/\n/', '</p><p>',$tama_heppa->sukuselvitys);
					$tama_heppa->sukuselvitys = "<p>{$tama_heppa->sukuselvitys}</p>";

					echo '<div class="sukuselvitys panel-group">
						  <div class="panel panel-default">
						    <div class="panel-heading">
						      <h4 class="panel-title">
						        <a data-toggle="collapse" href="#collapse1">Lue sukuselvitys</a>
						      </h4>
						    </div>
						    <div id="collapse1" class="panel-collapse collapse">
						      <div class="panel-body">'.$tama_heppa->sukuselvitys.'</div>
						    </div>
						  </div>
						</div>';
					}
				?>
			


			<div class="varsat">
				<div class="row">
				<?
					
					$varsat = $tama_heppa->hae_jalkelaiset($db, $tama_heppa->sukupuoli);
					if(isset($varsat)){

						foreach ($varsat as $varsa){
							echo '<div class="varsa col-sm-4"><big><b> <a href="'.$varsa->url.'" target="_blank"> '.$varsa->nimi.'</a>'.'</b></big><br />';
							echo $varsa->rotu_lyhenne.'-'.$varsa->sukupuoli.'<br />';
							echo 's.'.muotoile_paivamaara($varsa->syntymaaika).'<br />';
							if($tama_heppa->sukupuoli=='tamma'){
								echo 'i. <a href="'.$varsa->isa->url.'" target="_blank">'.$varsa->isa->nimi.'</a><br />';
							} else{
								echo 'e. <a href="'.$varsa->ema->url.'" target="_blank">'.$varsa->ema->nimi.'</a><br />';
							}
							
							echo 'om. <a href="'.$varsa->omistaja_url.'" target="_blank">'.$varsa->omistaja.'</a></div>';
						}
					}
					
				?>

					
				</div>
			</div>

			<hr />

			<div class="kilpailut">

			<h2>Kilpailut ja saavutukset</h2>

				<?
					if($tama_heppa->saavutukset != ""){
					echo '<div class="row">
							<div class="col-md-12">
								<div class="kisat panel panel-default">
								 	<div class="panel-body">
									 	<div class="saavutukset">
											'.$tama_heppa->saavutukset.'
										</div>
								  </div>
								 </div>
							</div>
						</div>';
					}
				?>

				<div class="row">
					<div class="col-md-12">
						<div class="kisat panel panel-default">
							 <div class="panel-body">
							 	<!-- Hepan kisat tekstinä -->
								<?
								if($tama_heppa->kilpailu_tyyppi == "teksti") {

						    		$stmt = $db->prepare('SELECT * FROM hevonen_kisat WHERE hevonen_id = :id');
						    		$stmt->bindParam(':id', $hevonen_id);
						    		$stmt->execute();
						    		$haettu_kisat = $stmt->fetch(PDO::FETCH_ASSOC);
								 ?>

							    <div class="sijoitukset">

							    <?
							    		echo '<div class="sijoitukset">'.$haettu_kisat['teksti'].'</div>';
							    	
							    ?>
								
								<!-- Hepan kisat sijoituksina -->
								<?
								    } elseif($tama_heppa->kilpailu_tyyppi == "normaali") {
											$stmt = $db->prepare('SELECT * FROM hevonen_kisat WHERE hevonen_id = :id');
							        		$stmt->bindParam(':id', $hevonen_id);
							        		$stmt->execute();
							        		$haettu_kisat = $stmt->fetchAll();
							      ?>
							        		
							        
							        <div class="sijoitukset">
							        	<p>Sijoituksia yhteensä <b><?=count($haettu_kisat)?></b></p>

							        	<?
							        		foreach ($haettu_kisat as $kisa) {
							        		  echo $kisa['pvm'].' - '.$kisa['laji'].' - <a href="'.$kisa['kutsu_url'].'" target="_blank">kutsu</a> - '.$kisa['luokka'].' - <b>'.$kisa['sijoitus'].'/'.$kisa['osallistujat'].'</b><br />';
							        		}
							        	?>
							    	</div>

							    <!-- Heppa kisaa porrastetuissa -->
							    	<? 
							    		} 
							    		else{

							            $reknro = $tama_heppa->vhtunnus; 
							            $json = file_get_contents('http://www.virtuaalihevoset.net/?rajapinta/ominaisuudet.html?vh=' . $reknro); 
							            $obj = json_decode($json, true); 
							   		 ?>

							   		 <div class="row">
							   		 	<div class="tasot col-md-6">

							    		   	<b>Kouluratsastus</b> taso <?php echo $obj['krj']['level'];?><br />

							    		  	<b>Esteratsastus</b> taso
							    		  	<?php echo $obj['erj']['level'];?><br />

							    		    <b>Kenttäratsastus</b> taso
							    		    <?php echo $obj['kerj']['level'];?><br />
							    		    
							    		    <b>Valjakkoajo</b> taso <?php echo $obj['vvj']['level'];?><br />
							    		 </div>
							    		 <div class="ominaisuuspisteet col-md-6">

							    		    Hyppykapasiteetti ja rohkeus:
							    		     <?php echo $obj['points']['hyppykapasiteetti_rohkeus'];?><br />

							    		     Kuuliaisuus ja luonne:
							    		     <?php echo $obj['points']['kuuliaisuus_luonne'];?><br />
			
							    		     Tahti ja irtonaisuus:
							    		     <?php echo $obj['points']['tahti_irtonaisuus'];?><br />

							    		     Nopeus ja kestävyys:
							    		      <?php echo $obj['points']['nopeus_kestavyys'];?><br />

							    		     Tarkkuus ja ketteryys:
							    		      <?php echo $obj['points']['tarkkuus_ketteryys'];?><br />

							    		</div>
							    		</div>
							    		<?php echo $obj['error_message'];
							    			}
							    		?>

							</div>
						</div>
					</div>
					</div>
			</div>
			<hr />
			<div class="paivakirja">
			
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
