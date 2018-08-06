<!DOCTYPE html>
<!--
This is a starter template page. Use this page to start your new project from
scratch. This page gets rid of all links and provides the needed markup only.
-->
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>{{ $page_title or "Dashboard" }}</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <!-- Bootstrap 3.3.7 -->
    <link href="{{ asset("/bower_components/bootstrap/dist/css/bootstrap.min.css") }}" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="{{ asset("/bower_components/font-awesome/css/font-awesome.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- Ionicons -->
    <link href="/bower_components/Ionicons/css/ionicons.min.css" rel="stylesheet" >
    <!-- Theme style -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/AdminLTE.min.css")}}" rel="stylesheet" type="text/css" />
    <!-- FancyBox CSS -->
    <link href="{{ asset("/bower_components/fancybox/dist/jquery.fancybox.min.css")}}" rel="stylesheet" type="text/css" media="screen" />
    <!-- Date Picker Plugin css -->
    <link href="{{ asset("/bower_components/eonasdan-bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css")}}" rel="stylesheet"  />
    <!-- Date Table css -->
    <link href="{{ asset("/bower_components/datatables.net-bs/css/dataTables.bootstrap.min.css")}}" rel="stylesheet"  />

    <link href="https://cdn.datatables.net/1.10.12/css/jquery.dataTables.min.css" rel="stylesheet" type="text/css" />
    <!-- AdminLTE Skins. We have chosen the skin-blue for this starter
          page. However, you can choose any other skin. Make sure you
          apply the skin class to the body tag so the changes take effect.
    -->
    <link href="{{ asset("/bower_components/admin-lte/dist/css/skins/skin-blue.min.css")}}" rel="stylesheet" type="text/css" />

    <!-- My style -->
    <link href="{{ asset("/css/main.css")}}" rel="stylesheet" type="text/css" />

    <!-- icon -->
    <link rel="shortcut icon" href="{{ asset("/images/ico/favicon.png") }}">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.3.0/respond.min.js"></script>
    <![endif]-->
    <!-- Google Font -->
    <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700,300italic,400italic,600italic">

</head>
<body class="hold-transition skin-blue sidebar-mini">
<div class="wrapper">
    <!-- Header -->
    @include('template/backend/header')

    <!-- Sidebar -->
    @include('template/backend/sidebar')

    <!-- Content Wrapper. Contains page content -->
    <div class="content-wrapper">
        <!-- Content Header (Page header) -->
        <section class="content-header">
            <h1>
                {{ $page_title or "Welcome" }}
                <small>{{ $page_description or null }}</small>
            </h1>
            <!-- You can dynamically generate breadcrumbs here -->
            <ol class="breadcrumb">
                <li><a href="/admin"><i class="fa fa-dashboard"></i> Dashboard</a></li>
                @if(isset($parent_page))
                    <li><a href="/{{$path}}"></i> {{$parent_page}}</a></li>
                @endif
                <li class="active">{{ $page_title or "Welcome" }}</li>
            </ol>
        </section>

        <!-- Main content -->
        <section class="content">
            <!-- Your Page Content Here -->
            @yield('content')
        </section><!-- /.content -->
    </div><!-- /.content-wrapper -->

    <!-- Footer -->
    @include('template/backend/footer')


<!-- REQUIRED JS SCRIPTS -->
<!-- jQuery v3.3.1 -->
<script src="{{ asset ("/bower_components/jquery/dist/jquery.min.js") }}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{ asset ("/bower_components/jquery-ui/jquery-ui.min.js") }}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    $.widget.bridge('uibutton', $.ui.button);
</script>
<!-- Bootstrap 3.3.2 JS -->
<script src="{{ asset ("/bower_components/bootstrap/dist/js/bootstrap.min.js") }}" type="text/javascript"></script>
<!-- Data Table JS -->
<script src="{{ asset ("/bower_components/datatables.net/js/jquery.dataTables.min.js") }}" type="text/javascript"></script>
<script src="{{ asset ("/bower_components/datatables.net-bs/js/dataTables.bootstrap.min.js") }}" type="text/javascript"></script>
<!-- Time javascript library -->
<script type="text/javascript" src="{{ asset ("/bower_components/moment/min/moment.min.js")}}"></script>
<!-- Date Picker Plugin js -->
<script type="text/javascript" src="{{ asset ("/bower_components/eonasdan-bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js")}}"></script>
<!-- FancyBox JS -->
<script src="{{ asset ("/bower_components/fancybox/dist/jquery.fancybox.min.js") }}" type="text/javascript" ></script>
<!-- AdminLTE App -->
<script src="{{ asset ("/bower_components/admin-lte/dist/js/adminlte.js") }}"></script>
<!-- ckeditor-->
<script src="{{ asset ("/bower_components/ckeditor/ckeditor.js") }}"></script>

@yield('plugins')
<!-- Initialize Scripts -->
<script type="text/javascript">
$(document).ready(function() {
  // Initialize Date Picker Plugin
  $('.date_time_picker').datetimepicker({
    format: "YYYY-MM-DD HH:mm:ss", // date time format
    allowInputToggle: true // allow on click on input to show date picker
  });

  $( ".treeview-menu" ).each(function() {
    if($(this).children().hasClass('active-submenu'))
    {
      $(this).addClass('menu-open');
      $(this).css('display','block');
      $(this).parent('li.treeview').addClass('active');
    }

  });

});
</script>



<!-- Initialize Delete Action -->
<script type="text/javascript">
$(document).ready(function() {
    $('.delete').click(function () {
        var id = $(this).data('id');
        $(".modal-body #row_id").val(id);

        $(this).parent().parent().addClass('about_to_delete');

    });

    $('.cancel_delete').click(function () {
        $("table").find(".about_to_delete").removeClass('about_to_delete');
    });

    $('.delete_row').click(function () {

        var id = $('#row_id').val();
        var path = $('#path').val();

        $.ajax({
              url: '/'+path+id,
              type: 'DELETE',
              data: { "_token": "{{ csrf_token() }}" },
              cache: false,
              dataType: "json",
              success: function(success_array)
              {
                //alert(success_array.msg);
                $("table").find(".about_to_delete").addClass('destroy_tr');
                setTimeout(remove_tr, 1500);

              },
              error: function(xhr, ajaxOptions, thrownError)
              {
                //alert("Test not working "+thrownError);
              }

            });

    });

    function remove_tr()
    {
        $(".destroy_tr").remove();
    }
  
});
</script>

<!-- Initialize Toggle Action -->
<script type="text/javascript">
$(document).ready(function() {

    $('.toggle').click(function (e) {

        var id = $(this).attr("data-id");
        var col = $(this).attr( "data-col");
        var table = $(this).attr( "data-table");
        var pk = $(this).attr("data-pk");

        $.ajax({
              url: "/common/toggle_active",
              type: "POST",
              data: {"_token": "{{ csrf_token() }}",id : id , col:col ,table:table,pk:pk },
              cache: false,
              dataType: "json",
              success: function(success_array)
              {

                $(".data-table tr[id="+id+"]  td."+col+" p " ).css("color","green").html(success_array.returned_array == 0 ? "No" : "Yes");
                                 
              },
              error: function(xhr, ajaxOptions, thrownError)
              {
                  alert("Test not working "+thrownError);
              }   
        });
        e.preventDefault();
    });

  
});
</script>


<!-- Initialize Change Password -->
<script type="text/javascript">
$(document).ready(function() {

    $(".field_error").hide();
    $('.popup').click(function () {
        var id = $(this).data('id');
        var email = $(this).data('email');
        $(".modal-body #row_id").val(id);
        $(".modal-body #email").html(email);

        //$(this).parent().parent().addClass('about_to_delete');

    });

    $('.popup_validate').click(function () {
        var id = $(this).data('id');
        $(".modal-body #user_id").val(id);
    });

    //hide popup window after ajax call
    function hide_popup()
    {
        $(".close_popup").trigger("click");
    }

    // $('.cancel_delete').click(function () {
    //     $("table").find(".about_to_delete").removeClass('about_to_delete');
    // });

    // Change Password Via Ajax
    $('.submit_change_password').click(function () {
        $(".field_error").hide();
        var id = $('#row_id').val();
        var path = $('#path').val();
        var password = $('#password').val();
        var confirm_password = $('#confirm_password').val();

        var state = Boolean();
        state = true; 
        
        
         if(password == "")
        {
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
              url: '/'+path+'change_password',
              type: 'POST',
              data: { "_token": "{{ csrf_token() }}",id:id,password:password },
              cache: false,
              dataType: "json",
              success: function(success_array)
              {
                //alert(success_array.msg);
                if(success_array.status == "success")
                {
                    $(".modal-footer #success").html(success_array.msg);
                }
                else
                {
                    $(".modal-footer #fail").html(success_array.msg);
                }
                 
                setTimeout(hide_popup, 3000);

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

    //Validate Code Via Ajax
        $('.submit_validate_account').click(function () {
        $(".field_error").hide();
        var id = $('#user_id').val();
        var path = $('#path').val();
        var code = $('#code').val();

        var state = Boolean();
        state = true; 
        
        if(code == "")
        {
            $("#code_error").fadeIn("fast");
            state = false;
        }
        
        if(state == true)
        {
            $.ajax({
              url: '/'+path+'validate_sms',
              type: 'POST',
              data: { "_token": "{{ csrf_token() }}",id:id,code:code },
              cache: false,
              dataType: "json",
              success: function(success_array)
              {
                if(success_array.status_code == 200)
                {
                    $(".modal-footer #success").html(success_array.status_description);
                }
                else
                {
                    $(".modal-footer #fail").html(success_array.status_description);
                }
                 
                setTimeout(hide_popup, 3000);

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
  
});
</script>
<script>
    $(function () {
        // Replace the <editor id="editor"> with a CKEditor
        // instance, using default configuration.
        CKEDITOR.replace('editor');
    })
</script>

<!-- Initialize Fancybox for Google Maps-->
<script type="text/javascript" >
$(document).ready(function() {
    $('.fancybox-media').fancybox({
        openEffect  : 'none',
        closeEffect : 'none',
        helpers : {
            media : {}
        }
    });
});
</script>

<!-- Show Pop up Window if there is message called back -->
<?php
if(session('message'))
{
    echo '<script>
        document.getElementById("popup_message").click();
    </script>';
}
?>
<!-- Optionally, you can add Slimscroll and FastClick plugins.
      Both of these plugins are recommended to enhance the
      user experience -->
</body>
</html>