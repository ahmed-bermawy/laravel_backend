@extends('template.backend.admin_template')
@section('content')
    @include('errors.list')
    <div style='border: 4px solid #a1a1a1;margin-top:5px;padding: 10px;border-radius:10px;'>
        <h4 class="float-left"  style='margin:0 0 10px 0;'>Upload Excel Sheet </h4>
        <a class="float-right" style="margin-right: 10px;" href="{{ asset("/files/$excel_example")}}">Excel Sheet Example</a>
        <div class="clear"></div>

        {!! Form::open(['url' => url($path.'saveExcel'),'encrypt' => 'multipart/form-data','files' => true ]) !!}

        @include('template.backend._form',['formAction'=>'create','submitButtonText'=>'Import File'])

        {!! Form::close() !!}

    </div>

@endsection