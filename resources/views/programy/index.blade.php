@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="devbuttons">
      <h2>
        {{ __('Programy') }}
      </h2>
      <form method="POST" action="{{ route('programy.add') }}">
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
          @if (session('order') == 'nazwa_p' && session('direction') == 'asc')
            <a href="?sort=nazwa_p&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_p"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nazwa Programu</div>
            </a>
          </th>      
          <th class="devHeadTH">
          @if (session('order') == 'typ_p' && session('direction') == 'asc')
            <a href="?sort=typ_p&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=typ_p"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Typ Programu</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'lic_p' && session('direction') == 'asc')
            <a href="?sort=lic_p&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=lic_p"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Rodzaj Licencji</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'licqty_p' && session('direction') == 'asc')
            <a href="?sort=licqty_p&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=licqty_p"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Liczba licencji</div>
            </a>
          </th>       
          <th class="devHeadTH">
          @if (session('order') == 'install' && session('direction') == 'asc')
            <a href="?sort=install&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=install"  class="devLinkTH"> 
          @endif  
              <div class="devHeadTH">Pozostało licencji</div>
            </a>
          </th>          
          <th class="devHeadTH">
          @if (session('order') == 'data_p' && session('direction') == 'asc')
            <a href="?sort=data_p&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=data_p"  class="devLinkTH"> 
          @endif  <div class="devHeadTH">Data zakupu</div>
            </a>
          </th>      
      <!-- </thead>
      <tbody> -->
        @foreach($programy as $program)
         <tr class="devBodyTR">      
            <td class="devBodyTD">
              <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">
                <div class="devBodyCell">
                  {{ $program->nazwa_p }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
            <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">
                <div class="devBodyCell">
                {{ $program->typ_p }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">
                <div class="devBodyCell">
                  {{ $program->lic_p }}
                </div>
              </a>
              </td>
            <td class="devBodyTD">
              <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">
                <div class="devBodyCell">
                @if ($program->lic_p != 'Freeware')
                    {{ $program->licqty_p }}
                  @else
                    {{ __('N/D')}}
                  @endif
                </div>
              </a>
            </td>
            
            <td class="devBodyTD">
              <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">
                <div class="devBodyCell">
                  @if ($program->lic_p != 'Freeware')
                    {{ ($program->licqty_p)-($program->install) }}
                  @else
                    {{ __('N/D')}}
                  @endif
                </div>
              </a>
            </td>
            <td class="devBodyTD">
            <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">
              <div class="devBodyCell">
                @if(isset($program->data_p))
                  {{ $program->data_p }}
                @endif
              </div>
            </a>
          </td>
        </tr>  
        @endforeach
      <!-- </tbody> -->
    </table>
    <script type="text/javascript" src="/js/filter.js"></script>
    <form method="POST" action="{{ route('programy.add') }}">
        @csrf
        <button type="submit" class="devButton">
            {{ __('Nowy') }}
        </button>
      </form>
  </div>
@endsection