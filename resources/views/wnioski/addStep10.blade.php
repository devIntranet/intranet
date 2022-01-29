@extends('layouts/layout')
@section('content')
  <div id="TRESC">
    <div class="wrapper add-komp">
    <script>
        function extMailboxesSelectCheck(modSelect) {
          if(modSelect){
            modEnabledValue = document.getElementById("modMailboxesEnabled").value;
            if(modEnabledValue == modSelect.value){
                document.getElementById("extMailbox").style.display = "block";
            }
            else{
                document.getElementById("extMailbox").style.display = "none";
            }
          }
          else{
              document.getElementById("extMailbox").style.display = "none";
          }
        }
      </script>
      <fieldset class="authFieldset">
        <legend>
          {{ __('Zasoby internetowe') }}  
        </legend>
        <form action="{{ route('wnioski.addStep10p') }}" method="POST">
          @csrf
          <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Poziom dostępu do sieci Internet') }}</label>
              </div>
              <div class="newDevice">
                <select name="internetLevel" id="internetLevel" class="devDetSelect">
                  <option value="1" 
                  @if (Session::has('internetLevel') && Session::get('internetLevel') == 1) 
                    selected
                  @endif
                  >Poziom 1</option>
                  <option value="2" 
                  @if (Session::has('internetLevel') && Session::get('internetLevel') == 2) 
                    selected
                  @endif
                  >Poziom 2</option>
                  <option value="3" 
                  @if (Session::has('internetLevel') && Session::get('internetLevel') == 3) 
                    selected
                  @endif
                  >Poziom 3</option>
                  <option value="4" 
                  @if (Session::has('internetLevel') && Session::get('internetLevel') == 4) 
                    selected
                  @endif
                  >Poziom 4</option>
                  <option value="5" @if (Session::has('internetLevel') && Session::get('internetLevel') == 5) 
                    selected
                  @endif
                  >Poziom 5</option>
                </select>
                @error('internetLevel')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Imienna poczta zewnętrzna w domenie rpwik.tychy.pl') }}</label>
              </div>
              <div class="newDevice">
                <select name="pocztaZew" id="pocztaZew" class="devDetSelect">
                @if (Session::has('pocztaZew') && Session::get('pocztaZew') == 1) 
                  <option value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('pocztaZew')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div>
            </div>
            <div class="authRowDiv">
              <div class="newDevice">
                <label for="windows" class="windows">{{ __('Współdzielone skrzynki pocztowe w domenie rpwik.tychy.pl') }}</label>
              </div>
              <div class="newDevice"><!-- New Device: Select mailboxes -->
                <select name="mailboxes" id="mailboxes" class="devDetSelect" onchange="extMailboxesSelectCheck(this);">
                @if (Session::has('mailboxes') && Session::get('mailboxes') == 1) 
                  <option id="modMailboxesEnabled" value="1" selected>Tak</option>
                  <option value="0">Nie</option>
                @else
                  <option id="modMailboxesEnabled" value="1">Tak</option>
                  <option value="0" selected>Nie</option>
                @endif
                </select>
                @error('mailboxes')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              </div><!-- New Device: Select mailboxes -->
            </div>
            @if (Session::has('mailboxes') && Session::get('mailboxes') == 1) 
              <div class="extMailbox" id="extMailbox" style="display:block;"><!-- extmailbox -->
            @else 
              <div class="extMailbox" id="extMailbox" style="display:none;"><!-- extmailbox -->
            @endif
              <div class="modulyLabelDiv">
                {{ __('Skrzynki współdzielone:')}}
              </div>
              @foreach($extMailboxes as $extMailbox)
                <div class="extMailbox">
                  @if (@isset(Session::get('extMbx')[$extMailbox->id_mbx]) && Session::get('extMbx')[$extMailbox->id_mbx] == true)
                    <input type="checkbox" name="extMbx[{{ $extMailbox->id_mbx }}]" checked> 
                  @else 
                    <input type="checkbox" name="extMbx[{{ $extMailbox->id_mbx }}]"> 
                  @endif
                  <label for="$extMailbox->nazwa_mbx">
                    {{ __($extMailbox->nazwa_mbx)}}
                  </label>
                </div>
              @endforeach
                
              </div>
            <button type="submit" class="wniosekDalejButton">
              {{ __('Dalej') }}
            </button>
          <span class="editButton"> 
            <a class ="devLink" href="{{ route('wnioski.addStep9') }}">WRÓĆ</a>
          </span>
        </form>
      </fieldset>
    </div> <!-- Wrapper -->
  </div> <!-- TREŚĆ -->
@endsection