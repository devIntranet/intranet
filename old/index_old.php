<?
require_once('class.session.php');
require_once('class.dbconf.php');
require_once('class.html.php');

$sesja = new Session;
$dbConnect = new Dbconf;
//echo $dbConnect->dbH;

if(isset($_POST['intralog'])) {
	$dbConnect->logIn($_POST['nazwa'], $_POST['haslo'], $sesja);
}
	
if ($_GET['m'] == 'lo') {
	$dbConnect->logOut();
}

$strona = new Html;
if ($_GET['m'] == 'wn') {
	$dbConnect->queryWnioskiDruk();
	$strona->showWnioskiDruk($dbConnect->getPlik());
}
if ($_GET['wn'] >0) {
	$dbConnect->queryWniosekDruk($_GET['wn']);
	$strona->showWniosekDruk($dbConnect->getPlik());
}
if ($_GET['m'] == 'bz' && $sesja->getLogin()) {
	$strona->showBazaMenu();
	if ($_GET['mt'] == 'usr') {
		$dbConnect->queryUzytkownicy($_GET['srtcol'], $_GET['srtdir']);
		$strona->showUzytkownicy($dbConnect->getUzytkownik(), $dbConnect->getDzial(), $dbConnect->getTelefon(), $_GET["srtcol"], $_GET["srtdir"]);
	}
	if ($_GET['mt'] == 'dzl') {
		$dbConnect->queryDzialy($_GET['srtcol'], $_GET['srtdir']);
		$strona->showDzialy($dbConnect->getDzial(), $dbConnect->getUzytkownik(), $_GET["srtcol"], $_GET["srtdir"]);
	}
	if ($_GET['mt'] == 'kmp') {
		$dbConnect->queryKomputery($_GET['srtcol'], $_GET['srtdir']);
		$strona->showKomputery($dbConnect->getKomputer(), $dbConnect->getModel(), $dbConnect->getDzial(), $dbConnect->getMonitor(), $dbConnect->getPodzespol(), 
								$_GET["srtcol"], $_GET["srtdir"]);
	}
	if ($_GET['mt'] == 'mon') {
		$dbConnect->queryMonitory($_GET['srtcol'], $_GET['srtdir']);
		$strona->showMonitory($dbConnect->getKomputer(), $dbConnect->getMonitor(), 
								$_GET["srtcol"], $_GET["srtdir"]);
	}
	if ($_GET['mt'] == 'drk') {
		$dbConnect->queryDrukarki($_GET['srtcol'], $_GET['srtdir']);
		$strona->showDrukarki($dbConnect->getDrukarka(), $dbConnect->getDzial(), $_GET["srtcol"], $_GET["srtdir"]);
	}
	if ($_GET['mt'] == 'prg') {
		$dbConnect->queryProgramy($_GET['srtcol'], $_GET['srtdir']);
		$strona->showProgramy($dbConnect->getProgram(), $_GET["srtcol"], $_GET["srtdir"]);
	}
	if ($_GET['usr'] > 0) {
		$dbConnect->queryUzytkownik($_GET['usr']);
		$strona->showUzytkownik($dbConnect->getUzytkownik(), $dbConnect->getDzial());
		$dbConnect->queryUzytkownikTelefony($_GET['usr']);
		$strona->showUzytkownikTelefony($dbConnect->getTelefon());
		$dbConnect->queryUzytkownikKomputery($_GET['usr']);
		$strona->showUzytkownikKomputery($dbConnect->getKomputer());
	}
}
$strona->echoStrona();

?>
