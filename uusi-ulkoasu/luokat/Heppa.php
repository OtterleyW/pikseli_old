<?php
class Heppa {
	public $id;
	public $url;
	public $nimi = 'tuntematon';
	public $lempinimi;
	public $vhtunnus;
	public $rotu;
	public $rotu_lyhenne;
	public $sukupuoli;
	public $syntymaaika;
	public $ika;
	public $saka;
	public $painotus;
	public $koulutustaso;
	public $kasvattaja;
	public $kasvattaja_url;
	public $omistaja;
	public $omistaja_url;
	public $meriitit;
	public $luonne;
	public $kaytto;
	public $kilpailu_tyyppi;
	public $vari;
	public $sukuselvitys;
	public $suvun_pituus;
	public $status;
	public $saavutukset;

	public $isa_id;
	public $ema_id;

	//isä Heppa(luokka)
	public $isa;
	//emä Heppa(luokka)
	public $ema;

	function __construct($tiedot = null, $suku = null) {
		if (is_null($tiedot)) {
			// Luodaan olematon heppa null-syötteellä
			return;
		}

		$this->id = $tiedot['id'];
		$this->url = $tiedot['url'];
		$this->nimi = $tiedot['nimi'];
		$this->lempinimi = $tiedot['lempinimi'];
		$this->vhtunnus = $tiedot['vhtunnus'];
		$this->rotu = $tiedot['rotu'];
		$this->rotu_lyhenne = $tiedot['rotu_lyhenne'];
		$this->sukupuoli = $tiedot['sukupuoli'];
		$this->syntymaaika = $tiedot['syntymaaika'];
		$this->ika = $tiedot['ika'];
		$this->saka = $tiedot['saka'];
		$this->painotus = $tiedot['painotus'];
		$this->koulutustaso = $tiedot['koulutustaso'];
		$this->kasvattaja = $tiedot['kasvattaja'];
		$this->kasvattaja_url = $tiedot['kasvattaja_url'];
		$this->omistaja = $tiedot['omistaja'];
		$this->omistaja_url = $tiedot['omistaja_url'];
		$this->meriitit = $tiedot['meriitit'];
		$this->luonne = $tiedot['luonne'];
		$this->kaytto = $tiedot['kaytto'];
		$this->kilpailu_tyyppi = $tiedot['kilpailu_tyyppi'];
		$this->vari = $tiedot['vari'];
		$this->sukuselvitys = $tiedot['sukuselvitys'];
		$this->suvun_pituus = $tiedot['suvun_pituus'];
		$this->status = $tiedot['status'];
		$this->saavutukset = $tiedot['saavutukset'];

		$this->isa_id = $suku['isa_id'];
		$this->ema_id = $suku['ema_id'];


	}

	function hae_sukupolvet($db, $suvun_pituus, $nykyinen_polvi = 1) {
		if($suvun_pituus < 3){
			$suvun_pituus = 3;
		}
		elseif($suvun_pituus > 4){
			$suvun_pituus = 4;
		}

		if ($nykyinen_polvi <= $suvun_pituus) {
			$this->hae_vanhemmat($db);
			$this->isa->hae_sukupolvet($db, $suvun_pituus, $nykyinen_polvi + 1);
			$this->ema->hae_sukupolvet($db, $suvun_pituus, $nykyinen_polvi + 1);
		}
	}

	private function hae_vanhemmat($db) {
		$this->hae_ema($db);
		$this->hae_isa($db);
	}

	private function hae_ema($db){
		if(isset($this->ema_id)){
			//Perustietojen hakeminen
			$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE id = :id');
			$stmt->bindParam(':id', $this->ema_id);
			$hevonen_id = 1;
			$stmt->execute();
			$haettu_tiedot = $stmt->fetch(PDO::FETCH_ASSOC);
			
			//Sukutietojen
			$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE id = :id');
			$stmt->bindParam(':id', $this->ema_id);
			$stmt->execute();
			$haettu_suku = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->ema = new Heppa($haettu_tiedot, $haettu_suku);
			return $this->ema;
		}
		else {
			$this->ema = new Heppa();
		}
	}

	private function hae_isa($db) {
		if(isset($this->isa_id)){
			//Perustietojen hakeminen
			$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE id = :id');
			$stmt->bindParam(':id', $this->isa_id);
			$hevonen_id = 1;
			$stmt->execute();
			$haettu_tiedot = $stmt->fetch(PDO::FETCH_ASSOC);
			
			//Sukutietojen
			$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE id = :id');
			$stmt->bindParam(':id', $this->isa_id);
			$stmt->execute();
			$haettu_suku = $stmt->fetch(PDO::FETCH_ASSOC);

			$this->isa = new Heppa($haettu_tiedot, $haettu_suku);
			return $this->isa;
		}
		else {
			$this->isa = new Heppa();
		}
	}

	public function hae_jalkelaiset($db, $sukupuoli){
		if($sukupuoli == 'tamma'){
		$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE ema_id = :id');
		}
		else {
			$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE isa_id = :id');
		}

		$stmt->bindParam(':id', $this->id);
		$stmt->execute();
		$haettu_varsat = $stmt->fetchAll();

		if($haettu_varsat){
			$varsa_lista = array();

			foreach ($haettu_varsat as $varsa){
				//Perustietojen hakeminen
				$stmt = $db->prepare('SELECT * FROM hevonen_tiedot WHERE id = :id');
				$stmt->bindParam(':id', $id);
				$id = $varsa['id'];
				$stmt->execute();
				$haettu_tiedot = $stmt->fetch(PDO::FETCH_ASSOC);
				
				//Sukutietojen
				$stmt = $db->prepare('SELECT * FROM hevonen_suku WHERE id = :id');
				$stmt->bindParam(':id', $id);
				$stmt->execute();
				$haettu_suku = $stmt->fetch(PDO::FETCH_ASSOC);

				$varsa = new Heppa($haettu_tiedot, $haettu_suku);
				$varsa->hae_vanhemmat($db);

				$varsa_lista[] = $varsa;
			}


			return $varsa_lista;
		}
		return null;
		}
}
	
#EOF