@extends('template.backend.admin_template')
@section('content')
@include('errors.list')
<div style='border: 4px solid #a1a1a1;margin-top:5px;padding: 10px;border-radius:10px;'>
    <h4 class="float-left"  style='margin:0 0 10px 0;'>Upload Excel Sheet </h4>
    <a class="float-right" style="margin-right: 10px;" href="{{ asset("/files/$excel_example")}}">Excel Sheet Example</a>
    <div class="clear"></div>

    {!! Form::open(['url' => $path.'/saveExcel','enctype' => 'multipart/form-data']) !!}

    <div class="form-group">
        {!! Form::label('language','Language : ') !!} <code> Required</code>
        {{--{!! Form::text('language', 'de',['id' => 'language','class'=>'form-control']) !!}--}}
        {!! Form::select('language', ['de' => 'Germany', 'en' => 'English', 'fr' => 'French'], 'de',['id' => 'language','class'=>'form-control']) !!}
    </div>

    <div class="form-group">
        {!! Form::label('import_file','Select File : ') !!} <code> Required</code>
        {!! Form::file('import_file',['class' => '']) !!}
    </div>

    {!! Form::submit('Import File',['class' => 'btn btn-primary']) !!}

    {!! Form::close() !!}

</div>

@endsection