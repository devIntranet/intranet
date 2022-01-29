@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <h2>
        {{ __('UPSy') }}
      </h2>
      <form method="POST" action="{{ route('upsy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
      @csrf
      @if (session('active') == 0)
      <span class="link-field">
        <a href="?active=1"  class="devLinkTH">
          {{ __('Pokaż aktywne') }}
       </a>
      </span>
      @else
      <span class="link-field">
        <a href="?active=0"  class="devLinkTH">
          {{ __('Pokaż usunięte') }}
        </a>
      </span>
      @endif
    </div>
    <table class="devTab" id="devTab">  
      <!-- <thead class="devTabHead"> -->
        <tr class="devHeadTR" style="cursor:pointer">
          <th class="devHeadTH">
          @if (session('order') == 'inwent_ups' && session('direction') == 'asc')
            <a href="?sort=inwent_ups&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=inwent_ups"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nr inwent</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'model_ups' && session('direction') == 'asc')
            <a href="?sort=model_ups&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=model_ups"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Model</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'dns_k' && session('direction') == 'asc')
            <a href="?sort=dns_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=dns_k"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Komputer</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'inwent_k' && session('direction') == 'asc')
            <a href="?sort=inwent_k&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=inwent_k"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Inwent K.</div>
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
          @if (session('order') == 'nazwa_u' && session('direction') == 'asc')
            <a href="?sort=nazwa_u&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_u"  class="devLinkTH"> 
          @endif<div class="devHeadTH">Użytkownik</div>
            </a>
          </th>      
         </tr>
      <!-- </thead>
      <tbody> -->
        @foreach($upsy as $ups)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
              <a href="{{ route('upsy.index') }}/{{ $ups->id_ups }}"
                class="devLink">
                @if ($ups->inwent_ups != $ups->inwent_k)
                  <div class="devBodyCellRed">
                @else
                  <div class="devBodyCell">
                @endif
                  {{ $ups->inwent_ups }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('upsy.index') }}/{{ $ups->id_ups }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $ups->model_ups }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('komputery.index') }}/{{ $ups->id_k }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($ups->dns_k))
                  {{ $ups->dns_k }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('komputery.index') }}/{{ $ups->id_k }}"
                class="devLink">
                @if ($ups->inwent_ups != $ups->inwent_k)
                  <div class="devBodyCellRed">
                @else
                  <div class="devBodyCell">
                @endif
                @if(isset($ups->inwent_k))
                  {{ $ups->inwent_k }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('dzialy.index') }}/{{ $ups->id_dz }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($ups->symbol_d))
                  {{ $ups->symbol_d }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('uzytkownicy.index') }}/{{ $ups->id_u }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($ups->nazwa_u))
                  {{ $ups->nazwa_u }} {{ $ups->imie_u }}
                @endif
                </div>
              </a>
            </td>
          </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    <script type="text/javascript" src="/js/filter.js"></script>
    <form method="POST" action="{{ route('upsy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
  </div>
@endsection