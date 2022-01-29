@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      <legend>
        {{ __('Szczegóły dealera') }}
      </legend>
      @if (@isset($tab['tab']) && $tab['tab'] == 'faktury' )
      <span class="devDetTabWrapper">
        <a href="/dealerzy/{{ $dealer->id_dea }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/dealerzy/{{ $dealer->id_dea }}?tab=faktury" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('FAKTURY') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      <table class="devDet">
        <tr class="devDetRow">
          <th class="devDetTH">Numer</th>
          <th class="devDetTH">Data</th>
          <th class="devDetTH">Plik</th>  
        </tr>
        @foreach($faktury as $faktura)
        <tr class="devDetRow">
            <td class="devBodyTD">
              <a href="/fw/{{ $faktura->id_fw }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $faktura->nr_fw }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/fw/{{ $faktura->id_fw }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $faktura->data_fw }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/fw/fwfile/{{ $faktura->id_fw }}"
                class="devLink">
                <div class="devBodyCell">
                  <img class="pdf2">
                </div>
              </a>
            </td>
        </tr>
        @endforeach
      </table>
      @else
      <span class="devDetTabWrapper">
        <a href="/dealerzy/{{ $dealer->id_dea }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/dealerzy/{{ $dealer->id_dea }}?tab=faktury" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('FAKTURY') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      <tr class="devDetRow">
          <td class="leftDevDetHead">Nazwa</td>
          <td>
            @isset($e['e'])
            <form action="/dealerzy/updateOneCol/{{ $dealer->id_dea }}">
            @csrf
              <input type="hidden" name="id_dea" value ="{{ $dealer->id_dea }}"> 
              @if ($e['e'] == 'nazwa')
              <input id="Nazwa" type="text" class="devDetField" name="nazwa_dea" value="{{ $dealer->nazwa_dea }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="nazwa_dea">
              @error('nazwa_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              @else
                <a href="/dealerzy/{{ $dealer->id_dea }}?e=nazwa" class="devLink">{{ $dealer->nazwa_dea }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=nazwa" class="devLink">{{ $dealer->nazwa_dea }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">NIP</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'nip')
              <input id="NIP" type="text" class="devDetField" name="NIP_dea" value="{{ $dealer->NIP_dea }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="NIP_dea">
              @error('nip_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=nip" class="devLink">  
                @if ($dealer->NIP_dea)
                    {{ $dealer->NIP_dea }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=nip" class="devLink">  
                @if ($dealer->NIP_dea)
                  {{ $dealer->NIP_dea }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Miasto</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'miasto')
              <input id="miasto" type="text" class="devDetField" name="miasto_dea" value="{{ $dealer->miasto_dea }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="miasto_dea">
              @error('miasto_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=miasto" class="devLink">  
                @if ($dealer->miasto_dea)
                    {{ $dealer->miasto_dea }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=miasto" class="devLink">  
                @if ($dealer->miasto_dea)
                  {{ $dealer->miasto_dea }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Ulica</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'ulica')
              <input id="ulica" type="text" class="devDetField" name="ulica_dea" value="{{ $dealer->ulica_dea }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="ulica_dea">
              @error('ulica_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=ulica" class="devLink">  
                @if ($dealer->ulica_dea)
                    {{ $dealer->ulica_dea }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=ulica" class="devLink">  
                @if ($dealer->ulica_dea)
                  {{ $dealer->ulica_dea }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Numer</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'lokal')
              <input id="lokal" type="text" class="devDetField" name="lokal_dea" value="{{ $dealer->lokal_dea }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="lokal_dea">
              @error('lokal_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=lokal" class="devLink">  
                @if ($dealer->lokal_dea)
                    {{ $dealer->lokal_dea }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            </form>
            @empty ($e)
              <a href="/dealerzy/{{ $dealer->id_dea }}?e=lokal" class="devLink">  
                @if ($dealer->lokal_dea)
                  {{ $dealer->lokal_dea }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
      </table>
      @endif
      @if($dealer->status_dea != 0)
      <span class="editButton">
        <form action="{{route('dealerzy.disable',$dealer->id_dea) }}" method="POST">
          @csrf
          <input type="hidden" name="id_dea" value="{{ $dealer->id_dea }}">
          <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy sprzedawcę jako usuniętego!!!')">
            {{ __('USUŃ') }}
          </button>
        </form>
      </span>
      @else
      <span class="editButton">
        <form action="/dealerzy/activate/{{ $dealer->id_dea }}" method="POST">
          @csrf
          <input type="hidden" name="id_k" value="{{ $dealer->id_dea }}">
          <button class="devButton" onClick="return confirm(Ta operacja przywróci sprzedawce !!!)">
            {{ __('PRZYWRÓĆ') }}
          </button>
        </form>
      </span>
      @endif
      @if($dealer->status_dea == 0)
        <span class="editButton"> 
          <a href="/st?tab=dealer&active=0" class="devLink">WRÓĆ</a>
        </span>
        @else
        <span class="editButton"> 
          <a href="/st?tab=dealer" class="devLink">WRÓĆ</a>
        </span>
      @endif  
    </fieldset>
  </div>
@endsection