@extends('template.backend.admin_template')
@section('content')

{!! Form::open(['url' => 'importUsers','enctype' => 'multipart/form-data']) !!}

{!! Form::file('import_file',['class' => 'col-xs-6','style'=>'margin-top: 10px;']) !!}
{!! Form::submit('Import File',['class' => 'btn btn-primary']) !!}
  
{!! Form::close() !!}

@if(session()->has('success') )
    <h5 class="alert alert-success">{{ session('success') }}</h5>
@endif

@if(session()->has('failed') )
    <h5 class="alert alert-danger">{{ session('failed') }}</h5>
@endif

@if(session()->has('no_file') )
    <h5 class="alert alert-danger">{{ session('no_file') }}</h5>
@endif

@stop