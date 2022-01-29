@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="{{ route('programy.store') }}" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy Program</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="nazwa_p" class="nazwa_p">{{ __('Nazwa') }}</label>
              </div>
              <div class="newDevice">
                <input id="Nazwa" type="text" class="authField" name="nazwa_p" value="{{ old('nazwa_p') }}" 
                  required autofocus>
                @error('nazwa_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="typ_p" class="typ_p">{{ __('Typ programu') }}</label>
              </div>
              <div class="newDevice">
                <select name ="typ_p" id="typ_p" class="devDetSelect">
                  <option value="1">{{ __('System Operacyjny') }}</option>
                  <option value="2">{{ __('Program Użytkowy') }}</option>
                </select>
                @error('typ_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="lic_p" class="lic_p">{{ __('Rodzaj licencji') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="lic_p" id="lic_p" class="authField" value="{{ old('lic_p') }}" 
                  required autofocus>
                @error('lic_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="licqty_p" class="licqty_p">{{ __('Liczba licencji') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="licqty_p" id="licqty_p" class="authField" value="{{ old('licqty_p') }}" 
                  required autofocus>
                @error('licqty_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="data_p" class="data_p">{{ __('Data zakupu') }}</label>
              </div>
              <div class="newDevice">
                <input id="data_p" type="date" class="authField" name="data_p" value="{{ old('data_p') }}" 
                  required autofocus>
                @error('data_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="authButton">
              {{ __('Dodaj') }}
            </button>
          </form>
          <span class="editButton"> 
            <a class ="devLink" href="{{ url()->previous() }}">WRÓĆ</a>
          </span>
    </fieldset>
    </div>
  </div>
@endsection