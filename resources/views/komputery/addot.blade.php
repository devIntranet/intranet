@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  <div class="wrapper-devDet">
    <fieldset class="devDetFieldset">
        <legend>
        <a href="/komputery/{{ $komputer->id_k }}?tab=st"
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
            <td class="rightDevDetHead">
              <form action="/komputery/storeot/{{ $komputer->id_k }}" method="post" enctype="multipart/form-data">
              @csrf
              <input type="hidden" name="tab" value="st">
              <input type="hidden" name="typ" value="ot">
              <input type="file" name="otfile" accept="application/pdf">
            </td>
            <td class="rightDevDetHead">
              <button type="submit" class="greenAddButton">
              </form> 
            </td>
          </tr>
          <tr class="devDetRow">
            <td class="leftDevDetHead">FW</td>
            <td class="rightDevDetHead"><form action="/komputery/storeot/{{ $komputer->id_k }}" method="post" enctype="multipart/form-data">
            
            </td>
            <td class="rightDevDetHead">
              <button type="submit" class="greenAddButton">
              </form> 
            </td>
          </tr>
          
        <tr class="devDetRow">
          <td class="leftDevDetHead"></td>
            @error('otfile')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
            @error('typ')
              <span class="invalid-feedback" role="alert">
                <strong>{{ $message }}</strong>
              </span>
            @enderror
          <td class="rightDevDetHead"></td>
        </tr>
      </table>