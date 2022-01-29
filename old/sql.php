<?php
$info = array("UID"=>"export_rcgw",
		"PWD"=>"Rcgw2014",
		"Database"=>"test_tychy1");
$sqlCon = sqlsrv_connect("(hpdl585g7)",$info);
if ($sqlCon === false) {
	echo'Babol';
	die( print_r( sqlsrv_errors(), true));

}
else {
echo "OK!";
sqlsrv_close($sqlCon);
}

?>