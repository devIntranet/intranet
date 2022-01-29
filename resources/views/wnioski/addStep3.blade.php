@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
      <script>
        function modSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("moduly").style.display = "block";
            }
            else{
                document.getElementById("moduly").style.display = "none";
            }
          }
          else{
              document.getElementById("moduly").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <form action="{{ route('wnioski.addStep3p') }}" method="POST">
          @csrf
            <legend>
              {{ __('TPMedia') }}  
            </legend>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Konto w programie TPMedia') }}</label>
              </div>
              <div class="newDevice">
                <select name="TPMedia" id="tpmedia" class="devDetSelect" onchange="modSelectCheck(this);">
                @if (Session::has('TPMedia') && Session::get('TPMedia') == 1) 
                  <option id="modEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('tpmedia')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
              @if (Session::has('TPMedia') && Session::get('TPMedia') == 1) 
                <div class="moduly" id="moduly" style="display:block;">
              @else 
                <div class="moduly" id="moduly" style="display:none;">
              @endif
                
              {{ __('Moduły TPMedia:')}}
              @foreach($moduly as $modul)
                <div class="modulyTPMedia">
                  @if (@isset(Session::get('selectedTPMediaModuly')[$modul->id_mod]) && Session::get('selectedTPMediaModuly')[$modul->id_mod] == true)
                    <input type="checkbox" name="selectedTPMediaModuly[{{ $modul->id_mod }}]" checked 
                      onclick="document.getElementById({{ $modul->id_mod }}).style.display = this.checked? 'inline' : 'none'; "> 
                  @else 
                    <input type="checkbox" name="selectedTPMediaModuly[{{ $modul->id_mod }}]"
                      onclick="document.getElementById({{ $modul->id_mod }}).style.display = this.checked? 'inline' : 'none'; "> 
                  @endif
                  <label for="$modul->nazwa_mod">
                    {{ __($modul->nazwa_mod)}}
                  </label>
                </div>
                @if (@isset(Session::get('selectedTPMediaModuly')[$modul->id_mod]) && Session::get('selectedTPMediaModuly')[$modul->id_mod] == true)
                  <div class="moduly" id="{{ $modul->id_mod }}" style="display:block;">
                @else  
                  <div class="moduly" id="{{ $modul->id_mod }}" style="display:none;">
                @endif
                @if($modul->id_mod == 40) <!-- jeśli Gospodarka Materiałowa (id=40) -->
                  <table class="magazynyTab" id="magazynTab">
                    <tr>
                      <th>Rola</th>
                      <th>Nr Magazynu</th>
                      <th>Typ Magazynu</th>
                      <th>Nazwa</th>
                    </tr>
                    @foreach($magazyny as $magazyn) <!-- magazyny dla poziomu magazyniera -->
                      <tr>
                        <td>
                          <select name="magazynRola[{{ $magazyn->MAGAZYN }}]" class="shareSelect">
                            <option>---</option>
                            @if (@isset(Session::get('magazynRola')[$magazyn->MAGAZYN]) && Session::get('magazynRola')[$magazyn->MAGAZYN] == '1')
                              <option value="1" selected="selected">Magazynier</option>
                              <option value="2">Dysponent</option>
                            @elseif (@isset(Session::get('magazynRola')[$magazyn->MAGAZYN]) && Session::get('magazynRola')[$magazyn->MAGAZYN] == '2')
                              <option value="1" >Magazynier</option>
                              <option value="2" selected="selected">Dysponent</option>
                            @else
                              <option value="1" >Magazynier</option>
                              <option value="2">Dysponent</option>
                            @endif
                        </select>
                        <td>{{ $magazyn->MAGAZYN }}</td>
                        <td>{{ $magazyn->TYP }}</td>
                        <td>{{ $magazyn->NAZWA }}</td>
                      </tr>
                    @endforeach
                  </table>
                @else
                  <table>
                    <tr>
                      <th>Poziom dostepu</th>
                    </tr>
                    <tr>
                      <td>
                        <select name="uprTPMediaModuly[{{ $modul->id_mod }}]" id="{{$modul->id_mod}} " class="shareSelect">
                          @if (@isset(Session::get('uprTPMediaModuly')[$modul->id_mod]) && Session::get('uprTPMediaModuly')[$modul->id_mod] == '1')
                            <option value="1" selected="selected">Odczyt</option>
                            <option value="2">Edycja</option>
                          @elseif (@isset(Session::get('uprTPMediaModuly')[$modul->id_mod]) && Session::get('uprTPMediaModuly')[$modul->id_mod] == '2')
                            <option value="1" >Odczyt</option>
                            <option value="2" selected="selected">Zapis</option>
                          @else
                            <option value="1" selected="selected">Odczyt</option>
                            <option value="2">Zapis</option>
                          @endif
                        </select>
                      </td>
                    </tr>
                  </table>
                @endif <!-- jeśli Gospodarka Materiałowa -->
                </div>
              @endforeach
            </div>   
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          <span class="editButton"> 
            <a class ="devLink" href="{{ route('wnioski.addStep2') }}">WRÓĆ</a>
          </span>
        </form>
      </fieldset>
    </div>
  </div>
@endsection