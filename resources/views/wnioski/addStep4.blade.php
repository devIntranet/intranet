@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <script>
        function modEkartSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modEkartEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("ekartRole").style.display = "inline";
            }
            else{
                document.getElementById("ekartRole").style.display = "none";
            }
          }
          else{
              document.getElementById("ekartRole").style.display = "none";
          }
        }
        function modKartMobileSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modKartMobileEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("kartMobileRole").style.display = "inline";
            }
            else{
                document.getElementById("kartMobileRole").style.display = "none";
            }
          }
          else{
              document.getElementById("kartMobileRole").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <form action="{{ route('wnioski.addStep4p') }}" method="POST">
          @csrf
            <legend>
              {{ __('Mapy Cyfrowe') }}  
            </legend>
            @if (Session::has('windows') && Session::get('windows') == 1) 
              <div class="authRowDiv" style="display:block;">
            @else
              <div class="authRowDiv" style="display:none;">
            @endif
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('eKart Analyst') }}</label>
              </div>
              <div class="newDevice">
                <select name="ekart" id="ekart" class="devDetSelect" onchange="modEkartSelectCheck(this);">
                @if (Session::has('ekart') && Session::get('ekart') == 1) 
                  <option id="modEkartEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modEkartEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('ekart')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('ekart') && Session::get('ekart') == 1)
                  <select name="ekartRole" id="ekartRole" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="ekartRole" id="ekartRole" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($ekartRole as $ekartRola)
                  @if (Session::has('ekartRola') && Session::get('ekartRola') == $ekartRola->id_r)
                    <option value="{{$ekartRola->id_r}}" selected>{{$ekartRola->nazwa_r}}</option>
                  @else
                    <option value="{{$ekartRola->id_r}}">{{$ekartRola->nazwa_r}}</option>
                  @endif
                  {{ $ekartRola->nazwa_r  }}
                  
                @endforeach
                </select>
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="kartmobile" class="windows">{{ __('KartMobile') }}</label>
              </div>
              <div class="newDevice">
                <select name="kartmobile" id="kartmobile" class="devDetSelect" onchange="modKartMobileSelectCheck(this);">
                @if (Session::has('kartmobile') && Session::get('kartmobile') == 1) 
                  <option id="modKartMobileEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modKartMobileEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('kartmobile')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                @if (Session::has('kartmobile') && Session::get('kartmobile') == 1)
                  <select name="kartMobileRole" id="kartMobileRole" class="devDetSelect"style="display:inline;"> 
                @else
                  <select name="kartMobileRole" id="kartMobileRole" class="devDetSelect"style="display:none;"> 
                @endif
                @foreach($kartMobileRole as $kartMobileRola)
                  @if (Session::has('kartMobileRole') && Session::get('kartMobileRole') == $kartMobileRola->id_r)
                    <option value="{{$kartMobileRola->id_r}}" selected>{{$kartMobileRola->nazwa_r}}</option>
                  @else
                    <option value="{{$kartMobileRola->id_r}}">{{$kartMobileRola->nazwa_r}}</option>
                  @endif
                  {{ $kartMobileRola->nazwa_r  }}
                @endforeach
                </select>
              </div>
            </div>
                
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          <span class="editButton"> 
            @if (Session::has('windows') && Session::get('windows') == 1) 
            <a class ="devLink" href="{{ route('wnioski.addStep3') }}">WRÓĆ</a>
            @else
            <a class ="devLink" href="{{ route('wnioski.addStep2') }}">WRÓĆ</a>
            @endif
          </span> 
        </form>
      </fieldset>
    </div>
  </div>
@endsection