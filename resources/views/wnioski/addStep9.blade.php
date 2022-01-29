@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <fieldset class="authFieldset">
        <legend>
          {{ __('Strefy dostępu i pomieszczenia archiwum') }}  
        </legend>
        <form action="{{ route('wnioski.addStep9p') }}" method="POST">
          @csrf
          @foreach($strefyDostepu as $strefaDostepu)
          <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ $strefaDostepu->nazwa_strdst }}</label>
              </div>
              <div class="newDevice">
                <select name="strdst[{{ $strefaDostepu->id_strdst }}]" class="devDetSelect">
                @if (@isset(Session::get('strdst')[$strefaDostepu->id_strdst]) && Session::get('strdst')[$strefaDostepu->id_strdst] == 1)
                  <option value="0">Nie</option>
                  <option value="1" selected>Tak</option>
                @else 
                  <option value="0" selected>Nie</option>
                  <option value="1">Tak</option>
                @endif
                </select>
                @error('strdst')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            @endforeach
          @foreach($pomieszczeniaArchiwum as $pomieszczenieArchiwum)
          <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ $pomieszczenieArchiwum->nazwa_archp }}</label>
              </div>
              <div class="newDevice">
                <select name="archp[{{ $pomieszczenieArchiwum->id_archp }}]" class="devDetSelect">
                @if (@isset(Session::get('archp')[$pomieszczenieArchiwum->id_archp]) && Session::get('archp')[$pomieszczenieArchiwum->id_archp] == 1)
                  <option value="0">Nie</option>
                  <option value="1" selected>Tak</option>
                @else 
                  <option value="0" selected>Nie</option>
                  <option value="1">Tak</option>
                @endif
                </select>
                @error('archp')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            @endforeach
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          <span class="editButton"> 
          @if (Session::has('windows') && Session::get('windows') == 1) 
            <a class ="devLink" href="{{ route('wnioski.addStep8') }}">WRÓĆ</a>
            @else
            <a class ="devLink" href="{{ route('wnioski.addStep4') }}">WRÓĆ</a>
            @endif
         </span>
        </form>
      </fieldset>
    </div> <!-- Wrapper -->
  </div> <!-- TREŚĆ -->
@endsection