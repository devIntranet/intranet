@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      @if (@isset($tab['tab']) && $tab['tab'] == 'soft' )
      <legend>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft"
        class="fieldsetLegendLink">
        Oprogramowanie Komputera
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/komputery/{{ $komputer->id_k }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('PROGRAMY') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetRow">
          <td class="leftDevSoftDet">
            @isset($e['e'])
            @if ($e['e'] == 'os')
            <div class="newDevice">
            <form action="/komputery/addSoft/{{ $komputer->id_k }}">
            @csrf
            <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
            <input type="hidden" name="tab" value="soft">
            @if (@isset($os->id_p))
              <input type="hidden" name="id_i" value="{{ $os->id_i }}">
            @endif
            <select name="id_p" id="os" class="devDetSelect">
            @foreach($osy as $program)
              @if (@isset($os->id_p) && $program->id_p == $os->id_p)
                <option value = "{{ $program->id_p }}" selected>{{ $program->nazwa_p }}</option>
              @else
                <option value = "{{ $program->id_p }}">{{ $program->nazwa_p }}</option>
              @endif
            @endforeach
            </select>
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </form>
            </div>
            @else
              <a href="{{ route('programy.show', $os->id_p) }}" class="devLink">  
                {{ $os->nazwa_p }}
              </a>
            @endif
          @endisset
          @empty($e)
            @isset($os)
              <a href="{{ route('programy.show', $os->id_p) }}" class="devLink">  
                {{ $os->nazwa_p }}
              </a>
            @else
              <a href="/komputery/{{ $komputer->id_k }}?tab=soft&e=os" class="devLink">      
                {{ __('Dodaj System') }}
              </a>
            @endisset
              @empty($os)
                <a href="/komputery/{{ $komputer->id_k }}?tab=soft&e=os" class="devLink">      
                  {{ __('Dodaj System') }}
                </a>
              @endempty  
          @endempty 
          </td>
          <td class="rightDevSoftDet">
          <a href="/komputery/{{ $komputer->id_k }}?tab=soft&e=os" class="devLink">
            <img class="changeIcon" src="/img/change.png">
          </a>
        </td>
        </tr>
        <tr class="devDetRow">   
          <td class="leftDevDetHeadEmpty"></td>
          <td class="rightDevDetHeadEmpty"></td>
      </tr>
      </table>
      <table class="devDet">
        @foreach($soft as $program)  
        <tr class="devDetRow">
          <td class="leftDevSoftDet">
            @isset($program->nazwa_p)
              <a href="{{ route('programy.show', $program->id_p) }}" class="devLink">  
                {{ $program->nazwa_p }}
              </a>
            @endisset
          </td>
          <td class="rightDevSoftDet">
            <form action="/komputery/delSoft/{{ $komputer->id_k }}">
              @csrf
              <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
              <input type="hidden" name="id_i" value="{{ $program->id_i }}">
              <input type="hidden" name="tab" value="soft">
              <button type="submit" class="redDelButton">
            </form>
          </td>
        </tr>
        @endforeach
        <tr class="devDetRow">
          @isset($e['e']) 
            @if ($e['e'] == 'soft')
            <td class="leftDevDetHead">  
              <form action="/komputery/addSoft/{{ $komputer->id_k }}">
              @csrf
              <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
              <input type="hidden" name="tab" value="soft">
              @if (count($softToAdd)>0)
              <select name="id_p" id="idp" class="devDetSelect">
              @foreach($softToAdd as $program)
                <option value="{{ $program->id_p }}">
                  {{ $program->nazwa_p }}
                </option>
              @endforeach
              </select>
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span> 
              @else
                <span class="quickSubmit">
                  {{ __('Brak dostępnych programów') }}
                </span>
              @endif
            </form>
            </td>
            <td class="rightDevDetHead">
            @else
            <td class="leftDevDetHead">
            @if (count($softToAdd)>0)
            <form action="/komputery/{{ $komputer->id_k }}">
              @csrf
              <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
              <input type="hidden" name="tab" value="soft">
              <input type="hidden" name="e" value="soft">
              <button type="submit" class="greenAddButton">
            </form>
            @endif
            </td>
            <td class="rightDevDetHead">
            @endif
          @endisset
          @empty($e)
          <td class="leftDevDetHead"></td>
          <td class="rightDevDetHead">
              <form action="/komputery/{{ $komputer->id_k }}">
                @csrf
                <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
                <input type="hidden" name="tab" value="soft">
                <input type="hidden" name="e" value="soft">
                <button type="submit" class="greenAddButton">
              </form>
          </td>
          @endempty
          <td class="rightDevDetHead">
          </td>
        </tr>
      </table>
      <span class="editButton"> 
        <a href="/komputery?tab=soft" class="devLink">WRÓĆ</a>
      </span>
      @elseif (@isset($tab['tab']) && $tab['tab'] == 'dev' )
      <legend>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft"
        class="fieldsetLegendLink">
        Dodatkowe urządzenia
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/komputery/{{ $komputer->id_k }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('PROGRAMY') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=dev" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset ($urzadzeniaKomp)
        @foreach ($urzadzeniaKomp as $dev)
        <tr class="devDetRow">
            <td class="leftDevDetHead">
              <a href="{{ route('urzadzenia.show', $dev->id_dev) }}" class="devDetTabLink">
                {{ $dev->nazwa_dev }}
              </a>
            </td>
            <td class="rightDevDetHead">
              <a href="{{ route('urzadzenia.show', $dev->id_dev) }}" class="devDetTabLink">
                {{ $dev->inwent_dev }}
              </a>
              <form action="/komputery/delDev/{{ $komputer->id_k }}">
                @csrf
                <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
                <input type="hidden" name="id_dev" value="{{ $dev->id_dev }}">
                <input type="hidden" name="tab" value="dev">
                <input type="hidden" name="dnr" value="1">
                <button type="submit" class="redDelButton">
              </form>
            </td>
          </tr>
          @endforeach
        @endisset
        @empty ($urzadzenia)
        <tr class="devDetRow">
          <td class="leftDevDetHead">{{ __('brak urządzeń')}}</td>
          <td class="rightDevDetHead"></td>
        </tr>
        @endempty
        <tr class="devDetRow">
          <td class="leftDevDetHead"></td>
          <td class="rightDevDetHead">
            @isset($e['e']) 
            <form action="/komputery/addDev/{{ $komputer->id_k }}">
            @csrf
            <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
            <input type="hidden" name="tab" value="dev">
            @isset($urzadzeniaKomp)
              @if(count($urzadzenia)>0)
                <select name="id_dev" id="dev" class="devDetSelect">
                @foreach($urzadzenia as $dev)
                  <option value = "{{ $dev->id_dev }}">{{ $dev->inwent_dev }} {{ $dev->nazwa_dev }}</option>
                @endforeach
                </select>
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span>
              </form>
              @else
              <span class="quickSubmit">
                  {{ __('Brak dostępnych urządzeń') }}
              </span>
              @endif
            @endisset
            @endisset
            @empty($e)
            @if (count($urzadzenia)>0)
            <form action="/komputery/{{ $komputer->id_k }}">
            @csrf
              <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
              <input type="hidden" name="tab" value="dev">
              <input type="hidden" name="e" value="dev">
              <button type="submit" class="greenAddButton">
            </form>
            @endif
          @endempty
          </td>
        </tr>
      </table>

      @elseif (@isset($tab['tab']) && $tab['tab'] == 'st' )
      <legend>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft"
        class="fieldsetLegendLink">
        Środki Trwałe
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/komputery/{{ $komputer->id_k }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('PROGRAMY') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=st" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetRow">
          <td class="leftDevDetHead">OT</td>
          <td>
            @if ($komputer->id_ot > 0)
            <a href="/ot/{{ $komputer->id_ot }}" class="devLink">{{ $komputer->nr_ot }}</a>
            @endif
          </td>    
          <td>
              @if ($komputer->id_ot > 0)
              <a href="/ot/otfile/{{ $komputer->id_ot }}" class="devLink">
                  <img class="pdf2">
              </a>
              @endif
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">FW</td>
          <td>
            @if ($komputer->id_fw > 0)
            <a href="/fw/{{ $komputer->id_fw }}" class="devLink">{{ $komputer->nr_fw }}</a>
            @endif
          </td>    
          <td>
            @if ($komputer->id_fw > 0)
            <a href="/fw/fwfile/{{ $komputer->id_fw }}" class="devLink">
              <img class="pdf2">
            </a>
            @endif
          </td>
      </tr>
      <tr class="trPause"> </tr>
      <tr>
        <td> Zmiany </td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>


      @elseif (@isset($tab['tab']) && $tab['tab'] == 'log' )
      <legend>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft"
        class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/komputery/{{ $komputer->id_k }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('PROGRAMY') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=log" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDetLog">
        <tr class="devDetLogRow">
          <td class="devDetHead">Czas</td>
          <td class="devDetHead">Wpis</td>
          <td class="devDetHead">Kto</td>
        </tr>
        @foreach ($logiKomp as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiKomp->links() }}
      
      @else
      <legend>
        <a href="/komputery/{{ $komputer->id_k }}"
          class="fieldsetLegendLink">
          Szczegóły Komputera
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/komputery/{{ $komputer->id_k }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=soft" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('PROGRAMY') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=dev" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('URZĄDZENIA') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/komputery/{{ $komputer->id_k }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset($e)
        <form action="/komputery/updateOneCol/{{ $komputer->id_k }}">
        @csrf
        <input type="hidden" name="id_k" value ="{{ $komputer->id_k }}"> 
       @endisset
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nazwa Komputera</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'dns')
              <input id="Nazwa" type="text" class="devDetField" name="dns_k" value="{{ $komputer->dns_k }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="dns_k">
              @if ($komputer->dns_k != NULL)
                <input type="hidden" name="old_dns_k" value ="{{ $komputer->dns_k }}">
              @endif
                 @error('dns_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="/komputery/{{ $komputer->id_k }}?e=dns" class="devLink">{{ $komputer->dns_k }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=dns" class="devLink">{{ $komputer->dns_k }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nr inwentaryzacyjny</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'inwent')
              <input id="Inwent" type="text" class="devDetField" name="inwent_k" value="{{ $komputer->inwent_k }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="inwent_k">
              @if ($komputer->inwent_k != NULL)
                <input type="hidden" name="old_inwent_k" value ="{{ $komputer->inwent_k }}">
              @endif
                  @error('inwent_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=inwent" class="devLink">  
                @if ($komputer->inwent_k)
                    {{ $komputer->inwent_k }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=inwent" class="devLink">  
                @if ($komputer->inwent_k)
                  {{ $komputer->inwent_k }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nr seryjny</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'serial')
              <input id="Serial" type="text" class="devDetField" name="serial_k" value="{{ $komputer->serial_k }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="serial_k">
              @if ($komputer->serial_k != NULL)
                <input type="hidden" name="old_serial_k" value ="{{ $komputer->serial_k }}">
              @endif
                  @error('serial_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=serial" class="devLink">  
                @if ($komputer->serial_k)
                    {{ $komputer->serial_k }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=serial" class="devLink">  
                @if ($komputer->serial_k)
                  {{ $komputer->serial_k }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Typ kompuetra</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'typ')
              <select name="typ_k" id="typ" class="devDetSelect">
                @if ($komputer->typ_k == 'K')
                  <option value="K" selected>
                    Komputer
                  </option>
                @else
                  <option value="K">
                    Komputer
                  </option>
                @endif
                @if ($komputer->typ_k == 'N')
                  <option value="N" selected>
                    Laptop
                  </option>
                @else
                  <option value="N">
                    Laptop
                  </option>
                @endif
                @if ($komputer->typ_k == 'S')
                  <option value="S" selected>
                    Serwer
                  </option>
                @else
                  <option value="S">
                    Serwer
                  </option>
                @endif
                </select>
                @error('typ_k')
                  <span class="invalid-feedback" role="alert">
                    <strong>{{ $message }}</strong>
                  </span>
                @enderror
                <input type="hidden" name="oldProperty" value="typ_k">
                @if ($komputer->typ_k != NULL)
                  <input type="hidden" name="old_typ_k" value ="{{ $komputer->typ_k }}">
                @endif
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span> 
                @else
                <a href="/komputery/{{ $komputer->id_k }}?e=typ" class="devLink">  
                  @if ($komputer->typ_k)
                    @if($komputer->typ_k == 'K')
                      {{ __('Komputer') }}
                    @elseif($komputer->typ_k == 'N')
                      {{ __('Laptop') }}
                    @else
                      {{ __('Serwer') }}
                    @endif
                  @else
                  <span class="greenAddButton">
                  @endif
                <a>
              @endif
            </a>
             
            @endisset
            @empty ($e)
            <a href="/komputery/{{ $komputer->id_k }}?e=typ" class="devLink">  
              @if ($komputer->typ_k)
                @if($komputer->typ_k == 'K')
                  {{ __('Komputer') }}
                @elseif($komputer->typ_k == 'N')
                  {{ __('Laptop') }}
                @else
                  {{ __('Serwer') }}
                @endif
              @else
                  <span class="greenAddButton">
              @endif
            </a>
            @endempty
          </td>
        </tr>

        <tr class="devDetRow">
          <td class="leftDevDetHead">Model kompuetra</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'model')
              <input id="IP" type="text" class="devDetField" name="model_k" value="{{ $komputer->model_k }}" 
                  required autofocus>
                @error('model_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              <input type="hidden" name="oldProperty" value="model_k">
              <input type="hidden" name="old_model_k" value ="{{ $komputer->model_k }}">
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=model" class="devLink">  
              @if ($komputer->model_k)
                  {{ $komputer->model_k }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=model" class="devLink">  
              @if ($komputer->model_k)
                  {{ $komputer->model_k }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td>
        </tr>


        <tr class="devDetRow">
          <td class="leftDevDetHead">Monitor</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'monitor')
            <div class="newDevice">
            <select name="id_m" id="monitor" class="devDetSelect">
            @if ($komputer->id_m)  
              <option value = "{{ $komputer->id_m }}">{{ __('USUŃ MONITOR') }}</option>  
            @endif
              @foreach($monitory as $monitor)
                @if ($komputer->id_m == $monitor->id_m)
                  <option value = "{{ $monitor->id_m }}" selected>{{ $monitor->inwent_m }} {{ $monitor->model_m }}</option>
                @else
                  <option value = "{{ $monitor->id_m }}">{{ $monitor->inwent_m }} {{ $monitor->model_m }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_m">
            @if ($komputer->id_m != NULL)
                <input type="hidden" name="old_id_m" value ="{{ $komputer->id_m }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              <a href="/monitory/{{ $komputer->id_m }}" class="devLink">{{ $komputer->model_m }}</a>
                @if ($komputer->id_m)
                  <a href="/komputery/{{ $komputer->id_k }}?e=monitor" class="devLink">
                    <img class="changeIcon" src="/img/change.png">
                  </a>  
                @else
                <a href="/komputery/{{ $komputer->id_k }}?e=monitor" class="devLink">
                  <span class="greenAddButton"></a>
                </a>
                @endif
              </a>
            @endif
          @endisset
          @empty($e)
              <a href="/monitory/{{ $komputer->id_m }}" class="devLink">{{ $komputer->model_m }}</a>
              @if ($komputer->id_m)
                <a href="/komputery/{{ $komputer->id_k }}?e=monitor" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=monitor" class="devLink">
                <span class="greenAddButton">
              </a>
              @endif
          @endempty
          </td>
        </tr>

        <tr class="devDetRow">
          <td class="leftDevDetHead">UPS</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'ups')
            <div class="newDevice">
            <select name="id_ups" id="UPS" class="devDetSelect">
            @if ($komputer->id_ups)  
              <option value = "{{ $komputer->id_ups }}">{{ __('USUŃ UPS') }}</option>  
            @endif
              @foreach($upsy as $ups)
                @if ($komputer->id_ups == $ups->id_ups)
                  <option value = "{{ $ups->id_ups }}" selected>{{ $ups->inwent_ups }} {{ $ups->model_ups }}</option>
                @else
                  <option value = "{{ $ups->id_ups }}">{{ $ups->inwent_ups }} {{ $ups->model_ups }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_ups">
            @if ($komputer->id_ups != NULL)
                <input type="hidden" name="old_id_ups" value ="{{ $komputer->id_ups }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              <a href="/upsy/{{ $komputer->id_ups }}" class="devLink">{{ $komputer->inwent_ups }} {{ $komputer->model_ups }}</a>
              <a href="/komputery/{{ $komputer->id_k }}?e=ups" class="devLink">  
                @if ($komputer->id_ups)
                  <img class="changeIcon" src="/img/change.png">  
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endif
          @endisset
          @empty($e)
              <a href="/upsy/{{ $komputer->id_ups }}" class="devLink">{{ $komputer->inwent_ups }} {{ $komputer->model_ups }}</a>
              <a href="/komputery/{{ $komputer->id_k }}?e=ups" class="devLink">  
              @if ($komputer->id_ups)
                <img class="changeIcon" src="/img/change.png">  
              @else
                <span class="greenAddButton">
              @endif
              </a>
          @endempty
          </td>
        </tr>



        <tr class="devDetRow">
          <td class="leftDevDetHead">Data zakupu</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'data')
              <input type="date" name="data_k" id="data" class="devDetField" value="{{ $komputer->data_k }}">
              @error('data_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              <input type="hidden" name="oldProperty" value="data_k">
              @if ($komputer->data_k != NULL)
                <input type="hidden" name="old_data_k" value ="{{ $komputer->data_k }}">
              @endif
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span> 
              @else
                <a href="/komputery/{{ $komputer->id_k }}?e=data" class="devLink">  
                @if ($komputer->data_k)
                    {{ $komputer->data_k }}
                @else
                    <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=data" class="devLink">  
              @if ($komputer->data_k)
                  {{ $komputer->data_k }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">IP kompuetra</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'ip')
              <input id="IP" type="text" class="devDetField" name="ip_k" value="{{ $komputer->ip_k }}" 
                  required autofocus>
                @error('ip_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              <input type="hidden" name="oldProperty" value="ip_k">
              <input type="hidden" name="old_ip_k" value ="{{ $komputer->ip_k }}">
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=ip" class="devLink">  
              @if ($komputer->ip_k)
                  {{ $komputer->ip_k }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=ip" class="devLink">  
              @if ($komputer->ip_k)
                  {{ $komputer->ip_k }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Procesor</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'proc')
              <input id="IP" type="text" class="devDetField" name="proc_k" value="{{ $komputer->proc_k }}" 
                  required autofocus>
                @error('proc_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              <input type="hidden" name="oldProperty" value="proc_k">
              @if ($komputer->proc_k != NULL)
                <input type="hidden" name="old_proc_k" value ="{{ $komputer->proc_k }}">
              @endif
              @else
                <a href="/komputery/{{ $komputer->id_k }}?e=proc" class="devLink">  
                @if ($komputer->proc_k)
                    {{ $komputer->proc_k }}
                @else
                    <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/komputery/{{ $komputer->id_k }}?e=proc" class="devLink">  
              @if ($komputer->proc_k)
                  {{ $komputer->proc_k }}
              @else
                  <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Pamięć RAM</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'ram')
              <input id="RAM" type="text" class="devDetField" name="ram_k" value="{{ $komputer->ram_k }}" 
                  required autofocus>
                @error('ram_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="hidden" name="oldProperty" value="ram_k">
                @if ($komputer->ram_k != NULL)
                  <input type="hidden" name="old_ram_k" value ="{{ $komputer->ram_k }}">
                @endif
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=ram" class="devLink">  
                @if ($komputer->ram_k)
                  {{ $komputer->ram_k }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
            <a href="/komputery/{{ $komputer->id_k }}?e=ram" class="devLink">  
              @if ($komputer->ram_k)
                {{ $komputer->ram_k }}
              @else
                <span class="greenAddButton">
              @endif
            </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Dysk Twardy</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'hdd')
                <input id="hdd" type="text" class="devDetField" name="hdd_k" value="{{ $komputer->hdd_k }}" 
                    required autofocus>
                @error('hdd_k')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
                <input type="hidden" name="oldProperty" value="hdd_k">
                @if ($komputer->hdd_k != NULL)
                  <input type="hidden" name="old_hdd_k" value ="{{ $komputer->hdd_k }}">
                @endif
              @else
              <a href="/komputery/{{ $komputer->id_k }}?e=hdd" class="devLink">  
                @if ($komputer->hdd_k)
                  {{ $komputer->hdd_k }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
            <a href="/komputery/{{ $komputer->id_k }}?e=hdd" class="devLink">  
              @if ($komputer->hdd_k)
                {{ $komputer->hdd_k }}
              @else
                <span class="greenAddButton">
              @endif
            </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Dział</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'dzial')
            <div class="newDevice">
            <select name="id_dz" id="dzial" class="devDetSelect">
            @if ($komputer->id_dz)  
              <option value = "{{ $komputer->id_dz }}" selected>{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($dzialy as $dzial)
                @if ($komputer->id_dz != $dzial->id_dz)
                  <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_dz">
            @if ($komputer->id_dz != NULL)
                <input type="hidden" name="old_id_dz" value ="{{ $komputer->id_dz }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($komputer->id_dz != $komputer->userIdDz)
                <span class="inconsist">
                  <a href="/dzialy/{{ $komputer->id_dz }}" class="devLink">{{ $komputer->symbol_d }}</a>
                </span>
                <a href="/komputery/{{ $komputer->id_k }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/dzialy/{{ $komputer->id_dz }}" class="devLink">{{ $komputer->symbol_d }}</a>
                <a href="/komputery/{{ $komputer->id_k }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($komputer->id_dz != $komputer->userIdDz)
              <span class="inconsist">
                <a href="/dzialy/{{ $komputer->id_dz }}" class="devLink">{{ $komputer->symbol_d }}</a>
              </span>
              <a href="/komputery/{{ $komputer->id_k }}?e=dzial" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/dzialy/{{ $komputer->id_dz }}" class="devLink">{{ $komputer->symbol_d }}</a>
              <a href="/komputery/{{ $komputer->id_k }}?e=dzial" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @endif
          @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td  class="leftDevDetHead">Użytkownk</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'user')
            <div class="newDevice">
            <select name="id_u" id="uzytkownik" class="devDetSelect">
              @if ($komputer->id_u)  
              <option value = "{{ $komputer->id_u }}">{{ __('USUŃ') }}</option>  
              @endif
              @foreach($uzytkownicy as $uzytkownik)
                @if ($komputer->id_u != $uzytkownik->id_u)
                  <option value = "{{ $uzytkownik->id_u }}">{{ $uzytkownik->nazwa_u }} {{ $uzytkownik->imie_u }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_u">
            @if ($komputer->id_u != NULL)
              <input type="hidden" name="old_id_u" value ="{{ $komputer->id_u }}">
            @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
            @if($komputer->id_dz != $komputer->userIdDz)
                <span class="inconsist">
                  <a href="/uzytkownicy/{{ $komputer->id_u }}" class="devLink">  
                    {{ $komputer->nazwa_u }}
                    {{ $komputer->imie_u}}
                  </a>
                </span>
              <a href="/komputery/{{ $komputer->id_k }}?e=user" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
              @else
                <a href="/uzytkownicy/{{ $komputer->id_u }}" class="devLink">  
                  {{ $komputer->nazwa_u }}
                  {{ $komputer->imie_u}}
                </a>
                <a href="/komputery/{{ $komputer->id_k }}?e=user" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif  
          @endif 
          @endisset
          @empty($e)
            @if($komputer->id_dz != $komputer->userIdDz)
              <span class="inconsist">
                <a href="/uzytkownicy/{{ $komputer->id_u }}" class="devLink">  
                  {{ $komputer->nazwa_u }}
                  {{ $komputer->imie_u}}
                </a>
              </span>
              <a href="/komputery/{{ $komputer->id_k }}?e=user" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/uzytkownicy/{{ $komputer->id_u }}" class="devLink">  
                {{ $komputer->nazwa_u }}
                {{ $komputer->imie_u}}
              </a>
              <a href="/komputery/{{ $komputer->id_k }}?e=user" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @endif 
          @endempty
          </td>
        </tr> 
      </table>
      @isset($e)
        </form>
      @endisset
   @if($komputer->status_k != 0)
   <span class="editButton">
    <form action="/komputery/editStep1/{{ $komputer->id_k }}" method="POST">
    @csrf
      <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
      <button class="devButton">
        EDYTUJ
      </button>
    </form>
  </span>
  @endif
  @isset($komputer)
    @if($komputer->status_k == 0)
    <span class="editButton">
      <form action="/komputery/{{ $komputer->id_k }}" method="POST">
        @csrf
        <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
        @method('DELETE')
        <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie komputer !!!')">
          USUŃ
        </button>
      </form>
    </span>
    <span class="editButton">
      <form action="/komputery/activate/{{ $komputer->id_k }}" method="POST">
        @csrf
        <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
        <button class="devButton" onClick="return confirm(Ta operacja przywróci komputer !!!)">
          PRZYWRÓĆ
        </button>
      </form>
    </span>
    @else
    <span class="editButton">
      <form action="{{route('komputery.disable',$komputer->id_k) }}" method="POST">
        @csrf
        <input type="hidden" name="id_k" value="{{ $komputer->id_k }}">
        <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy komputer jako usunięty!!!')">
          USUŃ
        </button>
      </form>
    </span>
    @endif
  @endisset
@if($komputer->status_k == 0)
<span class="editButton"> 
  <a href="/komputery/?active=0" class="devLink">WRÓĆ</a>
</span>
@else
<span class="editButton"> 
  <a href="/komputery" class="devLink">WRÓĆ</a>
</span>
@endif
@endif
  </fieldset>  
</div>
</div>
@endsection