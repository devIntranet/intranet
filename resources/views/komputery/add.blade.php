@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/komputery/addStep2" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy Komputer</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="dns_k" class="dns_k">{{ __('Nazwa') }}</label>
              </div>
              <div class="newDevice">
                @if (Session::has('kompStep1')) 
                  <input id="Nazwa" type="text" class="authField" name="dns_k" value="{{ Session::get('kompStep1')['dns_k'] }}"   
                  required autofocus>
                @else 
                <input id="Nazwa" type="text" class="authField" name="dns_k" value="{{ old('dns_k') }}" 
                  required autofocus>
                @endif
                @error('dns_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="inwent_k" class="inwent_k">{{ __('Nr inwent') }}</label>
              </div>
              <div class="newDevice">
              @if (Session::has('kompStep1'))
                <input type="text" name ="inwent_k" id="inwent_k" class="authField" value="{{ Session::get('kompStep1')['inwent_k'] }}" 
                  required autofocus>
              @else
              <input type="text" name ="inwent_k" id="inwent_k" class="authField" value="{{ old('inwent_k') }}" 
                  required autofocus>
              @endif
                @error('inwent_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="serial_k" class="serial_k">{{ __('Nr seryjny') }}</label>
              </div>
              <div class="newDevice">
              @if (Session::has('kompStep1'))
                <input type="text" name ="serial_k" id="serial_k" class="authField" value="{{ Session::get('kompStep1')['serial_k'] }}" 
                  required autofocus>
              @else
              <input type="text" name ="serial_k" id="serial_k" class="authField" value="{{ old('serial_k') }}" 
                  required autofocus>
              @endif
                @error('serial_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="data_k" class="data_k">{{ __('Data instalacji') }}</label>
              </div>
              <div class="newDevice">
              @if (Session::has('kompStep1'))
                <input id="data_k" type="date" class="authField" name="data_k" value="{{ Session::get('kompStep1')['data_k'] }}" 
                  required autofocus>
              @else
              <input id="data_k" type="date" class="authField" name="data_k" value="{{ old('data_k') }}" 
                  required autofocus>
              @endif
                  @error('data_k')
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
                @if (Session::has('kompStep1')) 
                  @foreach($dzialy as $dzial)
                    @if (Session::get('kompStep1')['id_dz'] == $dzial->id_dz)
                      <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }}</option>
                    @else
                      <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                    @endif
                  @endforeach  
                @else 
                  @foreach($dzialy as $dzial)
                    <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }}</option>
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
                <label for="nazwa_u" class="nazwa_u">{{ __('Użytkownik') }}</label>
              </div>
              <div class="newDevice">
                <select name="id_u" id="uzytkownik" class="devDetSelect">
                  <option value="" selected>{{ __('Brak') }}
                @if (Session::has('kompStep1')) 
                  @foreach($uzytkownicy as $uzytkownik)
                    @if (Session::get('kompStep1')['id_u'] == $uzytkownik->id_u)
                      <option value = "{{ $uzytkownik->id_u }}" selected>{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u}}</option>
                    @else
                      <option value = "{{ $uzytkownik->id_u }}">{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u}}</option>
                    @endif
                  @endforeach  
                @else 
                  @foreach($uzytkownicy as $uzytkownik)
                    <option value = "{{ $uzytkownik->id_u }}">{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u}}</option>
                  @endforeach
                @endif
                </select>
                @error('id_u')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            
            <button type="submit" class="authButton">
              {{ __('Dalej') }}
            </button>
          </form>
          <span class="editButton"> 
            <a class ="devLink" href="{{ url()->previous() }}">WRÓĆ</a>
          </span>
    </fieldset>
    </div>
  </div>
@endsection