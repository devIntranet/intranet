<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
    <link rel="Stylesheet" type="text/css" href="style\main.css" />
    <script type="text/javascript" src="js/prototype.js"></script>
	<script type="text/javascript" src="js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="js/lightbox.js"></script>
	<script type="text/javascript" src="js/wnioski_calendar.js"></script>
	<script src="http://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" language="javascript" src="TableFilter/tablefilter_all.js"></script>  
	<!-- <link rel=stylesheet type=text/css href=/Strona/style.css> -->
	<link rel="stylesheet" href="css/lightbox.css" type="text/css" media="screen" /> 
	<LINK REL="SHORTCUT ICON" HREF="img\intranet_s.ico">
	<title>RPWiK - Intranet</title>
  </head>
  <body>
	<div id="main">
	  <div id="TOP"><img src="img/top.jpg" /></div>
	  <div id="MENU">
	  	<ul id="menu-ul">
		  <li>
		  <a href=? class="l_glowna">Strona Główna</a>
		  </li>
		  <li>
		  <a href=?kursy class="l_wnioski">Kursy</a>	
		  </li>
		  <li>
		  <a href=?it class="it">Administracja IT</a>	
		  </li>
		
		<a href = "file://backupsrv/dokumenty_spółki" class="l_dokumenty"></a>
		<a class="l_instrukcje"><div  ></div></a>
	  </div>
	  
	  <div id="TRESC">
	  <?php
	  if (isset($_GET['kursy'])) {
		echo "
		  <ul id='pliki-ul'>
			<li>
			  <a href=/pliki/kursy/komunikacja/1.ekswsp.pps>
			  Efektywne komunikowanie się w środowisku pracy
			  </a>
			</li>
			<li>
			  <a href=/pliki/kursy/komunikacja/2.pokm.pps>
			  Profesjonalna obsługa klienta
			  </a>
			</li>
			<li>
			  <a href=/pliki/kursy/komunikacja/3.tkpi.pdf>
			  Test dominujacy kanal przetwarzania informacji
			  </a>
			</li>
		";
	  }


	 if (isset($_GET['it'])) 
		{
		echo "
		  <ul id='it-ul'>
			<li>
			  <a href=/pliki/schematy/Adresacja_WAN_2014.pdf>
			  Adresacja WAN 2014
			  </a>
			</li>
			<li>
			  <a href=/pliki/kursy/komunikacja/2.pokm.pps>
			  Profesjonalna obsługa klienta
			  </a>
			</li>
			<li>
			  <a href=/pliki/kursy/komunikacja/3.tkpi.pdf>
			  Test dominujacy kanal przetwarzania informacji
			  </a>
			</li>
		";
	  }


	  
	  ?>
	  </div>
	  <div id="BOTTOM"><img src="img\bottom.jpg" /></div>
	</div>
  </body>
</html>
<?php
?>
