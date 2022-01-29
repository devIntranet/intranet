@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      <legend>
        {{ __('Szczegóły OT') }}
      </legend>
      <span class="devDetTabWrapper">
        <a href="/ot/{{ $ot->id_ot }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      <tr class="devDetRow">
        <td class="leftDevDetHead">Numer</td>
        <td>
          @isset($e['e'])
          <form action="/ot/updateOneCol/{{ $ot->id_ot }}">
          @csrf
            <input type="hidden" name="id_ot" value ="{{ $ot->id_ot }}"> 
            @if ($e['e'] == 'numer')
            <input id="Nazwa" type="text" class="devDetField" name="nr_ot" value="{{ $ot->nr_ot }}" 
                required autofocus>
            <input type="hidden" name="oldProperty" value="nr_ot">
            @error('nr_ot')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
            @else
              <a href="/ot/{{ $ot->id_ot }}?e=numer" class="devLink">{{ $ot->nr_ot }}</a>
            @endif
          @endisset
          @empty ($e)
            <a href="/ot/{{ $ot->id_ot }}?e=numer" class="devLink">{{ $ot->nr_ot }}</a>
          @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Data</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'data')
              <input id="ot" type="date" class="devDetField" name="data_ot" value="{{ $ot->data_ot }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="data_ot">
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
              @error('data_ot')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              @else
              <a href="/ot/{{ $ot->id_ot }}?e=data" class="devLink">  
                @if ($ot->data_ot)
                    {{ $ot->data_ot }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/ot/{{ $ot->id_ot }}?e=data" class="devLink">  
                @if ($ot->data_ot)
                  {{ $ot->data_ot }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
        <td class="leftDevDetHead">Nazwa</td>
        <td>
          @isset($e['e'])
          <form action="/ot/updateOneCol/{{ $ot->id_ot }}">
          @csrf
            <input type="hidden" name="nazwa_ot" value ="{{ $ot->id_ot }}"> 
            @if ($e['e'] == 'nazwa')
            <input id="Nazwa" type="text" class="devDetField" name="nazwa_ot" value="{{ $ot->nazwa_ot }}" 
                required autofocus>
            <input type="hidden" name="oldProperty" value="nazwa_ot">
            @error('nazwa_ot')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
            @else
              <a href="/ot/{{ $ot->id_ot }}?e=nazwa" class="devLink">{{ $ot->nazwa_ot }}</a>
            @endif
          @endisset
          @empty ($e)
            <a href="/ot/{{ $ot->id_ot }}?e=nazwa" class="devLink">{{ $ot->nazwa_ot }}</a>
          @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
        <td class="leftDevDetHead">Inwent</td>
        <td>
          @isset($e['e'])
          <form action="/ot/updateOneCol/{{ $ot->id_ot }}">
          @csrf
            <input type="hidden" name="id_ot" value ="{{ $ot->id_ot }}"> 
            @if ($e['e'] == 'inwent')
            <input id="Inwent" type="text" class="devDetField" name="nr_inwent" value="{{ $ot->nr_inwent }}" 
                required autofocus>
            <input type="hidden" name="oldProperty" value="nr_inwent">
            @error('nr_inwent')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
            @else
              <a href="/ot/{{ $ot->id_ot }}?e=inwent" class="devLink">{{ $ot->nr_inwent }}</a>
            @endif
          @endisset
          @empty ($e)
            <a href="/ot/{{ $ot->id_ot }}?e=inwent" class="devLink">{{ $ot->nr_inwent }}</a>
          @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Dział</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'dzial')
              <input type="hidden" name="oldProperty" value="id_dz">
              <select id="dzial" class="devDetField" name="id_dz">
              @foreach ($dzialy as $dzial)
                <option value="{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
              @endforeach  
              </select>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
              @error('id_dz')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/dzialy/{{ $ot->id_dz }}" class="devLink">  
              @if ($ot->id_dz)
                    {{ $ot->symbol_d}}
              @endif
              </a>
              <a href="/ot/{{$ot->id_ot}}?e=dzial" class="devLink">
                <img class="changeIcon" src="/img/change.png">
              </a>  
              @endif
            @endisset
            @empty ($e)
              <a href="/dzialy/{{ $ot->id_dz }}" class="devLink">  
                @if ($ot->id_dz)
                  {{ $ot->symbol_d }}
                @endif
              </a>
              <a href="/ot/{{$ot->id_ot}}?e=dzial" class="devLink">
                <img class="changeIcon" src="/img/change.png">
              </a>
            @endempty
          </td>
        </tr>

        <tr class="devDetRow">
          <td class="leftDevDetHead">Faktura</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'faktura')
              <input type="hidden" name="oldProperty" value="id_fw">
              <select id="faktura" class="devDetField" name="id_fw">
              @foreach ($faktury as $faktura)
                <option value="{{ $faktura->id_fw }}">{{ $faktura->nr_fw }}</option>
              @endforeach  
              </select>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span>
              @error('id_fw')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/fw/{{ $ot->id_fw }}" class="devLink">  
              @if ($ot->id_fw)
                    {{ $ot->nr_fw}}
              @endif
              </a>
              <a href="/ot/{{$ot->id_ot}}?e=faktura" class="devLink">
                <img class="changeIcon" src="/img/change.png">
              </a>  
              @endif
            @endisset
            @empty ($e)
              <a href="/fw/{{ $ot->id_fw }}" class="devLink">  
                @if ($ot->id_fw)
                  {{ $ot->nr_fw }}
              <a href="/ot/{{$ot->id_ot}}?e=faktura" class="devLink">
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
          <a href="/ot/otfile/{{ $ot->id_ot }}" class="devLink">
            <div class="devBodyCell">
              <img class="pdf2">
            </div>
          </a>
          </td>
        </tr>
      </table>
      
      @if($ot->status_ot == 0)
        <span class="editButton"> 
          <a href="/st?active=0" class="devLink">WRÓĆ</a>
        </span>
        @else
        <span class="editButton"> 
          <a href="/st" class="devLink">WRÓĆ</a>
        </span>
      @endif  
    </fieldset>
  </div>
@endsection