@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="{{ route('uzytkownicy.store') }}" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy Użytkownik</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="nazwa_u" class="nazwa_u">{{ __('Nazwisko') }}</label>
              </div>
              <div class="newDevice">
                <input id="nazwa_u" type="text" class="authField" name="nazwa_u" value="{{ old('nazwa_u') }}" 
                  required autofocus>
                @error('nazwa_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="imie_u" class="imie_u">{{ __('Imię') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="imie_u" id="imie_u" class="authField" value="{{ old('imie_u') }}" 
                  required autofocus>
                @error('imie_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="loginad_u" class="loginad_u">{{ __('login AD') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="loginad_u" id="loginad_u" class="authField" value="{{ old('loginad_u') }}" 
                  required autofocus>
                @error('loginad_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="symbol_d" class="symbol_d">{{ __('Dział') }}</label>
              </div>
              <div class="newDevice">
                <select name="id_dz" id="dzial" class="devDetSelect">
                @foreach($dzialy as $dzial)
                    <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                @endforeach  
                </select>
                @error('id_dz')
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