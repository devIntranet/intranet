@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <h2>
        {{ __('Monitory') }}
      </h2>
      <form method="POST" action="{{ route('monitory.add') }}">
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
          @if (session('order') == 'inwent_m' && session('direction') == 'asc')
            <a href="?sort=inwent_m&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=inwent_m"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nr inwent</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'model_m' && session('direction') == 'asc')
            <a href="?sort=model_m&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=model_m"  class="devLinkTH"> 
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
        @foreach($monitory as $monitor)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
              <a href="{{ route('monitory.index') }}/{{ $monitor->id_m }}"
                class="devLink">
                @if ($monitor->inwent_m != $monitor->inwent_k)
                  <div class="devBodyCellRed">
                @else
                  <div class="devBodyCell">
                @endif
                  {{ $monitor->inwent_m }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('monitory.index') }}/{{ $monitor->id_m }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $monitor->model_m }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('komputery.index') }}/{{ $monitor->id_k }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($monitor->dns_k))
                  {{ $monitor->dns_k }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('komputery.index') }}/{{ $monitor->id_k }}"
                class="devLink">
                @if ($monitor->inwent_m != $monitor->inwent_k)
                  <div class="devBodyCellRed">
                @else
                  <div class="devBodyCell">
                @endif
                @if(isset($monitor->inwent_k))
                  {{ $monitor->inwent_k }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('dzialy.index') }}/{{ $monitor->id_dz }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($monitor->symbol_d))
                  {{ $monitor->symbol_d }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('uzytkownicy.index') }}/{{ $monitor->id_u }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($monitor->nazwa_u))
                  {{ $monitor->nazwa_u }} {{ $monitor->imie_u }}
                @endif
                </div>
              </a>
            </td>
          </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    <script type="text/javascript" src="/js/filter.js"></script>
    <form method="POST" action="{{ route('monitory.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
  </div>
@endsection