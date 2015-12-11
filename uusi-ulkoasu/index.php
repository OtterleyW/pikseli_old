<? 
	require('.yhdista.php');
	require('luokat/Heppa.php');
	require('yla.php');

		$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE omistaja = "Otterley Wilson VRL-12757" AND status <> "poistettu" AND status <> "kuollut" AND kaytto <>"pihatto" AND rotu_lyhenne<>"pre" ORDER BY id DESC');
		$stmt->execute();
		$uusinheppa = $stmt->fetch(PDO::FETCH_ASSOC);
	?>

			<h1 class="etusivun-otsikko">Virtuaalitalli Hukkapuro</h1>



			  <div class="etusivu">
			      <div class="col-sm-4">
			      	<a href="hevoset.php">
			  		<div class="panel panel-default">
			  		  <div class="hevosetpanel panel-body"></div>
			  		  <div class="panel-footer"><h4>Hevoset</h4></div>
			  		</div>
			  		</a>
			      </div>
			    <div class="col-sm-4">
			    	<a href="toiminta.php">
					<div class="panel panel-default">
					  <div class="toimintapanel panel-body"></div>
					  <div class="panel-footer"><h4>Toiminta</h4></div>
					</div>
					</a>
			    </div>
		        <div class="col-sm-4">
		        	<a href="esittely.php">
		    		<div class="panel panel-default">
		    		  <div class="esittelypanel panel-body"></div>
		    		  <div class="panel-footer"><h4>Tallin esittely</h4></div>
		    		</div>
		    		</a>
		        </div>
			  </div>
			
			<div class="row">


				<h3>Tervetuloa Hukkapuroon</h3>

				<div class="etusivun-teksti col-md-8">

					<p>
						Kilometritolkulla kuoppaista hiekkatietä, eikä kyltin kylttiä missään, navigaattori näyttää kuitenkin suoraan eteenpäin ja ruudussa lukee tasan varmasti se osoite, joka oli ilmoitettu kilpailukutsussa tai hevosen myynti-ilmoituksessa. Kun usko perille pääsemiseen alkaa täysin loppua, tekee tie vihdoin tiukan mutkan, jonka jälkeen edessä siintää suuri tallikompleksi. Tallialue saattaa muistuttaa ensisilmäykseltä varsinaista sekamelskaa eri aikaan rakennettuine tallirakennuksineen ja sinne tänne viriteltyine tarhoineen. Älä kuitenkaan anna sen hämätä, sillä olet saapunut Hukkapuroon, missä kasvatetaan suomalaisia puoliverisiä kouluratojen kunikaiksi ja kunigattariksi.
					</p>
					<p>
						Hukkapuro on vuoden 2014 syyskuussa perustettu virtuaalitalli, joka ei ympäristöltään vastaa aivan tyypillistä virtuaalista puoliverisiittolaa. Meillä tilat eivät ole aivan viimeisen päälle tai uusinta uutta ja treenaaminenkin tapahtuu melko vaatimattomissa olosuhteissa. Siitä huolimatta jokaiseen hevoseemme panostetaan vähintään yhtä paljon ja yhtä suurella rakkaudella kuin moderneimmillakin luksustalleilla. Voipa sen välillä laskea jopa kotikenttäeduksi, että hevoseme ovat tottuneet rämisevään maneesiin, Suomen sääoloihin ja melko huolettomaan arkeen.
					</p>
					<p>
						Vaikka tavoitteet jokaisen hevosemme kohdalla ovat korkealla, perustuu tallin toiminta rentoon meininkiin, eikä verenmaku suussa suorittamiseen. Meillä toimintaa on silloin kun huvittaa, varsoja syntyy silloin kun tuntuu sopivalta ja aikakin kuluu hyvin vaihtelevalla nopeudella.Näillä saatesanoilla olet erittäin tervetullut tutustumaan Hukkapuroon ja sen porukkaan!
					</p>
					<p>
						<span class="allekirjoitus">- <a href="mailto:virtuaali@POISTAsalaovi.net">Otterley Wilson</a></span><br />
						<small>tallin omistaja, VRL-12757</small>
					</p>
				</div>
				<div class="sivupalkki col-md-4">
					<div class="ajankohtaista well">
						<h4>Ajankohtaista</h4>
						<small><span class="glyphicon glyphicon-pushpin"></span></small>&nbsp; Tallia päivitetty viimeksi 22.10.2015<br />
						<small><span class="glyphicon glyphicon-pushpin"></span></small>&nbsp; Katso myytävät hevoset <a href="myytavat.php">täältä</a>!<br />
						<small><span class="glyphicon glyphicon-pushpin"></span></small>&nbsp; Uusin tulokas <?=$uusinheppa['rotu_lyhenne']?>-<?=$uusinheppa['sukupuoli']?> <a href="<?=$uusinheppa['url']?>"><?=$uusinheppa['nimi']?></a><br />
					</div>
						<a href="http://www.virtuaalihevoset.net/?tallit/tallirekisteri/talli.html?talli=HUKK9931&like=2" target="_blank" class="aanesta btn btn-primary btn-lg">
							Äänestä VRL:n tallilistalla<br />
							<span class="glyphicon glyphicon-thumbs-up"></span> 
							<span class="glyphicon glyphicon-heart-empty"></span> 
						</a>
				</div>
			</div>

<?
	require('ala.php');
?>