@extends('Layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <form action="{{ route('dzialy.store') }}" method="POST">
        @csrf
          <fieldset class="authFieldset">
            <legend>Nowy Dział</legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="nazwa_d" class="nazwa_d">{{ __('Nazwa') }}</label>
              </div>
              <div class="newDzial">
                <input id="Nazwa" type="text" class="authField" name="nazwa_d" value="{{ old('nazwa_d') }}" 
                  required autofocus>
                @error('nazwa_d')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="symbol_d" class="symbol_d">{{ __('Symbol') }}</label>
              </div>
              <div class="newDzial">
                <input id="Nazwa" type="text" class="authField" name="symbol_d" value="{{ old('symbol_d') }}" 
                  required autofocus>
                @error('symbol_d')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="pion_d" class="pion_d">{{ __('Pion') }}</label>
              </div>
              <div class="newDevice">
                <select name="id_p" id="pion" class="devDetSelect">
                  @foreach($piony as $pion)
                    <option value = "{{ $pion->id_p }}">{{ $pion->nazwa_p }}</option>
                  @endforeach
                </select>
                @error('id_p')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="parent_dz" class="parent_dz">{{ __('Dział Nadrzędny') }}</label>
              </div>
              <div class="newDevice">
                <select name="parent_dz" id="parent" class="devDetSelect">
                  <option value = "">{{ __(' --- ') }}</option>
                  @foreach($parents as $parent)
                    <option value = "{{ $parent->id_dz }}">{{ $parent->symbol_d }}</option>
                  @endforeach
                </select>
                @error('parent_dz')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="id_uk" class="id_uk">{{ __('Kierownik') }}</label>
              </div>
              <div class="newDevice">
                <select name="id_uk" id="manager" class="devDetSelect">
                  @foreach($managers as $manager)
                    <option value = "{{ $manager->id_u }}">{{ $manager->nazwa_u }} {{ $manager->imie_u }}</option>
                  @endforeach
                </select>
                @error('id_uk')
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