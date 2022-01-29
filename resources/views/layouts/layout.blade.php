<!DOCTYPE html>
<!--<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">--> 
<html lang="pl-PL">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "https://www.w3.org/TR/html4/strict.dtd">
        <html xmlns="https://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<!--<link rel="Stylesheet" type="text/css" href="/css/app.css" />-->
	<link rel="Stylesheet" type="text/css" href="/css/main.css" />
	
    <script type="text/javascript" src="/js/prototype.js"></script>
	<!-- 	<script type="text/javascript" src="/js/filter.js"></script> -->
	<script type="text/javascript" src="/js/scriptaculous.js?load=effects,builder"></script>
	<script type="text/javascript" src="/js/lightbox.js"></script>
	<script type="text/javascript" src="/js/wnioski_calendar.js"></script>
	<script>function delConfirm() {
  			confirm("Potwierdź!");
			}
	</script>
	<script src="https://code.jquery.com/jquery-latest.js"></script>
	<script type="text/javascript" language="javascript" src="/TableFilter/tablefilter_all.js"></script>
    <script>jQuery.noConflict();</script>  
	<!-- <link rel=stylesheet type=text/css href=/Strona/style.css> -->
	<link rel="stylesheet" href="/css/lightbox.css" type="text/css" media="screen" /> 
	<LINK REL="SHORTCUT ICON" HREF="/img/intranet_s.ico">
	<title>RPWiK - Intranet</title>
  </head>
  <body>
    <div id="main">
	<div id="TOP">
		@auth
		<div class="top-username">
		{{ Auth::user()->name }}
		</div>
		@endauth
	</div>
	<div id="MENU">
  	<ul id="menu-ul">
	<li>
      <a href=/ class="l_glowna">Strona Główna</a>
    </li>
	@auth
	<li>
      <a href=/komputery class="l_glowna">Komputery</a>
	</li>
	<li>
      <a href=/monitory class="l_glowna">Monitory</a>
	</li>
	<li>
      <a href=/upsy class="l_glowna">UPSy</a>
	</li>
	<li>
      <a href=/urzadzenia class="l_glowna">Urządzenia</a>
	</li>
	<li>
      <a href="{{route('uzytkownicy.index') }}" class="l_glowna">Użytkownicy</a>
    </li>
	<li>
      <a href="{{route('dzialy.index') }}" class="l_glowna">Działy</a>
    </li>
	<li>
      <a href=/st class="l_glowna">Środki Trwałe</a>
    </li>
    <li>
      <a href=/wnioski class="l_glowna">Wnioski</a>
	</li>
	@endauth
	@guest
	<li>
	  <a href=/dokumenty_wew class="it">Dokumenty działowe</a>	
	</li>
	<li>
	  <a href=/iBOK class="it">iBOK</a>	
	</li>
	<li>
	  <a href=/instrukcje_sod class="it">Instrukcje SOD</a>	
	</li>
	<li>
	  <a href=/mapy_cyfrowe class="it">Instrukcje Mapy Cyfrowe</a>	
	</li>
	<li>
	  <a href=/kursy class="l_wnioski">Kursy</a>	
	</li>
	<li>
	  <a href=/PPK class="PPK">PPK</a>	
	</li>
	<li>
	  <a href=/raporty class="it">Raporty</a>	
	</li>
	<li>
	  <a href=/RODO class="it">RODO</a>	
	</li>
	<li>
	  <a href=/telefony class="it">Telefony</a>	
	</li>
    <li>
	  <a href=/teleinformatyka class="it">Teleinformatyka</a>	
	</li>
	<li>
	  <a href=/login class="it">Loguj</a>	
	</li>
	@endguest
	@auth
	<li>
	  <a href=/logout class="it">Wyloguj</a>	
	</li>
	@endauth
    <a href = "file://backupsrv/dokumenty_spółki" class="l_dokumenty"></a>
	<a class="l_instrukcje"><div></div></a>
  </div>
      @yield('content')
      <div id="BOTTOM"><img src="/img/bottom.jpg" /></div>
	</div>
  </body>
</html>
