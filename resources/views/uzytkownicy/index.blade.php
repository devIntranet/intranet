@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <form method="POST" action="{{ route('uzytkownicy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
      @if (session('active') == 0)
      <span class="link-field">
        <a href="?active=1"  class="devLinkTH">
          {{ __('Pokaż aktywnych') }}
       </a>
      </span>
      @else
      <span class="link-field">
        <a href="?active=0"  class="devLinkTH">
          {{ __('Pokaż usuniętych') }}
        </a>
      </span>
      @endif
    </div>
    <table class="devTab" id="devTab">  
      <!-- <thead class="devTabHead"> -->
        <tr class="devHeadTR" style="cursor:pointer">
          <th class="devHeadTH">
          @if (session('order') == 'nazwa_u' && session('direction') == 'asc')
            <a href="?sort=nazwa_u&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_u"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nazwisko</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'imie_u' && session('direction') == 'asc')
            <a href="?sort=imie_u&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=imie_u"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Imię</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'loginad_u' && session('direction') == 'asc')
            <a href="?sort=loginad_u&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=loginad_u"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">login AD</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'symbol_d' && session('direction') == 'asc')
            <a href="?sort=symbol_d&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=symbol_d"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Dział</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'dns_k' && session('direction') == 'asc')
            <a href="?sort=dns_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=dns_k"  class="devLinkTH"> 
          @endif<div class="devHeadTH">Komputer</div>
            </a>
          </th>
          <th class="devHeadTH">
            <div class="devHeadTH">
              <a href=""  class="devLinkTH">
                Upoważnienie
              </a>
            </div>            
          </th>
          </tr>
      <!-- </thead>
      <tbody> -->
        @foreach($uzytkownicy as $uzytkownik)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
              @isset($uzytkownik->nazwa_u)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $uzytkownik->nazwa_u }}
                </div>
              </a>
              @endisset
            </td>
            <td class="devBodyTD">
              @isset($uzytkownik->imie_u)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $uzytkownik->imie_u }}
                </div>
              </a>
              @endisset
            </td>
            <td class="devBodyTD">
              @isset($uzytkownik->loginad_u)
              <a href="{{ route('uzytkownicy.show', $uzytkownik->id_u) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $uzytkownik->loginad_u }}
                </div>
              </a>
              @endisset
            </td>
            <td class="devBodyTD">
              @isset($uzytkownik->symbol_d)
              <a href="{{ route('dzialy.show', $uzytkownik->id_dz) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $uzytkownik->symbol_d }}
                </div>
              </a>
              @endisset
            </td>
            <td class="devBodyTD">
              @isset($uzytkownik->dns_k)
              <a href="{{ route('komputery.show', $uzytkownik->id_k) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $uzytkownik->dns_k }}
                </div>
              </a>
              @endisset
            </td>
          </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    @if($uzytkownicy->count() > 10)
    <script type="text/javascript" src="/js/filter.js"></script>
    <form method="POST" action="{{ route('uzytkownicy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
    @endif
  </div>
  
@endsection