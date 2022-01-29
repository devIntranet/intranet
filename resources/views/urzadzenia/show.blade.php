@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      @if (@isset($tab['tab']) && $tab['tab'] == 'st' )
      <legend>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=soft"
        class="fieldsetLegendLink">
        Środki Trwałe
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=st" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetRow">
          <td class="leftDevDetHead">OT</td>
          <td>
            @if ($urzadzenie->id_ot > 0)
            <a href="/ot/{{ $urzadzenie->id_ot }}" class="devLink">{{ $urzadzenie->nr_ot }}</a>
            @endif
          </td>    
          <td>
              @if ($urzadzenie->id_ot > 0)
              <a href="/ot/otfile/{{ $urzadzenie->id_ot }}" class="devLink">
                  <img class="pdf2">
              </a>
              @endif
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">FW</td>
          <td>
            @if ($urzadzenie->id_fw > 0)
            <a href="/fw/{{ $urzadzenie->id_fw }}" class="devLink">{{ $urzadzenie->nr_fw }}</a>
            @endif
          </td>    
          <td>
            @if ($urzadzenie->id_fw > 0)
            <a href="/fw/fwfile/{{ $urzadzenie->id_fw }}" class="devLink">
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
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=soft"
        class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=log" class="devDetTabLink">
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
        @foreach ($logiUrzadzenie as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiUrzadzenie->links() }}
      
      @else
      <legend>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}"
          class="fieldsetLegendLink">
          Szczegóły urzadzenia
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset($e)
        <form action="/urzadzenia/updateOneCol/{{ $urzadzenie->id_dev }}">
        @csrf
        <input type="hidden" name="id_dev" value ="{{ $urzadzenie->id_dev }}"> 
       @endisset
       <tr class="devDetRow">
          <td class="leftDevDetHead">Nazwa urzadzenia</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'nazwa')
              <input id="Nazwa" type="text" class="devDetField" name="nazwa_dev" value="{{ $urzadzenie->nazwa_dev }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="nazwa_dev">
              @if ($urzadzenie->nazwa_dev != NULL)
                <input type="hidden" name="old_nazwa_dev" value ="{{ $urzadzenie->nazwa_dev }}">
              @endif
                 @error('nazwa_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=nazwa" class="devLink">
                @if ($urzadzenie->nazwa_dev)
                  {{ $urzadzenie->nazwa_dev }}
                @else
                  <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=nazwa" class="devLink">
              @if ($urzadzenie->nazwa_dev)
                {{ $urzadzenie->nazwa_dev }}
              @else
                <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Typ urzadzenia</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'typ')
              <select name="typ_dev" id="typ" class="devDetSelect">
                  <option value = "drukarka">{{ __('drukarka') }}</option>
                  <option value = "skaner">{{ __('skaner') }}</option>
                  <option value = "switch">{{ __('switch') }}</option>
                  <option value = "router">{{ __('router') }}</option>                 
                  <option value = "biblioteka">{{ __('biblioteka') }}</option>
                  <option value = "inne">{{ __('inne') }}</option>
                </select>
              <input type="hidden" name="oldProperty" value="typ_dev">
              @if ($urzadzenie->typ_dev != NULL)
                <input type="hidden" name="old_typ_dev" value ="{{ $urzadzenie->typ_dev }}">
              @endif
              <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
              </span> 
              @error('typ_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              @else
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=typ" class="devLink">
                @if ($urzadzenie->typ_dev)
                  {{ $urzadzenie->typ_dev }}
                @else
                  <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=typ" class="devLink">
              @if ($urzadzenie->typ_dev)
                {{ $urzadzenie->typ_dev }}
              @else
                <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Model urzadzenia</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'model')
              <input id="Nazwa" type="text" class="devDetField" name="model_dev" value="{{ $urzadzenie->model_dev }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="model_dev">
              @if ($urzadzenie->model_dev != NULL)
                <input type="hidden" name="old_model_dev" value ="{{ $urzadzenie->model_dev }}">
              @endif
                 @error('model_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=model" class="devLink">
                @if ($urzadzenie->model_dev)
                  {{ $urzadzenie->model_dev }}
                @else
                  <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=model" class="devLink">
              @if ($urzadzenie->model_dev)
                {{ $urzadzenie->model_dev }}
              @else
                <span class="greenAddButton">
              @endif
              </a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nr inwentaryzacyjny</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'inwent')
              <input id="Inwent" type="text" class="devDetField" name="inwent_dev" value="{{ $urzadzenie->inwent_dev }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="inwent_dev">
              @if ($urzadzenie->inwent_dev != NULL)
                <input type="hidden" name="old_inwent_dev" value ="{{ $urzadzenie->inwent_dev }}">
              @endif
                  @error('inwent_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=inwent" class="devLink">  
                @if ($urzadzenie->inwent_dev)
                    {{ $urzadzenie->inwent_dev }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=inwent" class="devLink">  
                @if ($urzadzenie->inwent_dev)
                  {{ $urzadzenie->inwent_dev }}
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
              <input id="Serial" type="text" class="devDetField" name="serial_dev" value="{{ $urzadzenie->serial_dev }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="serial_dev">
              @if ($urzadzenie->serial_dev != NULL)
                <input type="hidden" name="old_serial_dev" value ="{{ $urzadzenie->serial_dev }}">
              @endif
                  @error('serial_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=serial" class="devLink">  
                @if ($urzadzenie->serial_dev)
                    {{ $urzadzenie->serial_dev }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=serial" class="devLink">  
                @if ($urzadzenie->serial_dev)
                  {{ $urzadzenie->serial_dev }}
                @else
                  <span class="greenAddButton">
                @endif
              </a>
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Adres IP</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'ip')
              <input id="ip" type="text" class="devDetField" name="ip_dev" value="{{ $urzadzenie->ip_dev }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="ip_dev">
              @if ($urzadzenie->ip_dev != NULL)
                <input type="hidden" name="old_ip_dev" value ="{{ $urzadzenie->ip_dev }}">
              @endif
                  @error('ip_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=ip" class="devLink">  
                @if ($urzadzenie->ip_dev)
                    {{ $urzadzenie->ip_dev }}
                </a>
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=delip" class="devLink">  
                  <span class="redDelButton">
                </a>
                  @else
                  <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=ip" class="devLink">  
                    <span class="greenAddButton">
                  </a>
                  @endif
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=ip" class="devLink">  
              @if ($urzadzenie->ip_dev)
                {{ $urzadzenie->ip_dev }}
              </a>
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=delip" class="devLink">  
                <span class="redDelButton">
              </a>
              @else
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=ip" class="devLink">  
                  <span class="greenAddButton">
                </a>
              @endif
            @endempty
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Data zakupu</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'data')
              <input type="date" name="data_dev" id="data" class="devDetField" value="{{ $urzadzenie->data_dev }}">
              @error('data_dev')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              <input type="hidden" name="oldProperty" value="data_dev">
              @if ($urzadzenie->data_dev != NULL)
                <input type="hidden" name="old_data_dev" value ="{{ $urzadzenie->data_dev }}">
              @endif
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span> 
              @else
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=data" class="devLink">  
                @if ($urzadzenie->data_dev)
                    {{ $urzadzenie->data_dev }}
                @else
                    <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=data" class="devLink">  
              @if ($urzadzenie->data_dev)
                  {{ $urzadzenie->data_dev }}
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
            @if ($urzadzenie->id_dz)  
              <option value = "{{ $urzadzenie->id_dz }}" selected>{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($dzialy as $dzial)
                @if ($urzadzenie->id_dz != $dzial->id_dz)
                  <option value = "{{ $dzial->id_dz }}">{{ $dzial->symbol_d }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_dz">
            @if ($urzadzenie->id_dz != NULL)
                <input type="hidden" name="old_id_dz" value ="{{ $urzadzenie->id_dz }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($urzadzenie->id_dz > 0 && $urzadzenie->kompIdDz > 0 && $urzadzenie->id_dz != $urzadzenie->kompIdDz)
                <span class="inconsist">
                  <a href="/dzialy/{{ $urzadzenie->id_dz }}" class="devLink">{{ $urzadzenie->symbol_d }}</a>
                </span>
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/dzialy/{{ $urzadzenie->id_dz }}" class="devLink">{{ $urzadzenie->symbol_d }}</a>
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($urzadzenie->id_dz > 0 && $urzadzenie->kompIdDz > 0 && $urzadzenie->id_dz != $urzadzenie->kompIdDz)
              <span class="inconsist">
                <a href="/dzialy/{{ $urzadzenie->id_dz }}" class="devLink">{{ $urzadzenie->symbol_d }}</a>
              </span>
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=dzial" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/dzialy/{{ $urzadzenie->id_dz }}" class="devLink">{{ $urzadzenie->symbol_d }}</a>
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=dzial" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @endif
          @endempty
          </td>
        </tr>

        <tr class="devDetRow">
          <td class="leftDevDetHead">Komputer</td>
          <td>
          @isset($e['e'])
            @if ($e['e'] == 'komp')
            <div class="newDevice">
            <select name="id_k" id="komp" class="devDetSelect">
            @if ($urzadzenie->id_k)  
              <option value = "{{ $urzadzenie->id_k }}" selected>{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($komputery as $komp)
                @if ($urzadzenie->id_k != $komp->id_k)
                  <option value = "{{ $komp->id_k }}">{{ $komp->dns_k }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_k">
            @if ($urzadzenie->id_k != NULL)
                <input type="hidden" name="old_id_k" value ="{{ $urzadzenie->id_k }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($urzadzenie->id_dz > 0 && $urzadzenie->kompIdDz > 0 && $urzadzenie->id_dz != $urzadzenie->kompIdDz)
                <span class="inconsist">
                  <a href="/komputery/{{ $urzadzenie->id_k }}" class="devLink">{{ $urzadzenie->dns_k }}</a>
                </span>
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=komp" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/komputery/{{ $urzadzenie->id_k }}" class="devLink">{{ $urzadzenie->dns_k }}</a>
                <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=komp" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($urzadzenie->id_dz > 0 && $urzadzenie->kompIdDz > 0 && $urzadzenie->id_dz != $urzadzenie->kompIdDz)
              <span class="inconsist">
                <a href="/komputery/{{ $urzadzenie->id_k }}" class="devLink">{{ $urzadzenie->dns_k }}</a>
              </span>
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=komp" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/komputery/{{ $urzadzenie->id_k }}" class="devLink">{{ $urzadzenie->dns_k }}</a>
              <a href="/urzadzenia/{{ $urzadzenie->id_dev }}?e=komp" class="devLink">  
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
   @isset($urzadzenie)
    @if($urzadzenie->status_dev == 0)
    <span class="editButton">
      <form action="/urzadzenia/{{ $urzadzenie->id_dev }}" method="POST">
        @csrf
        <input type="hidden" name="id_dev" value="{{ $urzadzenie->id_dev }}">
        @method('DELETE')
        <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie urzadzenie !!!')">
          USUŃ
        </button>
      </form>
    </span>
    <span class="editButton">
      <form action="/urzadzenia/activate/{{ $urzadzenie->id_dev }}" method="POST">
        @csrf
        <input type="hidden" name="id_dev" value="{{ $urzadzenie->id_dev }}">
        <button class="devButton" onClick="return confirm(Ta operacja przywróci urzadzenie !!!)">
          PRZYWRÓĆ
        </button>
      </form>
    </span>
    @else
    <span class="editButton">
      <form action="{{route('urzadzenia.disable',$urzadzenie->id_dev) }}" method="POST">
        @csrf
        <input type="hidden" name="id_dev" value="{{ $urzadzenie->id_dev }}">
        <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy urzadzenie jako usunięte!!!')">
          USUŃ
        </button>
      </form>
    </span>
    @endif
  @endisset
@if($urzadzenie->status_dev == 0)
<span class="editButton"> 
  <a href="/urzadzenia/?active=0" class="devLink">WRÓĆ</a>
</span>
@else
<span class="editButton"> 
  <a href="/urzadzenia" class="devLink">WRÓĆ</a>
</span>
@endif
@endif
  </fieldset>  
</div>
</div>
@endsection