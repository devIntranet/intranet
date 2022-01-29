<?php
$info = array("UID"=>"export_rcgw",
		"PWD"=>"Rcgw2014",
		"Database"=>"test_tychy1");
$sqlCon = sqlsrv_connect("hpdl585g7",$info);
if ($sqlCon === false) {
	echo'Babol';
	die( print_r( sqlsrv_errors(), true));

}
else {

$SqlQuery = "Select RODZAJDOK, TYP_DOK, NAZWA, USER_WPR from ASRODZDO";

$result = sqlsrv_query($sqlCon,$SqlQuery);
echo "<TABLE><TR>
<TD>RODZAJDOK</TD>
<TD>TYP_DOK</TD>
<TD>NAZWA</TD>
<TD>USER_WPR</TD>
</TR>";
while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) ) 
	{
//	echo 'dane <BR>';
        echo "<TR><TD>".$row['RODZAJDOK']."</TD>";
//	 <TD>".$row['TYP_DOK']."</TD><TD>".$row['NAZWA']."</TD><TD>".$row['USER_WPR']."</TD></TR>";
	}
echo '</TABLE>';

sqlsrv_close($sqlCon);
}

?>