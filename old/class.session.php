<?php
session_start();
class Session {
	
	public $id;
	private $czas;
	private $login;
	private $loginIE;
	private $loginMailIE;
	private $dzialIE;
	private $czasSesji = 6000;
	private $sortOrder = array();
	
	public function __construct() {
		$this->id=session_id();
		$this->loginIE = $_SESSION['loginIE'];
		$this->loginMailIE = $_SESSION['loginMailIE'];
		$this->dzialIE = $_SESSION['dzialIE'];
		$this->sortOrder = $_SESSION['sortOrder'];

		if (isset($_SESSION['user'])) {
			$this->login=$_SESSION['user'];
			$this->czas=$_SESSION['czas'];
			if ((time() - $this->czas) > $this->czasSesji) {
				session_unset();
				session_destroy();
			}
		}
		if (!isset($_SESSION['loginIE'])) {
			list($tmp, $this->loginIE) = explode("\\",$_SERVER['REMOTE_USER']);
			$_SESSION['loginIE'] = $this->loginIE;
			$ldapServer = "192.168.1.39";
			$ldapUser = "rpwik\Seba";
			$ldapPass = "C0k0lwiek";
			$ldapconn = ldap_connect($ldapServer)
    		or die("Could not connect to LDAP server.");
			ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
			ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);
			if ($ldapconn) {
				$ldapbind = ldap_bind($ldapconn, $ldapUser, $ldapPass)
				or die("Bidnowanie z serwerem zakończone błędem.");
				if ($ldapbind) {
					$base_dn = "dc=rpwik, dc=tychy, dc=pl";
					$filtr = "(sAMAccountName=".$this->loginIE.")";
					$wyjatki = array("department", "title", "sAMAccountName", "displayname", "mail");
					$czytaj = ldap_search($ldapconn, $base_dn, $filtr, $wyjatki);
					$wpis = ldap_get_entries($ldapconn, $czytaj);
					$_SESSION['loginMailIE'] = $wpis[0]['mail'][0];
					$_SESSION['dzialIE'] = $wpis[0]['department'][0];
				}
				//$aduzytkownik = $wpis[0]['displayname'][0];
				//$aduzytkownik = iconv('UTF-8', 'ISO-8859-2', $isologin);
				//echo "Login: $this->loginIE<BR>";
			}
		}
	}//KONSTRUKTOR
	
	public function getLoginIE() {
		if (isset($this->loginIE))
			return $this->loginIE;
		else return false;
	}
	public function getDzialIE() {
		if (isset($this->dzialIE))
			return $this->dzialIE;
		else return false;
	}
	public function getLogin() {
		if (isset($this->login))
			return $this->login;
		else return false;
	}
	public function getSortOrder() {
		if (isset($this->sortOrder))
			return $this->sortOrder;
		else return false;
	}
	public function getCzasSesji() {
		if (isset($this->czasSesji))
			return $this->czasSesji;
		else return false;
	}
}

?>