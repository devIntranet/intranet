@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
      @if (@isset($tab['tab']) && $tab['tab'] == 'st' )
      <legend>
        <a href="/upsy/{{ $ups->id_ups }}?tab=soft"
        class="fieldsetLegendLink">
        Środki Trwałe
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/upsy/{{ $ups->id_ups }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/upsy/{{ $ups->id_ups }}?tab=st" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/upsy/{{ $ups->id_ups }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
        <tr class="devDetRow">
          <td class="leftDevDetHead">OT</td>
          <td>
            @if ($ups->id_ot > 0)
            <a href="/ot/{{ $ups->id_ot }}" class="devLink">{{ $ups->nr_ot }}</a>
            @endif
          </td>    
          <td>
              @if ($ups->id_ot > 0)
              <a href="/ot/otfile/{{ $ups->id_ot }}" class="devLink">
                  <img class="pdf2">
              </a>
              @endif
          </td>
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">FW</td>
          <td>
            @if ($ups->id_fw > 0)
            <a href="/fw/{{ $ups->id_fw }}" class="devLink">{{ $ups->nr_fw }}</a>
            @endif
          </td>    
          <td>
            @if ($ups->id_fw > 0)
            <a href="/fw/fwfile/{{ $ups->id_fw }}" class="devLink">
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
        <a href="/upsy/{{ $ups->id_ups }}?tab=soft"
        class="fieldsetLegendLink">
        Historia zmian
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/upsy/{{ $ups->id_ups }}" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/upsy/{{ $ups->id_ups }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/upsy/{{ $ups->id_ups }}?tab=log" class="devDetTabLink">
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
        @foreach ($logiUPS as $log)
        <tr class="devDetRow">
          <td class="devDetLogData">{{ $log->created_at }}</td>
          <td class="devDetLogWpis">{{ $log->wpis }}</td>
          <td class="devDetLogKto">{{ $log->kto }}</td>
        </tr>
        @endforeach
      </table>
      {{ $logiUPS->links() }}
      
      @else
      <legend>
        <a href="/upsy/{{ $ups->id_ups }}"
          class="fieldsetLegendLink">
          Szczegóły upsa
        </a>
      </legend>
      <span class="devDetTabWrapper">
        <a href="/upsy/{{ $ups->id_ups }}" class="devDetTabLink">
          <span class="devDetActiveTab">
            {{ __('DANE') }}
          </span>
        </a>
        <a href="/upsy/{{ $ups->id_ups }}?tab=st" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('ST') }}
          </span>
        </a>
        <a href="/upsy/{{ $ups->id_ups }}?tab=log" class="devDetTabLink">
          <span class="devDetTab">
            {{ __('LOG') }}
          </span>
        </a>
      </span>
      <table class="devDet">
      @isset($e)
        <form action="/upsy/updateOneCol/{{ $ups->id_ups }}">
        @csrf
        <input type="hidden" name="id_ups" value ="{{ $ups->id_ups }}"> 
       @endisset
        <tr class="devDetRow">
          <td class="leftDevDetHead">Model upsa</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'model')
              <input id="Nazwa" type="text" class="devDetField" name="model_ups" value="{{ $ups->model_ups }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="model_ups">
              @if ($ups->model_ups != NULL)
                <input type="hidden" name="old_upsodel_ups" value ="{{ $ups->model_ups }}">
              @endif
                 @error('model_ups')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
                <a href="/upsy/{{ $ups->id_ups }}?e=model" class="devLink">{{ $ups->model_ups }}</a>
              @endif
            @endisset
            @empty ($e)
              <a href="/upsy/{{ $ups->id_ups }}?e=model" class="devLink">{{ $ups->model_ups }}</a>
            @endempty
          </td class="rightDevDetHead">
        </tr>
        <tr class="devDetRow">
          <td class="leftDevDetHead">Nr inwentaryzacyjny</td>
          <td>
            @isset($e['e'])
              @if ($e['e'] == 'inwent')
              <input id="Inwent" type="text" class="devDetField" name="inwent_ups" value="{{ $ups->inwent_ups }}" 
                  required autofocus>
              <input type="hidden" name="oldProperty" value="inwent_ups">
              @if ($ups->inwent_ups != NULL)
                <input type="hidden" name="old_inwent_ups" value ="{{ $ups->inwent_ups }}">
              @endif
                  @error('inwent_ups')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
                @enderror
              @else
              <a href="/upsy/{{ $ups->id_ups }}?e=inwent" class="devLink">  
                @if ($ups->inwent_ups)
                    {{ $ups->inwent_ups }}
                @else
                    <span class="greenAddButton">
                @endif
              </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/upsy/{{ $ups->id_ups }}?e=inwent" class="devLink">  
                @if ($ups->inwent_ups)
                  {{ $ups->inwent_ups }}
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
              <input type="date" name="data_ups" id="data" class="devDetField" value="{{ $ups->data_ups }}">
              @error('data_ups')
                <span class="invalid-feedback" role="alert">
                  <strong>{{ $message }}</strong>
                </span>
              @enderror
              <input type="hidden" name="oldProperty" value="data_ups">
              @if ($ups->data_ups != NULL)
                <input type="hidden" name="old_data_ups" value ="{{ $ups->data_ups }}">
              @endif
                <span class="quickSubmit">
                  <button type="submit" class="quickSubmitButton">
                    {{ __('OK') }}
                  </button>
                </span> 
              @else
                <a href="/upsy/{{ $ups->id_ups }}?e=data" class="devLink">  
                @if ($ups->data_ups)
                    {{ $ups->data_ups }}
                @else
                    <span class="greenAddButton">
                @endif
                </a>
              @endif
            @endisset
            @empty ($e)
              <a href="/upsy/{{ $ups->id_ups }}?e=data" class="devLink">  
              @if ($ups->data_ups)
                  {{ $ups->data_ups }}
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
            @if ($ups->id_dz)  
              <option value = "{{ $ups->id_dz }}">{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($dzialy as $dzial)
                @if ($ups->id_dz != $dzial->id_dz)
                  <option value = "{{ $dzial->id_dz }}" selected>{{ $dzial->symbol_d }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_dz">
            @if ($ups->id_dz != NULL)
                <input type="hidden" name="old_id_dz" value ="{{ $ups->id_dz }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($ups->id_dz != $ups->kompIdDz)
                <span class="inconsist">
                  <a href="/dzialy/{{ $ups->id_dz }}" class="devLink">{{ $ups->symbol_d }}</a>
                </span>
                <a href="/upsy/{{ $ups->id_ups }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/dzialy/{{ $ups->id_dz }}" class="devLink">{{ $ups->symbol_d }}</a>
                <a href="/upsy/{{ $ups->id_ups }}?e=dzial" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($ups->id_dz != $ups->kompIdDz)
              <span class="inconsist">
                <a href="/dzialy/{{ $ups->id_dz }}" class="devLink">{{ $ups->symbol_d }}</a>
              </span>
              <a href="/upsy/{{ $ups->id_ups }}?e=dzial" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/dzialy/{{ $ups->id_dz }}" class="devLink">{{ $ups->symbol_d }}</a>
              <a href="/upsy/{{ $ups->id_ups }}?e=dzial" class="devLink">  
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
            @if ($ups->id_k)  
              <option value = "{{ $ups->id_k }}">{{ __('USUŃ') }}</option>  
            @endif  
            @foreach($komputery as $komp)
                @if ($ups->id_k != $komp->id_k)
                  <option value = "{{ $komp->id_k }}" selected>{{ $komp->dns_k }}</option>
                @endif
              @endforeach
            </select>
            <input type="hidden" name="oldProperty" value="id_k">
            @if ($ups->id_k != NULL)
                <input type="hidden" name="old_id_k" value ="{{ $ups->id_k }}">
              @endif
            <span class="quickSubmit">
                <button type="submit" class="quickSubmitButton">
                  {{ __('OK') }}
                </button>
            </span>
            </div>
            @else
              @if($ups->id_dz != $ups->kompIdDz)
                <span class="inconsist">
                  <a href="/komputery/{{ $ups->id_k }}" class="devLink">{{ $ups->dns_k }}</a>
                </span>
                <a href="/upsy/{{ $ups->id_ups }}?e=komp" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @else
                <a href="/komputery/{{ $ups->id_k }}" class="devLink">{{ $ups->dns_k }}</a>
                <a href="/upsy/{{ $ups->id_ups }}?e=komp" class="devLink">  
                  <img class="changeIcon" src="/img/change.png">
                </a>
              @endif
            @endif
          @endisset
          @empty($e)
            @if($ups->id_dz != $ups->kompIdDz)
              <span class="inconsist">
                <a href="/komputery/{{ $ups->id_k }}" class="devLink">{{ $ups->dns_k }}</a>
              </span>
              <a href="/upsy/{{ $ups->id_ups }}?e=komp" class="devLink">  
                <img class="changeIcon" src="/img/change.png">
              </a>
            @else
              <a href="/komputery/{{ $ups->id_k }}" class="devLink">{{ $ups->dns_k }}</a>
              <a href="/upsy/{{ $ups->id_ups }}?e=komp" class="devLink">  
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
   @isset($ups)
    @if($ups->status_ups == 0)
    <span class="editButton">
      <form action="/upsy/{{ $ups->id_ups }}" method="POST">
        @csrf
        <input type="hidden" name="id_ups" value="{{ $ups->id_ups }}">
        @method('DELETE')
        <button class="devButtonRed" onClick="return confirm('Ta operacja usunie całkowicie ups !!!')">
          USUŃ
        </button>
      </form>
    </span>
    <span class="editButton">
      <form action="/upsy/activate/{{ $ups->id_ups }}" method="POST">
        @csrf
        <input type="hidden" name="id_ups" value="{{ $ups->id_ups }}">
        <button class="devButton" onClick="return confirm(Ta operacja przywróci ups !!!)">
          PRZYWRÓĆ
        </button>
      </form>
    </span>
    @else
    <span class="editButton">
      <form action="{{route('upsy.disable',$ups->id_ups) }}" method="POST">
        @csrf
        <input type="hidden" name="id_ups" value="{{ $ups->id_ups }}">
        <button class="devButtonRed" onClick="return confirm('Ta operacja oznaczy ups jako usunięty!!!')">
          USUŃ
        </button>
      </form>
    </span>
    @endif
  @endisset
@if($ups->status_ups == 0)
<span class="editButton"> 
  <a href="/upsy/?active=0" class="devLink">WRÓĆ</a>
</span>
@else
<span class="editButton"> 
  <a href="/upsy" class="devLink">WRÓĆ</a>
</span>
@endif
@endif
  </fieldset>  
</div>
</div>
@endsection