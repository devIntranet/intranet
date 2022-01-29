<?
require_once('fpdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage();    //dodaje now� stron� do dokumentu
$pdf->AddFont('georgia','','georgia.php');  //dodaje Twoj� czcionk� arialpl do dokumentu
$pdf->SetFont('georgia','',20);     //ustawia czcionk� arialpl, rozmiar 20
$pdf->Text(10,10, 'Witaj �wiecie. To jest tekst bez zawijania');  //tekst bez zawijania na pozycji x=10, y=10
$pdf->SetFont('georgia','',14);
$pdf->Multicell(0,4, 'Ten tekst z zamierzenia mia� by� d�ugi, w ka�dym razie raczej nie powinien zmie�ci� si� w jednej linijce, ale nie ma �adnego problemu, funkcja Multicell() s�u�y do wprowadzania tekstu z zawijaniem, ba je�li tekst b�dzie d�u�szy od strony, utworzy ona now�! ',0, 'J',0);   //tekst wieloliniowy o szeroko�ci do prawej linii, wysoko�ci linii 4, bez ramki, wyjustowany, bez t�a
/* Dopisuje niebieski podkre�lony odno�nik */
$pdf->SetFont('georgia','',14);
$pdf->Write(10,'Zapraszam na ');
$pdf->SetTextColor(0,0,255); //zmienia kolor czcionki
$pdf->SetFont('','U');  //zmienia styl czcionki na podkre�lenie
$pdf->Write(10,'4programmers.net','http://4programmers.net');
$iks = $pdf->GetX;
$igrek = $pdf->GetY;
$pdf->Line($iks, $igrek+2,200, $igrek+2);  //wstawia lini� 2mm pod tekstem, o d�ugo�ci 200mm.
/* narysuje granatowy prostok�t z zielonym wype�nieniem */
$pdf->SetDrawColor(170,255,64);
$pdf->SetFillColor(54,255,102);
$pdf->Rect($iks+20, $igrek+20,200,100);
$ident = $pdf->AddLink();
$pdf->SetLink($ident,0,2);  //tworzy (ale nie wstawia do dokumentu!) link do strony 2
$tekst = 'Tu znajduje si� link do nast�pnej strony!';
$dlugosc_tekstu = $pdf->GetStringWidth($tekst);  //oblicza d�ugo�� tekstu
$pdf->Text($pdf->GetX(),$pdf->GetY(),$tekst);  //wstawia tekst do dokumentu
$pdf->Link($pdf->GetX(),$pdf->GetY(),$dlugosc_tekstu,20, $ident);   //wstawia pod tekstem link do dokumentu
$pdf->AddPage(); //dodaje now� stron�.
$pdf->Image('derby.jpeg', $pdf->GetX()+10, $pdf->GetY()+10, 123, 240, 'JPG');
$pdf->SetFont('georgia','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Text($pdf->GetX(),$pdf->GetY()+1, 'i to by by�o na tyle');
$pdf->SetCompression(true);  //w��cza kompresj� dokumentu

/* a poni�sze tylko dla ambitnych */
$pdf->SetAuthor('Ceer');  //ustawia autora dokumentu
$pdf->SetCreator('Dokument generowany przy pomocy skryptu');  //ustawia generator dokumentu
$pdf->SetKeywords('s�owo_kluczowe1, s�owo_kluczowe2');  //ustawia s�owa kluczowe dokumentu
$pdf->SetSubject('Nauka dynamicznego tworzenia PDF�w');  //ustawia temat dokumentu
$pdf->SetTitle('Jak �atwo stworzy� PDFa');  //ustawia tytu� dokumentu

$pdf->SetDisplayMode(100);  //domy�lne powi�kszenie dokumentu w przegl�darce
$pdf->SetMargins(20, 20 , 20);  //ustawia marginesy dla dokumentu

/* ko�czy zabaw� i generuje dokument */
$pdf->Output();  //zamyka i generuje dokument
?>