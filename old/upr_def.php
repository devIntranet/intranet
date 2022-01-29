<?php
$DBconnect=mysql_connect("localhost", "root", "pwtychy");
$qry1 = mysql_db_query("ewidencja_dev", "SELECT id_ud,(16*ewidencja.uprawnienia_default.odczyt+
8*ewidencja.uprawnienia_default.wprowadzanie+
4*ewidencja.uprawnienia_default.modyfikacja+
2*ewidencja.uprawnienia_default.usuwanie+
ewidencja.uprawnienia_default.bez_ograniczen) as x 
FROM ewidencja.uprawnienia_default");
$ile1 = mysql_num_rows($qry1);
for($i=0;$i<$ile1;$i++) {
	$upr = mysql_fetch_array($qry1);
	$qry2 = mysql_db_query("ewidencja_dev", "update ewidencja_dev.uprawnienie_default
	set uprdef_bit = $upr[x]
	where id_ud = $upr[id_ud]
	");
	echo "$upr[id_ud] - $upr[x]";
	echo mysql_error();
	echo "<br>";
}

?>