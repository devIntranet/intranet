@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <h2>
        {{ __('Lista wniosków') }}
      </h2>
      <span >
        <a href="?nowe"  class="devLinkTH">
          <button type="submit" class="devButton">
            {{ __('Nowe') }}
          </button>
        </a>
      </span>
      <span >
        <a href="?otwarte"  class="devLinkTH">
          <button type="submit" class="devButton">
            {{ __('Otwarte') }}
          </button>
        </a>
      </span>
      <span >
        <a href="?zakonczone"  class="devLinkTH">
          <button type="submit" class="devButton">
            {{ __('Zakończone') }}
          </button>
        </a>
      </span>  
    </div>
  @foreach($wnioski as $wniosek)
    {{ $wniosek->imie }} - {{ $wniosek->nazwisko }} - {{ $wniosek->symbol_d }} - {{ $wniosek->nazwa_u }} <br>
  @endforeach
  </div>
@endsection