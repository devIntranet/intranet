@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/urzadzenia/store" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowe Urządzenie</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="nazwa_dev" class="nazwa_dev">{{ __('Nazwa') }}</label>
              </div>
              <div class="newDevice">
                <input id="Nazwa" type="text" class="authField" name="nazwa_dev" value="{{ old('nazwa_dev') }}" 
                  required autofocus>
                @error('nazwa_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="typ_dev" class="typ_dev">{{ __('Typ') }}</label>
              </div>
              <div class="newDevice">
                <select name="typ_dev" id="typ" class="devDetSelect">
                  <option value = "drukarka">{{ __('drukarka') }}</option>
                  <option value = "skaner">{{ __('skaner') }}</option>
                  <option value = "switch">{{ __('switch') }}</option>
                  <option value = "router">{{ __('router') }}</option>                 
                  <option value = "biblioteka">{{ __('biblioteka') }}</option>
                  <option value = "inne">{{ __('inne') }}</option>
                </select>
                @error('typ_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="model_dev" class="model_dev">{{ __('Model') }}</label>
              </div>
              <div class="newDevice">
                <input id="Model" type="text" class="authField" name="model_dev" value="{{ old('model_dev') }}" 
                  required autofocus>
                @error('model_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="inwent_dev" class="inwent_dev">{{ __('Nr inwent') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="inwent_dev" id="inwent_dev" class="authField" value="{{ old('inwent_dev') }}" 
                  required autofocus>
                @error('inwent_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="serial_dev" class="serial_dev">{{ __('Nr seryjny') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="serial_dev" id="serial_dev" class="authField" value="{{ old('serial_dev') }}" 
                  required autofocus>
                @error('serial_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="ip_dev" class="ip_dev">{{ __('Adres IP') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="ip_dev" id="ip_dev" class="authField" value="{{ old('ip_dev') }}" 
                  placeholder="Może pozostać puste" autofocus>
                @error('ip_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="data_dev" class="data_dev">{{ __('Data zakupu') }}</label>
              </div>
              <div class="newDevice">
                <input id="data_dev" type="date" class="authField" name="data_dev" value="{{ old('data_dev') }}" 
                  required autofocus>
                @error('data_dev')
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
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="id_k" class="id_k">{{ __('Komputer') }}</label>
              </div>
              <div class="newDevice">
                <select name="id_k" id="id_k" class="devDetSelect">
                    <option value = "" selected>{{ __('Brak') }}</option>    
                    @foreach($komputery as $komputer)
                        <option value = "{{ $komputer->id_k }}">{{ $komputer->dns_k }}</option>
                    @endforeach  
                </select>
                @error('id_k')
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