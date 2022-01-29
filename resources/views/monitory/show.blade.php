@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      @if (@isset($tab['tab']) && $tab['tab'] == 'st' )
      <legend>
        <a href="/monitory/{{ $monitor->id_m }}?tab=soft"
        class="fieldsetLegendLink">
        Środki Trwałe
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/monitory/{{ $monitor->id_m }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/monitory/{{ $monitor->id_m }}?tab=st" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/monitory/{{ $monitor->id_m }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetRow">
          <td class="leftDevDetHead">OT</td>
          <td>
            @if ($monitor->id_ot > 0)
            <a href="/ot/{{ $monitor->id_ot }}" class="devLink">{{ $monitor->nr_ot }}</a>
            @endif
          </td>    
          <td>
              @if ($monitor->id_ot > 0)
              <a href="/ot/otfile/{{ $monitor->id_ot }}" class="devLink">
                  <img class="pdf2">
              </a>
              @endif
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">FW</td>
          <td>
            @if ($monitor->id_fw > 0)
            <a href="/fw/{{ $monitor->id_fw }}" class="devLink">{{ $monitor->nr_fw }}</a>
            @endif
          </td>    
          <td>
            @if ($monitor->id_fw > 0)
            <a href="/fw/fwfile/{{ $monitor->id_fw }}" class="devLink">
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
        <a href="/monitory/{{ $monitor->id_m }}?tab=soft"
        class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/monitory/{{ $monitor->id_m }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/monitory/{{ $monitor->id_m }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/monitory/{{ $monitor->id_m }}?tab=log" class="devDetTabLink">
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
        @foreach ($logiMonitor as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiMonitor->links() }}
      
      @else
      <legend>
        <a href="/monitory/{{ $monitor->id_m }}"
          class="fieldsetLegendLink">
          Szczegóły monitora
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/monitory/{{ $monitor->id_m }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/monitory/{{ $monitor->id_m }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/monitory/{{ $monitor->id_m }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset($e)
        <form action="/monitory/updateOneCol/{{ $monitor->id_m }}">
        @csrf
        <input type="hidden" name="id_m" value ="{{ $monitor->id_m }}"> 
       @endisset
        <tr class="devDetRow">
          <td class="leftDevDetHead">Model monitora</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'model')
              <input id="Nazwa" type="text" class="devDetField" name="model_m" value="{{ $monitor->model_m }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="model_m">
              @if ($monitor->model_m != NULL)
                <input type="hidden" name="old_model_m" value ="{{ $monitor->model_m }}">
              @endif
                 @error('model_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="/monitory/{{ $monitor->id_m }}?e=model" class="devLink">{{ $monitor->model_m }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="/monitory/{{ $monitor->id_m }}?e=model" class="devLink">{{ $monitor->model_m }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nr inwentaryzacyjny</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'inwent')
              <input id="Inwent" type="text" class="devDetField" name="inwent_m" value="{{ $monitor->inwent_m }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="inwent_m">
              @if ($monitor->inwent_m != NULL)
                <input type="hidden" name="old_inwent_m" value ="{{ $monitor->inwent_m }}">
              @endif
                  @error('inwent_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/monitory/{{ $monitor->id_m }}?e=inwent" class="devLink">  
                @if ($monitor->inwent_m)
                    {{ $monitor->inwent_m }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/monitory/{{ $monitor->id_m }}?e=inwent" class="devLink">  
                @if ($monitor->inwent_m)
                  {{ $monitor->inwent_m }}
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
              <input id="Serial" type="text" class="devDetField" name="serial_m" value="{{ $monitor->serial_m }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="serial_m">
              @if ($monitor->serial_m != NULL)
                <input type="hidden" name="old_serial_m" value ="{{ $monitor->serial_m }}">
              @endif
                  @error('serial_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/monitory/{{ $monitor->id_m }}?e=serial" class="devLink">  
                @if ($monitor->serial_m)
                    {{ $monitor->serial_m }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/monitory/{{ $monitor->id_m }}?e=serial" class="devLink">  
                @if ($monitor->serial_m)
                  {{ $monitor->serial_m }}
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
              <input type="date" name="data_m" id="data" class="devDetField" value="{{ $monitor->data_m }}">
              @error('data_m')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              <input type="hidden" name="oldProperty" value="data_m">
              @if ($monitor->data_m != NULL)
                <input type="hidden" name="old_data_m" value ="{{ $monitor->data_m }}">
              @endif
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span> 
              @else
                <a href="/monitory/{{ $monitor->id_m }}?e=data" class="devLink">  
                @if ($monitor->data_m)
                    {{ $monitor->data_m }}
                @else
                    <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/monitory/{{ $monitor->id_m }}?e=data" class="devLink">  
              @if ($monitor->data_m)
                  {{ $monitor->data_m }}
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
            @if ($monitor->id_dz)  
              <option value = "{{ $monitor->id_dz }}">{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($dzialy as $dzial)
                @if ($monitor->id_dz != $dzial->id_dz)
                  <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_dz">
            @if ($monitor->id_dz != NULL)
                <input type="hidden" name="old_id_dz" value ="{{ $monitor->id_dz }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($monitor->id_dz != $monitor->kompIdDz)
                <span class="inconsist">
                  <a href="/dzialy/{{ $monitor->id_dz }}" class="devLink">{{ $monitor->symbol_d }}</a>
                </span>
                <a href="/monitory/{{ $monitor->id_m }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/dzialy/{{ $monitor->id_dz }}" class="devLink">{{ $monitor->symbol_d }}</a>
                <a href="/monitory/{{ $monitor->id_m }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($monitor->id_dz != $monitor->kompIdDz)
              <span class="inconsist">
                <a href="/dzialy/{{ $monitor->id_dz }}" class="devLink">{{ $monitor->symbol_d }}</a>
              </span>
              <a href="/monitory/{{ $monitor->id_m }}?e=dzial" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/dzialy/{{ $monitor->id_dz }}" class="devLink">{{ $monitor->symbol_d }}</a>
              <a href="/monitory/{{ $monitor->id_m }}?e=dzial" class="devLink">  
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
            @if ($monitor->id_k)  
              <option value = "{{ $monitor->id_k }}">{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($komputery as $komp)
                @if ($monitor->id_k != $komp->id_k)
                  <option value = "{{ $komp->id_k }}" selected>{{ $komp->dns_k }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_k">
            @if ($monitor->id_k != NULL)
                <input type="hidden" name="old_id_k" value ="{{ $monitor->id_k }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($monitor->id_dz != $monitor->kompIdDz)
                <span class="inconsist">
                  <a href="/komputery/{{ $monitor->id_k }}" class="devLink">{{ $monitor->dns_k }}</a>
                </span>
                <a href="/monitory/{{ $monitor->id_m }}?e=komp" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/komputery/{{ $monitor->id_k }}" class="devLink">{{ $monitor->dns_k }}</a>
                <a href="/monitory/{{ $monitor->id_m }}?e=komp" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($monitor->id_dz != $monitor->kompIdDz)
              <span class="inconsist">
                <a href="/komputery/{{ $monitor->id_k }}" class="devLink">{{ $monitor->dns_k }}</a>
              </span>
              <a href="/monitory/{{ $monitor->id_m }}?e=komp" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/komputery/{{ $monitor->id_k }}" class="devLink">{{ $monitor->dns_k }}</a>
              <a href="/monitory/{{ $monitor->id_m }}?e=komp" class="devLink">  
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
   @isset($monitor)
    @if($monitor->status_m == 0)
    <span class="editButton">
      <form action="/monitory/{{ $monitor->id_m }}" method="POST">
        @csrf
        <input type="hidden" name="id_m" value="{{ $monitor->id_m }}">
        @method('DELETE')
        <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie monitor !!!')">
          USUŃ
        </button>
      </form>
    </span>
    <span class="editButton">
      <form action="/monitory/activate/{{ $monitor->id_m }}" method="POST">
        @csrf
        <input type="hidden" name="id_m" value="{{ $monitor->id_m }}">
        <button class="devButton" onClick="return confirm(Ta operacja przywróci monitor !!!)">
          PRZYWRÓĆ
        </button>
      </form>
    </span>
    @else
    <span class="editButton">
      <form action="{{route('monitory.disable',$monitor->id_m) }}" method="POST">
        @csrf
        <input type="hidden" name="id_m" value="{{ $monitor->id_m }}">
        <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy monitor jako usunięty!!!')">
          USUŃ
        </button>
      </form>
    </span>
    @endif
  @endisset
@if($monitor->status_m == 0)
<span class="editButton"> 
  <a href="/monitory/?active=0" class="devLink">WRÓĆ</a>
</span>
@else
<span class="editButton"> 
  <a href="/monitory" class="devLink">WRÓĆ</a>
</span>
@endif
@endif
  </fieldset>  
</div>
</div>
@endsection