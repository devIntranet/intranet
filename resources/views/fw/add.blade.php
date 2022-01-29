@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      <legend>
        {{ __('Nowa faktura') }}
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
          <td class="rightDevDetHead">
            <form action="/fw/store" method="POST" enctype="multipart/form-data">
            @csrf
              <input id="Numer" type="text" class="devDetField" name="nr_fw" required autofocus>
              @error('nr_fw')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Opis</td>
          <td class="rightDevDetHead">
            <textarea rows="3" cols="31" class="devDetField" name="info_fw" 
              placeholder="Maksymalnie 50 znaków" maxlength="50" required autofocus></textarea>
            @error('info_fw')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Data</td>
          <td>
            <input id="data" type="date" class="devDetField" name="data_fw" required autofocus>
            @error('data_fw')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetRow">Sprzedawca</td>
          <td>
            <input type="hidden" name="oldProperty" value="id_dea"> 
            <select id="dealer" class="devDetField" name="id_dea">
              @foreach ($dealerzy as $dealer)
                <option value="{{ $dealer->id_dea }}">{{ $dealer->nazwa_dea }}</option>
              @endforeach  
              @error('id_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
            </select>
          </td>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Plik</td>
          <td>
            <input id="fwfile" type="file" name="dok_fw" class="fileButton" accept="application/pdf">
            @error('dok_fw')
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
        <a href="/st?tab=dealer" class="devLink">WRÓĆ</a>
      </span>
    </form>
    </fieldset>
  </div>
@endsection