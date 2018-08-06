@extends('template.backend.admin_template')
@section('content')
    <style>
        table.table-bordered{
            border:2px solid lightgrey;
        }
        table.table-bordered tr th{
            border:2px solid lightgrey;
        }
    </style>
    <div class="clear"></div>
    <div class="table-responsive">
        <table class="table table-striped data-table table-bordered">
            <thead>
                <tr>
                    <th width="30%">Column</th>
                    <th>Value</th>
                </tr>
            </thead>
            <tbody>
                @foreach($article as $key=>$value)
                    <tr>
                        <td width="30%"><p>{!! $key !!}</p></td>
                        <td><p>{!! $value !!}</p></td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <h3>Category</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th width="30%">Column</th>
                <th>Value</th>
            </tr>
            </thead>
            <tbody>
            @foreach($category as $key=>$value)
                <tr>
                    <td width="30%"><p>{!! $key !!}</p></td>
                    <td><p>{!! $value !!}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Article Images</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th width="40%">Name</th>
                <th>Image</th>
            </tr>
            </thead>
            <tbody>
            @foreach($article_image as $key=>$value)
                <tr>
                    <td><p>{!! $value['image'] !!}</p></td>
                    <td><a title="{!! $value['image'] !!}" data-fancybox="" href="{!! prepareFile($value['image']) !!}"><img class="img-responsive thumbnail" src="{!! prepareFile($value['image']) !!}" alt=""></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Blueprint</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th width="40%">Blueprint Name</th>
                <th>Blueprint Image</th>
            </tr>
            </thead>
            <tbody>
            @foreach($blueprint as $key=>$value)
                <tr>
                    <td><p>{!! $value['blueprint_image'] !!}</p></td>
                    <td><a title="{!! $value['blueprint_image'] !!}" data-fancybox="" href="{!! prepareFile($value['blueprint_image']) !!}"><img class="img-responsive thumbnail" src="{!! prepareFile($value['blueprint_image']) !!}" alt=""></a></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Related Article</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th>Article ID</th>
                <th>Order Number</th>
            </tr>
            </thead>
            <tbody>
            @foreach($related as $key=>$value)
                <tr>
                    <td><p>{!! $value['related_article_id'] !!}</p></td>
                    <td><p>{!! $value['ordernumber'] !!}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Certification</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Description</th>
                <th>Description US</th>
                <th>State</th>
                <th>Document</th>
            </tr>
            </thead>
            <tbody>
            @foreach($certification as $key=>$value)
                <tr>
                    <td><p>{!! $value['name'] !!}</p></td>
                    <td><p>{!! $value['description'] !!}</p></td>
                    <td><p>{!! $value['translation_description_us'] !!}</p></td>
                    <td><p>{!! $value['state'] !!}</p></td>
                    <td><p>{!! $value['document'] !!}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Download</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th>File</th>
                <th>Description</th>
                <th>Link text</th>
                <th>Translation</th>
                <th>Language</th>
            </tr>
            </thead>
            <tbody>
            @foreach($download as $key=>$value)
                <tr>
                    <td><a target="_blank" href="{!! prepareFile($value['path']) !!}">{!! $value['path'] !!}</a></td>
                    <td><p>{!! $value['description'] !!}</p></td>
                    <td><p>{!! $value['linktext'] !!}</p></td>
                    <td><p>{!! $value['translation'] !!}</p></td>
                    <td><p>{!! $value['language'] !!}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Feature</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th>Name</th>
                <th>Value</th>
                <th>Name US</th>
                <th>Value US</th>
            </tr>
            </thead>
            <tbody>
            @foreach($feature as $key=>$value)
                <tr>
                    <td><p>{!! $value['name'] !!}</p></td>
                    <td><p>{!! $value['value'] !!}</p></td>
                    <td><p>{!! $value['translation_name_us'] !!}</p></td>
                    <td><p>{!! $value['translation_value_us'] !!}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>

        <h3>Symbol</h3>
        <table class="table table-striped data-table table-bordered">
            <thead>
            <tr>
                <th>Image</th>
                <th>Subline</th>
                <th>Group Name</th>
                <th>Option Name</th>
                <th>Tooltip Headline</th>
                <th>Tooltip Headline US</th>
                <th>Tooltip Text</th>
                <th>Tooltip Text US</th>
                <th>Order</th>
            </tr>
            </thead>
            <tbody>
            @foreach($symbol as $key=>$value)
                <tr>
                    <td><a title="{!! $value['symbol_image'] !!}" data-fancybox="" href="{!! prepareFile($value['symbol_image']) !!}"><img class="img-responsive thumbnail" src="{!! prepareFile($value['symbol_image']) !!}" alt=""></a></td>
                    <td><p>{!! $value['subline'] !!}</p></td>
                    <td><p>{!! $value['group_name'] !!}</p></td>
                    <td><p>{!! $value['option_name'] !!}</p></td>
                    <td><p>{!! $value['tooltip_headline'] !!}</p></td>
                    <td><p>{!! $value['tooltip_headline_us'] !!}</p></td>
                    <td><p>{!! $value['tooltip_text'] !!}</p></td>
                    <td><p>{!! $value['tooltip_text_us'] !!}</p></td>
                    <td><p>{!! $value['order'] !!}</p></td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@stop