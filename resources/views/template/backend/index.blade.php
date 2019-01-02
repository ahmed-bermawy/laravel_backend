@extends('template.backend.admin_template')
@section('content')

    <?php
    $user_id = \Auth::id();
    $order = Request::get('order');
    $dir = (Request::get('dir') == "" || Request::get('dir') == 0)? 1 : 0;
    ?>

    @if(isset($create) && $create == false)
        @if(isset($import) && $import == true)
            <h4 class="col-lg-6 col-md-6 col-sm-6  no-padding">
                @foreach($import_array as $import_row)
                    <a class="btn btn-info btn-lg" href="{{url($path.$import_row['url'])}}">{{$import_row['name']}}</a>
                @endforeach
            </h4>
        @else
            <h4 class="col-lg-6 col-md-6 col-sm-6  no-padding">
                @if(isset($order_link))
                    <a class="btn btn-info btn-lg" href="{{url($order_link)}}">Order {{$page_title}}</a>
                @endif
            </h4>
        @endif
        <h4 class="col-lg-6 col-md-6 col-sm-6 text-right">Total Result:@if(isset($total_result)) {!! $total_result !!} @else {!! count($array)!!} @endif</h4>
    @elseif(empty($create ) || $create  == true)
        @if(roles($user_id) != 'subscriber')
            <h4 class="col-lg-6 col-md-6 col-sm-6 no-padding">
                <a class="btn btn-primary btn-lg" href='{{url($path.'create')}}'>Create New {{$page_title}}</a>
                @if(isset($order_link))
                    <a class="btn btn-info btn-lg" href="{{url($order_link)}}">Order {{$page_title}}</a>
                @endif
            </h4>
            <h4 class="col-lg-6 col-md-6 col-sm-6 text-right">Total Result:@if(isset($total_result)) {!! $total_result !!} @else {!! count($array)!!} @endif</h4>
        @else
            <h4 class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-6 col-sm-push-6 text-right">Total Result:@if(isset($total_result)) {!! $total_result !!} @else {!! count($array)!!} @endif</h4>
        @endif
    @endif
    <div class="clear"></div>
    @if(isset($custom_search) && $custom_search == true)
        @include('template.backend.custom_search_form')
    @endif
    <div class="clear"></div>
    <div class="table-responsive">
        @if(count($array) == 0)
            <h3 class="text-center">No Result Found</h3>
        @else
            <table class="table table-striped data-table">
                <thead>
                <tr>
                    <!-- <th>#</th> -->
                    {{--<th>ID</th>--}}
                    @foreach($header as $row)
                        @if($row['canView'] == true)
                            @if(isset($row['canOrder']) && $row['canOrder'] == true)
                                @if($row['dbName'] == $order)
                                    <th><a href ="{{ url($path.'?order='.$row['dbName'].'&dir='.$dir) }}"><i class="fa fa-fw fa-sort"></i>{{$row['title']}}</a></th>
                                @else
                                    <th><i class="fa fa-fw fa-sort"></i><a href ="{{ url($path.'?order='.$row['dbName']) }}">{{$row['title']}}</a></th>
                                @endif
                            @else
                                <th>{{$row['title']}}</th>
                            @endif
                        @endif
                    @endforeach
                    @if(isset($edit) && $edit == false && isset($delete) && $delete == false)
                    @else
                        <th>Actions</th>
                    @endif
                </tr>

                </thead>
                <tbody>
                @foreach($array as $key=>$record)
                    <tr id="{{$record->$table_pk}}">
                    {{--<th scope="row"> {{$key+1}} </th>--}}
                    {{--<td scope="row"><p> {{$record->$table_pk}}</p></td>--}}

                    @foreach($header as $row)

                        @if($row['canView'] == true)

                            @if($row['type'] == 'date')
                                <!-- Start Date -->
                                    @if(isset($row['format']) && $row['format'] == 'date')
                                        @if(empty($record->{$row['dbName']}))
                                            <td><p>{!! $record->{$row['dbName']} !!}</p></td>
                                        @else
                                            <td><p>{!! date('Y-m-d', strtotime($record->{$row['dbName']} )) !!}</p></td>
                                        @endif
                                    @elseif(isset($row['format']) && $row['format'] == 'dateTime')
                                        <td><p>{!! date('Y-m-d h:i:s', strtotime($record->{$row['dbName']} )) !!}</p></td>
                                    @else
                                        <td><p>{!! $record->{$row['dbName']} !!}</p></td>
                                        <!-- End Date -->
                                    @endif

                                <!-- Start link -->
                                @elseif($row['type'] == 'link')
                                    <td><p><a  href='{!! url($row['path'].$record->{$row['dbName']}) !!}'>@if($record->{$row['message']}){!! $record->{$row['message']} !!} @else {{$row['message']}} @endif</a></p></td>
                                    <!-- End link -->

                                    <!-- Start concat_link -->
                                @elseif($row['type'] == 'concat_link')
                                    <?php
                                    $array = explode(',', $row['variables']);
                                    $result = '';
                                    foreach ($array as $value)
                                    {
                                        $result .= $record->$value.' ';
                                    }
                                    ?>
                                    <td><p><a target='_blank' href='{!! url($row['path'].$record->{$row['dbName']}) !!}'>{{$result}}</a></p></td>
                                    <!-- End concat_link -->

                                    <!-- Start popup -->
                                @elseif($row['type'] == 'popup')
                                    <td><p><a class='popup' title='Change Password' data-email="{!! $record->{$row['value']} !!}" data-id="{{$record->$table_pk}}" data-toggle="modal" data-target="#popup" href='#'>{{$row['message']}}</a></p></td>
                                    <!-- End popup -->

                                    <!-- Start toggle -->
                                @elseif($row['type'] == 'toggle')
                                    <td><p><a class='toggle' title='{{$row['message']}}' data-col="{{$row['dbName']}}" data-table="{{$table_name}}" data-pk="{{$table_pk}}" data-id="{{ $record->{$row['pk']} }}"  href=''>{{$row['message']}}</a></p></td>
                                    <!-- End toggle -->

                                @elseif($row['type'] == 'select')
                                <!-- Start Select -->
                                    @if(isset($row['arrayOfData']))
                                        @if($row['dbName'] == 'parent_role')
                                            <td class='{{$row['dbName']}}'>
                                                <p>
                                                    Parent Role
                                                </p>
                                            </td>
                                        @else
                                            <td class='{{$row['dbName']}}'><p>{!! get_value_from_array($record->{$row['dbName']},$row['arrayOfData']) !!}</p></td>
                                        @endif
                                    @else
                                        <td>
                                            @foreach($record->roles as $role)
                                                @if($role->name == 'Admin' && count($record->roles) == 2)
                                                @else
                                                    <span class="badge" >{{ $role->name }}</span>
                                                @endif
                                            @endforeach
                                        </td>
                                        <!-- End Select -->
                                    @endif

                                @elseif($row['type'] == 'image')
                                    <td >
                                        <?php
                                        if (!empty($record->{$row['dbName']}))
                                        {
                                            $url_path = url($row['file_path']).'/'.$record->{$row['dbName']};
                                            $public_path = public_path($row['file_path'].'/'.$record->{$row['dbName']});

                                            if (File::exists($public_path))
                                            {
                                                $ext = pathinfo($url_path, PATHINFO_EXTENSION);
                                                if ($ext == 'png' || $ext == 'jpg' || $ext == 'jpeg' )
                                                {
                                                    echo '<a data-fancybox href="'.$url_path.'" ><img class="img-responsive thumbnail" src="'.$url_path.'" alt=""></a>';
                                                }
                                            }
                                        }
                                        ?>
                                    </td>

                                @elseif($row['type'] == 'text' && isset($row['value']))
                                    <td><p>{!! $record->{$row['value']} !!}</p></td>

                                @elseif($row['type'] == 'external_link' && isset($record->{$row['dbName']}))
                                <!-- Form Input for external_link -->
                                    <td>
                                        <a TARGET="_blank" href="{!! url($row['path'].$record->{$row['dbName']}) !!}" >{!! $record->{$row['dbName']} !!}</a>
                                    </td>

                                @elseif($row['type'] == 'external_image' && isset($record->{$row['dbName']}))
                                <!-- Form Input for image -->
                                    <td>
                                        <p style="max-width: 75px;">
                                            <a data-fancybox href="{!! url($row['path'].$record->{$row['dbName']}) !!}" ><img class="img-responsive thumbnail" src="{!! $row['path'].$record->{$row['dbName']} !!}" alt=""></a>
                                        </p>
                                    </td>

                                @else
                                    <td><p>{{ str_limit($record->{$row['dbName']},250) }}</p></td>
                                @endif

                            @endif
                        @endforeach
                        <td class='action'>
                            @if(roles($user_id) == 'subscriber')
                                {{-- subscriber can view and edit only --}}
                                @if(isset($view) && $view == true)
                                    <a class='view' title="View" href='{{url($path.$record->$table_pk)}}'>
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                @endif
                                @if(isset($edit) && $edit == false)
                                @else
                                    <a class='edit' title="Edit" href='{{url($path.$record->$table_pk.'/edit')}}'>
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                @endif
                            @else
                                {{-- anyone else can view, edit and delete --}}
                                @if(isset($view) && $view == true)
                                    <a class='view' title="View" href='{{url($path.$record->$table_pk)}}'>
                                        <span class="glyphicon glyphicon-eye-open"></span>
                                    </a>
                                @endif
                                @if(isset($edit) && $edit == false)
                                @else
                                    <a class='edit' title="Edit" href='{{url($path.$record->$table_pk.'/edit')}}'>
                                        <span class="glyphicon glyphicon-pencil"></span>
                                    </a>
                                @endif
                                @if(isset($delete) && $delete == false)
                                @else
                                    <a class="delete" title="Delete" data-path='{{url($path)}}' data-id="{{$record->$table_pk}}" data-toggle="modal" data-target="#delete" href="#">
                                        <span class="glyphicon glyphicon-trash"></span>
                                    </a>
                                @endif
                            @endif
                        </td>
                        <td></td>
                    </tr>

                @endforeach
                </tbody>

            </table>

            <!--begin of pagination -->
            <div class='pagination_wrapper text-center'>
                @if(!Request::input('q'))
                    {!! $array->links() !!}
                @endif
            </div>
            <!--end of pagination -->
    @endif

    @if(isset($message))
        {!! message_pop_up_window($message) !!}
    @endif

    {!! change_password_pop_up_window() !!}

    {!! delete_pop_up_window($path) !!}

@stop