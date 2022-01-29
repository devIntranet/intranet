<?
require_once('fpdf/fpdf.php');  //odniesienie do skryptu komponentu
$pdf=new FPDF();
$pdf->Open();     //otwiera nowy dokument
$pdf->AddPage();    //dodaje now± stronê do dokumentu
$pdf->AddFont('georgia','','georgia.php');  //dodaje Twoj± czcionkê arialpl do dokumentu
$pdf->SetFont('georgia','',20);     //ustawia czcionkê arialpl, rozmiar 20
$pdf->Text(10,10, 'Witaj ¶wiecie. To jest tekst bez zawijania');  //tekst bez zawijania na pozycji x=10, y=10
$pdf->SetFont('georgia','',14);
$pdf->Multicell(0,4, 'Ten tekst z zamierzenia mia³ byæ d³ugi, w ka¿dym razie raczej nie powinien zmie¶ciæ siê w jednej linijce, ale nie ma ¿adnego problemu, funkcja Multicell() s³u¿y do wprowadzania tekstu z zawijaniem, ba je¶li tekst bêdzie d³u¿szy od strony, utworzy ona now±! ',0, 'J',0);   //tekst wieloliniowy o szeroko¶ci do prawej linii, wysoko¶ci linii 4, bez ramki, wyjustowany, bez t³a
/* Dopisuje niebieski podkre¶lony odno¶nik */
$pdf->SetFont('georgia','',14);
$pdf->Write(10,'Zapraszam na ');
$pdf->SetTextColor(0,0,255); //zmienia kolor czcionki
$pdf->SetFont('','U');  //zmienia styl czcionki na podkre¶lenie
$pdf->Write(10,'4programmers.net','http://4programmers.net');
$iks = $pdf->GetX;
$igrek = $pdf->GetY;
$pdf->Line($iks, $igrek+2,200, $igrek+2);  //wstawia liniê 2mm pod tekstem, o d³ugo¶ci 200mm.
/* narysuje granatowy prostok±t z zielonym wype³nieniem */
$pdf->SetDrawColor(170,255,64);
$pdf->SetFillColor(54,255,102);
$pdf->Rect($iks+20, $igrek+20,200,100);
$ident = $pdf->AddLink();
$pdf->SetLink($ident,0,2);  //tworzy (ale nie wstawia do dokumentu!) link do strony 2
$tekst = 'Tu znajduje siê link do nastêpnej strony!';
$dlugosc_tekstu = $pdf->GetStringWidth($tekst);  //oblicza d³ugo¶æ tekstu
$pdf->Text($pdf->GetX(),$pdf->GetY(),$tekst);  //wstawia tekst do dokumentu
$pdf->Link($pdf->GetX(),$pdf->GetY(),$dlugosc_tekstu,20, $ident);   //wstawia pod tekstem link do dokumentu
$pdf->AddPage(); //dodaje now± stronê.
$pdf->Image('derby.jpeg', $pdf->GetX()+10, $pdf->GetY()+10, 123, 240, 'JPG');
$pdf->SetFont('georgia','',8);
$pdf->SetTextColor(0,0,0);
$pdf->Text($pdf->GetX(),$pdf->GetY()+1, 'i to by by³o na tyle');
$pdf->SetCompression(true);  //w³±cza kompresjê dokumentu

/* a poni¿sze tylko dla ambitnych */
$pdf->SetAuthor('Ceer');  //ustawia autora dokumentu
$pdf->SetCreator('Dokument generowany przy pomocy skryptu');  //ustawia generator dokumentu
$pdf->SetKeywords('s³owo_kluczowe1, s³owo_kluczowe2');  //ustawia s³owa kluczowe dokumentu
$pdf->SetSubject('Nauka dynamicznego tworzenia PDFów');  //ustawia temat dokumentu
$pdf->SetTitle('Jak ³atwo stworzyæ PDFa');  //ustawia tytu³ dokumentu

$pdf->SetDisplayMode(100);  //domy¶lne powiêkszenie dokumentu w przegl±darce
$pdf->SetMargins(20, 20 , 20);  //ustawia marginesy dla dokumentu

/* koñczy zabawê i generuje dokument */
$pdf->Output();  //zamyka i generuje dokument
?>