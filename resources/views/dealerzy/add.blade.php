@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      <legend>
        {{ __('Nowy dealer') }}
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
          <td class="leftDevDetHead">Nazwa</td>
          <td class="rightDevDetHead">
            <form action="/dealerzy/store">
            @csrf
              <input id="Nazwa" type="text" class="devDetField" name="nazwa_dea" required autofocus>
              
              @error('nazwa_dea')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">NIP</td>
          <td>
            <input id="NIP" type="text" class="devDetField" name="NIP_dea" required autofocus>
            @error('NIP_dea')
              <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Miasto</td>
          <td>
            <input id="miasto" type="text" class="devDetField" name="miasto_dea" required autofocus>
            @error('miasto_dea')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Ulica</td>
          <td>
            <input id="ulica" type="text" class="devDetField" name="ulica_dea" required autofocus>
            @error('ulica_dea')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
            @enderror
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Numer</td>
          <td>
            <input id="lokal" type="text" class="devDetField" name="lokal_dea" required autofocus>
              @error('lokal_dea')
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