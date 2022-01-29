@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="/komputery/update/{{ $id }}" method="POST">
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
                  @if ($step1['typ_k'] == 'K')
                    <option value="K" selected>Komputer</option>
                  @else
                    <option value="K">Komputer</option>
                  @endif
                  @if ($step1['typ_k'] == 'N')
                    <option value="N" selected>Laptop</option>
                  @else
                    <option value="L">Laptop</option>
                  @endif
                  @if ($step1['typ_k'] == 'S')
                    <option value="S" selected>Serwer</option>
                  @else
                    <option value="S">Serwer</option>
                  @endif
                </select>
                @error('typ_k')
                <span- class="invalid-feedback" role="alert">
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
                <input id="model_k" type="text" class="authField" name="model_k" value="{{ $step1['model_k'] }}" 
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
                <input id="ip_k" type="text" class="authField" name="ip_k" value="{{ $step1['ip_k'] }}" 
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
                <input id="proc_k" type="text" class="authField" name="proc_k" value="{{ $step1['proc_k'] }}" 
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
                <input id="ram_k" type="text" class="authField" name="ram_k" value="{{ $step1['ram_k'] }}" 
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
                <input id="hdd_k" type="text" class="authField" name="hdd_k" value="{{ $step1['hdd_k'] }}" 
                  required autofocus>
                @error('hdd_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="authButton">
              {{ __('Zapisz') }}
            </button>
          </form>
        <p>
      <a class ="devLink" href="{{ url()->previous() }}">WRÓĆ</a>
    </p>
    </fieldset>
    </div>
  </div>
@endsection
