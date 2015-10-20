<? 
	require('../../hukkapuro/.yhdista.php');
	require('../../hukkapuro/luokat/Heppa.php');
	require('yla.php');

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
			<h1>Hukkapuron hevoset</h1>
			<? $hevoset = count($orit)+count($tammat)+count($muut); ?>

			<p class="hevoset">
			Tällä hetkellä Hukkapurossa asuu yhteensä <?=$hevoset?> hevosta, joista <?=count($orit);?> on puoliverisiä oreja, <?=count($tammat)?> puoliverisiä tammoja ja <?=count($muut);?> muita hevosia.<br />
			Lähes kaikki hevosemme ovat tarjolla jalostukseen myös ulkopuolisille oreille ja tammoille (<a href="toiminta.php">lue lisää</a>).
			</p>

			<ul class="hevoslistausnav nav nav-pills nav-justified">
			  <li class="active"><a data-toggle="tab" href="#pvorit">Puoliveriset orit </a> </li>
			  <li><a data-toggle="tab" href="#pvtammat">Puoliveriset tammat </a></li>
			  <li><a data-toggle="tab" href="#muut">Muut hevoset </a></li>
			</ul>

			<div class="tab-content">
			  <div id="pvorit" class="tab-pane fade in active">
			    <h2>Puoliveriset orit</h2>

			    <div class="hevoslistaus">
			    
			    <?
			    	foreach ($orit as $hevonen) {
			    		$tama_heppa = hae_tiedot($hevonen['id'], $db);
			    		
			    		$suku = $tama_heppa->suvun_pituus.'-polvinen';
			    		if($suku ==0){$suku = 'evm';}
			    		elseif($suku > 5){$suku ='pitkä suku';}

			    		echo '<div class="heppalaatikko panel panel-default">
			    					<a href="'.$tama_heppa->url.'">
			    					<div class="panel-body">
			    						<h4><b>'.$tama_heppa->nimi.'</b></h4>
			    							'.$tama_heppa->rotu.'<br />
				    						'.$suku.' suku<br />
				    						'.$tama_heppa->painotus.'<br />
			    						<b>'.$tama_heppa->meriitit.'&nbsp;</b>
			    					</div>
			    					</a>
			    				</div>';
			    		}
			    ?>

			    </div>
			  </div>
			  <div id="pvtammat" class="tab-pane fade">
			    <h2>Puoliveriset tammat</h2>

			    <div class="hevoslistaus">
			    
			    <?
			    	foreach ($tammat as $hevonen) {
			    		$tama_heppa = hae_tiedot($hevonen['id'], $db);
			    		
			    		$suku = $tama_heppa->suvun_pituus.'-polvinen';
			    		if($suku ==0){$suku = 'evm';}
			    		elseif($suku > 5){$suku ='pitkä suku';}

			    		echo '<div class="heppalaatikko panel panel-default">
			    					<a href="'.$tama_heppa->url.'">
			    					<div class="panel-body">
			    						<h4><b>'.$tama_heppa->nimi.'</b></h4>
			    							'.$tama_heppa->rotu.'<br />
				    						'.$suku.' suku<br />
				    						'.$tama_heppa->painotus.'<br />
			    						<b>'.$tama_heppa->meriitit.'&nbsp;</b>
			    					</div>
			    					</a>
			    				</div>';
			    		}
			    ?>

			    </div>
			   
			  </div>
			  <div id="muut" class="tab-pane fade">
			    <h2>Muut hevoset</h2>

			    <div class="hevoslistaus">
			    
			    <?
			    	foreach ($muut as $hevonen) {
			    		$tama_heppa = hae_tiedot($hevonen['id'], $db);
			    		
			    		$suku = $tama_heppa->suvun_pituus.'-polvinen';
			    		if($suku ==0){$suku = 'evm';}
			    		elseif($suku > 5){$suku ='pitkä suku';}

			    		echo '<div class="heppalaatikko panel panel-default">
			    					<a href="'.$tama_heppa->url.'">
			    					<div class="panel-body">
			    						<h4><b>'.$tama_heppa->nimi.'</b></h4>
			    							'.$tama_heppa->rotu.'<br />
				    						'.$suku.' suku<br />
				    						'.$tama_heppa->painotus.'<br />
			    						<b>'.$tama_heppa->meriitit.'&nbsp;</b>
			    					</div>
			    					</a>
			    				</div>';
			    		}
			    ?>

			    </div>
			  </div>
			</div>

			

			

		    <div class="clearfix visible-lg"></div>
		</div>
	</body>
</html>