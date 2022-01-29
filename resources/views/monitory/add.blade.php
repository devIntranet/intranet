@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/monitory/store" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy Monitor</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="model_m" class="model_m">{{ __('Model') }}</label>
              </div>
              <div class="newDevice">
                <input id="Model" type="text" class="authField" name="model_m" value="{{ old('model_m') }}" 
                  required autofocus>
                @error('model_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="inwent_m" class="inwent_m">{{ __('Nr inwent') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="inwent_m" id="inwent_m" class="authField" value="{{ old('inwent_m') }}" 
                  required autofocus>
                @error('inwent_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="serial_m" class="serial_m">{{ __('Nr seryjny') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="serial_m" id="serial_m" class="authField" value="{{ old('serial_m') }}" 
                  required autofocus>
                @error('serial_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="data_k" class="data_k">{{ __('Data zakupu') }}</label>
              </div>
              <div class="newDevice">
                <input id="data_m" type="date" class="authField" name="data_m" value="{{ old('data_m') }}" 
                  required autofocus>
                @error('data_m')
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