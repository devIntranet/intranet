/***********************************************
 Fool-Proof Date Input Script with DHTML Calendar
 by Jason Moon - http://calendar.moonscript.com/dateinput.cfm
 ************************************************/

// Funckja sprawdzaj�ca wprowadzone dane w formularzu
// dodaj�cym nowy wniosek

function sprawdz_addwn() {
var wiadomosc = \"\"; 
if (document.addwn.nazwisko.value.length<1) {
wiadomosc = wiadomosc + ' - Nazwisko';
}
if (document.addwn.imie.value.length<1) {
wiadomosc = wiadomosc + ' - Imi�';
}
if (wiadomosc.length<1) {
document.addwn.submit(); 
return true;
}
else {
alert('Brak danych z p�l: '+ wiadomosc);
} 
}


