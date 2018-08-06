@extends('template.backend.admin_template')
@section('content')
<?php
$user_id = \Auth::id();

?>
@if(isset($create) && $create == false)
<h4 class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-6 col-sm-push-6 text-right">Total Result:@if(isset($total_result)) {!! $total_result !!} @else {!! count($array)!!} @endif</h4>
@elseif(empty($create ) || $create  == true)
  @if(roles($user_id) != 'subscriber')
  <h4 class="col-lg-6 col-md-6 col-sm-6"><a style='text-decoration: underline;' href='/{{$path}}/create'>Create New {{$page_title}}</a></h4>
  <h4 class="col-lg-6 col-md-6 col-sm-6 text-right">Total Result:@if(isset($total_result)) {!! $total_result !!} @else {!! count($array)!!} @endif</h4>
  @else
  <h4 class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-6 col-sm-push-6 text-right">Total Result:@if(isset($total_result)) {!! $total_result !!} @else {!! count($array)!!} @endif</h4>
  @endif
@endif
<div class="clear"></div>
@if(isset($custom_search) && $custom_search == true)
@include('template.backend.custom_search_form')
@endif
<?php
  $order = Input::get('order');
  $dir = (Input::get('dir') == "" || Input::get('dir') == 0)? 1 : 0;
?>

<div class="table-responsive">
  @if(count($array) == 0)
  <h3 class="text-center">No Result Found</h3>
  @else
  <table class="table table-striped data-table">
  	<thead>
    <tr>
		<!-- <th>#</th> -->
    <th>ID</th>
    <!-- <th><a href ='/{!! $path."?order=&dir=".$dir !!}'>ID</a></th> -->
    @foreach($header as $row)
      @if($row['canView'] == true)
        @if(isset($row['canOrder']) && $row['canOrder'] == true)
          @if($row['dbName'] == $order)
            <th><a href ='/{!! $path."?order=".$row['dbName']."&dir=".$dir !!}'>{{$row['title']}}</a></th>
          @else
            <th><a href ='/{!! $path."?order=".$row['dbName']!!}'>{{$row['title']}}</a></th>
          @endif          
        @else
          <th>{{$row['title']}}</th>
        @endif
        
      @endif
  	@endforeach
  		<th>Actions</th>

    </tr>
  </thead>
  <tbody>

    @foreach($array as $key=>$record)
    <tr id="{{$record->$table_pk}}">

      <!-- <th scope="row"> {{$key+1}} </th> -->
      <td scope="row"><p> {{$record->$table_pk}}</p></td>
      
        @foreach($header as $row)

          @if($row['canView'] == true)
            
            @if($row['type'] == 'date')
            <!-- Start Date -->
              @if(empty($record->$row['dbName']))
                <td><p>{!! $record->$row['dbName'] !!}</p></td>
              @else
                @if(isset($row['format']) && $row['format'] == 'date')
                  <td><p>{!! date('Y-m-d', strtotime($record->$row['dbName'])) !!}</p></td>
                @elseif(isset($row['format']) && $row['format'] == 'dateTime')
                  <td><p>{!! date('Y-m-d H:i:s', strtotime($record->$row['dbName'])) !!}</p></td>
                @else
                  <td><p>{{$record->$row['dbName']}}</p></td>
                @endif
              @endif
            <!-- End Date -->
            
            <!-- Start link -->
            @elseif($row['type'] == 'link')
              <td><p><a  href='{{$row['path']}}/{{$record->$row['dbName']}}'>{{$row['message']}}</a></p></td>
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
                <td><p><a target='_blank' href='{{$row['path']}}/{{$record->$row['dbName']}}'>{{$result}}</a></p></td>
            <!-- End concat_link -->    
                                
            <!-- Start popup -->
            @elseif($row['type'] == 'popup')
              <td><p><a class='popup' title='Change Password' data-email="{!! $record->$row['value'] !!}" data-id="{{$record->$table_pk}}" data-toggle="modal" data-target="#popup" href='#'>{{$row['message']}}</a></p></td>
            <!-- End popup -->

            <!-- Start popup_validate -->
            @elseif($row['type'] == 'popup_validate')
              <td><p><a class='popup_validate' title='Validate Code' data-id="{!! $record->$row['value'] !!}" data-id="{{$record->$table_pk}}" data-toggle="modal" data-target="#validate" href='#'>{{$row['message']}}</a></p></td>
            <!-- End popup_validate -->

            <!-- Start toggle -->
            @elseif($row['type'] == 'toggle')
              <td><p><a class='toggle' title='{{$row['message']}}' data-col="{{$row['dbName']}}" data-table="{{$table_name}}" data-pk="{{$table_pk}}" data-id="{{$record->$table_pk}}"  href=''>{{$row['message']}}</a></p></td>
            <!-- End toggle -->

            <!-- Start popup_map -->
            @elseif($row['type'] == 'popup_map')
            <?php
              $pieces = explode(",", $row['value']);
              $lat = $pieces[0];
              $long = $pieces[1];
            ?>
              <td><p><a class="fancybox-media" href="http://maps.google.com/maps?q={{$record->$lat}},{{$record->$long}}&z=15">{{$row['message']}}</a></p></td>
            <!-- End popup_map -->
            
            @elseif($row['type'] == 'select')
              <!-- Start Select -->
              @if(isset($row['arrayOfData']))

                  <td class='{{$row['dbName']}}'><p>{!! get_value_from_array($record->$row['dbName'],$row['arrayOfData']) !!}</p></td>

              <!-- End Select -->
              @endif
            
            @elseif($row['type'] == 'text' && isset($record->$row['dbName']))
              <td><p>{{ $record->$row['dbName'] }}</p></td>

            @else
              <td><p>{{ $record->$row['dbName']}}</p></td>
            @endif

          @endif         
          
        @endforeach
      <td class='action'>
        @if(roles($user_id) != 'subscriber' && roles($user_id) != 'contributor')
          <a class='edit' title="Edit" href='/{{$path}}/{{$record->$table_pk}}/edit'><span class="glyphicon glyphicon-pencil"></span></a>
          <a class="delete" title="Delete" data-path='{{$path}}/' data-id="{{$record->$table_pk}}" data-toggle="modal" data-target="#delete" href="#"><span class="glyphicon glyphicon-trash"></span></a>
        @elseif(roles($user_id) == 'contributor')
          <a class='edit' title="Edit" href='/{{$path}}/{{$record->$table_pk}}/edit'><span class="glyphicon glyphicon-pencil"></span></a>
        @endif 
      </td>
      <td>
        
      </td>
    </tr>

    @endforeach
  </tbody>
    
  </table>

  <!--begin of pagination --> 
  <div class='pagination_wrapper col-lg-8 col-lg-push-2'>
    <!-- For sending order with Pagination -->
    @if($order)
    {!! $pagination->appends(['order' => $order])->links() !!}
    @elseif(!Request::input() || Request::input('page'))
    {!! $pagination->links() !!}
    @else
    <!-- this to check if all GET variables is empty or not -->
      <?php $total_values = 0; ?>
      @foreach(Request::input() as $key => $value)
      @if(empty($value))
      <?php $total_values += 0; ?>
      @else
      <?php $total_values += 1; ?>
      @endif
      @endforeach
      <!-- If all GET variables is empty so show Pagination -->
      @if($total_values == 0)
      {!! $pagination->links() !!}
      @endif

    @endif
  <!--end of pagination -->
  @endif

  @if(isset($message))
    {!! message_pop_up_window($message) !!}
  @endif

  {!! change_password_pop_up_window() !!}

  {!! validate_code_pop_up_window() !!}

  {!! delete_pop_up_window($path) !!}

@stop