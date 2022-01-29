@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="{{ route('wnioski.addStep1p') }}" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy Wniosek</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="imie_u" class="imie_u">{{ __('Imię') }}</label>
              </div>
              <div class="newDevice">
                <input id="Imię" type="text" class="authField" name="imie" value="{{ $wniosek->imie ?? '' }}"   
                  required autofocus>
                @error('imie')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="nazwisko" class="nazwisko">{{ __('Nazwisko') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="nazwisko" id="nazwisko" class="authField" value="{{ $wniosek->nazwisko ?? '' }}" 
                  required autofocus>
                @error('nazwisko')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="data_start" class="data_start">{{ __('Data rozpoczęcia') }}</label>
              </div>
              <div class="newDevice">
                <input id="data_start" type="date" class="authField" name="data_start" value="{{ $wniosek->data_start ?? '' }}" 
                  required autofocus>
                @error('data_start')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="data_end" class="data_end">{{ __('Data zakończenia') }}</label>
              </div>
              <div class="newDevice">
                <input id="data_end" type="date" class="authField" name="data_end" 
                  value="{{ $wniosek->data_end ?? '' }}" autofocus>
                @error('data_end')
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
                @if (Session::has('wniosek')) 
                  @foreach($dzialy as $dzial)
                    @if (Session::get('wniosek')['id_dz'] == $dzial->id_dz)
                      <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }}</option>
                    @else
                      <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                    @endif
                  @endforeach  
                @else 
                  @foreach($dzialy as $dzial)
                    <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                  @endforeach
                @endif
                </select>
                @error('id_dz')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="symbol_d" class="symbol_d">{{ __('Karta RCP') }}</label>
              </div>
              <div class="newDevice">
                <select name="kartaRCP" id="kartaRCP" class="devDetSelect">
                @if (Session::has('kartaRCP') && Session::get('kartaRCP') == 1) 
                  <option value = "0">{{ __('NIE') }}</option>
                  <option value = "1" selected>{{ __('TAK') }}</option>
                @else
                  <option value = "0" selected>{{ __('NIE') }}</option>
                  <option value = "1">{{ __('TAK') }}</option>
                @endif
                </select>
                @error('kartaRCP')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          </form>
          <span class="editButton"> 
            <a class ="devLink" href="{{ route('wnioski.addStep1') }}">WRÓĆ</a>
          </span>
    </fieldset>
    </div>
  </div>
@endsection