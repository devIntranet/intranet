@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <h2>
        {{ __('Urządzenia') }}
      </h2>
      <form method="POST" action="{{ route('urzadzenia.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowe') }}
        </button>
      </form>
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
          @if (session('order') == 'inwent_dev' && session('direction') == 'asc')
            <a href="?sort=inwent_dev&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=inwent_dev"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Nr Inwent</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'nazwa_dev' && session('direction') == 'asc')
            <a href="?sort=nazwa_dev&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_dev"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nazwa</div>
            </a>
          </th>   
          <th class="devHeadTH">
          @if (session('order') == 'model_dev' && session('direction') == 'asc')
            <a href="?sort=model_dev&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=model_dev"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Model</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'serial_dev' && session('direction') == 'asc')
            <a href="?sort=serial_dev&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=serial_dev"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Serial</div>
            </a>
          </th>   
          <th class="devHeadTH">
          @if (session('order') == 'typ_dev' && session('direction') == 'asc')
            <a href="?sort=typ_dev&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=typ_dev"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Typ</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'id_dz' && session('direction') == 'asc')
            <a href="?sort=id_dz&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=id_dz"  class="devLinkTH"> 
          @endif<div class="devHeadTH">Dział</div>
            </a>
          </th>            
        </tr>
      <!-- </thead>
      <tbody> -->
        @foreach($urzadzenia as $urzadzenie)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
                <a href="{{ route('urzadzenia.show',$urzadzenie->id_dev) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $urzadzenie->inwent_dev }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('urzadzenia.show',$urzadzenie->id_dev) }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($urzadzenie->nazwa_dev))
                  {{ $urzadzenie->nazwa_dev }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('urzadzenia.show', $urzadzenie->id_dev) }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($urzadzenie->model_dev))
                  {{ $urzadzenie->model_dev }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('urzadzenia.show', $urzadzenie->id_dev) }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($urzadzenie->serial_dev))
                  {{ $urzadzenie->serial_dev }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <div class="devBodyCell">
                {{ $urzadzenie->typ_dev }}
              </div>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('dzialy.show',$urzadzenie->id_dz ) }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $urzadzenie->symbol_d }}
                </div>
              </a>
            </td>
          </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    <script type="text/javascript" src="/js/filter.js"></script>
    @if (count($urzadzenia) > 20)
      <form method="POST" action="{{ route('urzadzenia.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowe') }}
        </button>
      </form>
    @endif
  </div>
  
@endsection