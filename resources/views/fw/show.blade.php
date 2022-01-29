@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      <legend>
        {{ __('Szczegóły faktury') }}
      </legend>
      @if (@isset($tab['tab']) && $tab['tab'] == 'ot' )
      <span class="devDetTabWrapper">
        <a href="/fw/{{ $fw->id_fw }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/fw/{{ $fw->id_fw }}?tab=ot" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('OT') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetRow">
          <th class="devDetTH">Numer</th>
          <th class="devDetTH">Data</th>
          <th class="devDetTH">Nazwa</th>
          <th class="devDetTH">Inwent</th>
          <th class="devDetTH">Dział</th>
          <th class="devDetTH">Plik</th>  
        </tr>
        @foreach($otki as $ot)
        <tr class="devDetRow">
            <td class="devBodyTD">
              <a href="/ot/{{ $ot->id_ot }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $ot->nr_ot }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/ot/{{ $ot->id_ot }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $ot->data_ot }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/ot/{{ $ot->id_ot }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $ot->nazwa_ot }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/ot/{{ $ot->id_ot }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $ot->nr_inwent }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/dzialy/{{ $ot->id_dz }}"
                class="devLink">
                <div class="devBodyCell">
                {{ $ot->symbol_d }}
                </div>
              </a>
            </td>
            <td class="devBodyTD">
              <a href="/ot/otfile/{{ $ot->id_ot }}"
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
        <a href="/fw/{{ $fw->id_fw }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/fw/{{ $fw->id_fw }}?tab=ot" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('OT') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      <tr class="devDetRow">
          <td class="leftDevDetHead">Numer</td>
          <td>
            @isset($e['e'])
            <form action="/fw/updateOneCol/{{ $fw->id_fw }}">
            @csrf
              <input type="hidden" name="id_fw" value ="{{ $fw->id_fw }}"> 
              @if ($e['e'] == 'numer')
              <input id="Nazwa" type="text" class="devDetField" name="nr_fw" value="{{ $fw->nr_fw }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="nr_fw">
              @error('nr_fw')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              @else
                <a href="/fw/{{ $fw->id_fw }}?e=numer" class="devLink">{{ $fw->nr_fw }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="/fw/{{ $fw->id_fw }}?e=numer" class="devLink">{{ $fw->nr_fw }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>

        <td class="leftDevDetHead">Opis</td>
          <td>
            @isset($e['e'])
            <form action="/fw/updateOneCol/{{ $fw->id_fw }}">
            @csrf
              <input type="hidden" name="id_fw" value ="{{ $fw->id_fw }}"> 
              <input type="hidden" name="oldProperty" value="info_fw">
              @if ($e['e'] == 'opis')
              <textarea rows="3" cols="31" class="devDetField" name="info_fw" 
              placeholder="Maksymalnie 50 znaków" maxlength="50" required autofocus>{{ $fw->info_fw }}</textarea>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
              @error('info_fw')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              @else
                <a href="/fw/{{ $fw->id_fw }}?e=opis" class="devLink">{{ $fw->info_fw }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="/fw/{{ $fw->id_fw }}?e=opis" class="devLink">{{ $fw->info_fw }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>


        <tr class="devDetRow">
          <td class="leftDevDetHead">Data</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'data')
              <input id="fw" type="date" class="devDetField" name="data_fw" value="{{ $fw->data_fw }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="data_fw">
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
              @error('data_fw')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/fw/{{ $fw->id_fw }}?e=data" class="devLink">  
                @if ($fw->data_fw)
                    {{ $fw->data_fw }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/fw/{{ $fw->id_fw }}?e=data" class="devLink">  
                @if ($fw->data_fw)
                  {{ $fw->data_fw }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Sprzedawca</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'dealer')
              <input type="hidden" name="oldProperty" value="id_dea">
              <select id="dealer" class="devDetField" name="id_dea">
              @foreach ($dealerzy as $dealer)
                <option value="{{ $dealer->id_dea }}">{{ $dealer->nazwa_dea }}</option>
              @endforeach  
              </select>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
              @error('id_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/fw/{{ $fw->id_fw }}?e=dealer" class="devLink">  
                @if ($fw->id_dea)
                    {{ $fw->nazwa_dea }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/dealerzy/{{ $fw->id_dea }}" class="devLink">  
                @if ($fw->id_dea)
                  {{ $fw->nazwa_dea }}
              <a href="/fw/{{$fw->id_fw}}?e=dealer" class="devLink">
                <img class="changeIcon" src="/img/change.png">
              </a>  
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Plik</td>
          <td>
          <a href="/fw/fwfile/{{ $fw->id_fw }}"
                class="devLink">
                <div class="devBodyCell">
                  <img class="pdf2">
                </div>
              </a>
          </td>
        </tr>
      </table>
      @endif
      @if($fw->status_fw == 0)
        <span class="editButton"> 
          <a href="/st?tab=fw&active=0" class="devLink">WRÓĆ</a>
        </span>
        @else
        <span class="editButton"> 
          <a href="/st?tab=fw" class="devLink">WRÓĆ</a>
        </span>
      @endif  
    </fieldset>
  </div>
@endsection