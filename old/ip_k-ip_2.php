<?php
$DBconnect=mysql_connect("localhost", "root", "pwtychy");
$qry1 = mysql_db_query("ewidencja_dev", "select * from drukarki");
$ile1 = mysql_num_rows($qry1);
for($i=0;$i<$ile1;$i++) {
	$drukarki = mysql_fetch_array($qry1);
	$qry2 = mysql_db_query("ewidencja_dev", "update drukarki
	set ip_2 = (SELECT INET_ATON(ip_dr) from(
	select * from drukarki) as X
	where id_dr = $drukarki[id_dr])
	where id_dr = $drukarki[id_dr]");
	echo "$drukarki[id_dr] - $drukarki[ip_dr]";
	echo mysql_error();
	echo "<br>";
}

?>