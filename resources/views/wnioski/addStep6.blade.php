@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <script>
        function modTransportSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modTransportEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("transportRole").style.display = "inline";
            }
            else{
                document.getElementById("transportRole").style.display = "none";
            }
          }
          else{
              document.getElementById("transportRole").style.display = "none";
          }
        }
        function modGPSSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modGPSEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("GPSModuly").style.display = "inline";
            }
            else{
                document.getElementById("GPSModuly").style.display = "none";
            }
          }
          else{
              document.getElementById("GPSModuly").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <legend>
          {{ __('Transport') }}  
        </legend>
        <form action="{{ route('wnioski.addStep6p') }}" method="POST">
          @csrf
          
             <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Program Transport') }}</label>
              </div>
              <div class="newDevice">
                <select name="transport" id="transport" class="devDetSelect" onchange="modTransportSelectCheck(this);">
                @if (Session::has('transport') && Session::get('transport') == 1) 
                  <option id="modTransportEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modTransportEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('Transport')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('transport') && Session::get('transport') == 1)
                  <select name="transportRole" id="transportRole" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="transportRole" id="transportRole" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($transportRole as $transportRola)
                  @if (Session::has('transportRole') && Session::get('transportRole') == $transportRola->id_r)
                    <option value="{{$transportRola->id_r}}" selected>{{$transportRola->nazwa_r}}</option>
                  @else
                    <option value="{{$transportRola->id_r}}">{{$transportRola->nazwa_r}}</option>
                  @endif
                  {{ $transportRola->nazwa_r  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv"><!-- Blok Monitoring Pojazdów -->
              <div class="newDevice"><!-- Monitoring Pojazdów -->
                <label for="windows" class="windows">{{ __('Monitoring Pojazdów') }}</label>
              </div><!-- Monitoring Pojazdów -->
              <div class="newDevice">
                <select name="GPS" id="GPS" class="devDetSelect" onchange="modGPSSelectCheck(this);">
                @if (Session::has('GPS') && Session::get('GPS') == 1) 
                  <option id="modGPSEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modGPSEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('GPS')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('GPS') && Session::get('GPS') == 1)
                  <select name="GPSModuly" id="GPSModuly" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="GPSModuly" id="GPSModuly" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($GPSModuly as $GPSModul)
                  <option value="{{$GPSModul->id_mod}}">{{$GPSModul->nazwa_mod}}</option>
                  {{ $GPSModul->nazwa_mod  }}
                @endforeach
                </select>
              </div>
            </div><!-- Blok Monitoring Pojazdów -->
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          <span class="editButton"> 
            <a class ="devLink" href="{{ route('wnioski.addStep5') }}">WRÓĆ</a>
          </span>
        </form>
      </fieldset>
    </div> <!-- Wrapper -->
  </div> <!-- TREŚĆ -->
@endsection