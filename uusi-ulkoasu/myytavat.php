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

	?>
			<h1>Myytävät kasvatit</h1>
					<p>Täältä löydät kaikki Hukkapuron myynnissä olevat kasvatit. Jos olet kiinnostunut ostamaan kasvatin, ota yhteyttä tallin vieraskirjaan tai sähköpostitse (<a href="mailto:virtuaali@salaovi.net">virtuaali@salaovi.net</a>). Jos tarjolla ei juuri tällä hetkellä ole sopivaa kasvattia, on tallimme hevosista mahdollista saada myös tilausvarsoja.</p>

					<h2>Myyntiehdot</h2>
					<p>
					- Kasvatin sivut ilmoitetaan 14vrk sisällä ostosta (lisäaikaa on mahdollista saada kysymällä) <br />
					- Kasvatin perustietoja (nimi, sukupuoli, rotu, syntymäaika, suku) ei saa muuttaa, kun ne on kerran päätetty<br />
					- Kasvatti rekisteröidään VRL:ään, kasvattajaksi merkitään HUKK9931 ja kasvatusliitteeksi Wolf's, Wolf tai Hukkapuron<br />
					- Kasvatin vaihtaessa osoitetta on siitä ilmoitettava kasvattajalle (lupaa kasvatin myyntiin ei tarvitse erikseen kysyä, kunhan uudet sivut ilmoitetaan tietooni)<br />
					- Kasvattajaksi sivuille on merkittävä Hukkapuro linkitettynä tallin etusivulle (<a href="http://www.salaovi.net/hukkapuro">http://www.salaovi.net/hukkapuro</a>)<br />
					</p>

					<p>Vaikka tähtäämme omien hevostemme kanssa laatuarvosteluihin, emme vaadi kasvattiemme tulevalta kodilta samaa. Voit siis rohkeasti tarjota kasvatistamme, vaikka sinulla olisikin koti tarjolla tarinapainotteisella puskatallillta tai suursiittolassa, jossa hevonen tuskin tulisi kilpailemaan sijan sijaa. Tärkeintä on, että kasvatin sivut säilyvät netissä ja että se on ostajalle mieluinen. Rekisteröimättömien varsojen nimiin ja syntymäaikoihin ostajan on mahdollista vielä vaikuttaa!</p>

					<p>Huom! Jos vanhempien sivuilta löytyy sukuselvitys, saa sitä käyttää myös jälkeläisten sivuilla.</p>


					
					<hr />
					
					<h2>Myytävät varsat</h2>
					

				
					<div class="row">
						<h4>fwb-o/t. Chocolatte Wolf / Choclatino Wolf </h4>
					
					<div class="col-md-6">
						s. 07/2015<br />
						koulupainoitteinen<br />
						n. 4-polvinen suku<br /><br />


						<small>
						Isälinja: Chocolate Chip - Amarn Joey - Joe Talent G - Mafia GER<br />
						Emälinja: Sokerikuun Cha-Cha - Meriana CTB xx - Medinilla CTB xx - Happy BiIrthday xx<br /><br />
						</small>
						
						</div>
						<div class="col-md-6">
						<table class="table table-bordered myyntisuku">
							<tr>
								<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/chocolate-chip">Chocolate Chip</a> KRJ-I, KTK-II</td>
								<td rowspan="1">ii. <a href="http://airlea.altervista.org/joe/">Amarn Joey</a></td>
								<tr>
									<td rowspan="1">ie. <a href="http://www.lasileija.net/pikkulintu/hevoset/kit-kat/">Kit Kat</a> KRJ-I, KTK-II</td>
								</tr>
							</tr>
							<tr>
								<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/sokerikuun-cha-cha">Sokerikuun Cha-Cha</a></td>
								<td rowspan="1">ei. <a href="http://ruiskukka.org/yksityiset/h/KWBSalsa.php">KWB Salsa</a></td>
								<tr>
									<td rowspan="1">ee. <a href="http://lumipantteri.net/moonsugar/meppi.php">Meriana CTB xx</a></td>
								</tr>
							</tr>
						</table>
						</div>

						
					</div>

					<hr />
					<div class="row">
						<h4>fwb-o/t. Rockstar Wolf / Space Shot Wolf </h4>
					<div class="col-md-6">

						s. 07/2015<br />
						koulupainoitteinen<br />
						3-polvinen suku<br /><br />


						<small>
						Isälinja: Rockabee Wolf - Rogue Wolf - Rontigo<br />
						Emälinja: Stellar Wind Wolf - Solar Storm LM - Quick Sun Star<br /><br />
						</small>
						
						</div>
						<div class="col-md-6">
						<table class="table table-bordered myyntisuku">
							<tr>
								<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/rockabee-wolf">Rockabee Wolf</a></td>
								<td rowspan="1">ii. <a href="http://www.salaovi.net/hukkapuro/rogue-wolf">Rogue Wolf</a></td>
								<tr>
									<td rowspan="1">ie. <a href="http://vahtipossu.org/eucarya/bumblebee.html">Bumblebee Solo</a></td>
								</tr>
							</tr>
							<tr>
								<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/stellar-wind-wolf">Stellar Wind Wolf</a> KRJ-I</td>
								<td rowspan="1">ei. <a href="http://www.salaovi.net/hukkapuro/nameas-obsidian-dc">Nameas Obsidian DC</a></td>
								<tr>
									<td rowspan="1">ee. <a href="http://www.salaovi.net/hukkapuro/solar-storm-lm">Solar Storm LM</a> KRJ-I</td>
								</tr>
							</tr>
						</table>
						</div>


					</div>



				
					<hr />
					<div class="row">
						<h4>fwb-o/t. Supersonic Wolf / Wolf's Dainty </h4>
					<div class="col-md-6">
						s. 07/2015<br />
						koulupainoitteinen<br />
						pitkä suku<br /><br />


						<small>
						Isälinja: Sonique Wolf - Opaque F - Opalescent Cersei - Walking Skeleton F - Nicotinecall PB - Craven GER<br />
						Emälinja: Shadow's Dauntless - Shadow's Linia Falista - KWB Rubinelle - Geneva F - Gemini F - Gaudiana<br /><br />
						</small>
						
						</div>
						<div class="col-md-6">
						<table class="table table-bordered myyntisuku">
							<tr>
								<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/sonique-wolf">Sonique Wolf</a></td>
								<td rowspan="1">ii. <a href="http://www.salaovi.net/hukkapuro/opaque-f">Opaque F</a> KRJ-I</td>
								<tr>
									<td rowspan="1">ie. <a href="http://www.salaovi.net/hukkapuro/hukkapuron-evangeline">Hukkapuron Evangeline</a> KRJ-I</td>
								</tr>
							</tr>
							<tr>
								<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/shadows-dauntless">Shadow's Dauntless</a></td>
								<td rowspan="1">ei. <a href="http://zorniger-engel.net/seppo/h/jaylove.html">Adoro's Jaylove</a> YLA2</td>
								<tr>
									<td rowspan="1">ee. <a href="http://web.archive.org/web/20091027155738/http://www.geocities.com/greathorse04/fanni.html">Shadow's Linia Falista</a> KRJ-II, YLA3</td>
								</tr>
							</tr>
						</table>
						</div>


					</div>
					<hr />
					<div class="row">
						<h4>fwb-o/t. Black Cat Wolf / Wolf's Blackness </h4>
					<div class="col-md-6">
						s. 07/2015<br />
						koulupainoitteinen<br />
						pitkä suku<br /><br />


						<small>
						Isälinja: Black Jaguar HRW - Black Panther W - Indigo Blue V - Livingstone - May 14th H'Dark Zel xx - Greymask's Móricz xx  - Summer Electro Fire xx<br />
						Emälinja: Blackette DON - Sweet Leaf DON - Crimson Leaves PB - Crimson Tear PB - Wayfaerer<br /><br />
						</small>
						
						</div>
						<div class="col-md-6">
						<table class="table table-bordered myyntisuku">
							<tr>
								<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/black-jaguar-hrw">Black Jaguar HRW</a></td>
								<td rowspan="1">ii. <a href="http://www.anfarwol.net/windsor/p/blackpantherw">Black Panther W</a> YLA3</td>
								<tr>
									<td rowspan="1">ie. <a href="http://web.archive.org/web/20150526135136/http://hrws.webs.com/tammat/xsiara.html">Xsiara VR</a></td>
								</tr>
							</tr>
							<tr>
								<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/blackette-don">Blackette DON</a> KRJ-I</td>
								<td rowspan="1">ei. <a href="http://eripura.net/bairdon/h/blackwoodamor.php">Blackwood Amor</a></td>
								<tr>
									<td rowspan="1">ee. <a href="http://eripura.net/bairdon/h/sweetleafdon.php">Sweet LEaf DON</a> KRJ-I</td>
								</tr>
							</tr>
						</table>
						</div>


					</div>


						


					<hr />

			<h2>Varatut</h2>

			

				<div class="row">
					<h4>hann-o/t. Wolf's Mistico / Wolf's Mystic </h4>
				
				<div class="col-md-6">
					s. 07/2015<br />
					koulupainoitteinen<br />
					1-polvinen suku<br /><br />


					<small>
					Isälinja: Daskang Michell<br />
					Emälinja: Dorett<br /><br />
					</small>

					<span style="color:red;"><i>Varattu Scilla</i></span>	
				</div>
				<div class="col-md-6">
					<table class="table table-bordered myyntisuku">
						<tr>
							<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/daskang-michell">Daskang Michell</a></td>
							<td rowspan="1">ii. Cambelon</td>
							<tr>
								<td rowspan="1">ie. Empossible</td>
							</tr>
						</tr>
						<tr>
							<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/dorett">Dorett</a></td>
							<td rowspan="1">ei. Donatle Grün</td>
							<tr>
								<td rowspan="1">ee. Retescha</td>
							</tr>
						</tr>
					</table>
				</div>

				</div>

									<hr />
				<div class="row">
					<h4>fwb-o/t. Royale Wolf / Nocturne Wolf</h4>
					
						<div class="col-md-6">
					
					s. 06/2015<br />
					koulupainoitteinen<br />
					2-polvinen suku<br /><br />


					<small>
					Isälinja: Rogue Wolf - Rontigo<br />
					Emälinja: Norica Prime - Epanterias<br /><br />
					</small>

					<span style="color:red;"><i>Varattu Riella</i></span>
					</div>

						<div class="col-md-6">
					<table class="table table-bordered myyntisuku">
						<tr>
							<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/rogue-wolf">Rogue Wolf</a></td>
							<td rowspan="1">ii. <a href="hhttp://www.salaovi.net/hukkapuro/rontigo">Rontigo</a> KRJ-I</td>
							<tr>
								<td rowspan="1">ie. <a href="http://www.salaovi.net/hukkapuro/schmidt-joyanna">Schmidt Joyanna</a></td>
							</tr>
						</tr>
						<tr>
							<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/norica-prime">Norica Prime</a></td>
							<td rowspan="1">ei. <a href="http://suomenpolle.webs.com/prime/Brighgaze.htm">Brighgaze</a> KRJ-I, KTK-II</td>
							<tr>
								<td rowspan="1">ee. <a href="http://suomenpolle.webs.com/prime/Epanterias.htm">Epanterias</a></td>
							</tr>
						</tr>
					</table>
					</div>


				</div>
					<hr />
				<div class="row">
					<h4>fwb-o/t. Wolf's Shadow Jewel / Wolf's Neon Tiger </h4>

					<div class="col-md-6">

					s. 07/2015<br />
					koulupainoitteinen<br />
					pitkä suku<br /><br />


					<small>
					Isälinja: Jungle Jewel Wolf - Jon-Jewel HRW - Jeweled HRW - JK's Jewel of Cee - Des Lumen' Descoro - le Noir-Masque<br />
					Emälinja: Wolf's Brightside - Blackette DON - Sweet Leaf DON - Crimson Leaves PB - Crimson Tear PB - Wayfaerer<br /><br />
					</small>

					<span style="color:red;"><i>Varattu Miltsu</i></span>	
					</div>

					<div class="col-md-6">
					<table class="table table-bordered myyntisuku">
						<tr>
							<td rowspan="2">i. <a href="http://www.salaovi.net/hukkapuro/jungle-jewel-wolf">Jungle Jewel Wolf</a></td>
							<td rowspan="1">ii. <a href="http://uinuva.net/h/jon-jewel.html">Jon-Jewel HRW</a></td>
							<tr>
								<td rowspan="1">ie. <a href="http://www.salaovi.net/hukkapuro/wolfs-tigerclaw">Wolf's Tigerclaw</a></td>
							</tr>
						</tr>
						<tr>
							<td rowspan="2">e. <a href="http://www.salaovi.net/hukkapuro/wolfs-shadowplay">Wolf's Shadowplay</a></td>
							<td rowspan="1">ei. <a href="http://www.salaovi.net/hukkapuro/wolfs-londonology">Wolf's Londonology</a> KRJ-I</td>
							<tr>
								<td rowspan="1">ee. <a href="http://www.salaovi.net/hukkapuro/wolfs-brightside">Wolf's Brightside</a> KRJ-I</td>
							</tr>
						</tr>
					</table>
					</div>
				<hr />
				</div>
			
		    <div class="clearfix visible-lg"></div>
		</div>
	</body>
</html>