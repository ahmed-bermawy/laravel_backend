@extends('template.backend.admin_template')
@section('content')

    @include('errors.list')

    {!! Form::open(['url' => $path,'files' => true ]) !!}

    @include('template.backend._form',['formAction'=>'create','submitButtonText'=>'Add '.$page_name])

    {!! Form::close() !!}

@endsection