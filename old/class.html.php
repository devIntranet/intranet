<?php

class Html {

	public $head;	
	public $top;
	public $bottom;
	public $menu;
	public $tresc;
	public $logowanie;
	public $zalogowany;
	public $login;
	private $hover;
	
	public function __construct() {
		$this->head = "<!DOCTYPE HTML PUBLIC \"-//W3C//DTD HTML 4.01//EN\" \"http://www.w3.org/TR/html4/strict.dtd\">
					   <html xmlns=\"http://www.w3.org/1999/xhtml\">
					   <head>
					   <meta http-equiv=\"Content-Type\" content=\"text/html; charset=UTF-8\" />
					   <link rel=\"Stylesheet\" type=\"text/css\" href=\"style\main.php\" />
					   <script type=\"text/javascript\" src=\"js/prototype.js\"></script>
					   <script type=\"text/javascript\" src=\"js/scriptaculous.js?load=effects,builder\"></script>
					   <script type=\"text/javascript\" src=\"js/lightbox.js\"></script>
					   <script type=\"text/javascript\" src=\"js/wnioski_calendar.js\"></script>
					   <script src=\"http://code.jquery.com/jquery-latest.js\"></script>
					   <script type=\"text/javascript\" language=\"javascript\" src=\"TableFilter/tablefilter_all.js\"></script>  
					   <!-- <link rel=stylesheet type=text/css href=/Strona/style.css> -->
  					   <link rel=\"stylesheet\" href=\"css/lightbox.css\" type=\"text/css\" media=\"screen\" /> 
					   <LINK REL=\"SHORTCUT ICON\" HREF=\"img\intranet_s.ico\">
   					   <title>RPWiK - Intranet</title>
					   </head>
					   <body>
					  ";
		$this->top =  "<div id=\"main\">
					   <div id=\"TOP\"><img src=\"img/top.jpg\" /></div>
					  ";
		$this->menu = "<div id=\"MENU\">
    				   <a href=? class=\"l_glowna\"><div  ></div></a>
					   <a href=?m=wn class=\"l_wnioski\"><div  ></div></a>
					   <a href=\"?m=up\" class=\"l_upowaznienia\"><div  ></div></a>
					   <a class=\"l_telefony\"><div  ></div></a>
					   <a href = \"file://backupsrv/dokumenty_spółki\" class=\"l_dokumenty\"><div  ></div></a>
					   <a class=\"l_instrukcje\"><div  ></div></a>
					  ";
		$this->hr = "</div>
					 <div id=\"HR\"><img src=\"img/hr.jpg\" /></div>
					";
		$this->tresc = "<div id=\"PASEK_TOP\">
					    </div>
						<div id=\"TRESC\">
    				    ";
		$this->bottom = "</div>
						 <div id=\"BOTTOM\"><img src=\"img\bottom.jpg\" /></div>
						 </div>
						 </body>
						 </html>
					    ";
						
		$this->logowanie = "<div id=VOID_MENU></div>
					 	    <div>
						    <form action=index.php method=post>
						    <input class=i_login type=text name=nazwa><br>
						    <input class=i_login type=password name=haslo>
						    <input class=s_password name=intralog type=submit value=' '>  
							</form>
						    </div>
						   ";
		$this->zalogowany = "<a href=?m=bz class=l_baza><div  ></div></a>
							 <div id=VOID_MENU2></div>
							 ". (6000 + ($_SESSION[czas])- time()) ."
							 <a href=?m=lo class=l_logout><div  ></div></a>
							
							";
		if (!isset($_SESSION[user])) {
			$this->login = $this->logowanie;
		}
		if (isset($_SESSION[user])) {
			$this->login = $this->zalogowany;
		}
	 	$this->hover = "onMouseOver=\"this.style.backgroundColor='#E1EAFE'\"; onMouseOut=\"this.style.backgroundColor='transparent'\"";	
	}
	
	public function loginZalogowany() {
		//$this->login = $this->zalogowany;
	}
	public function loginLogowanie() {
		//$this->login = $this->logowanie; 
	}

	public function showWnioskiDruk($plik) {
		$this->tresc.="<br>";
		for ($i = 0; $i <count($plik['Id']); $i++) {
			$this->tresc .= "<div><a href=?wn=" .$plik['Id'][$i] ."><img src = img/". $plik['Type'][$i]. ".png class=dokument></a> ";
			$this->tresc .= "<b>". $plik['Name'][$i] .": </b>";
			$this->tresc .= $plik['Description'][$i] ."</div><br class=clear><hr>";
		}
	}
	
	public function showWniosekDruk($plik) {
		//while ($row = $wniosek->fetch()) {
			if ($plik['Type'] == 'doc') header("Content-type:application/msword");
			if ($plik['Type'] == 'pdf') header("Content-type:application/pdf");
			if ($plik['Type'] == 'docx') header("Content-type:application/vnd.openxmlformats-officedocument.wordprocessingml.document");
			header("Content-Disposition: inline; filename=$fileName");
			print $plik['Content'];
			exit();
		//}
	}
	public function showBazaMenu() {
		$this->tresc = "<div id=\"PASEK_TOP\">
						<div class=\"menuBaza1\">
						<a href=?m=bz&mt=usr class=\"m_uzytkownicy\"></a>
						<a href=?m=bz&mt=dzl class=\"m_dzialy\"></a>
						<a href=?m=bz&mt=kmp class=\"m_komputery\"></a>
						<a href=?m=bz&mt=mon class=\"m_monitory\"></a>
						<a href=?m=bz&mt=ups class=\"m_upsy\"></a>
						</div>
						<div class=\"menuBaza2\">
						<a href=?m=bz&mt=drk class=\"m_drukskan\"></a>
						<a href=?m=bz&mt=prg class=\"m_programy\"></a>
						<a href=?m=bz&mt=szk class=\"m_szukacz\"></a>
						<a href=?m=bz&mt=hst class=\"m_historia\"></a>
						<a href=\"javascript: history.back()\" class=\"m_wroc\"></a>
						</div>
						</div>												
						<div id=\"TRESC\">
					
						";
	}
	
	public function showUzytkownicy($uzytkownik, $dzial, $telefon, $sortColumn, $sortDirection) {
		if ($sortColumn == "nzw" && $sortDirection == 'a') $srtDirNzw = "&srtdir=d";
			else $srtDirNzw = "&srtdir=a";
		if ($sortColumn == "imi" && $sortDirection == 'a') $srtDirImi = "&srtdir=d";
			else $srtDirImi = "&srtdir=a";
		if ($sortColumn == "dzl" && $sortDirection == 'a') $srtDirDzl = "&srtdir=d";
			else $srtDirDzl = "&srtdir=a";
		if ($sortColumn == "tel" && $sortDirection == 'a') $srtDirTel = "&srtdir=d"; 
			else $srtDirTel = "&srtdir=a";

		$this->tresc .= "<br>";
		$this->tresc .= "<table id=\"uzytkownicy\" class=\"mytable filterable\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td><a class=nag href=?m=bz&mt=usr&srtcol=nzw$srtDirNzw><div>Nazwisko</div></a></td>";
		$this->tresc .= "<td><a class=nag href=?m=bz&mt=usr&srtcol=imi$srtDirImi><div>Imię</div></a></td>";
		$this->tresc .= "<td><a class=nag href=?m=bz&mt=usr&srtcol=dzl$srtDirDzl><div>Dział</div></a></td>";
		$this->tresc .= "<td><a class=nag href=?m=bz&mt=usr&srtcol=tel$srtDirTel><div>Nr telefonu</div></a></td>";
		$this->tresc .= "</tr>";
						
		for ($i = 0; $i <count($uzytkownik['Id']); $i++) {
			$this->tresc .= "<tr class=hov $this->hover>";
			$this->tresc .= "<td><a href=?m=bz&usr=".$uzytkownik['Id'][$i].">". $uzytkownik['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td>". $uzytkownik['Imie'][$i] ."</td>";
			$this->tresc .= "<td><a href=?m=bz&usr=".$dzial['Id'][$i].">". $dzial['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td>". $telefon['NrTel'][$i] ."</td>";
			$this->tresc .= "</tr>";
		}
		$this->tresc .= "</table>";
	}
	public function showUzytkownik($uzytkownik, $dzial) {
		$this->tresc .= "<br>";
		$this->tresc .= "<table id=\"uzytkownik\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td>Nazwisko: </td>";
		$this->tresc .= "<td>".$uzytkownik['Nazwa'][0]."</td></tr>";
		$this->tresc .= "<tr><td>Imię: </td>";
		$this->tresc .= "<td>".$uzytkownik['Imie'][0]."</td></tr>";
		$this->tresc .= "<tr><td>Login: </td>";
		$this->tresc .= "<td>".$uzytkownik['Login'][0]."</td></tr>";
		$this->tresc .= "<tr><td>Dział: </td>";
		$this->tresc .= "<td>".$dzial['Nazwa'][0]."</td></tr>";
		$this->tresc .= "</table>";
	}
	public function showUzytkownikTelefony($telefon){
		$this->tresc .= "<br>";
		$this->tresc .= "Numery telefonów: ";
		for ($i = 0; $i <count($telefon['NrTel']); $i++) 
			$this->tresc .= $telefon['NrTel'][$i].', ';
		$this->tresc .= "<br>";
	}
	public function showUzytkownikKomputery($komputer){
		$this->tresc .= "<br>";
		$this->tresc .= "Komputery: <br>";
		$this->tresc .= "<table id=\"komputery\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td>Nazwa: </td>";
		$this->tresc .= "<td>Typ: </td>";
		$this->tresc .= "<td>Ip: </td>";
		$this->tresc .= "<td>Nr Inwent: </td>";
		$this->tresc .= "</tr>";
		
		for ($i = 0; $i <count($telefon['NrTel']); $i++) {
			$this->tresc .= "<tr>";
			$this->tresc .= $komputer['Nazwa'][$i].', ';
			$this->tresc .= $komputer['Typ'][$i].', ';
			$this->tresc .= $komputer['Ip'][$i].', ';
			$this->tresc .= $komputer['Inwent'][$i].', ';
			$this->tresc .= "<tr>";
		}
		$this->tresc .= "</table>";
	}
	
	public function showDzialy($dzial, $uzytkownik, $sortColumn, $sortDirection) {
		if ($sortColumn == "dzl" && $sortDirection == 'a') $srtDirDzl = "&srtdir=d";
			else $srtDirDzl = "&srtdir=a";
		if ($sortColumn == "sbl" && $sortDirection == 'a') $srtDirSbl = "&srtdir=d";
			else $srtDirSbl = "&srtdir=a";
		if ($sortColumn == "nzw" && $sortDirection == 'a') $srtDirNzw = "&srtdir=d";
			else $srtDirNzw = "&srtdir=a";
		if ($sortColumn == "imi" && $sortDirection == 'a') $srtDirImi = "&srtdir=d"; 
			else $srtDirImi = "&srtdir=a";

		$this->tresc .= "<br>";
		$this->tresc .= "<table id=\"dzialy\" class=\"mytable filterable\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=dzl&srtcol=dzl$srtDirDzl><div>Dział</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=dzl&srtcol=sbl$srtDirSbl><div>Symbol</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=dzl&srtcol=nzw$srtDirNzw><div>Nazwisko</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=dzl&srtcol=imi$srtDirImi><div>Imię</div></a></td>";
		$this->tresc .= "</tr>";
						
		for ($i = 0; $i <count($dzial['Id']); $i++) {
			$this->tresc .= "<tr $this->hover>";
			$this->tresc .= "<td>". $dzial['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td>". $dzial['Symbol'][$i] ."</td>";
			$this->tresc .= "<td>". $uzytkownik['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td>". $uzytkownik['Imie'][$i] ."</td>";
			$this->tresc .= "</tr>";
		}
		$this->tresc .= "</table>";
	}
	
	public function showMonitory($komputer, $monitor, $sortColumn, $sortDirection) {
		if ($sortColumn == "dns" && $sortDirection == 'a') $srtDirDns = "&srtdir=d";
			else $srtDirDns = "&srtdir=a";
		if ($sortColumn == "iwk" && $sortDirection == 'a') $srtDirIwk = "&srtdir=d"; 
			else $srtDirIwk = "&srtdir=a";
		if ($sortColumn == "iwm" && $sortDirection == 'a') $srtDirIwm = "&srtdir=d"; 
			else $srtDirIwm = "&srtdir=a";
		if ($sortColumn == "mdm" && $sortDirection == 'a') $srtDirMdm = "&srtdir=d"; 
			else $srtDirMdm = "&srtdir=a";
		if ($sortColumn == "rzm" && $sortDirection == 'a') $srtDirRzm = "&srtdir=d"; 
			else $srtDirRzm = "&srtdir=a";
		$this->tresc .= "<br>";
		$this->tresc .= "<table id=\"monitory\" class=\"mytable filterable\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=mon&srtcol=iwm$srtDirIwm><div>Inwent M</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=mon&srtcol=mdm$srtDirMdm><div>Model</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=mon&srtcol=rzm$srtDirRzm><div>Rozmiar</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=mon&srtcol=iwk$srtDirIwk><div>Inwent K</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=mon&srtcol=dns$srtDirDns><div>Komputer</div></a></td>";
		$this->tresc .= "</tr>";

						
		for ($i = 0; $i <count($komputer['Id']); $i++) {
			$this->tresc .= "<tr  $this->hover>";
			$this->tresc .= "<td>". $monitor['Inwent'][$i] ."</td>";
			$this->tresc .= "<td>". $monitor['Model'][$i] ."</td>";
			$this->tresc .= "<td>". $monitor['Rozmiar'][$i] ."</td>";
			$this->tresc .= "<td><a href=?m=bz&kmp=". $komputer['Id'][$i] .">".$komputer['Inwent'][$i]."</td>";
			$this->tresc .= "<td><a href=?m=bz&kmp=". $komputer['Id'][$i] .">".$komputer['Nazwa'][$i]."</td>";
			$this->tresc .= "</tr>";
		}
		$this->tresc .= "</table>";
	}
		public function showKomputery($komputer, $model, $dzial, $monitor, $podzespol, $sortColumn, $sortDirection) {
		if ($sortColumn == "dns" && $sortDirection == 'a') $srtDirDns = "&srtdir=d";
			else $srtDirDns = "&srtdir=a";
		if ($sortColumn == "mdk" && $sortDirection == 'a') $srtDirMdk = "&srtdir=d";
			else $srtDirMdk = "&srtdir=a";
		if ($sortColumn == "dzl" && $sortDirection == 'a') $srtDirDzl = "&srtdir=d";
			else $srtDirDzl = "&srtdir=a";
		if ($sortColumn == "ipk" && $sortDirection == 'a') $srtDirIpk = "&srtdir=d";
			else $srtDirIpk = "&srtdir=a";
		if ($sortColumn == "typ" && $sortDirection == 'a') $srtDirTyp = "&srtdir=d"; 
			else $srtDirTyp = "&srtdir=a";
		if ($sortColumn == "iwk" && $sortDirection == 'a') $srtDirIwk = "&srtdir=d"; 
			else $srtDirIwk = "&srtdir=a";
		if ($sortColumn == "iwm" && $sortDirection == 'a') $srtDirIwm = "&srtdir=d"; 
			else $srtDirIwm = "&srtdir=a";
		if ($sortColumn == "iwp" && $sortDirection == 'a') $srtDirIwp = "&srtdir=d"; 
			else $srtDirIwp = "&srtdir=a";
		$this->tresc .= "<br>";
		$this->tresc .= "<table id=\"komputery\" class=\"mytable filterable\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=dns$srtDirDns><div>Nazwa</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=mdk$srtDirMdk><div>Model</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=dzl$srtDirDzl><div>Dział</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=ipk$srtDirIpk><div>Adres IP</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=typ$srtDirTyp><div>Typ</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=iwk$srtDirIwk><div>Nr inwent</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=iwm$srtDirIwm><div>Monitor</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=kmp&srtcol=iwp$srtDirIwp><div>UPS</div></a></td>";
		$this->tresc .= "</tr>";

						
		for ($i = 0; $i <count($komputer['Id']); $i++) {
			$this->tresc .= "<tr  $this->hover>";
			$this->tresc .= "<td><a href=?m=bz&kmp=". $komputer['Id'][$i] .">".$komputer['Nazwa'][$i]."</td>";
			$this->tresc .= "<td><a href=?m=bz&mdl=". $model['Id'][$i] .">". $model['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td><a href=?m=bz&dzl=". $dzial['Id'][$i] .">". $dzial['Symbol'][$i] ."</td>";
			$this->tresc .= "<td>". $komputer['Ip'][$i] ."</td>";
			$this->tresc .= "<td>". $komputer['Typ'][$i] ."</td>";
			$this->tresc .= "<td>". $komputer['Inwent'][$i] ."</td>";
			$this->tresc .= "<td>". $monitor['Inwent'][$i] ."</td>";
			$this->tresc .= "<td>". $podzespol['Inwent'][$i] ."</td>";
			$this->tresc .= "</tr>";
		}
		$this->tresc .= "</table>";
	}
	public function showDrukarki($drukarka, $dzial, $sortColumn, $sortDirection) {
		if ($sortColumn == "nzw" && $sortDirection == 'a') $srtDirNzw = "&srtdir=d";
			else $srtDirNzw = "&srtdir=a";
		if ($sortColumn == "typ" && $sortDirection == 'a') $srtDirTyp = "&srtdir=d";
			else $srtDirTyp = "&srtdir=a";
		if ($sortColumn == "ipd" && $sortDirection == 'a') $srtDirIpd = "&srtdir=d";
			else $srtDirIpd = "&srtdir=a";
		if ($sortColumn == "udl" && $sortDirection == 'a') $srtDirUdl = "&srtdir=d"; 
			else $srtDirUdl = "&srtdir=a";
		if ($sortColumn == "iwd" && $sortDirection == 'a') $srtDirIwd = "&srtdir=d"; 
			else $srtDirIwd = "&srtdir=a";
		if ($sortColumn == "sbl" && $sortDirection == 'a') $srtDirSbl = "&srtdir=d"; 
			else $srtDirSbl = "&srtdir=a";
		$this->tresc .= "<br>";
		$this->tresc .= "<table id=\"drukarki\" class=\"mytable filterable\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=drk&srtcol=nzw$srtDirNzw><div>Nazwa Drukarki</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=drk&srtcol=typ$srtDirTyp><div>Typ</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=drk&srtcol=ipd$srtDirIpd><div>Adres IP</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=drk&srtcol=udl$srtDirUdl><div>Udział</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=drk&srtcol=iwd$srtDirIwd><div>Nr inwent</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=drk&srtcol=sbl$srtDirSbl><div>Dział</div></a></td>";
		$this->tresc .= "</tr>";
						
		for ($i = 0; $i <count($drukarka['Id']); $i++) {
			$this->tresc .= "<tr class=hov  $this->hover>";
			$this->tresc .= "<td>". $drukarka['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td>". $drukarka['Typ'][$i] ."</td>";
			$this->tresc .= "<td>". $drukarka['Ip'][$i] ."</td>";
			$this->tresc .= "<td>". $drukarka['Udzial'][$i] ."</td>";
			$this->tresc .= "<td>". $drukarka['Inwent'][$i] ."</td>";
			$this->tresc .= "<td>". $dzial['Symbol'][$i] ."</td>";
			$this->tresc .= "</tr>";
		}
		$this->tresc .= "</table>";
	}
	public function showProgramy($program, $sortColumn, $sortDirection) {
		if ($sortColumn == "nzw" && $sortDirection == 'a') $srtDirNzw = "&srtdir=d";
			else $srtDirNzw = "&srtdir=a";
		if ($sortColumn == "dat" && $sortDirection == 'a') $srtDirDat = "&srtdir=d";
			else $srtDirDat = "&srtdir=a";
		if ($sortColumn == "rdz" && $sortDirection == 'a') $srtDirRdz = "&srtdir=d";
			else $srtDirRdz = "&srtdir=a";
		if ($sortColumn == "ilc" && $sortDirection == 'a') $srtDirIlc = "&srtdir=d"; 
			else $srtDirIlc = "&srtdir=a";
		if ($sortColumn == "ius" && $sortDirection == 'a') $srtDirIus = "&srtdir=d"; 
			else $srtDirIus = "&srtdir=a";
		if ($sortColumn == "izt" && $sortDirection == 'a') $srtDirIzt = "&srtdir=d"; 
			else $srtDirIzt = "&srtdir=a";
		$this->tresc .= "<br>";
		$this->tresc .= "<input type=checkbox checked=checked id=os>";
		$this->tresc .= "<label for=os>Systemy Operacyjne</label>";
		$this->tresc .= "<input type=checkbox checked=checked id=usr>";
		$this->tresc .= "<label for=usr>Programy użytkowe</label>";
		$this->tresc .= "<input type=checkbox checked=checked id=rst>";
		$this->tresc .= "<label for=rst>Pozostałe Programy</label>";
		$this->tresc .= "<table id=programy class=\"mytable filterable\">";
		$this->tresc .= "<tr>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=prg&srtcol=nzw$srtDirNzw><div>Nazwa Programu</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=prg&srtcol=dat$srtDirDat><div>Data zakupu</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=prg&srtcol=rdz$srtDirRdz><div>Rodzaj licencji</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=prg&srtcol=ilc$srtDirIlc><div>Ilość</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=prg&srtcol=ius$srtDirIus><div>Instal</div></a></td>";
		$this->tresc .= "<td><a class=\"nag\" href=?m=bz&mt=prg&srtcol=izt$srtDirIzt><div>reszta</div></a></td>";
		$this->tresc .= "</tr>";
						
		for ($i = 0; $i <count($program['Id']); $i++) {
			$this->tresc .= "<tr class=". $program['Typ'][$i] ."  $this->hover>";
			$this->tresc .= "<td>". $program['Nazwa'][$i] ."</td>";
			$this->tresc .= "<td>". $program['Data'][$i] ."</td>";
			$this->tresc .= "<td>". $program['Rodzaj'][$i] ."</td>";
			$this->tresc .= "<td>". $program['IloscP'][$i] ."</td>";
			$this->tresc .= "<td>". $program['IloscI'][$i] ."</td>";
			$this->tresc .= "<td>". $program['IloscR'][$i] ."</td>";
			$this->tresc .= "</tr>";
		}
		$this->tresc .= "</table>";
		$this->tresc .= "<script>";
		$this->tresc .= "$(\"#os\").click(function () {";
		$this->tresc .= "$(\".1\").toggle(\"slow\")";
		$this->tresc .= "});";
		$this->tresc .= "$(\"#usr\").click(function () {";
		$this->tresc .= "$(\".2\").toggle(\"slow\")";
		$this->tresc .= "});";
		$this->tresc .= "$(\"#rst\").click(function () {";
		$this->tresc .= "$(\".3\").toggle(\"slow\")";
		$this->tresc .= "});";            
		$this->tresc .= "</script>";
	}
	
	public function echoStrona() {
		echo $this->head;
		echo $this->top;
		echo $this->menu;
		echo $this->login;
		echo $this->hr;
		echo $this->tresc;
		echo $this->bottom;
	}
	public function logIn($user, $password) {
	}
		
}


?>