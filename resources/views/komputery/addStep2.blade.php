@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/komputery/store" method="POST">
        @csrf
        <input type="hidden" name="dns_k" value="{{ $step1['dns_k'] }}">
        <input type="hidden" name="inwent_k" value="{{ $step1['inwent_k'] }}">
        <input type="hidden" name="serial_k" value="{{ $step1['serial_k'] }}">
        <input type="hidden" name="data_k" value="{{ $step1['data_k'] }}">
        <input type="hidden" name="id_u" value="{{ $step1['id_u'] }}">
        <input type="hidden" name="id_dz" value="{{ $step1['id_dz'] }}">
          <fieldset class="authFieldset">
            <legend>
              {{ request()->get('dns_k') }}  
              &bull; {{ request()->get('inwent_k') }}
            </legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="typ_k" class="typ">{{ __('Typ') }}</label>
              </div>
              <div class="newDevice">
                <select name="typ_k" id="typ" class="devDetSelect">
                  <option value="K">Komputer</option>
                  <option value="N">Laptop</option>
                  <option value="S">Serwer</option>
                </select>
                @error('typ_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="model_k" class="model_k">{{ __('Model') }}</label>
              </div>
              <div class="newDevice">
                <input id="model_k" type="text" class="authField" name="model_k" value="{{ old('model_k') }}" 
                  required autofocus>
                @error('model_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="ip_k" class="ip_k">{{ __('Adres IP') }}</label>
              </div>
              <div class="newDevice">
                <input id="ip_k" type="text" class="authField" name="ip_k" value="{{ old('ip_k') }}" 
                  required autofocus>
                @error('ip_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="proc_k" class="proc_k">{{ __('Procesor') }}</label>
              </div>
              <div class="newDevice">
                <input id="proc_k" type="text" class="authField" name="proc_k" value="{{ old('proc_k') }}" 
                  required autofocus>
                @error('proc_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="ram_k" class="ram_k">{{ __('RAM') }}</label>
              </div>
              <div class="newDevice">
                <input id="ram_k" type="text" class="authField" name="ram_k" value="{{ old('ram_k') }}" 
                  required autofocus>
                @error('ram_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="hdd_k" class="hdd_k">{{ __('HDD') }}</label>
              </div>
              <div class="newDevice">
                <input id="hdd_k" type="text" class="authField" name="hdd_k" value="{{ old('hdd_k') }}" 
                  required autofocus>
                @error('hdd_k')
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
        <p>
      <a class ="devLink" href="{{ url()->previous() }}">WRÓĆ</a>
    </p>
    </fieldset>
    </div>
  </div>
@endsection