@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <script>
        function CCTVSelectCheck(udSelect) {
          if(udSelect){
            udEnabledValue = document.getElementById("CCTVEnabled").value;
            if(udEnabledValue == udSelect.value){
                document.getElementById("CCTVdiv").style.display = "block";
            }
            else{
                document.getElementById("CCTVdiv").style.display = "none";
            }
          }
          else{
              document.getElementById("CCTVdiv").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <legend>
          {{ __('Monitoring CCTV') }}  
        </legend>
        <div class="newDevice">
          <label for="CCTV" class="windows">{{ __('Monitoring wizyjny') }}</label>
        </div>
        <form action="{{ route('wnioski.addStep8p') }}" method="POST">
          @csrf
          <select name="CCTV" id="CCTV" class="devDetSelect" onchange="CCTVSelectCheck(this);">
          @if (Session::has('CCTV') && Session::get('CCTV') == 1) 
            <option id="CCTVEnabled" value="1" selected>Tak</option>
            <option value="0">Nie</option>
          @else
            <option id="CCTVEnabled" value="1">Tak</option>
            <option value="0" selected>Nie</option>
          @endif
          </select>
          @if (Session::has('CCTV') && Session::get('CCTV') == 1) 
          <div id="CCTVdiv" style="display:block">
          @else
          <div id="CCTVdiv" style="display:none">
          @endif
          @foreach($monitoringSystemy as $monitoringSystem)
          <div class="authRowDiv">
              <div class="newDevice">
                <label for="monsys[{{ $monitoringSystem->id_monsys }}]" class="windows">{{ $monitoringSystem->nazwa_monsys }}</label>
              </div>
              <div class="newDevice">
                <select name="monsys[{{ $monitoringSystem->id_monsys }}]" class="devDetSelect">
                @if (@isset(Session::get('monsys')[$monitoringSystem->id_monsys]) && Session::get('monsys')[$monitoringSystem->id_monsys] == 1)
                  <option value="0">Nie</option>
                  <option value="1" selected>Podgląd</option>
                  <option value="2">Odtwarzanie</option>
                  <option value="3">Administracja</option>
                @elseif (@isset(Session::get('monsys')[$monitoringSystem->id_monsys]) && Session::get('monsys')[$monitoringSystem->id_monsys] == 2)
                  <option value="0">Nie</option>
                  <option value="1">Podgląd</option>
                  <option value="2" selected>Odtwarzanie</option>
                  <option value="3">Administracja</option>
                @elseif (@isset(Session::get('monsys')[$monitoringSystem->id_monsys]) && Session::get('monsys')[$monitoringSystem->id_monsys] == 3) 
                  <option value="0">Nie</option>
                  <option value="1">Podgląd</option>
                  <option value="2">Odtwarzanie</option>
                  <option value="3" selected>Administracja</option>
                @else 
                  <option value="0" selected>Nie</option>
                  <option value="1">Podgląd</option>
                  <option value="2">Odtwarzanie</option>
                  <option value="3">Administracja</option>
                @endif
                </select>
                @error('cctvTychy')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            @endforeach
            </div> <!-- CCTVdiv (ukrywany) -->
            <div>
              <button type="submit" class="wniosekDalejButton">
                {{ __('Dalej') }}
              </button>
            <span class="editButton"> 
              <a class ="devLink" href="{{ route('wnioski.addStep7') }}">WRÓĆ</a>
            </span>
          </div>
        </form>
      </fieldset>
    </div> <!-- Wrapper -->
  </div> <!-- TREŚĆ -->
@endsection