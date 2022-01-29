@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <form method="POST" action="{{ route('komputery.addStep1') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
    </div>
    <table class="devTab" id="devTab">  
      <!-- <thead class="devTabHead"> -->
        <tr class="devHeadTR" style="cursor:pointer">
          <th class="devHeadTH">
          @if (session('order') == 'dns_k' && session('direction') == 'asc')
            <a href="?sort=dns_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=dns_k"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nazwa</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'nazwa_u' && session('direction') == 'asc')
            <a href="?sort=nazwa_u&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_u"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Użytkownik</div>
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
          @if (session('order') == 'ip_k' && session('direction') == 'asc')
            <a href="?sort=ip_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=ip_k"  class="devLinkTH"> 
          @endif<div class="devHeadTH">Adres IP</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'typ_k' && session('direction') == 'asc')
            <a href="?sort=typ_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=typ_k"  class="devLinkTH"> 
          @endif<div class="devHeadTH">Typ</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'inwent_k' && session('direction') == 'asc')
            <a href="?sort=inwent_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=inwent_k"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Nr inwent</div>
            </a>
          </th>      
        </tr>
      <!-- </thead>
      <tbody> -->
        @foreach($komps as $komp)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
              <a href="{{ route('komputery.index') }}/{{ $komp->id_k }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $komp->dns_k }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('uzytkownicy.index') }}/{{ $komp->id_u }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($komp->nazwa_u))
                  {{ $komp->nazwa_u }} {{ $komp->imie_u }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('dzialy.index') }}/{{ $komp->id_dz }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($komp->symbol_d))
                  {{ $komp->symbol_d }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
            <a href="{{ route('komputery.index') }}/{{ $komp->id_k }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $komp->ip_k }}
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              {{ $komp->typ_k}}
              </td>
            <td class="devBodyTD">
            <a href="{{ route('komputery.index') }}/{{ $komp->id_k }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $komp->inwent_k }}
                </div>
              </a>
            </td>
          </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    <script type="text/javascript" src="/js/filter.js"></script>
    <form method="POST" action="{{ route('komputery.addStep1') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
  </div>
  
@endsection