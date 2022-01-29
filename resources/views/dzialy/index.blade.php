@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <h2>
        {{ __('Działy') }}
      </h2>
      <form method="POST" action="{{ route('dzialy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
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
          @if (session('order') == 'symbol_d' && session('direction') == 'asc')
            <a href="?sort=symbol_d&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=symbol_d"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Dział</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'symbol_parent' && session('direction') == 'asc')
            <a href="?sort=symbol_parent&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=symbol_parent"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Sekcja</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'nazwa_d' && session('direction') == 'asc')
            <a href="?sort=nazwa_d&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_d"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Pełna Nazwa</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'id_uk' && session('direction') == 'asc')
            <a href="?sort=id_uk&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=id_uk"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Kierownik</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'id_p' && session('direction') == 'asc')
            <a href="?sort=id_p&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=id_p"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Pion</div>
            </a>
          </th>     
        </tr>
      <!-- </thead>
      <tbody> -->
        @foreach($dzialy as $dzial)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
              @if($dzial->parent_dz == 0 && $dzial->symbol_d)
                <a href="{{ route('dzialy.show',$dzial->id_dz) }}" class="devLink">
                  <div class="devBodyCell">
                    {{ $dzial->symbol_d }}
                  </div>
                </a>
              @elseif ($dzial->parent_dz > 0 && $dzial->symbol_parent)
                <a href="{{ route('dzialy.show',$dzial->id_parent) }}" class="devLink">
                  <div class="devBodyCell">
                    {{ $dzial->symbol_parent }}
                  </div>
                </a>
              @endif
            </td>
            <td class="devBodyTD">
              @if($dzial->parent_dz > 0 && $dzial->symbol_d)
                <a href="{{ route('dzialy.show',$dzial->id_dz) }}"
                  class="devLink">
                  <div class="devBodyCell">
                    {{ $dzial->symbol_d }}
                  </div>
                </a>
              @endif
            </td>
            <td class="devBodyTD">
              <a href="{{ route('dzialy.show', $dzial->id_dz) }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($dzial->nazwa_d))
                  {{ $dzial->nazwa_d }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('uzytkownicy.show', $dzial->id_uk) }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($dzial->nazwa_u))
                  {{ $dzial->nazwa_u }} {{ $dzial->imie_u }}
                @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('dzialy.show',$dzial->id_dz) }}"
                class="devLink">
                <div class="devBodyCell">
                @if(isset($dzial->nazwa_p))
                  {{ $dzial->nazwa_p }}
                @endif
                </div>
              </a>
            </td>
          </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    <script type="text/javascript" src="/js/filter.js"></script>
    @if (count($dzialy) > 20)
      <form method="POST" action="{{ route('dzialy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowe') }}
        </button>
      </form>
    @endif
  </div>
  
@endsection