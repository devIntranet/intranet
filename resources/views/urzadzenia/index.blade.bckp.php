@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <form method="POST" action="{{ route('urzadzenia.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowe') }}
        </button>
      </form>
    </div>
    <table class="devTab" id="devTab">  
      <!-- <thead class="devTabHead"> -->
        <tr class="devHeadTR" style="cursor:pointer">
          <th class="devHeadTH">
          @if (session('order') == 'model' && session('direction') == 'asc')
            <a href="?sort=model&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=model"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Model</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'typ' && session('direction') == 'asc')
            <a href="?sort=typ&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=typ"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Typ</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'inwent' && session('direction') == 'asc')
            <a href="?sort=inwent&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=inwent"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Nr Inwent</div>
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
              <a href="{{ route('urzadzenia.show') }}/{{ $urzadzenie->id_dev }}"
                class="devLink">
                <div class="devBodyCell">
                  {{ $urzadzenie->model_dev }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('urzadzenia.show') }}/{{ $urzadzenie->id_dev }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($urzadzenie->typ_dev))
                  {{ $urzadzenie->typ_dev }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('urzadzenia.index') }}/{{ $urzadzenie->id_dev }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($urzadzenie->inwent_dev))
                  {{ $urzadzenie->inwent_dev }}
                @endif
                </div>
              </a>
              </td>
            <td class="devBodyTD">
            <a href="{{ route('dzialy.show') }}/{{ $urzadzenie->id_dz }}"
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
    <form method="POST" action="{{ route('urzadzenia.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowe') }}
        </button>
      </form>
  </div>
  
@endsection