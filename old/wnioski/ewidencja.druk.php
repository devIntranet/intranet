<html>
<head>
<meta http-equiv='Content-Type' content='text/html; charset=iso-8859-2'>
<title>
Ewidencja upoważnień do przetwarzania danych osobowych
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
	width: 41%;
	text-align: left;
	font-weight: bold;
	font-size: 11px;
	font-family: arial, sans-serif;
	}
td.naglowek2 {
	width: 42%;
	text-align: center;
	font-weight: bold;
	font-size: 11px;
	font-family: arial, sans-serif;
	}
td.naglowek3 {
	width: 20%;
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
td.lp {
   width: 5%;
   text-align: center;
   font-size: 11px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
td.id {
   width: 8%;
   text-align: center;
   font-size: 11px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
td.rest {
   width: 15%;
   text-align: center;
   font-size: 11px;
   font-family: arial, sans-serif;
   border: 1px solid black;
   border-style: dotted;
   }
</style>
</head>

<?
$data=date("Y-m-d");
echo"
<body>
<center>
<table class=top>
<tr>
<td class=naglowek>
<img src=img/rpwik3.jpg>
</td>
<td class=naglowek1>
REJONOWE PRZEDSIĘBIORSTWO WODOCIĄGÓW<br> 
I KANALIZACJI W TYCHACH SPÓŁKA AKCYJNA
</td>
<td class=naglowek2>
EWIDENCJA UPOWAŻNIEŃ DO PRZETWARZANIA <br>
DANYCH OSOBOWYCH W RPWiK w TYCHACH S.A. 
</td>
<td class=naglowek3>
wydruk z dnia<br> $data
</td>
</tr>
</table>
</center>
<br>
<br>
<br>
<center>

<table class=dot>
	<tr class=wn_top>
	<td class=lp>LP</td>
	<td class=id>Nr wniosku</td>
	<td class=rest>Imię</d>
	<td class=rest>Nazwisko</td>
	<td class=rest>Data złożenia</td>
	<td class=rest>Data zatwierdzenia</td>
	<td class=rest>Obowiązuje od</td>
	<td class=rest>Obowiązuje do</td>
	</tr>
	";
	if ($_GET['wnst'] == "wazne")
		{$wnstqry = 9;}
	if ($_GET['wnst'] == "niewazne")
		{$wnstqry = 11;}
	$odw_up_connect=mysql_connect("localhost", "root", "pwtychy");
	mysql_query("SET NAMES latin2");
	$list_ewidencja_upowaznien_qry=mysql_db_query("ewidencja", "select wnioski.id_wn, wnioski.nazwisko, wnioski.imie, wnioski.data_zl, wnioski.data_zat, 
	wnioski.data_od, wnioski.data_do, dokumenty_wnioski.link_dok 
	from wnioski 
	left join dokumenty_wnioski
	on wnioski.id_wn = dokumenty_wnioski.id_wn
	where wnioski.status_wn = $wnstqry");
	
	$ile_list_ewidencja_upowaznien=mysql_num_rows($list_ewidencja_upowaznien_qry);
	for($i = 0; $i < $ile_list_ewidencja_upowaznien; $i++)
		{
		$list_ewidencja_upowaznien=mysql_fetch_array($list_ewidencja_upowaznien_qry);	
		if (($list_ewidencja_upowaznien[data_do] == "0000-00-00") || ($list_ewidencja_upowaznien[data_do] == NULL))
			{$list_ewidencja_upowaznien[data_do] = "do odwołania";}
		$data_dzis = date("Y-m-d");
		$data_dzis_str = strtotime($data_dzis);
		$data_str = strtotime($list_ewidencja_upowaznien[data_do]);
	    $daty = $data_str-$data_dzis_str;
		if (($list_ewidencja_upowaznien[data_do] != "0000-00-00") && ($list_ewidencja_upowaznien[data_do] != "do odwołania") && ($list_ewidencja_upowaznien[data_do] != NULL) && ($daty<0))
			{
			$list_ewidencja_upowaznien[data_do] = "upłynęło";
			}
		$lp=$i+1;
		
		echo "
		<tr class=topdot>
		<td class=lp>
		$lp
		</td>
		<td class=id>
		$list_ewidencja_upowaznien[id_wn]
		</td>
		<td class=rest>
		$list_ewidencja_upowaznien[imie]
		</td>
		<td class=rest>
		$list_ewidencja_upowaznien[nazwisko]
		</td>
		<td class=rest>
		$list_ewidencja_upowaznien[data_zl]
		</td>
		<td class=rest>
		$list_ewidencja_upowaznien[data_zat]
		</td>
		<td class=rest>
		$list_ewidencja_upowaznien[data_od]
		</td>
		<td class=rest>
		$list_ewidencja_upowaznien[data_do]
		</td>
		</tr>
		";
		}
	echo "
	</table><br>
	<hr>
	";




?>