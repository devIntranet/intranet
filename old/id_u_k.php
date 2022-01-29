<?php
$DBconnect=mysql_connect("localhost", "root", "pwtychy");
$qry1 = mysql_db_query("ewidencja_dev", "Select wniosek.id_wn, uzytkownik.id_u from wniosek left join uzytkownik
on uzytkownik.nazwa_u = wniosek.nazwisko
where wniosek.imie = uzytkownik.imie_u");
$ile1 = mysql_num_rows($qry1);
for($i=0;$i<$ile1;$i++) {
	$wniosek = mysql_fetch_array($qry1);
	$qry2 = mysql_db_query("ewidencja_dev", "update wniosek
	set id_u = $wniosek[id_u]
	where id_wn = $wniosek[id_wn]
	");
	echo "$wniosek[id_wn] $wniosek[id_u]";
	echo mysql_error();
	echo "<br>";
}

?>