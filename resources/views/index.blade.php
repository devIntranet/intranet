@extends('layouts/layout')
@section('content')
  <div id="TRESC">
  @if (session('status'))
                        
                            {{ session('status') }}
                        
                    @endif
  </div>
@endsection