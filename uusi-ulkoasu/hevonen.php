<? 
	require('.yhdista.php');
	require('luokat/Heppa.php');
	require('yla.php');

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
						<br /><span class="copyteksti">Kuvat &copy;
						<?	
							foreach ($kuvaajat as $kuvaaja) {
								if($kuvaaja['url'] != "kuvaajan url"){echo '<a href="'.$kuvaaja['url'].'" target="_blank">'.$kuvaaja['nimi'].'</a>, ';}
								else{echo $kuvaaja['nimi'];}
							}
						?>
						</span>  
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


			<div class="kuvagalleria">
				<?
					foreach($kuvat as $kuva){
						echo '<div class="galleriakuva"><a href="http://www.salaovi.net/hukkapuro/img/h/'.$kuva['osoite'].'" rel="lightbox"><img src="http://www.salaovi.net/hukkapuro/img/h/'.$kuva['osoite'].'"/></a></div>';
					}

				?>
			</div>

			<hr />


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
				<div class="row">
					<div class="col-md-6">
							 	<!-- Hepan kisat tekstinä -->
								<?
								if($tama_heppa->kilpailu_tyyppi == "teksti") {

						    		$stmt = $db->prepare('SELECT * FROM hevonen_kisat WHERE hevonen_id = :id');
						    		$stmt->bindParam(':id', $hevonen_id);
						    		$stmt->execute();
						    		$haettu_kisat = $stmt->fetch(PDO::FETCH_ASSOC);
								 ?>

		

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
							        		
							        <p>Sijoituksia yhteensä <b><?=count($haettu_kisat)?></b></p>
							        <div class="sijoitukset">
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
							   		 	<p><?=$tama_heppa->lempinimi?> kilpailee porrastetuissa kilpailuissa</p>
							   		 		<?
							   		 			$krjtaso = $obj['krj']['level'];
							   		 			$krjtasomax = $obj['krj']['level_max'];
							   		 			$krjprosentti = ($krjtaso/($krjtasomax))*100;
							   		 			if($krjprosentti > 100){
							   		 				$krjprosentti = 100;
							   		 			}

							   		 		?>

							    		   	<b>Kouluratsastus</b> taso <?php echo $obj['krj']['level'];?><br />
							    		   	<div class="progress">
							    		   	  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
							    		   	  aria-valuenow="<?=$krjtaso?>" aria-valuemin="0" aria-valuemax="<?=$krjtasomax ?>" style="width:<?=$krjprosentti?>%">
							    		   	  <?php echo $obj['krj']['points'];?> 
							    		   	  </div>
							    		   	</div>

							    		  	<?
							   		 			$erjtaso = $obj['erj']['level'];
							   		 			$erjtasomax = $obj['erj']['level_max'];
							   		 			$erjprosentti = ($erjtaso/($erjtasomax))*100;
							   		 			if($erjprosentti > 100){
							   		 				$erjprosentti = 100;
							   		 			}

							   		 		?>

							    		   	<b>Esteratsastus</b> taso <?php echo $obj['erj']['level'];?><br />
							    		   	<div class="progress">
							    		   	  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
							    		   	  aria-valuenow="<?=$erjtaso?>" aria-valuemin="0" aria-valuemax="<?=$erjtasomax ?>" style="width:<?=$erjprosentti?>%">
							    		   	  <?php echo $obj['erj']['points'];?> 
							    		   	  </div>
							    		   	</div>

							    		    <?
							   		 			$kerjtaso = $obj['kerj']['level'];
							   		 			$kerjtasomax = $obj['kerj']['level_max'];
							   		 			$kerjprosentti = ($kerjtaso/($kerjtasomax))*100;
							   		 			if($kerjprosentti > 100){
							   		 				$kerjprosentti = 100;
							   		 			}

							   		 		?>

							    		   	<b>Kenttäratsastus</b> taso <?php echo $obj['kerj']['level'];?><br />
							    		   	<div class="progress">
							    		   	  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
							    		   	  aria-valuenow="<?=$kerjtaso?>" aria-valuemin="0" aria-valuemax="<?=$kerjtasomax ?>" style="width:<?=$kerjprosentti?>%">
							    		   	  <?php echo $obj['kerj']['points'];?> 
							    		   	  </div>
							    		   	</div>

							    		   	<?
							   		 			$vvjtaso = $obj['vvj']['level'];
							   		 			$vvjtasomax = $obj['vvj']['level_max'];
							   		 			$vvjprosentti = ($vvjtaso/($vvjtasomax))*100;
							   		 			if($vvjprosentti > 100){
							   		 				$vvjprosentti = 100;
							   		 			}

							   		 		?>

							    		   	<b>Valjakkoajo</b> taso <?php echo $obj['vvj']['level'];?><br />
							    		   	<div class="progress">
							    		   	  <div class="progress-bar progress-bar-info progress-bar-striped" role="progressbar"
							    		   	  aria-valuenow="<?=$vvjtaso?>" aria-valuemin="0" aria-valuemax="<?=$vvjtasomax ?>" style="width:<?=$vvjprosentti?>%">
							    		   	  <?php echo $obj['vvj']['points'];?> 
							    		   	  </div>
							    		   	</div>
							    		
							    		<?php echo $obj['error_message'];
							    			}
							    		?>
							   	</div>


					<?
						if($tama_heppa->saavutukset != ""){
						echo '
								<div class="col-md-6">
										 	<div class="saavutukset">
												'.$tama_heppa->saavutukset.'
											</div>
								</div>';
						}
					?>
					</div>
			</div>
			<hr />
			<div class="paivakirja">
			<?
				$stmt = $db->prepare('SELECT * FROM hevonen_tekstit WHERE hevonen_id = :id ORDER BY pvm DESC');
				$stmt->bindParam(':id', $tama_heppa->id);
				$stmt->execute();
				$tekstit = $stmt->fetchAll();
				
				if(count($tekstit) != 0){
			?>

				<h2>Päiväkirja</h2>

				<div class="row">
					<div class="col-md-12">
					<?
						foreach($tekstit as $teksti){
					?>
					
						<h4><? if($teksti['pvm'] != "0000-00-00"){echo muotoile_paivamaara($teksti['pvm']).' - ';} echo$teksti['otsikko']?></h4>
						<span class="copyteksti"><?=$teksti['tekstin_tyyppi'].' - kirjoittanut '.$teksti['kirjoittaja']?><br /><br /></span>
							<?
								$teksti = preg_replace('/\n/', '</p><p>',$teksti['teksti']);
								$teksti = "<p>{$teksti}</p>";
								echo $teksti
							?>


						<hr />
					
					<?}?>
					
					</div>
				</div>
				<? }?>


			</div>


		    <div class="clearfix visible-lg"></div>
		</div>

	</body>
</html>
