<?php
class Dbconf {
	
	protected $dbServer = "localhost";
	protected $dbUser = "hp-wsus";
	protected $dbPass = "p152c21k";
	protected $dbName = "ewidencja_dev";
	
	private $querySort = array(sortColumn =>'', sortDirection =>'');
	private $plik		= 	array(	"Id"			=> array(),
									"Type"			=> array(),
									"Name"			=> array(),
									"Description"	=> array(),
									"Content"		=> array(),
									);
	private $uzytkownik = 	array(	"Id"			=> array(),
									"Nazwa"			=> array(),
									"Imie"			=> array(),
									"Login"			=> array(),
									);
	private $telefon	= 	array(	"NrTel"			=> array()
									);
	private $komputer 	= 	array(	"Id"			=> array(),
									"Nazwa"			=> array(),
									"Typ"			=> array(),
									"Ip"			=> array(),
									"Inwent"		=> array()
									);
	private $model		= 	array(	"Id"			=> array(),
									"Nazwa"			=> array()
									);
	private $dzial 		= 	array(	"Id"			=> array(),
									"Nazwa"			=> array(),
									"Symbol"		=> array(),
									);
	private $monitor 	=	array(	"Id"			=> array(),
									"Inwent"		=> array(),
									"Model"			=> array(),
									"Rozmiar"		=> array(),
									);
	private $podzespol 	=	array(	"Id"			=> array(),
									"Inwent"		=> array(),
									);
	private $drukarka 	= 	array(	"Id"			=> array(),
									"Nazwa"			=> array(),
									"Typ"			=> array(),
									"Ip"			=> array(),
									"Udzial"		=> array(),
									"Inwent"		=> array()
									);
	private $program 	= 	array(	"Id"			=> array(),
									"Nazwa"			=> array(),
									"Data"			=> array(),
									"Typ"			=> array(),
									"Rodzaj"		=> array(),
									"IloscP"		=> array(),
									"IloscI"		=> array(),
									"IloscR"		=> array()
									);
	
	private $rodzajP;
	public $dbResult;
	public $dbH;	

	public function __construct() {
		try {
      		$this->dbH = new PDO('mysql:host='.$this->dbServer.';dbname='.$this->dbName, $this->dbUser, $this->dbPass, 
			array(PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
      		//echo 'Połączenie nawiązane!';
   		}	
   		catch(PDOException $e) {
	    	echo 'Połączenie nie mogło zostać utworzone: ' . $e->getMessage();
   		}

	return $this->dbH;
	}
	public function getQuerySort() {
		return $this->querySort;
	}
	public function getPlik() {
		return $this->plik;
	}
	public function getUzytkownik() {
		return $this->uzytkownik;
	}
	public function getDzial() {
		return $this->dzial;
	}
	public function getKomputer() {
		return $this->komputer;
	}
	public function getModel() {
		return $this->model;
	}
	public function getMonitor() {
		return $this->monitor;
	}
	public function getPodzespol() {
		return $this->podzespol;
	}
	public function getDrukarka() {
		return $this->drukarka;
	}
	public function getProgram() {
		return $this->program;
	}
	public function getTelefon() {
		return $this->telefon;
	}

	public function logIn($user, $password, Session $sesja) {
		
		$query = $this->dbH->query('SELECT * FROM user');
		while ($row = $query->fetch()) {
			if(($user==$row["username"]) && (md5($password)==$row["password"])){
				//return $nazwa=$row["username"];
				$_SESSION[user] = $user;
				//echo $_SESSION[user];
				$_SESSION[czas] = time();
				//echo $_SESSION[czas];
			}
		}
	}
	public function logOut() {
			session_unset();
			session_destroy();
	}
	
	public function queryWnioskiDruk(){
		$query = $this->dbH->query('SELECT nazwa_wnd, opis_wnd, typ_wnd, id_wnd FROM wniosek_druk WHERE aktwn_wnd = 1');
		$i = 0;
		while ($row = $query->fetch()) {
			$this->file['Id'][$i] = $row[id_wnd];
			$this->file['Name'][$i] = $row[nazwa_wnd];
			$this->file['Type'][$i] = $row[typ_wnd];
			$this->file['Description'][$i] = $row[opis_wnd];
			$i++;
		}
		//return $query;
	}
	
	public function queryWniosekDruk($id){
		$query = $this->dbH->query("SELECT typ_wnd, plik_wnd, nazwa_wnd FROM wniosek_druk WHERE id_wnd = $id");
		while ($row = $query->fetch()) {
			$this->file['Name'] = $row[nazwa_wnd];
			$this->file['Type'] = $row[typ_wnd];
			$this->file['Content'] = $row[plik_wnd];
		}
	}
	public function queryUzytkownicy($sortColumn, $sortDirection='a'){
		if ($sortDirection == 'd') $sortDirection =  "DESC";
			else  $sortDirection = "ASC";
		if ($sortColumn == 'nzw') $sortuj = "ORDER BY uzytkownik.nazwa_u $sortDirection";
		if ($sortColumn == 'imi') $sortuj = "ORDER BY uzytkownik.imie_u $sortDirection";
		if ($sortColumn == 'dzl') $sortuj = "ORDER BY dzial.nazwa_d $sortDirection";
		if ($sortColumn == 'tel') $sortuj = "ORDER BY telefon.nr_tel $sortDirection";
		//$this->querySort['sortColumn'] = $sortColumn;
		//$this->querySort['sortDirection'] = $sortDirection;

		$query = $this->dbH->query("SELECT uzytkownik.id_u, nazwa_u, imie_u, dzial.id_dz, nazwa_d, telefon.nr_tel 
									FROM uzytkownik 
									LEFT JOIN dzial
									ON dzial.id_dz = uzytkownik.id_dz
									LEFT JOIN telefon_uzytkownika
									ON telefon_uzytkownika.id_u = uzytkownik.id_u
									LEFT JOIN telefon
									ON telefon.nr_tel = telefon_uzytkownika.nr_tel
									WHERE aktwn_u = 1 $sortuj");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->uzytkownik['Id'][$i] = $row[id_u];
			$this->uzytkownik['Nazwa'][$i] = $row[nazwa_u];
			$this->uzytkownik['Imie'][$i] = $row[imie_u];
			$this->dzial['Id'][$i] = $row[id_dz];
			$this->dzial['Nazwa'][$i] = $row[nazwa_d];
			$this->telefon['NrTel'][$i] = $row[nr_tel];
			$i++;
		}
	}
	public function queryUzytkownik($uzytkownikId) {
		$query = $this->dbH->query("SELECT uzytkownik.id_u, nazwa_u, imie_u, dzial.id_dz, nazwa_d, loginad_u 
									FROM uzytkownik 
									LEFT JOIN dzial
									ON dzial.id_dz = uzytkownik.id_dz
									WHERE uzytkownik.id_u = $uzytkownikId");
		$row = $query->fetch();
		$this->uzytkownik['Id'][0] = $row[id_u];
		$this->uzytkownik['Nazwa'][0] = $row[nazwa_u];
		$this->uzytkownik['Imie'][0] = $row[imie_u];
		$this->uzytkownik['Login'][0] = $row[loginad_u];
		$this->dzial['Id'][0] = $row[id_dz];
		$this->dzial['Nazwa'][0] = $row[nazwa_d];
	}
	public function queryUzytkownikTelefony($uzytkownikId) {
		$query = $this->dbH->query("SELECT uzytkownik.id_u, nazwa_u, telefon.nr_tel 
									FROM telefon_uzytkownika
									LEFT JOIN telefon
									ON telefon_uzytkownika.nr_tel = telefon.nr_tel
									LEFT JOIN uzytkownik
									ON telefon_uzytkownika.id_u = uzytkownik.id_u
									WHERE uzytkownik.id_u = $uzytkownikId");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->telefon['NrTel'][$i] = $row[nr_tel];
			$i++;
		}
	}
	public function queryUzytkownikKomputery($uzytkownikId) {
		$query = $this->dbH->query("SELECT uzytkownik.id_u, nazwa_u, komputer.dns_k, komputer.id_k, inet_ntoa(komputer.ip_k) as ip_k, inwent_k, typ_k 
									FROM komputer_uzytkownika
									LEFT JOIN komputer
									ON komputer_uzytkownika.id_k = komputer.id_k
									LEFT JOIN uzytkownik
									ON komputer_uzytkownika.id_u = uzytkownik.id_u
									WHERE uzytkownik.id_u = $uzytkownikId");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->komputer['Id'][$i] = $row[id_k];
			$this->komputer['Nazwa'][$i] = $row[dns_k];
			$this->komputer['Typ'][$i] = $row[typ_k];
			$this->komputer['Ip'][$i] = $row[ip_k];
			$this->komputer['Inwent'][$i] = $row[inwent_k];
			$i++;
		}
	}
	public function queryDzialy($sortColumn, $sortDirection='a'){
		if ($sortDirection == 'd') $sortDirection = "DESC";
			else $sortDirection = "ASC";
		if ($sortColumn == 'dzl') $sortuj = "ORDER BY dzial.nazwa_d $sortDirection";
		if ($sortColumn == 'sbl') $sortuj = "ORDER BY dzial.symbol_d $sortDirection";
		if ($sortColumn == 'nzw') $sortuj = "ORDER BY uzytkownik.nazwa_u $sortDirection";
		if ($sortColumn == 'imi') $sortuj = "ORDER BY uzytkownik.imie_u $sortDirection";
		//$this->querySort['sortColumn'] = $sortColumn;
		//$this->querySort['sortDirection'] = $sortDirection;

		$query = $this->dbH->query("SELECT dzial.id_dz, dzial.nazwa_d, dzial.symbol_d, uzytkownik.id_u, nazwa_u, imie_u
									FROM dzial 
									LEFT JOIN uzytkownik
									ON dzial.id_u = uzytkownik.id_u
									$sortuj");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->dzial['Id'][$i] = $row[id_dz];
			$this->dzial['Nazwa'][$i] = $row[nazwa_d];
			$this->dzial['Symbol'][$i] = $row[symbol_d];
			$this->uzytkownik['Id'][$i] = $row[id_u];
			$this->uzytkownik['Nazwa'][$i] = $row[nazwa_u];
			$this->uzytkownik['Imie'][$i] = $row[imie_u];
			$i++;
		}
	}
	public function queryKomputery($sortColumn, $sortDirection='a'){
		if ($sortDirection == 'd') $sortDirection =  "DESC";
			else  $sortDirection = "ASC";
		if ($sortColumn == 'dns') $sortuj = "ORDER BY komputer.dns_k $sortDirection";
		if ($sortColumn == 'mdk') $sortuj = "ORDER BY model_komp.nazwa_modkomp $sortDirection";
		if ($sortColumn == 'dzl') $sortuj = "ORDER BY dzial.symbol_d $sortDirection";
		if ($sortColumn == 'ipk') $sortuj = "ORDER BY komputer.ip_k $sortDirection";
		if ($sortColumn == 'typ') $sortuj = "ORDER BY komputer.typ_k $sortDirection";
		if ($sortColumn == 'iwk') $sortuj = "ORDER BY komputer.inwent_k $sortDirection";
		if ($sortColumn == 'iwm') $sortuj = "ORDER BY monitor.inwent_m $sortDirection";
		if ($sortColumn == 'iwp') $sortuj = "ORDER BY podzespol.inwent_po $sortDirection";
		//$this->querySort['sortColumn'] = $sortColumn;
		//$this->querySort['sortDirection'] = $sortDirection;

		$query = $this->dbH->query("SELECT komputer.id_k, komputer.dns_k, INET_NTOA(komputer.ip_k) as ip_k, komputer.typ_k, komputer.inwent_k, 
									dzial.id_dz, dzial.nazwa_d, dzial.symbol_d, monitor.id_m, monitor.inwent_m, podzespol.id_po, podzespol.inwent_po,
									model_komp.id_modkomp, nazwa_modkomp
									FROM komputer 
									LEFT JOIN model_komp
									ON model_komp.id_modkomp = komputer.id_modkomp
									LEFT JOIN dzial
									ON dzial.id_dz = komputer.id_dz
									LEFT JOIN monitor
									ON monitor.id_k = komputer.id_k
									LEFT JOIN podzespol
									ON podzespol.id_k = komputer.id_k
									$sortuj");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->komputer['Id'][$i] = $row[id_k];
			$this->komputer['Nazwa'][$i] = $row[dns_k];
			$this->komputer['Ip'][$i] = $row[ip_k];
			$this->komputer['Typ'][$i] = $row[typ_k];
			$this->komputer['Inwent'][$i] = $row[inwent_k];
			$this->dzial['Id'][$i] = $row[id_dz];
			$this->dzial['Symbol'][$i] = $row[symbol_d];
			$this->monitor['Id'][$i] = $row[id_m];
			$this->monitor['Inwent'][$i] = $row[inwent_m];
			$this->podzespol['Id'][$i] = $row[id_po];
			$this->podzespol['Inwent'][$i] = $row[inwent_po];
			$this->model['Id'][$i] = $row[id_modkomp];
			$this->model['Nazwa'][$i] = $row[nazwa_modkomp];
			$i++;
		}
	}
	public function queryMonitory($sortColumn, $sortDirection='a'){
		if ($sortDirection == 'd') $sortDirection =  "DESC";
			else  $sortDirection = "ASC";
		if ($sortColumn == 'mdm') $sortuj = "ORDER BY monitor.model_m $sortDirection";
		if ($sortColumn == 'iwm') $sortuj = "ORDER BY monitor.inwent_m $sortDirection";
		if ($sortColumn == 'rzm') $sortuj = "ORDER BY monitor.rozmiar_m $sortDirection";
		if ($sortColumn == 'iwk') $sortuj = "ORDER BY komputer.inwent_k $sortDirection";
		if ($sortColumn == 'dns') $sortuj = "ORDER BY komputer.dns_k $sortDirection";
		
		$query = $this->dbH->query("SELECT monitor.id_m, monitor.model_m, monitor.rozmiar_m, monitor.inwent_m, 
									komputer.id_k, komputer.inwent_k, komputer.dns_k
									FROM monitor 
									LEFT JOIN komputer
									ON monitor.id_k = komputer.id_k
									$sortuj");
									
		$i = 0;
		while ($row = $query->fetch()) {
			$this->komputer['Id'][$i] = $row[id_k];
			$this->komputer['Nazwa'][$i] = $row[dns_k];
			$this->komputer['Inwent'][$i] = $row[inwent_k];
			$this->monitor['Id'][$i] = $row[id_m];
			$this->monitor['Inwent'][$i] = $row[inwent_m];
			$this->monitor['Model'][$i] = $row[model_m];
			$this->monitor['Rozmiar'][$i] = $row[rozmiar_m];
			$i++;
		}
	}
	public function queryDrukarki($sortColumn, $sortDirection='a'){
		if ($sortDirection == 'd') $sortDirection =  "DESC";
			else  $sortDirection = "ASC";
		if ($sortColumn == 'nzw') $sortuj = "ORDER BY drukarka.nazwa_dr $sortDirection";
		if ($sortColumn == 'typ') $sortuj = "ORDER BY drukarka.typ_dr $sortDirection";
		if ($sortColumn == 'ipd') $sortuj = "ORDER BY drukarka.ip_dr $sortDirection";
		if ($sortColumn == 'udl') $sortuj = "ORDER BY drukarka.udzial_dr $sortDirection";
		if ($sortColumn == 'iwd') $sortuj = "ORDER BY drukarka.inwent_dr $sortDirection";
		if ($sortColumn == 'sbl') $sortuj = "ORDER BY dzial.symbol_d $sortDirection";
		$query = $this->dbH->query("SELECT drukarka.id_dr, drukarka.nazwa_dr, drukarka.typ_dr, INET_NTOA(drukarka.ip_dr) as ip_dr, 
									drukarka.udzial_dr, drukarka.inwent_dr,	dzial.id_dz, dzial.symbol_d
									FROM drukarka 
									LEFT JOIN dzial
									ON dzial.id_dz = drukarka.id_dz
									$sortuj");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->drukarka['Id'][$i] = $row[id_dr];
			$this->drukarka['Nazwa'][$i] = $row[nazwa_dr];
			$this->drukarka['Typ'][$i] = $row[typ_dr];
			$this->drukarka['Ip'][$i] = $row[ip_dr];
			$this->drukarka['Udzial'][$i] = $row[udzial_dr];
			$this->drukarka['Inwent'][$i] = $row[inwent_dr];
			$this->dzial['Id'][$i] = $row[id_dz];
			$this->dzial['Symbol'][$i] = $row[symbol_d];
			$i++;
		}
	}
	public function queryProgramy($sortColumn, $sortDirection='a'){
		$this->rodzajP = $rodzajP;
		if ($sortDirection == 'd') $sortDirection =  "DESC";
			else  $sortDirection = "ASC";
		if ($sortColumn == 'nzw') $sortuj = "ORDER BY tmp.nazwa_p $sortDirection";
		if ($sortColumn == 'dat') $sortuj = "ORDER BY tmp.data_p $sortDirection";
		if ($sortColumn == 'rdz') $sortuj = "ORDER BY tmp.rodzaj_p $sortDirection";
		if ($sortColumn == 'ilc') $sortuj = "ORDER BY tmp.ilosc_p $sortDirection";
		if ($sortColumn == 'ius') $sortuj = "ORDER BY tmp.install $sortDirection";
		if ($sortColumn == 'izt') $sortuj = "ORDER BY sub $sortDirection";
		$prquery = $this->dbH->query("SET sql_mode = 'NO_UNSIGNED_SUBTRACTION';");
		$query = $this->dbH->query("SELECT tmp.id_p, tmp.nazwa_p, tmp.data_p, tmp.rodzaj_p, tmp.typ_p, tmp.ilosc_p, tmp.install, (tmp.ilosc_p - tmp.install) as sub
									FROM 
									(SELECT program.id_p, program.nazwa_p, program.data_p, program.rodzaj_p, program.ilosc_p, program.typ_p,
									COUNT(program_instalacja.id_p) AS install
									FROM program 
									LEFT JOIN program_instalacja 
									ON program.id_p = program_instalacja.id_p
									GROUP BY program.id_p) 
									AS tmp
									$sortuj");
		$i = 0;
		while ($row = $query->fetch()) {
			$this->program['Id'][$i] = $row[id_p];
			$this->program['Nazwa'][$i] = $row[nazwa_p];
			$this->program['Data'][$i] = $row[data_p];
			$this->program['Typ'][$i] = $row[typ_p];
			$this->program['Rodzaj'][$i] = $row[rodzaj_p];
			$this->program['IloscP'][$i] = $row[ilosc_p];
			$this->program['IloscI'][$i] = $row[install];
			$this->program['IloscR'][$i] = $row[sub];
			$i++;
		}
	}
}

?>