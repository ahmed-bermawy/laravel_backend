@extends('template.backend.admin_template')
@section('content')
    @if(Request::segment(1) == 'profile')
        <a class='popup btn btn-primary btn-lg margin_5' title='Change Password' data-email="{!! $data->email !!}" data-id="{{$data->id}}" data-toggle="modal" data-target="#change_my_password" href='#'>Change Password</a>
    @endif
@include('errors.list')

{!! Form::model($data,['method'=>'PUT','files' => true,'url' => $path.'/'.$data->$table_pk]) !!}

@include('template.backend._form',['formAction'=>'update','submitButtonText'=>'Update '.$page_name])

{!! Form::close() !!}

@if(Request::segment(1) == 'profile')
    {!! change_my_password_pop_up_window() !!}
@endif
@endsection
@section('plugins')
    <!-- selectize plugin -->
    <link rel="stylesheet" href="{{ asset ("/bower_components/selectize/dist/css/selectize.bootstrap3.css")}}" type="text/css" media="screen">
    <script src="{{ asset ("/bower_components/selectize/dist/js/standalone/selectize.min.js")}}"></script>
    <script>
      $('#cpts').selectize({
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
                        callback(response);
                    }
                });
            }
        });
    </script>


    <script>
        $('#provider_id').selectize({
            valueField: 'id',
            labelField: 'name',
            searchField: 'name',
            options: [],
            create: false,
            render: {
                option: function(data, escape) {
                    return '<div class="option">' + escape(data.name) +'</div>';
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
                        user_id: {!! Auth::id() !!},
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
    <script src="https://cdn.ckeditor.com/4.5.7/standard/ckeditor.js"></script>
    <script>
    //hide popup window after ajax call
    function hide_popup()
    {
        $(".modal-body input[type=password]").val('');
        $(".modal-footer #fail").html('');
        $(".modal-footer #success").html('');
        $(".close_popup").trigger("click");
    }
    $(document).ready(function () {
        var id = {{ $data->id }};
        $(".modal-body #row_id").val(id);
        var id = $('#row_id').val();


    });

    // change password for logged in user
    $('#submit_change_my_password').click(function () {
        $(".field_error").hide();
        var id = $('#row_id').val();
        var path = $('#path').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();
        var old_password = $('#old_password').val();

        var state = Boolean();
        state = true;

        if(old_password == '')
        {
            $("#old_password_error").fadeIn("fast");
            state = false;
        }

        if (password == "") {
            $("#password_error").fadeIn("fast");
            state = false;
        }

        if(confirm_password == "")
        {
            $("#confirm_password_error").fadeIn("fast");
            state = false;
        }

        if(confirm_password !== password)
        {
            $("#not_match_error").fadeIn("fast");
            state = false;
        }


        if(state == true)
        {
            $.ajax({
                url: '/admins/change_password',
                type: 'POST',
                data: { "_token": "{{ csrf_token() }}",id:id,password:password,old_password:old_password },
                cache: false,
                dataType: "json",
                success: function(success_array)
                {
                    //alert(success_array.msg);
                    if(success_array.status == "success")
                    {
                        $(".modal-footer #fail").html('');
                        $(".modal-footer #success").html(success_array.msg);
                        setTimeout(hide_popup, 3000);
                    }
                    else
                    {
                        $(".modal-footer #fail").html(success_array.msg);
                    }

                },
                error: function(xhr, ajaxOptions, thrownError)
                {
                    //alert("Test not working "+thrownError);
                }

            });
        }
        else
        {
            return false;
        }

    });

      $(function () {
        // Replace the <textarea id="editor1"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor');
      });
    </script>
@endsection

@if(session('message'))
    {!! message_pop_up_window(session('message')) !!}
@endif