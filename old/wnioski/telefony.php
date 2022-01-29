<html>
 <head>
  <title>Spis Telefonów</title>
  <meta http-equiv="Content-Type" content="text/html; charset=latin2" />
  <link rel="stylesheet" type="text/css" href="/style.css">

 </head>

<style type="text/css">
<!-- body {background-image: \tlo\tlo4.jpg);  BGPROPERTIES="fixed");} 
		table.telefony {width:80%;}
		td.stanowisko {width: 10%;}
		td.dzial {width:25%;}
		td.nazwisko {width:15%;}
		td.imie {width:15%;}
		td.symbol {width:5%;}
		td.numer {width:5%;}
		td.edytuj {width:5%;}
		tr.telefony {width:70%;}
-->
</style>
<BODY onLoad="show3()" align="center" bgcolor=#f9bf13 BACKGROUND="../tlo/tlo4.jpg" BGPROPERTIES="fixed">
<CENTER><H1>Spis telefonów</H1></CENTER>
<HR>

 <?
error_reporting(1);
$edytuj = $_GET['edytuj'];
$tel = $_GET['tel'];
$nrtel = $_POST['nrtel'];
$stanowiskopost = $_POST['stanowiskopost'];
$ukrytylogin = $_POST['ukrytylogin'];
$ulogin = $_GET['ulogin'];


$ldaprdn  = 'admin';     // ldap rdn or dn
$ldappass = 'c0k0lwiek';  // associated password
// connect to ldap server
$ldapconn = ldap_connect("192.168.1.97")
    or die("Could not connect to LDAP server.");
ldap_set_option($ldapconn, LDAP_OPT_PROTOCOL_VERSION,3);
ldap_set_option($ldapconn, LDAP_OPT_REFERRALS,0);

if ($ldapconn) 
	{
    // binding to ldap server
    $ldapbind = ldap_bind($ldapconn, $ldaprdn, $ldappass);
	$base_dn = "dc=rpwik, dc=tychy, dc=pl";
	}
if (($edytuj==2) && ($nrtel))
	{
	$edit_tel_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$dolacz=mysql_db_query("ewidencja", "update telefony set nr_tel = '$nrtel' where id_t = $tel");
	$loginad=$row["loginad_u"];
	#echo "ukryty: $ukrytylogin !!!!!<br><br>";
	$filtr = "(sAMAccountName=$ukrytylogin)";
	$wyjatki = array("dn", "title");
	$czytaj = ldap_search($ldapconn, $base_dn, $filtr, $wyjatki);
	$wpis = ldap_get_entries($ldapconn, $czytaj);	
	$dm = $wpis[0]["dn"];
	#echo "ZMIENNA: $dm LOGIN: $ukrytylogin";
	$zmiana["title"] = $stanowiskopost; 
  	#$zmiana2 = ldap_modify($ldapconn,$dm, $zmiana);
	}

function getGetParam($aParam, $aDefault = '')
{
	if(isset($_GET[$aParam]))
		return $_GET[$aParam];
	else 
		return $aDefault;
}


$link = mysqli_connect('spis', 'spis', '123', 'ewidencja');

/* check connection */
if (mysqli_connect_errno()) {
    printf("Connect failed: %s\n", mysqli_connect_error());
    exit();
	}
mysqli_query($link, "SET NAMES 'latin2'");


$reqSort = getGetParam('sort', 0);
if($reqSort==1) 
	{
	$sortowanie="ORDER BY nazwa_u";
	}
elseif($reqSort==2) 
	{
	$sortowanie="ORDER BY imie_u";
	}
elseif($reqSort==3) 
	{
	$sortowanie="ORDER BY symbol_d";
	}
elseif($reqSort==4) 
	{
	$sortowanie="ORDER BY nr_tel";
	}
elseif($reqSort==5) 
	{
	$sortowanie="ORDER BY nazwa_d";
	}
else
	{
	$sortowanie="ORDER BY nr_tel";
	}
$query = "select telefony.nr_tel, uzytkownicy.nazwa_u, uzytkownicy.imie_u, dzialy.symbol_d,  dzialy.nazwa_d, uzytkownicy.loginad_u, 
	uzytkownicy.id_u, dzialy.id_dz, telefony.id_t
	from telefony
	left join uzytkownicy on uzytkownicy.id_u = telefony.id_u
	left join dzialy on dzialy.id_dz = uzytkownicy.id_dz
	$sortowanie ";

$result = mysqli_query($link, $query);
printf ('<TABLE class=telefony border="1" FRAME="void" RULES="rows">');
printf ('<TR class=telefony><TD><A HREF="telefony.php?sort=4">Numer telefonu</A></TD><TD><A HREF="telefony.php?sort=1">Nazwisko / Nazwa</A></TD><TD><A HREF="telefony.php?sort=2">Imię</A></TD><TD><A HREF="telefony.php?sort=3">Symbol działu</A></TD><TD><A HREF="telefony.php?sort=5">Nazwa działu</A></TD><TD><A HREF="telefony.php?sort=1">Stanowisko</A></TD><TD><a herf=telefony.php?edit=4>Edytuj<a></TD></TR>');
while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
	$remote_user = $_SERVER['REMOTE_USER'];
list($domena, $user) = explode("\\", $remote_user);



	if ($ldapconn) 
	{
	$filter = "(sAMAccountName=$user)";
	$justthese = array("directreports");
	$read = ldap_search($ldapconn, $base_dn, $filter);
	$entry = ldap_get_entries($ldapconn, $read);
	#echo var_dump($entry);
	$loginad=$row["loginad_u"];
	$filtr = "(sAMAccountName=$loginad)";
	$wyjatki = array("department", "title", "sAMAccountName");
	$czytaj = ldap_search($ldapconn, $base_dn, $filtr, $wyjatki);
	$wpis = ldap_get_entries($ldapconn, $czytaj);
	$wpis2 =$wpis[0]["title"][0];
	$stanowisko = $wpis2;
	$ukrytylogin2=$wpis[0]["samaccountname"][0];
	$ile=$entry[0]["directreports"][0];
	$ile2=count($entry[0]["directreports"]);
	$ile3=$ile2-1;
	
	for ($i=0; $i < $ile3; $i++)
		{
		$pelnanazwa=$entry[0]["directreports"][$i];
		$filtr2 = "(distinguishedname=$pelnanazwa)";
		$wyjatki2 = array("department", "title", "sAMAccountName", "distinguishedname");
		$czytaj2 = ldap_search($ldapconn, $base_dn, $filtr2, $wyjatki2);
		$wpis2 = ldap_get_entries($ldapconn, $czytaj2);
		$profil=$wpis2[0]['samaccountname'][0];
		if (($profil == $row[loginad_u]) || ($user == $row[loginad_u]))
			{
			if ($edytuj != 1)
				{
				$numer = $row["nr_tel"];
				$edit = "<a href=telefony.php?edytuj=1&tel=$row[id_t]#linia>edytuj</a>";
				$edytuj = NULL;
				}
			if ($edytuj == 1)
				{
				if ($row["id_t"] == $tel)
					{
					$numer = "<form action=telefony.php?edytuj=2&tel=$row[id_t] method=post>
									<input type=text maxlength=3 name=nrtel value=$row[nr_tel] id=linia>
									";
					$edit = "<input type=submit name=popraw value=popraw></form>";
					#$edytuj = NULL;
					}
				}
			
			}
		
		}
# distinguishedname
#	 for ($i=0; $i < $entry["count"]; $i++)
#    {
#        if (($entry[$i]["directreports"][0]) && ($entry[$i]["department"][0] == $row["symbol_d"]))
#			{
#			if ($edytuj != 1)
#				{
#				$numer = $row["nr_tel"];
#				$edit = "<a href=/telefony.php?edytuj=1&tel=$row[id_t]#linia>edytuj</a>";
#				$edytuj = NULL;
#				$stanowisko = $wpis2;
#				}
#			if ($edytuj == 1)
#				{
#				if ($row["id_t"] == $tel)
#					{
#					$numer = "<form action=/telefony.php?edytuj=2&tel=$row[id_t] method=post>
#									<input type=text maxlength=3 name=nrtel value=$row[nr_tel] id=linia>
#									";
#					$edit = "<input type=submit name=popraw value=popraw></form>";
#					$stanowisko = "$wpis2";
#					#$edytuj = NULL;
#					}
#				}
#			}
#	}
}
	
	
	
	if (!$numer) {$numer = $row["nr_tel"];}
	if ($wpis["count"] > 0)
		{
	
		printf ('<TR class=telefony><TD class=numer>%s</TD><TD class=nazwisko>%s</TD><TD class=imie>%s</TD><TD class=symbol>%s</TD><TD class=dzial>%s</TD><TD class=stanowisko>%s</TD><TD class=edytuj>%s</TD></TR>', $numer, $row["nazwa_u"], $row["imie_u"], $row["symbol_d"], $row["nazwa_d"], $stanowisko, $edit);
		$edit = NULL;
		$numer = NULL;
		$stanowisko = NULL;
		}
	}

printf ("</TABLE><HR>");
$back="'http://install/strona.html'";
printf ('<FORM><INPUT TYPE="button" VALUE="Wróć" onClick="location.href=%s"></FORM>',$back);
/* Zwalnianie pamięci */
mysqli_free_result($result); 

/* Rozłšczanie */
mysqli_close($link);

?>
 </body>
</html>
