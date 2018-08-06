@extends('template.backend.admin_template')
@section('content')
    <h4 class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-6 col-sm-push-6 text-right">Total Result: {!! count($array)!!} </h4>
    <div class="clear"></div>
    <div class="table-responsive">
        @if(count($array) == 0)
            <h3 class="text-center">No Result Found</h3>
        @else
            <table class="table table-striped data-table">
                <thead>
                    <tr>
                        @foreach($header as $row)
                            @if($row['canView'] == true)
                                @if($row['type'] == '2levels')

                                    @foreach($array[0][$row['dbNameFirstLevel']] as $key=>$record)
                                        <th>{!! $row['message'].' - '.strtoupper($record['locale']) !!}</th>
                                    @endforeach
                                @else
                                    <th>{{$row['title']}}</th>
                                @endif
                            @endif
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach($array as $key=>$record)
                        <tr id="{{$record[$table_pk]}}">
                            @foreach($header as $row)
                                @if($row['canView'] == true)
                                    @if($row['type'] == '2levels')
                                        @foreach($record[$row['dbNameFirstLevel']] as $second_level)
                                            <td><p>{!! $second_level[$row['dbNameSecondLevel']] !!}</p></td>
                                        @endforeach
                                    @else
                                        <td><p>{!! $record[$row['dbName']] !!}</p></td>
                                    @endif

                                @endif
                            @endforeach
                        </tr>
                    @endforeach
                </tbody>
            </table>
        @endif
    </div>
@stop