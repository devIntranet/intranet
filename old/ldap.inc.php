<?
### LDAP ###
$ldapsrv="192.168.1.39";
$remote_user = $_SERVER['REMOTE_USER'];
list($domena, $user) = explode("\\", $remote_user);

$ldaprdn  = 'admin';     // ldap rdn or dn
$ldappass = 'c0k0lwiek';  // associated password
// connect to ldap server
$ldapconn = ldap_connect($ldapsrv)
    or die("Could not connect to LDAP server.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);
if ($ldapconn) 
	{
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
	$base_dn = "dc=rpwik, dc=tychy, dc=pl";
	$filter = "(sAMAccountName=$user)";
	$justthese = array("department", "directreports", "title", "displayname", "mail");
	$read = ldap_search($ldapconn, $base_dn, $filter, $justthese);
	$entry = ldap_get_entries($ldapconn, $read);
	#echo var_dump($entry);
	$loginad=$row["loginad_u"];
	$filtr = "(sAMAccountName=$user)";
	$wyjatki = array("department", "title", "sAMAccountName", "displayname", "mail");
	$czytaj = ldap_search($ldapconn, $base_dn, $filtr, $wyjatki);
	$wpis = ldap_get_entries($ldapconn, $czytaj);
	$aduzytkownik = $wpis[0]['displayname'][0];
	$aduzytkownikmail = $wpis[0]['mail'][0];
	$isologin = $wpis[0]['displayname'][0];
	$aduzytkownik = iconv('UTF-8', 'ISO-8859-2', $isologin);
	#echo "U¿ytkownik: " .$aduzytkownik. "<BR>";
	#echo "Dzia³: " .$wpis[0]['department'][0]. "<BR>";
	$department = $wpis[0]['department'][0];
	#echo "Login: $user<BR>";
	$sprawdz_usera_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$sprawdz_usera=mysql_db_query("ewidencja", "select uzytkownicy.id_u, uzytkownicy.loginad_u, uzytkownicy.id_dz, dzialy.symbol_d 
	from uzytkownicy
	left join dzialy
	on uzytkownicy.id_dz = dzialy.id_dz
	where uzytkownicy.loginad_u = '$user'");
	$ile_sprawdz_usera=mysql_num_rows($sprawdz_usera);
	}
?>