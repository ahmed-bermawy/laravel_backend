@extends('template.backend.admin_template')
@section('content')
    <h4 class="col-lg-6 col-lg-push-6 col-md-6 col-md-push-6 col-sm-6 col-sm-push-6 text-right">Total Result: {!! count($array)!!} </h4>
    <div class="clear"></div>
    <div class="table-responsive">
        @if(count($array) == 0)
            <h3 class="text-center">No Result Found</h3>
        @else
            <table class="table table-striped data-table table-bordered">
                <thead>
                <tr>
                    <th width="30%">Column</th>
                    <th>Value</th>
                </tr>
                </thead>
                <tbody>
                @foreach($array as $key=>$value)
                    <tr>
                        <td width="30%"><p>{!! $key !!}</p></td>
                        @if($key == 'image')
                            <td><a data-fancybox="" href="{!! url($value) !!}"><img class="img-responsive thumbnail" src="{!! url($value) !!}" alt=""></a></td>
                        @else
                            <td><p>{!! $value !!}</p></td>
                        @endif
                    </tr>
                @endforeach
                </tbody>
            </table>
        @endif
    </div>
@stop