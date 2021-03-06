<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-2'>
<title>
Upoważnienie elektroniczne
</title>
<style type='text/css'>
P.prawy {
		text-align: right;
		font-size: 9px;}
P.lewy {
		text-align: left;}
P.zlam { page-break-after: always; }

table.top {
	width: 100%;
	}
td.naglowek {
	width: 5%;
	text-align: right;
	font-weight: bold;
	font-size: 9px;
	font-family: arial, sans-serif;
	}
td.przerwa {
	width: 20%;
	}
td.naglowek1 {
	width: 37%;
	text-align: left;
	font-weight: bold;
	font-size: 11px;
	font-family: arial, sans-serif;
	}
td.naglowek2 {
	width: 35%;
	text-align: center;
	font-weight: bold;
	font-size: 11px;
	font-family: arial, sans-serif;
	}
td.naglowek3 {
	width: 30%;
	font-size: 10px;
	text-align: right;
	}
P.tytul {
	text-align: center;
	font-weight: bold;
	font-size: 12px;
	font-family: arial, sans-serif;
	}
div.imie_nazwisko {
	font-weight: bold;
	text-align: center;
	font-size: 15px;
	font-family: arial, sans-serif;
	}
div.dzial {
	font-weight: bold;
	font-size: 13px;
	font-family: arial, sans-serif;
	}
div.dla {
	text-align: center;
	font-size: 9px;
	font-family: arial, sans-serif;
	}
div.center {
	text-align: center;
	}
td.male {
	text-align: center;
	font-size: 9px;
	font-family: arial, sans-serif;
	}
td.duze {
	font-weight: bold;
	text-align: center;
	font-size: 14px;
	font-family: arial, sans-serif;
	}
td.pion {
	font-weight: bold;
	text-align: left;
	font-size: 10px;
	font-family: arial, sans-serif;
	layout-flow : vertical-ideographic;
	border: 1px solid black;
    border-style: dotted;
	}
td.pionsrodek {
	width: 5%;
	font-weight: bold;
	text-align: left;
	font-size: 10px;
	font-family: arial, sans-serif;
	layout-flow : vertical-ideographic;
	}
td.nazwa {
	font-weight: bold;
	text-align: left;
	font-size: 11px;
	border: 1px solid black;
    border-style: dotted;
	}
input.maly {	
	width: 8px; 
	height: 8px;
	}
table.thin {
	border-width: 1px;
	border-spacing: 0px;
    border-collapse: collapse;
	border-style: dotted;
	border-color: #000000;
	background-color: #ffffff;
   }
table.thinpap {
	width: 95%;
	border-width: 1px;
	border-spacing: 0px;
    border-collapse: collapse;
	border-color: #000000;
	background-color: #ffffff;
   }
td.thin {
   text-align: center;
   font-size: 9px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
td.thinname {
   width: 30%;
   text-align: center;
   font-size: 8px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
td.thinrest {
   width: 3%;
   text-align: center;
   font-size: 8px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
table.stemple {
	
	width: 800px;
	border-width: 1px;
	border-spacing: 0px;
    border-collapse: collapse;
	border-style: dotted;
	border-color: #000000;
	background-color: #ffffff;
   }
td.stemple_text {
   width: 25%;
   height: 75px;
   text-align: center;
   font-weight: bold;
   font-size: 11px;
   border: 1px solid black;
   border-style: dotted;
   }
td.stemple_text2 {
    text-align: center;
   font-size: 8px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }	
td.stemple {
   width: 25%;
   text-align: center;
   font-size: 8px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
</style>
</head>


<?
$data = date("j.n.Y");
$rok = date("Y");
$idwn = $_GET['idwn'];
$pokaz_wnioski_connect=mysql_connect("localhost", "root", "pwtychy");
mysql_query("SET NAMES latin2");
$pokaz_wnioski=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.imie, wnioski.nazwisko, wnioski.data_od, wnioski.data_do, 
		wnioski.full_zaspap, wnioski.full_sysmod, wnioski.id_dz, dzialy.nazwa_d
		from wnioski
		left join dzialy
		on dzialy.id_dz = wnioski.id_dz
		where wnioski.id_wn = '$_GET[idwn]'
		");
$wniosek=mysql_fetch_array($pokaz_wnioski);
$pokaz_zbiory=mysql_db_query("ewidencja", "select * from (select uprawnienia.id_upr, uprawnienia.id_mod, uprawnienia.odczyt, uprawnienia.modyfikacja, uprawnienia.wprowadzanie, uprawnienia.usuwanie, uprawnienia.bezograniczen, moduly.id_zb

from uprawnienia 

left join moduly

on moduly.id_mod = uprawnienia.id_mod

where uprawnienia.id_wn = $_GET[idwn]

and uprawnienia.id_mod > 0

and (uprawnienia.odczyt = 1

or uprawnienia.wprowadzanie = 1

or uprawnienia.modyfikacja = 1

or uprawnienia.usuwanie = 1

or uprawnienia.bezograniczen = 1)

UNION

select uprawnienia.id_upr, uprawnienia.id_zaspap, uprawnienia.odczyt, uprawnienia.modyfikacja, uprawnienia.wprowadzanie, uprawnienia.usuwanie, uprawnienia.bezograniczen, zasoby_papierowe.id_zb

from uprawnienia 

left join zasoby_papierowe

on zasoby_papierowe.id_zaspap = uprawnienia.id_zaspap

where uprawnienia.id_wn = $_GET[idwn]

and uprawnienia.id_zaspap > 0

and (uprawnienia.odczyt = 1

or uprawnienia.wprowadzanie = 1

or uprawnienia.modyfikacja = 1

or uprawnienia.usuwanie = 1

or uprawnienia.bezograniczen = 1)) as alltog

left join zbiory_do

on zbiory_do.id_zb = alltog.id_zb

group by alltog.id_zb");
$ile_zbiorów=mysql_num_rows($pokaz_zbiory);

echo "
<center>
<body>
<table class=top>
<tr>
<td class=naglowek>
<img src=img/rpwik3.jpg>
</td>
<td class=naglowek1>
REJONOWE PRZEDSIĘBIORSTWO WODOCIˇGÓW<br> 
I KANALIZACJI W TYCHACH SPÓŁKA AKCYJNA
</td>
<td class=naglowek2>
UPOWAŻNIENIE DO PRZETWARZANIA<BR>
DANYCH OSOBOWYCH W RPWiK Tychy S.A.
</td>
<td class=naglowek3>
NR UPOWAŻNIENIA $idwn / $rok
</td>
</tr>
</table>
</center>
<br>
<br>
<br>
<center>
<table>
<tr>
<td>
<div class='dla'>Dla Pana/Pani</div><div class='imie_nazwisko'>
$wniosek[imie] $wniosek[nazwisko]</div><br>
</td>
<td class=przerwa>
</td>
<td>
<div class='dla'>Nazwa komórki organizacyjnej</div>
<div class='imie_nazwisko'>$wniosek[nazwa_d]</div><br>
</td>
</tr>
</table>
</center>
<center>
<table>
<tr>
<td class=male>Okres obowi±zywania od</td>
<td class=duze>$wniosek[data_od]</td>
<td class=male>do</td>
<td class=duze>$wniosek[data_do]</td>
</tr>
<tr>
<td class=male><br><br>Data odwołania upoważnienia</td>
<td class=duze><br>.......................</td>
<td class=male><br><br>podpis osoby odwołuj±cej</td>
<td class=duze><br>.......................</td>
</tr>
</table>
</center><br>
";
for($i = 0; $i < $ile_zbiorów; $i++)
	{
	$zbior=mysql_fetch_array($pokaz_zbiory);
	if ($zbior[nazwa_zb])
		{
		echo "
		<div class='dla'>Dane osobowe objęte zbiorem o nazwie \"$zbior[nazwa_zb]\"
		</div>
		";
		}
	}
echo "
<br><br>
<p class='tytul'>
ZAKRES UPRAWNIEŃ (PRZETWARZANIA DANYCH OSOBOWYCH):
</p>
</center>
<center>
<table class=thin>
<tr>
<td>
<div class='dzial'>1. Systemy, programy, aplikacje</div>
</td>
<tr>
";
			
			echo "
			<tr>
			<td class=nazwa>Nazwa systemu</td>
			<td class=nazwa>Nazwa modułu</td>
			<td class=pion>Odczyt<br></div></td>
			<td class=pion>Wprowadzanie danych</td>
			<td class=pion>Modyfikacja danych</td>
			<td class=pion>Usuwanie danych</td>
			<td class=pion>Bez ograniczeń</td>
			<td class=pion>Identyfikator</td>
			<td class=pion>Pocz±tkowe hasło</td>
			</tr>
			";
			
	
		$sysmod_connect=mysql_connect("localhost", "root", "pwtychy");
		mysql_query("SET NAMES latin2");
		$jakie_sysmod=mysql_db_query("ewidencja", "select systemy.nazwa_sys, systemy.id_sys, moduly.id_mod, moduly.nazwa_mod, 
		uprawnienia.odczyt, uprawnienia.wprowadzanie, 
		uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen, uprawnienia.login_mod, uprawnienia.haslo_mod
		from uprawnienia 
		left join moduly
		on uprawnienia.id_mod = moduly.id_mod
		left join systemy
		on systemy.id_sys = moduly.id_sys
		where uprawnienia.id_wn = '$idwn'
		and
		uprawnienia.id_mod > 0");
		$ile_sysmod=mysql_num_rows($jakie_sysmod);
		for($i = 0; $i < $ile_sysmod; $i++)
				{
				$sysmod=mysql_fetch_array($jakie_sysmod);
				$idsysmod = $sysmod[id_mod];
				if ($sysmod[odczyt] == 1) {$checked_odczyt = "<img src=img/checked.jpeg>";} else {$checked_odczyt = "";}
				if ($sysmod[wprowadzanie] == 1) {$checked_wprowadzanie = "<img src=img/checked.jpeg>";} else {$checked_wprowadzanie = "";}
				if ($sysmod[modyfikacja] == 1) {$checked_modyfikacja = "<img src=img/checked.jpeg>";} else {$checked_modyfikacja = "";}
				if ($sysmod[usuwanie] == 1) {$checked_usuwanie = "<img src=img/checked.jpeg>";} else {$checked_usuwanie = "";}
				if ($sysmod[bezograniczen] == 1) {$checked_bezograniczen = "<img src=img/checked.jpeg>";} else {$checked_bezograniczen = "";}
				if ($sysmod[login_mod]) {$mod_identyfikator = "$sysmod[login_mod]";} else {$mod_identyfikator = "";}
				if ($sysmod[haslo_mod]) {$mod_haslo = "$sysmod[haslo_mod]";} else {$mod_haslo = "";}
				#echo var_dump($odczyt_sysmod_arr). "<br>";
				#echo var_dump($wprowadznie_sysmod_arr). "<br>";
				echo "
				<tr>
				<td class=thin>$sysmod[nazwa_sys]</td>
				<td class=thin>$sysmod[nazwa_mod]</td>
				<td class=thin>$checked_odczyt</td>
				<td class=thin>$checked_wprowadzanie</td>
				<td class=thin>$checked_modyfikacja</td>
				<td class=thin>$checked_usuwanie</td>
				<td class=thin>$checked_bezograniczen</td>
				<td class=thin>$mod_identyfikator</td>
				<td class=thin>$mod_haslo</td>
				</tr>
				";
				$checked_odczyt = '';
				$checked_wprowadzanie = '';
				$checked_modyfikacja = '';
				$checked_usuwanie = '';
				$checked_bezograniczen = '';
				}
		
		#<A onclick="window.print();return false;" href=" "><b>DRUKUJ v.1</b></a>
		echo "
		</table>
		";
if ($wniosek[full_sysmod] == 1)
	{
	echo "
	<table>
	<tr>
	<td class=thin>
	<img src=img/checked.jpeg> Pełny dostęp do zasobów systemowych
	</td>
	<td class=thin>
	Pełne uprawnienia może nadać jedynie Administrator Danych Osobowych
	</td>
	</tr>
	</table>
	";
	}
		echo "
		</center>
		<br>
		<table>
		<tr>
		<td class=male>
		<br><br>
		
		
		<hr>
		Od 1 Maja 2004 r. niniejsze upoważnienie jest elementem obligatoryjnej Ewidencji Osób upoważnionych okre¶lonej w art. 39 ust. 1<br>
		ustawy z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (Dz. U. z 2002 r. Nr 101, poz. 926 ze zm.) któr± prowadzi administrator danych.
		</td>
		</tr>
		</table>
		
		
		<p class=zlam>

		<div class='dzial'>2. Tradycyjna Ewidencja Zasobów Papierowych</div>
		<table class=thinpap>
		<tr>
		<td class=nazwa>Nazwa zasobu</td>
		<td class=pion>Odczyt<br></td>
		<td class=pion>Wprowadzanie danych</td>
		<td class=pion>Modyfikacja danych</td>
		<td class=pion>Usuwanie danych</td>
		<td class=pion>Bez ograniczeń</td>
		<td class=pionsrodek></td>
		<td class=nazwa>Nazwa zasobu</td>
		<td class=pion>Odczyt<br></td>
		<td class=pion>Wprowadzanie danych</td>
		<td class=pion>Modyfikacja danych</td>
		<td class=pion>Usuwanie danych</td>
		<td class=pion>Bez ograniczeń</td>
		</tr>
		";
$jakie_dzialy_connect=mysql_connect("localhost", "root", "pwtychy");
mysql_query("SET NAMES latin2");
$jakie_dzialy=mysql_db_query("ewidencja", "select nazwa_d, id_dz 
from dzialy 
where symbol_d = '$department'");

$ile_dzialow=mysql_num_rows($jakie_dzialy);
for($i = 0; $i < $ile_dzialow; $i++)
	{
	$dzialy=mysql_fetch_array($jakie_dzialy);
	}
$zasoby_papierowe_connect=mysql_connect("localhost", "root", "pwtychy");
mysql_query("SET NAMES latin2");
$jakie_zaspap=mysql_db_query("ewidencja", "select zasoby_papierowe.id_zaspap,
zasoby_papierowe.nazwa_zaspap, uprawnienia.odczyt, uprawnienia.wprowadzanie,
uprawnienia.modyfikacja, uprawnienia.usuwanie, uprawnienia.bezograniczen
from uprawnienia 
left join zasoby_papierowe
on uprawnienia.id_zaspap = zasoby_papierowe.id_zaspap
where uprawnienia.id_wn = '$idwn'
and
uprawnienia.id_zaspap > 0");
$ile_zaspap=mysql_num_rows($jakie_zaspap);
for($i = 0; $i < $ile_zaspap; $i++)
	{
	$zaspap=mysql_fetch_array($jakie_zaspap);
	$j = $i+1;
	$idzaspap2 = $zaspap[id_zaspap];
	#echo var_dump($odczyt_arr). "<br>";
	#echo var_dump($wprowadznie_arr). "<br>";
	if ($zaspap[odczyt] == 1) {$checked_odczyt = "<img src=img/checked.jpeg>";} 
	else {$checked_odczyt = "";}
	if ($zaspap[wprowadzanie] == 1) {$checked_wprowadzanie = "<img src=img/checked.jpeg>";} 
	else {$checked_wprowadzanie = "";}
	if ($zaspap[modyfikacja] == 1) {$checked_modyfikacja = "<img src=img/checked.jpeg>";} 
	else {$checked_modyfikacja = "";}
	if ($zaspap[usuwanie] == 1) {$checked_usuwanie = "<img src=img/checked.jpeg>";} 
	else {$checked_usuwanie = "";}
	if ($zaspap[bezograniczen] == 1) {$checked_bezograniczen = "<img src=img/checked.jpeg>";} 
	else {$checked_bezograniczen = "";}
	
	if ($i % 2 == 0) echo 	"<tr>";
	if ($i % 2 != 0) echo 	"";
	echo "
	<td class=thinname>$zaspap[nazwa_zaspap]</td>
	<td class=thinrest>$checked_odczyt </td>
	<td class=thinrest>$checked_wprowadzanie</td>
	<td class=thinrest>$checked_modyfikacja</td>
	<td class=thinrest>$checked_usuwanie</td>
	<td class=thinrest>$checked_bezograniczen</td>
	";
	if ($i % 2 != 0) echo 	"</tr>";
	if ($i % 2 == 0) echo 	"<td></td>";
	
	$checked_odczyt = '';
	$checked_wprowadzanie = '';
	$checked_modyfikacja = '';
	$checked_usuwanie = '';
	$checked_bezograniczen = '';
	}

echo "
</table>
<br>
";
if ($wniosek[full_zaspap] == 1)
	{
	echo "
	<table>
	<tr>
	<td class=thin>
	<img src=img/checked.jpeg> Pełny dostęp do zasobów papierowych
	</td>
	<td class=thin>
	Pełne uprawnienia może nadać jedynie Administrator Danych Osobowych
	</td>
	</tr>
	</table>
	";
	}

	$full_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$full_query=mysql_db_query("ewidencja", "select * from wnioski where id_wn = '$idwn'");
	$full=mysql_fetch_array($full_query);
	if ($full[full] == 1)
		{
		echo "
		<div class='dzial'>3. Pełne uprawnienia do tradycyjnej ewidencji zasobów babierowych<br>
		oraz wszystkich systemów informatycznych, aplikacji i programów. <img src=img/checked.jpeg></div>
		<table>
		<tr>
		<td class=male>
		Pełne uprawnienia może nadać jedynie Administrator Danych Osobowych
		</td>
		</tr>
		</table>
		
		";
		}
	echo "
	<br><br><br><br><br>
		<br><br><br><br><br>
		<br><br><br><br><br>
		<br><br><br><br><br>
	<table class=stemple>
	<tr>
	<td class=stemple_text>
		Data i podpis upoważnionego
	</td>
	<td class=stemple>
		.
	</td>
	<td class=stemple_text>
		Data przyjęcia wniosku i podpis osoby prowadz±cej 
		ewidencję upoważnionych do przetwarzania danych	
	</td>
	<td class=stemple>
		.
	</td>
	</tr>
	<tr>
	<td class=stemple_text>
		Data i podpis wnioskuj±cego <br>o nadanie upoważnienia (przełożony)
	</td>
	<td class=stemple>
		.
	</td>
	<td class=stemple_text>
		Data i podpis ADO lub osoby wskazanej
		przez ADO do nadawania upoważnień
	</td>
	<td class=stemple>
		.
	</td>
	</tr>
	<tr>
	<td class=stemple_text2 colspan=2>
		RPWiK Tychy S.A. z siedzib± w Tychach jako Administrator Danych Osobowych w rozumieniu art. 7 pkt 4 ustawy
		z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (tekst jednolity Dz. U. z 2002 r. Nr 101, poz. 926 ze zm), a
		w jej imieniu Prezes Zarz±du niniejszym upoważnia Pani±/Pana, na mocy art. 37 tej ustawy, do przetwarzania danych osobowych.
		W ramach tego upoważnienia otrzymuje Pani/Pan dostęp do danych osobowych w powyżej okre¶lonym zakresie.

	</td>
	<td class=stemple_text>
		Data zarejestrowania w systemach informatycznych
		i podpis Administratora Systemu
	</td>
	<td class=stemple>
		.
	</td>
	</tr>
	</table>
	
	<br><br><br><br><br>
	<br><br><br><br><br>

	<table>
	<tr>
	<td class=male>
		Od 1 Maja 2004 r. niniejsze upoważnienie jest elementem obligatoryjnej Ewidencji Osób upoważnionych okre¶lonej w art. 39 ust. 1<br>
		ustawy z dnia 29 sierpnia 1997 r. o ochronie danych osobowych (Dz. U. z 2002 r. Nr 101, poz. 926 ze zm.) któr± prowadzi administrator danych.
	</td>
	</tr>
	</table>
	<hr>
	";		 
?>
</body>
</html>