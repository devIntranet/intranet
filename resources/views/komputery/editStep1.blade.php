@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/komputery/editStep2/{{ $komputer->id_k }}" method="POST">
      <input type="hidden" name="typ_k" value="{{ $komputer->typ_k }}">
      <input type="hidden" name="model_k" value="{{ $komputer->model_k }}">
      <input type="hidden" name="ip_k" value="{{ $komputer->ip_k }}">
      <input type="hidden" name="proc_k" value="{{ $komputer->proc_k }}">
      <input type="hidden" name="hdd_k" value="{{ $komputer->hdd_k }}">
      <input type="hidden" name="ram_k" value="{{ $komputer->ram_k }}">
        @csrf
          <fieldset class="authFieldset">
            <legend>{{ $komputer->dns_k }}</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="dns_k" class="dns_k">{{ __('Nazwa') }}</label>
              </div>
              <div class="newDevice">
                @if (Session::has('kompStep1')) 
                  <input id="Nazwa" type="text" class="authField" name="dns_k" value="{{ Session::get('kompStep1')['dns_k'] }}"   
                  required autofocus>
                @else 
                <input id="Nazwa" type="text" class="authField" name="dns_k" value="{{ $komputer->dns_k }}" 
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
              <input type="text" name ="inwent_k" id="inwent_k" class="authField" value="{{ $komputer->inwent_k }}" 
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
              <input type="text" name ="serial_k" id="serial_k" class="authField" value="{{ $komputer->serial_k }}" 
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
              <input id="data_k" type="date" class="authField" name="data_k" value="{{ $komputer->data_k }}" 
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
                <label for="dzial_k" class="dzial_k">{{ __('Dział') }}</label>
              </div>
              <div class="newDevice">
                <select name="id_dz" id="dzial" class="devDetSelect">
                @if (Session::has('kompStep1')) 
                  @foreach($dzialy as $dzial)
                    @if (Session::get('kompStep1')['id_dz'] == $dzial->id_dz)
                      <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }} </option>
                    @else
                      <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                    @endif
                  @endforeach  
                @else 
                  @foreach($dzialy as $dzial)
                    @if ($komputer->id_dz == $dzial->id_dz)
                      <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }}</option>
                    @else
                      <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                    @endif
                  @endforeach
                @endif
                </select>
                @error('symbol_d')
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
                    @if ($komputer->id_u == $uzytkownik->id_u)
                      <option value = "{{ $uzytkownik->id_u }}" selected>{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u}}</option>
                    @else
                      <option value = "{{ $uzytkownik->id_u }}">{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u}}</option>
                    @endif
                  @endforeach
                @endif
                </select>
                @error('nazwa_u')
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
            <a class ="devLink" href="/komputery/{{ $komputer->id_k }}">WRÓĆ</a>
          </span>
          @error('ip_k')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          @error('proc_k')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          @error('ram_k')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
          @error('hdd_k')
            <span class="invalid-feedback" role="alert">
              <strong>{{ $message }}</strong>
            </span>
          @enderror
    </fieldset>
    </div>
  </div>
@endsection