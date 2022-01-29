@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      <legend>
        {{ __('Nowy Dokument OT') }}
      </legend>
      <span class="devDetTabWrapper">
        <a href="" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
       </span>
       <table class="devDet">
      <tr class="devDetRow">
        <td class="leftDevDetHead">Numer</td>
        <td>
          <form action="/ot/store" method="POST" enctype="multipart/form-data">
            @csrf
            <input id="Nazwa" type="text" class="devDetField" name="nr_ot"
                required autofocus>
            @error('nr_ot')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Data</td>
          <td>
              <input id="ot" type="date" class="devDetField" name="data_ot"
                  required autofocus>
              @error('data_ot')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </td>
        </tr>
        <tr class="devDetRow">
        <td class="leftDevDetHead">Nazwa</td>
        <td>
            <input id="Nazwa" type="text" class="devDetField" name="nazwa_ot"
                required autofocus>
            @error('nazwa_ot')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
        <td class="leftDevDetHead">Inwent</td>
        <td>
          <input id="Inwent" type="text" class="devDetField" name="nr_inwent"
                required autofocus>
          @error('nr_inwent')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
           @enderror
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Dział</td>
          <td>
              <select id="dzial" class="devDetField" name="id_dz">
              @foreach ($dzialy as $dzial)
                <option value="{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
              @endforeach  
              </select>
              @error('id_dz')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
          </td>
        </tr>

        <tr class="devDetRow">
          <td class="leftDevDetHead">Faktura</td>
          <td>
              <select id="faktura" class="devDetField" name="id_fw">
              @foreach ($faktury as $faktura)
                <option value="{{ $faktura->id_fw }}">{{ $faktura->nr_fw }}</option>
              @endforeach  
              </select>
              @error('id_fw')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Plik</td>
          <td>
          <input id="otfile" type="file" name="dok_ot" accept="application/pdf">
            @error('dok_ot')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td>
        </tr>
      </table>
      <span class="editButton"> 
        <button type="submit" class="authButton">
          {{ __('Dodaj') }}
        </button>
      </span>
      <span class="editButton"> 
        <a href="/st" class="devLink">WRÓĆ</a>
      </span>
    </form>
    </fieldset>
  </div>
@endsection