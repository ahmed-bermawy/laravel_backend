@extends('template.backend.admin_template')
@section('content')

@include('errors.list')

{!! Form::open(['url' => $path,'files' => true ]) !!}

@include('template.backend._form',['formAction'=>'create','submitButtonText'=>'Add '.$page_name])
    
{!! Form::close() !!}

@endsection

@section('plugins')
    <!-- selectize plugin -->
    <link rel="stylesheet" href="{{ asset ("/bower_components/selectize/dist/css/selectize.bootstrap3.css")}}" type="text/css" media="screen">
    <script src="{{ asset ("/bower_components/selectize/dist/js/standalone/selectize.min.js")}}"></script>

    <script>
        $('#cpts').selectize({
            valueField: 'value',
            labelField: 'value',
            searchField: 'value',
            options: [],
            create: false,
            render: {
                option: function(data, escape) {
                    return '<div class="option">' + escape(data.value) +'</div>';
                },
            },

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/api/searchCpts',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        //page_limit: 10,
                    },
                    error: function() {
                        callback();
                    },
                    success: function(response) {
                        console.log(response);
                        callback(response);
                    }
                });
            }
        });
    </script>

    <script>
        $('#provider_id').selectize({
            valueField: 'key',
            labelField: 'value',
            searchField: 'value',
            options: [],
            create: false,
            render: {
                option: function(data, escape) {
                    return '<div class="option">' + escape(data.value) +'</div>';
                },
            },

            load: function(query, callback) {
                if (!query.length) return callback();
                $.ajax({
                    url: '/api/searchProviders',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        q: query,
                        //page_limit: 10,
                    },
                    error: function() {
                        callback();
                    },
                    success: function(response) {
                        console.log(response);
                        callback(response);
                    }
                });
            }
        });
    </script>
@endsection
