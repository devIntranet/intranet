<?php
$DBconnect=mysql_connect("localhost", "root", "pwtychy");
$qry1 = mysql_db_query("ewidencja_dev", "SELECT * 
FROM  uprawnienie_wniosek 
WHERE LENGTH( haslo_mod ) >1");
$ile1 = mysql_num_rows($qry1);
for($i=0;$i<$ile1;$i++) {
	$upr = mysql_fetch_array($qry1);
	$qry2 = mysql_db_query("ewidencja_dev", "insert into ewidencja_dev.login_pass
	(id_upr, login_mod, pass_mod) values ($upr[id_upr],
	'$upr[login_mod]', '$upr[haslo_mod]')
	");
	echo "$upr[id_upr] - $upr[login_mod] - $upr[haslo_mod]";
	echo mysql_error();
	echo "<br>";
}

?>