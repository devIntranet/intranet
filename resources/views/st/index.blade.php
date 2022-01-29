@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <legend>
        
        Środki Trwałe
        
    </legend>
  @if (@isset($tab['tab']) && $tab['tab'] == 'fw' )
      
      <span class="devDetTabWrapper">
        <a href="/st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('OT') }}
          </span>
        </a>
        <a href="/st?tab=fw" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('FK') }}
          </span>
        </a>
        <a href="/st?tab=dealer" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('Sprzedawcy') }}
          </span>
        </a>
      </span>
      <table class="devDetLog">
        <tr>
          <td>
            <form method="POST" action="{{ route('fw.add') }}">
              @csrf
              <button type="submit" class="devButton">
              {{ __('Nowa') }}
              </button>
            </form>
          </td>
          <td></td>
          <td>
          @if (session('active') == 0)
            <span class="link-field">
              <a href="?tab=fw&active=1"  class="devLinkTH">
                {{ __('Pokaż aktywne') }}
              </a>
            </div>
          @else
            <span class="link-field">
              <a href="?tab=fw&active=0"  class="devLinkTH">
                {{ __('Pokaż usunięte') }}
              </a>
            </div>
          @endif
          </td>
        </tr>
        
        <tr class="devDetLogRow">
        <th class="devHeadTH">
          @if (session('order') == 'nr_fw' && session('direction') == 'desc')
            <a href="?tab=fw&sort=nr_fw&direction=asc"  class="devLinkTH">
          @else
            <a href="?tab=fw&sort=nr_fw&direction=desc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Numer</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'data_fw' && session('direction') == 'desc')
            <a href="?tab=fw&sort=data_fw&direction=asc"  class="devLinkTH">
          @else
            <a href="?tab=fw&sort=data_fw&direction=desc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Data</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'info_fw' && session('direction') == 'desc')
            <a href="?tab=fw&sort=info_fw&direction=asc"  class="devLinkTH">
          @else
            <a href="?tab=fw&sort=info_fw&direction=desc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Info</div>
            </a>
          </th>  
          <th class="devHeadTH">
          @if (session('order') == 'id_dea' && session('direction') == 'desc')
            <a href="?tab=fw&sort=id_dea&direction=asc"  class="devLinkTH">
          @else
            <a href="?tab=fw&sort=id_dea&direction=desc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Dealer</div>
            </a>
          </th>
          <th class="devHeadTH">
            <a href=""  class="devLinkTH">
            <div class="devHeadTH">Plik</div>
            </a>
          </th>  
        </tr>
        @foreach($faktury as $faktura)
          <tr class="devDetRow">
            <td class="devDet">
              <a href="{{ route('fw.show', $faktura->id_fw) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $faktura->nr_fw }}
                  </div>
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('fw.show', $faktura->id_fw) }}" class="devLink">
                {{ $faktura->data_fw }}
              </a>  
            </td>
            <td class="devDet">
              <a href="{{ route('fw.show', $faktura->id_fw) }}" class="devLink">
                {{ $faktura->info_fw }}
              </a>  
            </td>
            <td class="devDet">
              <a href="{{ route('dealerzy.show', $faktura->id_dea) }}" class="devLink">
                {{ $faktura->nazwa_dea }}
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('fw.downloadFwFile', $faktura->id_fw) }}" class="devLink">
                  <div class="devHeadTH">
                      <img class="pdf2">
                  </div>
              </a>
            </td>
          </tr>
       @endforeach 
      </table>

      @elseif (@isset($tab['tab']) && $tab['tab'] == 'dealer' )
      
      <span class="devDetTabWrapper">
        <a href="/st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('OT') }}
          </span>
        </a>
        <a href="/st?tab=fw" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('FK') }}
          </span>
        </a>
        <a href="/st?tab=dealer" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('Sprzedawcy') }}
          </span>
        </a>
      </span>
      
      <table class="devDetLog">
        <tr>
          <td>
            <form method="POST" action="{{ route('dealerzy.add') }}">
              @csrf
              <button type="submit" class="devButton">
              {{ __('Nowy') }}
              </button>
            </form>
          </td>
          <td>
          @if (session('active') == 0)
            <span class="link-field">
              <a href="?tab=dealer&active=1"  class="devLinkTH">
                {{ __('Pokaż aktywnych') }}
              </a>
            </div>
          @else
            <span class="link-field">
              <a href="?tab=dealer&active=0"  class="devLinkTH">
                {{ __('Pokaż usuniętych') }}
              </a>
            </div>
          @endif
          </td>
        </tr>
        <tr class="devDetLogRow">
        <th class="devHeadTH">
          @if (session('order') == 'nazwa_dea' && session('direction') == 'asc')
            <a href="?tab=dealer&sort=nazwa_dea&direction=desc"  class="devLinkTH">
          @else
            <a href="?tab=dealer&sort=nazwa_dea&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nazwa</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'nip_dea' && session('direction') == 'asc')
            <a href="?tab=dealer&sort=nip_dea&direction=desc"  class="devLinkTH">
          @else
            <a href="?tab=dealer&sort=nip_dea&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">NIP</div>
            </a>
          </th> <th class="devHeadTH">
          @if (session('order') == 'miasto_dea' && session('direction') == 'asc')
            <a href="?tab=dealer&sort=miasto_dea&direction=desc"  class="devLinkTH">
          @else
            <a href="?tab=dealer&sort=miasto_dea&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Adres</div>
            </a>
          </th> 
        </tr>
        @foreach($dealerzy as $dealer)
          <tr class="devDetRow">
            <td class="devDet">
              <a href="{{ route('dealerzy.show', $dealer->id_dea) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $dealer->nazwa_dea }}
                  </div>
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('dealerzy.show', $dealer->id_dea) }}" class="devLink">
                {{ $dealer->NIP_dea }}
              </a>  
            </td>
            <td class="devDet">
              <a href="{{ route('dealerzy.show', $dealer->id_dea) }}" class="devLink">
                {{ $dealer->miasto_dea }} {{ $dealer->ulica_dea }} {{ $dealer->lokal_dea }}
              </a>
            </td>
          </tr>
       @endforeach 
      </table>
   @else 
   <span class="devDetTabWrapper">
        <a href="/st" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('OT') }}
          </span>
        </a>
        <a href="/st?tab=fw" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('FK') }}
          </span>
        </a>
        <a href="/st?tab=dealer" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('Sprzedawcy') }}
          </span>
        </a>
      </span>
    
      <table class="devDetLog">
        <tr>
          <td>
            <form method="POST" action="{{ route('ot.add') }}">
              @csrf
              <button type="submit" class="devButton">
              {{ __('Nowy') }}
              </button>
            </form>
          </td>
          <td></td>
          <td></td>
          <td>
          @if (session('active') == 0)
            <span class="link-field">
              <a href="?active=1"  class="devLinkTH">
                {{ __('Pokaż aktywne') }}
              </a>
            </div>
          @else
            <span class="link-field">
              <a href="?active=0"  class="devLinkTH">
                {{ __('Pokaż usunięte') }}
              </a>
            </div>
          @endif
          </td>
        </tr>
        <tr class="devDetLogRow">
        <th class="devHeadTH">
          @if (session('order') == 'nr_ot' && session('direction') == 'asc')
            <a href="?sort=nr_ot&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nr_ot&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Numer</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'nr_inwent' && session('direction') == 'asc')
            <a href="?sort=nr_inwent&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nr_inwent&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Inwent</div>
            </a>
          </th> 
          <th class="devHeadTH">
          @if (session('order') == 'data_ot' && session('direction') == 'asc')
            <a href="?sort=data_ot&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=data_ot&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Data</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'nazwa_ot' && session('direction') == 'asc')
            <a href="?sort=nazwa_&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=nazwa_ot&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Nazwa</div>
            </a>
          </th>
          <th class="devHeadTH">
          @if (session('order') == 'id_dz' && session('direction') == 'asc')
            <a href="?sort=id_dz&direction=desc"  class="devLinkTH">
          @else
            <a href="?sort=id_dz&direction=asc"  class="devLinkTH"> 
          @endif
              <div class="devHeadTH">Dział</div>
            </a>
          </th> 
          <th class="devHeadTH">
            <a href=""  class="devLinkTH"> 
            {{ __('Plik')}}
            </a>
          </th>
        </tr>
        @foreach($otki as $ot)
          <tr class="devDetRow">
            <td class="devDet">
              <a href="{{ route('ot.show', $ot->id_ot) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $ot->nr_ot }}
                  </div>
              </a>
            </td><td class="devDet">
              <a href="{{ route('ot.show', $ot->id_ot) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $ot->nr_inwent }}
                  </div>
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('ot.show', $ot->id_ot) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $ot->data_ot }}
                  </div>
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('ot.show', $ot->id_ot) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $ot->nazwa_ot }}
                  </div>
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('dzialy.show', $ot->id_dz) }}" class="devLink">
                  <div class="devHeadTH">
                      {{ $ot->symbol_d }}
                  </div>
              </a>
            </td>
            <td class="devDet">
              <a href="{{ route('ot.downloadOtFile', $ot->id_ot) }}" class="devLink">
                  <div class="devHeadTH">
                      <img class="pdf2">
                  </div>
              </a>
            </td>
          </tr>
       @endforeach 
      </table>
      
  @endif   
  </div>
@endsection