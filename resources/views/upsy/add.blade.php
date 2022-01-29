@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/upsy/store" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy UPS</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="model_ups" class="model_ups">{{ __('Model') }}</label>
              </div>
              <div class="newDevice">
                <input id="Model" type="text" class="authField" name="model_ups" value="{{ old('model_ups') }}" 
                  required autofocus>
                @error('model_ups')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="inwent_ups" class="inwent_ups">{{ __('Nr inwent') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="inwent_ups" id="inwent_ups" class="authField" value="{{ old('inwent_ups') }}" 
                  required autofocus>
                @error('inwent_ups')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="serial_ups" class="serial_ups">{{ __('Nr seryjny') }}</label>
              </div>
              <div class="newDevice">
                <input type="text" name ="serial_ups" id="serial_ups" class="authField" value="{{ old('serial_ups') }}" 
                  required autofocus>
                @error('serial_ups')
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
                <input id="data_ups" type="date" class="authField" name="data_ups" value="{{ old('data_ups') }}" 
                  required autofocus>
                @error('data_ups')
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