<?
$pokaz_upowaznienie_connect=mysql_connect("localhost", "root", "pwtychy");
mysql_query("SET NAMES latin2");
$pokaz_upowaznienie_qry=mysql_db_query("ewidencja", "select dokumenty_wnioski.link_dok
	from dokumenty_wnioski
	left join uzytkownicy
	on dokumenty_wnioski.id_wn = uzytkownicy.id_wn
	where uzytkownicy.loginad_u = '$user'");
$ile_dok=mysql_num_rows($pokaz_upowaznienie_qry);
$link=mysql_fetch_array($pokaz_upowaznienie_qry);
$im = new imagick( "dokumenty\\$link[link_dok][0]" );
	// resize by 200 width and keep the ratio
	$im->thumbnailImage( 300, 0);
	// write to disk
	$im->writeImage( "$user"."1.jpg" );
	$jpg1="$user"."1.jpg";
$im = new imagick( "dokumenty\\$link[link_dok][0]" );
	// resize by 200 width and keep the ratio
	$im->thumbnailImage( 800, 0);
		// write to disk
	$im->writeImage( "$user"."2.jpg" );
	$jpg2="$user"."2.jpg";
$im = new imagick( "dokumenty\\$link[link_dok][1]" );
	// resize by 200 width and keep the ratio
	$im->thumbnailImage( 300, 0);
	// write to disk
	$im->writeImage( "$user"."3.jpg" );
	$jpg3="$user"."3.jpg";
$im = new imagick( "dokumenty\\$link[link_dok][1]" );
	// resize by 200 width and keep the ratio
	$im->thumbnailImage( 800, 0);
	// write to disk
	$im->writeImage( "$user"."4.jpg" );
	$jpg4="$user"."4.jpg";

mysql_close($pokaz_upowaznienie_connect); 
echo "
</center><br><br>
<a href=$jpg2 rel=\"lightbox[roadtrip]\"><img src=$jpg1></a>
<a href=$jpg4 rel=\"lightbox[roadtrip]\"><img src=$jpg3></a>
";

?>