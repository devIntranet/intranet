@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <script>
        function modKomaxSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modKomaxEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("komaxRola").style.display = "inline";
            }
            else{
                document.getElementById("komaxRola").style.display = "none";
            }
          }
          else{
              document.getElementById("komaxRola").style.display = "none";
          }
        }
        function modRCPSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modRCPEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("RCPRola").style.display = "inline";
            }
            else{
                document.getElementById("RCPRola").style.display = "none";
            }
          }
          else{
              document.getElementById("RCPRola").style.display = "none";
          }
        }
        function modPlatnikSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modPlatnikEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("platnikRola").style.display = "inline";
            }
            else{
                document.getElementById("platnikRola").style.display = "none";
            }
          }
          else{
              document.getElementById("platnikRola").style.display = "none";
          }
        }
        function modPPKSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modPPKEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("PPKRola").style.display = "inline";
            }
            else{
                document.getElementById("PPKRola").style.display = "none";
            }
          }
          else{
              document.getElementById("PPKRola").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <form action="{{ route('wnioski.addStep5p') }}" method="POST">
          @csrf
            <legend>
              {{ __('Programy Kadrowe') }}  
            </legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('KOMAX') }}</label>
              </div>
              <div class="newDevice">
                <select name="komax" id="komax" class="devDetSelect" onchange="modKomaxSelectCheck(this);">
                @if (Session::has('komax') && Session::get('komax') == 1) 
                  <option id="modKomaxEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modKomaxEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('komax')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('komax') && Session::get('komax') == 1)
                  <select name="komaxRola" id="komaxRola" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="komaxRola" id="komaxRola" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($komaxRole as $komaxRola)
                  @if (Session::has('komaxRola') && Session::get('komaxRola') == $komaxRola->id_r)
                    <option value="{{$komaxRola->id_r}}" selected>{{$komaxRola->nazwa_r}}</option>
                  @else
                    <option value="{{$komaxRola->id_r}}">{{$komaxRola->nazwa_r}}</option>
                  @endif
                  {{ $komaxRola->nazwa_r  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('RCP') }}</label>
              </div>
              <div class="newDevice">
                <select name="RCP" id="RCP" class="devDetSelect" onchange="modRCPSelectCheck(this);">
                @if (Session::has('RCP') && Session::get('RCP') == 1) 
                  <option id="modRCPEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modRCPEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('RCP')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('RCP') && Session::get('RCP') == 1)
                  <select name="RCPRola" id="RCPRola" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="RCPRola" id="RCPRola" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($RCPRole as $RCPRola)
                  @if (Session::has('RCPRola') && Session::get('RCPRola') == $RCPRola->id_r)
                    <option value="{{$RCPRola->id_r}}" selected>{{$RCPRola->nazwa_r}}</option>
                  @else
                    <option value="{{$RCPRola->id_r}}">{{$RCPRola->nazwa_r}}</option>
                  @endif
                  {{ $RCPRola->nazwa_r  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Płatnik') }}</label>
              </div>
              <div class="newDevice">
                <select name="platnik" id="platnik" class="devDetSelect" onchange="modPlatnikSelectCheck(this);">
                @if (Session::has('platnik') && Session::get('platnik') == 1) 
                  <option id="modPlatnikEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modPlatnikEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('platnik')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('platnik') && Session::get('platnik') == 1)
                  <select name="platnikRola" id="platnikRola" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="platnikRola" id="platnikRola" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($platnikRole as $platnikRola)
                  @if (Session::has('platnikRola') && Session::get('platnikRola') == $platnikRola->id_r)
                    <option value="{{$platnikRola->id_r}}" selected>{{$platnikRola->nazwa_r}}</option>
                  @else
                    <option value="{{$platnikRola->id_r}}">{{$platnikRola->nazwa_r}}</option>
                  @endif
                  {{ $platnikRola->nazwa_r  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('PPK') }}</label>
              </div>
              <div class="newDevice">
                <select name="ppk" id="ppk" class="devDetSelect" onchange="modPPKSelectCheck(this);">
                @if (Session::has('ppk') && Session::get('ppk') == 1) 
                  <option id="modPPKEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modPPKEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('ppk')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('ppk') && Session::get('ppk') == 1)
                  <select name="PPKRola" id="PPKRola" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="PPKRola" id="PPKRola" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($PPKRole as $PPKRola)
                  @if (Session::has('PPKRola') && Session::get('PPKRola') == $PPKRola->id_r)
                    <option value="{{$PPKRola->id_r}}" selected>{{$PPKRola->nazwa_r}}</option>
                  @else
                    <option value="{{$PPKRola->id_r}}">{{$PPKRola->nazwa_r}}</option>
                  @endif
                  {{ $PPKRola->nazwa_r  }}
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('e-PFRON') }}</label>
              </div>
              <div class="newDevice">
                <select name="epfron" id="epfron" class="devDetSelect">
                @if (Session::has('epfron') && Session::get('epfron') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('epfron')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Ubezpieczenia Pracownicze') }}</label>
              </div>
              <div class="newDevice">
                <select name="ubezpieczenia" id="ubezpieczenia" class="devDetSelect">
                @if (Session::has('ubezpieczenia') && Session::get('ubezpieczenia') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('ubezpieczenia')
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
            <a class ="devLink" href="{{ route('wnioski.addStep4') }}">WRÓĆ</a>
          </span>
        </form>
      </fieldset>
    </div>
  </div>
@endsection