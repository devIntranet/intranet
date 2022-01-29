<B>GENEROWANIE PLIKU SWRK</B>
<BR><BR>

<?php
	error_reporting(E_ALL); 
	date_default_timezone_set('Europe/Warsaw');

	if(version_compare(PHP_VERSION, '5.3.0', '<'))
		{
	    	set_magic_quotes_runtime(0);
		}

	if(get_magic_quotes_runtime())
	{
	    // Deactivate
	    set_magic_quotes_runtime(false);
	}




	//date_default_timezone_set("Warsaw");
	//phpinfo();

	$server = '192.168.1.108';
	$user = 'export_rcgw';
	$pass = 'Rcgw2014';
	
	$connectionInfo = array( "UID"=>$user,"PWD"=>$pass,"Database"=>"tychy1");		
	
	
	$link = sqlsrv_connect($server,$connectionInfo);
	if (!$link) 
		{
		die( print_r( sqlsrv_errors(), true));
		//die('Nie udało się połączyć z bazą');
		//echo "nic";
		}


	else
		{
		echo '<I>Nawiązano połączenie z bazą danych...</I>';
		echo '<BR><BR>';
		$dane_form = $_GET['f0'];
		echo '<I>Wybrano datę rejestru księgowego: </I>'.$dane_form;
		echo '<BR><BR>';

		
		// otwarcie pliku do zapisu
		$day   = date('d'); // dzie�
		$month = date('m'); // miesi�c
		$year  = date('y'); // rok
		$Year  = date('Y'); // ca�y rok

		$rok = substr($dane_form, 0, 4);
		$rok_krotki = substr($dane_form, 2, 2);
		$miesiac = substr($dane_form, 5, 2);
		$dzien = substr($dane_form, 8, 2);
		
		//echo '<BR>';
		//echo $rok;
		//echo '<BR>';
		//echo $miesiac;
		//echo '<BR>';
		//echo $dzien;
		//echo '<BR>';
		//echo $rok_krotki;


		$plik = "PLIKI/BLB".$rok_krotki.$miesiac.$dzien."01".".DRR";
		//$plik = "PLIKI/BLB".$year.$month.$day."01".".DRR";
	 	$fp = fopen($plik, "w+");


		$SqlQuery = "select * from rapkasrcgw ('$dane_form')";

		$result = sqlsrv_query($link,$SqlQuery) or die("Błędne zapytanie");

		echo "
			<TABLE border='1' cellspacing='0' cellpadding='10' colspan='1'>
				<TR>
					<TD>TREŚĆ</TD>
					<TD>KOD KRESKOWY</TD>
					<TD>KTR</TD>
					<TD>KOD</TD>
					<TD>ROK</TD>
					<TD>NUMER RAPORTU</TD>
					<TD>NR POZYCJI</TD>
					<TD>DATA PłATNOśCI</TD>
					<TD>PREFIKS</TD>
					<TD>PREFIKS C</TD>
					<TD>NR FAKTURY</TD>
					<TD>NR ABONENTA</TD>
					<TD>NR FAKTURY I NR ABONENTA</TD>
					<TD>KWOTA PłATNOŚCI</TD>
					<TD>CYFRA KONTROLNA</TD>				
				</TR>
		     ";


		// stworzenie nowych danych - NAG��WEK

		$kwota = 0;
		$liczba = 0;
		
		while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) )
				{
				$kwota = $kwota + $row['KWOTA_PLATNOSCI'];
				$liczba = $liczba + 1;
				}


 		$naglowek  = "H;".$rok.$miesiac.$dzien.";"."BLB".$rok_krotki.$miesiac.$dzien."01".".DRR".";0;0;".$rok.$miesiac.$dzien.";".$kwota.";0;0;0;0;\r\n";

		// zapisanie danych
		fputs($fp, $naglowek);
		

		// stworzenie nowych danych - POZYCJE

		$SqlQuery = "select * from rapkasrcgw ('$dane_form')";

		$result = sqlsrv_query($link,$SqlQuery) or die("Błędne zapytanie");
		
		while( $row = sqlsrv_fetch_array( $result, SQLSRV_FETCH_ASSOC) )
				{
				echo "<TR><TD>"
				.$row['tresc']."</TD><TD>"
				.$row['KOD_KRESKOWY']."</TD><TD>"
				.$row['ktr']."</TD><TD>"
				.$row['KOD']."</TD><TD>"
				.$row['Rok']."</TD><TD>"
				.$row['NumerRap']."</TD><TD>"
				.$row['Nr_poz']."</TD><TD>"
				.$row['DATA_PLATNOSCI']."</TD><TD>"
				.$row['PREFIKS']."</TD><TD>"
				.$row['prefiks_C']."</TD><TD>"
				.$row['NUMER_FAKTURY']."</TD><TD>"
				.$row['NUMER_ABONENTA']."</TD><TD>"
				.$row['NUMER_FAKTURY_NUMER_ABONENTA']."</TD><TD>"
				.$row['KWOTA_PLATNOSCI']."</TD><TD>"
				.$row['cyfra_kontrolna']."</TD></TR>";

				$data_transakcji = $row['DATA_PLATNOSCI'];
				$nowe = str_replace("-","",$data_transakcji); 
		
				$pozycja = "P;0;0;".$row['KWOTA_PLATNOSCI'].";".$nowe.";0;".$row['NUMER_FAKTURY_NUMER_ABONENTA'].";".$row['KOD_KRESKOWY'].";\r\n";
				fputs($fp, $pozycja);			
				}
		echo '</TABLE>';


		// stworzenie nowych danych - STOPKA

		$stopka  = "T;".$liczba.";".$kwota.";0\r\n";
		fputs($fp, $stopka);

		//


		sqlsrv_close($link);

		echo '<I><BR>...dane zostały wygenerowane</I><BR>';
		echo '<I>Zamknięto połączenie z bazą danych.</I><BR>';

		// zamkni�cie pliku
		fclose($fp);
		}



	require("PHPMailer-FE_v4.1/class.phpmailer.php");
	require("mailconnauth2.php");
	$mail->SMTPDebug = 2;
	$mail->IsHTML(true);
	$mail->CharSet = "UTF-8";
	$mail->Subject = "Wygenerowany plik SWRK";//temat maila

	// w zmiennej $text_body wpisujemy tre�� maila

	$data=date("Y-m-d");
	$czas=date("H:i");	

	$text_body = "Wygenerowany plik w załączniku o nazwie BLB".$rok_krotki.$miesiac.$dzien."01".".DRR"."\n"."Data i czas wygenerowania pliku: ".$data." ".$czas;
	$mail->Body = $text_body;

	// adresat�w dodajemy poprzez metode 'AddAddress'
	//$mail->AddAddress("darekm@rpwik.tychy.pl;sebastianj@rpwik.tychy.pl","Dzia� NI");

	$mail->AddAddress("jerzy@rpwiktychy.local","Eksport SWRK");
	$mail->AddAddress("dariuszm@rpwiktychy.local","Eksport SWRK");
	$mail->AddAddress("joannat@rpwiktychy.local","Eksport SWRK");
	$mail->AddAddress("elzbietam@rpwiktychy.local","Eksport SWRK");
	$mail->AddAddress("dariuszw@rpwiktychy.local","Eksport SWRK");
	
	$nowy_plik = "BLB".$rok_krotki.$miesiac.$dzien."01".".DRR";
	$mail->AddAttachment($plik, $nowy_plik); 

	if(!$mail->Send()) {
		echo "Błąd podczas wysyłania powiadomienia<br>";
		echo $mail->ErrorInfo."<br>";
	}

	else {
		// Clear all addresses and attachments
		$mail->ClearAddresses();
		$mail->ClearAttachments();
		echo "<br><br>Powiadomienie wysłano... <br>";
	}


	// Nag��wek sekcji:
	//echo time(); 


	//$fp = fopen("PLIKI/test.txt", "r");
	// $tekst = fread($fp, 10);

	// echo "Stron� wy�wietlono dnia $data o godzinie $czas";
	echo '<img src="Logo.png" align="left">';


?>




