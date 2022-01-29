@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <script>
        function modOfficeSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modOfficeEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("officeModuly").style.display = "inline";
            }
            else{
                document.getElementById("officeModuly").style.display = "none";
            }
          }
          else{
              document.getElementById("officeModuly").style.display = "none";
          }
        }
        function modTelwinSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modTelwinEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("telwinModuly").style.display = "inline";
            }
            else{
                document.getElementById("telwinModuly").style.display = "none";
            }
          }
          else{
              document.getElementById("telwinModuly").style.display = "none";
          }
        }
        function modSensusReadSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modSensusReadEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("sensusReadModuly").style.display = "inline";
            }
            else{
                document.getElementById("sensusReadModuly").style.display = "none";
            }
          }
          else{
              document.getElementById("sensusReadModuly").style.display = "none";
          }
        }
        function modSensusKonwerterSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modSensusKonwerterEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("sensusKonwerterModuly").style.display = "inline";
            }
            else{
                document.getElementById("sensusKonwerterModuly").style.display = "none";
            }
          }
          else{
              document.getElementById("sensusKonwerterModuly").style.display = "none";
          }
        }
        function modDiavasoSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modDiavasoEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("diavasoModuly").style.display = "inline";
            }
            else{
                document.getElementById("diavasoModuly").style.display = "none";
            }
          }
          else{
              document.getElementById("diavasoModuly").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <legend>
          {{ __('Pozostałe aplikacje') }}  
        </legend>
        <form action="{{ route('wnioski.addStep7p') }}" method="POST">
          @csrf
          <div class="authRowDiv"><!-- Blok Monitoring Pojazdów -->
              <div class="newDevice"><!-- Monitoring Pojazdów -->
                <label for="windows" class="windows">{{ __('Microsoft Office') }}</label>
              </div><!-- Monitoring Pojazdów -->
              <div class="newDevice">
                <select name="office" id="office" class="devDetSelect" onchange="modOfficeSelectCheck(this);">
                @if (Session::has('office') && Session::get('office') == 1) 
                  <option id="modOfficeEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modOfficeEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('office')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('office') && Session::get('office') == 1)
                  <select name="officeModuly" id="officeModuly" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="officeModuly" id="officeModuly" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($officeModuly as $officeModul)
                  @if (Session::has('officeModuly') && Session::get('officeModuly') == $officeModul->id_mod)
                    <option value="{{$officeModul->id_mod}}" selected>{{$officeModul->nazwa_mod}}</option>
                  @else
                  <option value="{{$officeModul->id_mod}}">{{$officeModul->nazwa_mod}}</option>
                  @endif
                  {{ $officeModul->nazwa_mod  }}
                @endforeach
                </select>
              </div>
            </div>
          <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Telwin') }}</label>
              </div><!-- Monitoring Pojazdów -->
              <div class="newDevice">
                <select name="telwin" id="telwin" class="devDetSelect" onchange="modTelwinSelectCheck(this);">
                @if (Session::has('telwin') && Session::get('telwin') == 1) 
                  <option id="modTelwinEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modTelwinEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('telwin')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('telwin') && Session::get('telwin') == 1)
                  <select name="telwinModuly" id="telwinModuly" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="telwinModuly" id="telwinModuly" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($telwinModuly as $telwinModul)
                @if (Session::has('telwinModuly') && Session::get('telwinModuly') == $telwinModul->id_mod)
                  <option value="{{$telwinModul->id_mod}}" selected>{{$telwinModul->nazwa_mod}}</option>
                @else
                  <option value="{{$telwinModul->id_mod}}">{{$telwinModul->nazwa_mod}}</option>
                @endif
                  {{ $telwinModul->nazwa_mod  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Sensus Read') }}</label>
              </div>
              <div class="newDevice">
                <select name="sensusRead" id="sensusRead" class="devDetSelect" onchange="modSensusReadSelectCheck(this);">
                @if (Session::has('sensusRead') && Session::get('sensusRead') == 1) 
                  <option id="modSensusReadEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modSensusReadEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('sensusRead')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('sensusRead') && Session::get('sensusRead') == 1)
                  <select name="sensusReadModuly" id="sensusReadModuly" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="sensusReadModuly" id="sensusReadModuly" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($sensusReadModuly as $sensusReadModul)
                  @if (Session::has('sensusReadModuly') && Session::get('sensusReadModuly') == $sensusReadModul->id_mod)
                    <option value="{{$sensusReadModul->id_mod}}" selected>{{$sensusReadModul->nazwa_mod}}</option>
                  @else
                    <option value="{{$sensusReadModul->id_mod}}">{{$sensusReadModul->nazwa_mod}}</option>
                  @endif
                  {{ $sensusReadModul->nazwa_mod  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Sensus Konwerter') }}</label>
              </div>
              <div class="newDevice">
                <select name="sensusKonwerter" id="sensusKonwerter" class="devDetSelect" onchange="modSensusKonwerterSelectCheck(this);">
                @if (Session::has('sensusKonwerter') && Session::get('sensusKonwerter') == 1) 
                  <option id="modSensusKonwerterEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modSensusKonwerterEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('sensusKonwerter')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('sensusKonwerter') && Session::get('sensusKonwerter') == 1)
                  <select name="sensusKonwerterModuly" id="sensusKonwerterModuly" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="sensusKonwerterModuly" id="sensusKonwerterModuly" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($sensusKonwerterModuly as $sensusKonwerterModul)
                @if (Session::has('sensusKonwerterModuly') && Session::get('sensusKonwerterModuly') == $sensusKonwerterModul->id_mod)
                  <option value="{{$sensusKonwerterModul->id_mod}}" selected>{{$sensusKonwerterModul->nazwa_mod}}</option>
                  @else
                    <option value="{{$sensusKonwerterModul->id_mod}}">{{$sensusKonwerterModul->nazwa_mod}}</option>
                  @endif
                  {{ $sensusKonwerterModul->nazwa_mod  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Diavaso') }}</label>
              </div>
              <div class="newDevice">
                <select name="diavaso" id="diavaso" class="devDetSelect" onchange="modDiavasoSelectCheck(this);">
                @if (Session::has('diavaso') && Session::get('diavaso') == 1) 
                  <option id="modDiavasoEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modDiavasoEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('diavaso')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('diavaso') && Session::get('diavaso') == 1)
                  <select name="diavasoModuly" id="diavasoModuly" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="diavasoModuly" id="diavasoModuly" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($diavasoModuly as $diavasoModul)
                  @if (Session::has('diavasoModuly') && Session::get('diavasoModuly') == $diavasoModul->id_mod)
                    <option value="{{$diavasoModul->id_mod}}" selected>{{$diavasoModul->nazwa_mod}}</option>
                  @else
                    <option value="{{$diavasoModul->id_mod}}">{{$diavasoModul->nazwa_mod}}</option>
                  @endif
                  {{ $diavasoModul->nazwa_mod  }}
                @endforeach
                </select>
              </div>
            </div>
            
             <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Rozliczenie Inkasenta') }}</label>
              </div>
              <div class="newDevice">
                <select name="rozliczenieInkasenta" id="rozliczenieInkasenta" class="devDetSelect">
                @if (Session::has('rozliczenieInkasenta') && Session::get('rozliczenieInkasenta') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('rozliczenieInkasenta')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('AutoCAD') }}</label>
              </div>
              <div class="newDevice">
                <select name="autocad" id="autocad" class="devDetSelect">
                @if (Session::has('autocad') && Session::get('autocad') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('autocad')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('G-Star CAD') }}</label>
              </div>
              <div class="newDevice">
                <select name="g-starCad" id="g-starCad" class="devDetSelect">
                @if (Session::has('g-starCad') && Session::get('g-starCad') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('g-starCad')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('IS-PRO Profil Koordynator') }}</label>
              </div>
              <div class="newDevice">
                <select name="profilKoordynator" id="profilKoordynator" class="devDetSelect">
                @if (Session::has('profilKoordynator') && Session::get('profilKoordynator') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('profilKoordynator')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('IS-PRO Profil Administrator') }}</label>
              </div>
              <div class="newDevice">
                <select name="profilAdministrator" id="profilAdministrator" class="devDetSelect">
                @if (Session::has('profilAdministrator') && Session::get('profilAdministrator') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('profilAdministrator')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Norma PRO') }}</label>
              </div>
              <div class="newDevice">
                <select name="normaPRO" id="normaPRO" class="devDetSelect">
                @if (Session::has('normaPRO') && Session::get('normaPRO') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('normaPRO')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          <span class="editButton"> 
            <a class ="devLink" href="{{ route('wnioski.addStep6') }}">WRÓĆ</a>
          </span>
        </form>
      </fieldset>
    </div> <!-- Wrapper -->
  </div> <!-- TREŚĆ -->
@endsection