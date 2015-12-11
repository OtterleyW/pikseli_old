<? 
	require('.yhdista.php');
	require('luokat/Heppa.php');
	require('yla.php');

	//Päivämäärän muotoilu
function muotoile_paivamaara($paivamaara_merkkijono){
try {
	$date = new DateTime($paivamaara_merkkijono);
} catch (Exception $e) {
	return $e->getMessage();
}

return $date->format('d.m.Y');
}

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

	//Tämän Heppa-olin luonti
	$tama_heppa = new Heppa($haettu_tiedot, $haettu_suku);
	$tama_heppa->hae_sukupolvet($db, $tama_heppa->suvun_pituus);

	return $tama_heppa;
}
?>

			<h1>Hukkapuron toiminta</h1>

			  <div class="toiminta row">
			      <div class="col-sm-12">
				
				<div class="img"><img src="img/toiminta.jpg" title="&copy; Gestüt Hämelschenburg, thank you!" /></div>
			      <p>
			      Hukkapuron toiminta painottuu pääosin kuolupainoitteisten suomalaisten puoliveristen kasvatukseen. Tavoitteenamme on kasvattaa suorituskykyisiä, kilpakentillä ja laatuarvosteluissa menestyviä ratsuja samalla myös vaalien vanhoja sukulinjoja. Niinpä tallistamme löytyykin monipuolinen valikoima sekä vanhoja että uusia sukua edustavia hevosia. Hevosemme ovat tarjolla jalostukseen myös ulkopuolisille tammoille ja oreille. Kasvatustoiminnan lisäksi Hukkapurossa järjestetään myös jonkin verran kilpailuita ja valmennuksia.</p>


				
			      <h2>Myytävät kasvatit</h2>

			      <p>Vaikka omien hevostemme kohdalla panostammekin kilpailukäyttöön ja laatuarvosteluihin tähtäämiseen, emme vaadi kasvattiemme omistajilta samaa, vaan tärkeintä on asiallinen ja pysyvä koti. Tarjoamme kasvatin omistajan halutessa myös apua kasvatin kilpailukokemuksen kartuttamisessa ja valmentautumisessa.</p>

				  <a href="myytavat.php"><button type="button" class="btn btn-primary">Myytävät kasvatit ja myyntiehdot</button></a>

					

			      <h3>Tilausvarsat ja astutuspyynnöt</h3>

			      <p>Lähes kaikki hevosemme ovat tarjolla jalostukseen myös tallin ulkopuolisille tammoille ja oreille. Tämän lisäksi tarjoamme mahdollisuuden tilausvarsoihin, mikäli myytävistä kasvateista ei löydy juuri sillä hetkellä sopivaa yksilötä. Jokainen astutus- ja tilausvarsapyyntö käsitellään yksilöllisesti, joten otathan yhteyttä sähköpostitse osoitteeseen <b><a href="mailto:virtuaali@POISTAsalaovi.net">virtuaali@salaovi.net</a></b>.</p>

			      <hr />

			      <h2>Syntyneet kasvatit</h2>

			      <?
			      	$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE kasvattaja = "Hukkapuro" ORDER BY syntymaaika DESC');
			      	$stmt->execute();
			      	$hevoset = $stmt->fetchAll();
			      ?>
			      <p>Hukkapurossa on syntynyt tähän mennessä <?=count($hevoset);?> kasvattia, joista suurin osa on suomalaisia puoliverisiä, mutta joukkoon mahtuu myös liuta muiden kantakirjojen edustajia. Kasvattimme tunnista kasvatusliitteistä <b>Wolf's</b>, <b>Wolf</b> ja <b>Hukkapuron</b>. Ilmoitathan sähköpostitse, jos omistat kasvattimme, joka ei löydy listalta.
			      </p>
					
					<button  class="btn btn-primary" data-toggle="collapse" data-target="#kasvatit">Katso lista Hukkapuron kasvateista</button>
						<div id="kasvatit" class="collapse">
			            <ul class="kasvattilista  list-group">
			              <?
			              	foreach ($hevoset as $hevonen) {
			              		$tama_heppa = hae_tiedot($hevonen['id'], $db);

			              		echo '<li class="list-group-item"><div class="row">';
			              		
			              		$skp = $tama_heppa->sukupuoli;
			              		if($skp=='ori'){$skp='o';}
			              		elseif($skp=='tamma'){$skp='t';}

			              		echo '<div class="col-sm-1"><small>'.$tama_heppa->rotu_lyhenne.'-'.$skp.'.</small></div>';
			              		echo '<div class="col-sm-3"><b><a href="'.$tama_heppa->url.'" target="_blank">'.$tama_heppa->nimi.'</a></b></div>';
			              		echo '<div class="col-sm-2"><small>s. '.muotoile_paivamaara($tama_heppa->syntymaaika).'</small></div>';
			              		echo '<div class="col-sm-3"><small>i. <a href="'.$tama_heppa->isa->url.'" target="_blank">'.$tama_heppa->isa->nimi.'</a><br /> e. <a href="'.$tama_heppa->ema->url.'" target="_blank">'.$tama_heppa->ema->nimi.'</a></small></div>';

			              		if($tama_heppa->omistaja=='Otterley Wilson VRL-12757'){
			              			echo '<div class="col-sm-3"><small>om. Hukkapuro</small></div>';
			              		} else{
			              		echo '<div class="col-sm-3"><small>om. <a href="'.$tama_heppa->omistaja_url.'">'.$tama_heppa->omistaja.'</a></small></div>';
			              		}
			           			echo '</div></li>';
			              	}
			              ?>
			       
			            </ul>
			            </div>
			            <hr />
			          </div>
			        </div>
			      </div>

			      

			      </div>
			  </div>
			

			

		    <div class="clearfix visible-lg"></div>
		</div>
	</body>
</html>