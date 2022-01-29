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
		  <a href=?dokumenty_wew class="it">Dokumenty działowe</a>	
		  </li>
		  <li>
		  <a href=?iBOK class="it">iBOK</a>	
		  </li>
		  <li>
		  <a href=?instrukcje_sod class="it">Instrukcje SOD</a>	
		  </li>
		  <li>
		  <a href=?mapy_cyfrowe class="it">Instrukcje Mapy Cyfrowe</a>	
		  </li>
		  <li>
		  <a href=?kursy class="l_wnioski">Kursy</a>	
		  </li>
		  <li>
		  <a href=?PPK class="PPK">PPK</a>	
		  </li>
		  <li>
		  <a href=?raporty class="it">Raporty</a>	
		  </li>
		  <li>
		  <a href=?RODO class="it">RODO</a>	
		  </li>
		  <li>
		  <a href=?telefony class="it">Telefony</a>	
		  </li>
          <li>
		  <a href=?teleinformatyka class="it">Teleinformatyka</a>	
		  </li>

		<a href = "file://backupsrv/dokumenty_spółki" class="l_dokumenty"></a>
		<a class="l_instrukcje"><div></div></a>
	  </div>
	  
	  <div id="TRESC">

	  <?php

	  if (isset($_GET['dokumenty_wew']) && !isset($_GET['dep'])) {
		echo "
		  <ul id='pliki-ul'>
		    <li>
			  <a href=?dokumenty_wew&dep=fk>
			  Dział FK
			  </a>
			</li>
			<li>
			  <a href=?dokumenty_wew&dep=kz>
			  Dział KZ
			  </a>
			</li>
			<li>
			  <a href=?dokumenty_wew&dep=sp>
			  Dział SP
			  </a>
			</li>
			<li>
			  <a href=?dokumenty_wew&dep=ta>
			  Dział TA
			  </a>
			</li>
			<li>
			  <a href=?dokumenty_wew&dep=tf>
			  Dział TF
			  </a>
			</li>
		</ul>
		";
	  }
	  else if (isset($_GET['dokumenty_wew']) && isset($_GET['dep'])) {
		if ($_GET['dep'] == 'tf') {
			echo "
			<ul id='pliki-ul'>
				<li>
					<a href=/pliki/dokumenty/$_GET[dep]/4101847164.xls>
					Orange - wniosek o nadzór
					</a>
				</li>
				<li>
					<a href=?dokumenty_wew>
					<br>
					powrót
					</a>
				</li>
			</ul>
		";
		}
		else if ($_GET['dep'] == 'kz') {
			echo "
			<ul id='pliki-ul'>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Formularz zapotrzebowanie.docx\">
					Formularz zapotrzebowanie
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wykaz pozycji HZP w roku 2016.pdf\">
					Wykaz pozycji HZP w roku 2016
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wykaz pozycji HZP w roku 2017.pdf\">
					Wykaz pozycji HZP w roku 2017
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wykaz pozycji HZP w roku 2018.pdf\">
					Wykaz pozycji HZP w roku 2018
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wykaz pozycji HZP w roku 2019 v2.pdf\">
					Wykaz pozycji HZP w roku 2019
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Ścieżki akceptacji dla wniosków zakupowych składanych z wykorzystaniem platformy logintrade - obowiązuje od 2019-01-07.pdf\">
					Ścieżka akceptacji zamówień dla wniosków zakupowych wer. 2019-07-01
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek o wszczęcie postępowania o udzielenie zamówienia publicznego bez podziału na zadania 2020-01-01.docx\">
					Wniosek o wszczęcie postępowania o udzielenie zamówienia publicznego bez podziału na zadania 2020-01-01
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek o wszczęcie postępowania o udzielenie zamówienia publicznego z podziałem na zadania 2020-01-01.docx\">
					Wniosek o wszczęcie postępowania o udzielenie zamówienia publicznego z podziałem na zadania 2020-01-01
					</a>
				</li>
				<li>
					<a href=?dokumenty_wew>
					<br>
					powrót
					</a>
				</li>
			</ul>
		";
		}
		else if ($_GET['dep'] == 'fk') {
			echo "
			<ul id='pliki-ul'>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/blankiet polecenia przelewu pusty.doc\">
					Polecenie przelewu
					</a>
				</li>
				<li>
					<a href=?dokumenty_wew>
					<br>
					powrót
					</a>
				</li>
			</ul>
		";
		}
		else if ($_GET['dep'] == 'ta') {
			echo "
			<ul id='pliki-ul'>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/zlecenie prac geodezyjnych.pdf\">
					Zlecenie prac geodezyjnych
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/reklamacja zaopatrzenie.pdf\">
					Reklamacja - zaopatrzenie
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek MZUiM.pdf\">
					Wniosek o wydanie zezwolenia na zajęcie pasa drogowego drogi publicznej
					</a>
				</li>
				<li>
					<a href=?dokumenty_wew>
					<br>
					powrót
					</a>
				</li>
			</ul>
		";
		}
		else if ($_GET['dep'] == 'sp') {
			echo "
			<ul id='pliki-ul'>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek o anulowanie faktury.doc\">
					Wniosek o anulowanie faktury
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek o dodanie usługi do Wykazu usług świadczonych przez RPWiK Tychy S.A..xls\">
					Wniosek o dodanie usługi do Wykazu usług
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek o wystawienie faktury - faktury PRO-FORMA.doc\">
					Wniosek o wystawienie faktury PRO-FORMA
					</a>
				</li>
				<li>
					<a href=\"/pliki/dokumenty/$_GET[dep]/Wniosek o wystawienie faktury korygującej.doc\">
					Wniosek o wystawienie faktury korygującej
					</a>
				</li>
				<li>
					<a href=?dokumenty_wew>
					<br>
					powrót
					</a>
				</li>
			</ul>
		";
		}

	}
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
 if (isset($_GET['instrukcje_sod'])) {
		echo "
		  <ul id='pliki-ul'>
			<li>
			  <a href=/pliki/instrukcje/SOD/SOD_Instr.1-Wpłynął_dokument_do_Działu_Administracji.pdf>
			  Wpłynął dokument do spółki
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/SOD/SOD_Instr.2-Zastępstwo_w_SOD.pdf>
			  Zastępstwo w SOD
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/SOD/SOD_Instr.3-Pismo_do_kontrahenta.pdf>
			  Pismo do kontrahenta
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/SOD/SOD_Instr.4-Zgłoszenia_iBOK.pdf>
			  Zgłoszenia iBOK
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/SOD/SOD_Instr.5-Wiadomość_dla_klienta_iBOK.pdf>
			  Wiadomość dla klienta iBOK
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/SOD/zarzadzenie_nr_22_2016_FA.pdf>
			  Zarządzenie w sprawie zasad przetwarzania korespondencji
			  </a>
			</li>						
			<li>
			  <a href=/pliki/instrukcje/SOD/Załacznik_do_zarzadzenia_nr_22_2016_FA.docx>
			  Załacznik do powyższego zarządzenia
			  </a>
			</li>			
		";
	  }

if (isset($_GET['mapy_cyfrowe'])) 

	{
		echo 	"
		  	<ul id='pliki-ul'>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_tablety.pdf>
			  Instrukcja obsługi tabletów
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_uzytkownika_ekartanalyst.pdf>
			  Instrukcja obsługi systemu eKartAnalyst
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_przeglądy_hydrantów.pdf>
			  Instrukcja modułu - Przegląd Hydrantów
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_przeglądy_hydrantów_rozszerzona.pdf>
			  Instrukcja modułu - Przegląd Hydrantów - moduł rozszerzony
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_modul_dyspozytorski.pdf>
			  Instrukcja modułu - Moduł Dyspozytorski
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_wewnętrzna_modul_dyspozytorsk_operator_terenowy.pdf>
			  Instrukcja wewnętrzna - Moduł Dyspozytorski - Operator Terenowy
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_wewnętrzna_modul_dyspozytorski_dyspozytor.pdf>
			  Instrukcja wewnętrzna - Moduł Dyspozytorski - Dyspozytor
			  </a>
			</li>
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/Instrukcja_wewnętrzna_Moduł_Dyspozytorski_Automatyczne_Nadawanie_Numerów_Zleceń.pdf>
			  Instrukcja wewnętrzna - Moduł Dyspozytorski - Automatyczne Nadadawanie Numerów Zleceń
			  </a>
			</li>	
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_zajętość_pasa.pdf>
			  Instrukcja wewnętrzna - Muduł Dyspozytorski - Zajętość Pasa
			  </a>
			</li>	
			<li>
			  <a href=/pliki/instrukcje/mapy_cyfrowe/instrukcja_moduł_służebności_przesyłu.pdf>
			  Instrukcja wewnętrzna - Służebność Przesyłu
			  </a>
			</li>							
			";
	}





	 if (isset($_GET['it'])) 
		{
		echo "
		  <ul id='pliki-ul'>
			<li>
			  <B>SCHEMATY</B><BR><BR>
			  </a>
			</li>
			<li>
			  <a href=/pliki/schematy/Adresacja_WAN_2014.pdf>
			  1. Adresacja WAN 2014
			  </a>
			</li>
			<li>
			  <a href=/pliki/schematy/Komunikacja_VoIP.pdf>
			  2. Komunikacja VoIP
			  </a>
			</li>
			<li>
			  <a href=/pliki/schematy/Komunikacja_z_oddzialami_IPSec_CISCO.pdf>
			  3. Komunikacja z oddziałami IPSec CISCO
			  </a>
			</li>
			<li>
			  <a href=/pliki/schematy/Struktury_Archiwizacji_Danych.pdf>
			  4. Struktury Archiwizacji Danych
			  </a>
			</li>
		";
	  	}
		
if (isset($_GET['iBOK'])) 
		{
		echo "
		  <ul id='pliki-ul'>
			<li>
			  <a href=/pliki/iBOK/charakterystyka_iBOK.pdf>
			  Krótka charakterystyka iBOK 
			  </a>
			</li>
			<li>
			  <a href=/pliki/iBOK/sms.pdf>
			  Wykaz treści wysyłanych sms-ów wraz z czasem wysyłania oraz metodą 
			  </a>
			</li>
			<li>
			  <a href=/pliki/iBOK/mail.pdf>
			   Wykaz treści wysyłanych pocztą elektroniczną ze wskazaniem na metodę oraz plan czasowy.
			  </a>
			</li>
			<li>
			  <a href=/pliki/iBOK/ibok_sod.pdf>
			  Wykaz spraw w korelacji iBOK <---> SOD 
			  </a>
			</li>
		
		";
		}
		
if (isset($_GET['telefony'])) 
		{
		echo "
		  <ul id='pliki-ul'>
			<li>
			  <a href=/pliki/telefony/nr_telefonów_wew.pdf>
			  Telefony wewnętrzne
			  </a>
			</li>
			<!-- <a href=/pliki/telefony/telefony.html>Telefony </a>		-->
		";
		}

if (isset($_GET['teleinformatyka']) && !isset($_GET['dep']))
		{
		echo "
		  <ul id='pliki-ul'>
			
			<li>
			  	<a href=?teleinformatyka&dep=schematy>
			  	Schematy
			  	</a>
			</li>	
          ";
          }

if (isset($_GET['teleinformatyka']) && isset($_GET['dep']))
        {
            if ($_GET['dep'] == 'schematy')
            {
            echo "
            <ul id='pliki-ul'>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Adresacja_WAN_2014.pdf>
				1. Adresacja WAN 2014
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/KartGIS_obsługa_nr_zleceń.pdf>
				2. KartGIS obsługa nr zleceń
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Komunikacja_VoIP.pdf>
				3. Komunikacja VoIP
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Komunikacja_z_oddzialami_IPSec_CISCO.pdf>
				4. Komunikacja z oddziałami IPSec CISCO
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Komunikacja_z_oddzialami_VOIP.pdf>
				5. Komunikacja z oddzialami VOIP
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_Centrala_IVR_2019.pdf>
				6. Schemat algorytmu komunikatów głosowych IVR w RPWiK Tychy S.A.
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_Obiegu_Dokumentów.pdf>
				7. Schemat funkcjonalny Systemu Obiegu Dokumentów
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/macierzSSD_z_SAN_I_DB_SQL1.pdf>
				8. Schemat podłączenia systemu macierzy dyskowej SSD i serwerów baz danych
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_FIrewall_RODO.pdf>
				9. Schemat przetwarzania informacji
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_infrastruktury.pdf>
				10. Schemat infrastruktury 
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_infrastruktury_2007-2010.pdf>
				11. Schemat infrastruktury 2007
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_komunikacji_awaryjnej_z_oddziałami_IPSec.pdf>
				12. Schemat komunikacji awaryjnej z oddziałami RPWiK Tychy S.A. IPSec - 3Des
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Schemat_APN.pdf>
				13. Schemat przesyłu danych RPWiK Tychy S.A. - APN
				</a>
			</li>
			<li>
				<a href=/pliki/teleinformatyka/schematy/Struktury_Archiwizacji_Danych.pdf>
				14. Schemat struktur archiwizacji danych
				</a>
			</li>
			<li>
					<a href=?l_glowna>
					<br>
					powrót
					</a>
				</li>
            </ul>
        ";
            }
        }



if (isset($_GET['PPK'])) 
		{
		echo "
		  <ul id='pliki-ul'>
			<li>
			  <a href=/pliki/PPK/PPK_prezentacja_dla_pracownika.pdf>
			  Pracownicze Plany Kapitałowe - Prezentacja 
			  </a>
			</li>
			<li>
			  <a href=/pliki/PPK/QA.pdf>
			  PPK w pytaniach i odpowiedziach
			  </a>
			</li>
			<li>
				<a target='_blank' href='https://www.pkotfi.pl/ppk-z-pko-tfi/kalkulator-ppk-pracowniczych-planow-kapitalowych/'>
				Kalkulator dodatkowej emerytury 
				</a>
			</li>		
		";
		}




if (isset($_GET['raporty'])) 
		{
		echo "
		  <ul id='pliki-ul'>
			<li>
			<a target='_blank' href='http://w16sq2/Raporty/report/Dzia%C5%82%20Sprzeda%C5%BCy%20i%20Controllingu/RAPORT%20ZU%C5%BBY%C4%86'>
			  Raport zużyć - Dział FS 
			  </a>
			</li>
			<li>
			</li>
			
		";
		}


if (isset($_GET['RODO']) && !isset($_GET['dep']))
		{
		echo "
		  <ul id='pliki-ul'>
			<li>
				<a target='_blank' href='https://rpwik.fiblearning.pl/account/'>
				Platforma szkoleniowa - RODO 
				</a>
			</li>

			<li>				
				<a href=/pliki/dokumenty/RODO/Prezentacja_RODO_2019.pdf>
				Szkolenie RODO 2019 r.
				</a>
			</li>
			
			<li>
			  	<a href=?RODO&dep=IKONOGRAFIKI>
			  	IKONOGRAFIKI
			  	</a>
			</li>

			<li>
			  	<a href=?RODO&dep=SZBI>
			  	System Zarządzania Bezpieczeństwem Informacji
			  	</a>
			</li>

		  </ul>
		";
	 	}

if (isset($_GET['RODO']) && isset($_GET['dep'])) 
		{
			if ($_GET['dep'] == 'IKONOGRAFIKI') 
				{
				echo "
				<ul id='pliki-ul'>
					<li>
					<a href=/pliki/dokumenty/RODO/Monitoring.pdf>
					Monitoring
					</a>
					</li>
			
					<li>
					<a href=?RODO>
					<br>
					powrót
					</a>
					</li>				
				</ul>
				";
				}			
		}

if (isset($_GET['RODO']) && isset($_GET['dep'])) 
		{
			if ($_GET['dep'] == 'SZBI') 
				{
				echo "
				<ul id='pliki-ul'>
					<li>
					<a href=/pliki/dokumenty/RODO/Uchwala.pdf>
					<b>Uchwała Zarządu RPWiK Tychy S.A. nr 105/V/10 w dnia 9 kwietnia 2019 roku</b>
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/PBI.pdf>
					Polityka Bezpieczeństwa Informacji
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/RCPDO.pdf>
					Rejestr czynności przetwarzania danych sobowych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/SPDPPS.pdf>
					Sposób przepływu danych pomiędzy poszczególnymi systemami
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/RODO.pdf>
					Regulamin ochrony danych osobowych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/PNUDPDO.pdf>
					Procedura nadawania uprawnień do przetwarzania danych osobowych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/UDPDO.pdf>
					Upoważnienie do przetwarzania danych osobowych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/PPZOSI.pdf>
					Polityka Pracy Zdalnej oraz Systemu Informatycznego
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/PPZDOPRIWTZ.pdf>
					Procedura postępowania z danymi osobowymi podczas rekrutacji i w trakcie zatrudnienia
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/IODNTZM.pdf>
					Informacja o działającym na terenie zakładu systemu monitoringu
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/PBT.pdf>
					Polityka Bezpieczeństwa Teleinformatycznego
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/SNUIT.pdf>
					Schemat nadawania uprawnień IT
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/PZIZZBI.pdf>
					Procedura zarządzania incydentami związanymi z bezpieczeństwem informacji
					</a>
					</li>

					<li>
					<br><br><b>
					<a href=?RODO&dep=SZBI>
					Wzory dokumentów do pobrania:
					</a></b>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/KIDP.pdf>
					Klauzula informacyjna dla pracownika RPWiK Tychy S.A.
					</a>
					</li>


					<li>
					<a href=/pliki/dokumenty/RODO/UPPDO.docx>
					Umowa powierzenia przetwarzania danych osobowych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/KPIiDwZISRP.docx>
					Klauzula poufności informacji i DEKLARACJA w zakresie informacji stanowiących tajemnicę przedsiębiorstwa
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/KPIiDwZISRP-Interpretacja.pdf>
					Klauzula poufności informacji i DEKLARACJA w zakresie informacji stanowiących tajemnicę przedsiębiorstwa - INTERPRETACJA
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/KODOUSOZ.docx>
					Kwestionariusz osobowy dla osoby ubiegającej sie o zatrudnienie
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/ZNPDO.docx>
					Zgoda na przetwarzanie danych osobowych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/KODP.docx>
					Kwestionariusz osobowy dla pracownika
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/ZNPDSK.docx>
					Zgoda na przetwarzanie danych szczególnych kategorii
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/ZPNPDWPW.docx>
					Zgoda pracownika na przetwarzanie danych w postaci wizerunku.docx
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/KZNPDOPT.docx>
					Klauzula zgody na przetwarzanie danych osobowych pracownika tymczasowego
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/FRZPD.docx>
					Formularz realizacji żądań podmiotu danych
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/IDPODP.docx>
					Informacja dla pracownika o dokumentacji pracowniczej
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/ZOZKP.docx>
					Zawiadomienie o zastosowaniu kary porządkowej
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/OOZSZPBDO_a.docx>
					Oświadczenie o zapoznaniu się z przepisami bezpieczeństwa danych osobowych
					</a>
					</li>


					<li>
					<a href=/pliki/dokumenty/RODO/OOZSZPBDO_b.docx>
					Oświadczenie o zapoznaniu się z przepisami bezpieczeństwa danych osobowych - pracownicy obcy
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/IODNTZM.docx>
					Informacja o działającym na terenie zakładu systemu monitoringu - formularz
					</a>
					</li>

					<li>
					<a href=/pliki/dokumenty/RODO/Nowe_oswiadczenie_do_celow_podatkowych_i_ubezpieczeniowych_2019.docx>
					Oświadczenie do celów podatkowych i ubezpieczeniowych
					</a>
					</li>

			
					<li>
					<a href=?RODO>
					<br>
					powrót
					</a>
					</li>				
				</ul>
				";
				}			
		}

	  ?>
	  </div>
	  <div id="BOTTOM"><img src="img\bottom.jpg" /></div>
	</div>
  </body>
</html>
<?php
?>
