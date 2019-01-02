<!-- Start Form -->
@foreach ($tasks as $task)
    @if(isset($task['canEdit']) && isset($formAction) && $task['canEdit'] == false && $formAction == 'update')
        <?php /* for update form and you didn't want to show input in form  */ ?>
    @elseif(isset($task['canAdd']) && isset($formAction) && $task['canAdd'] == false && $formAction == 'create')
        <?php /* for create form and you didn't want to show input in form  */ ?>
    @else
        @if (($task['type'] == 'text' || $task['type'] == 'textarea' || $task['type'] == 'email') )
            <!-- Form Input for Text and Textarea-->
            <div class="form-group">
                {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                @if(isset($task['message']) && $task['message'] != '')
                    <code>{!! $task['message'] !!}</code>
                @endif
                {!! Form::{$task['type']}($task['dbName'],null,['class' => 'form-control', 'data-id' => $task['dbName']]) !!}
            </div>
        @elseif($task['type'] == 'date')
            <!-- Form Input for Date -->
            <div class="form-group">
                {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                @if(isset($task['message']) && $task['message'] != '')
                    <code>{!! $task['message'] !!}</code>
                @endif
                @if(empty($data[$task['dbName']]))
                    @if(isset($task['format']) && $task['format'] == 'dateTime')
                        <div class="input-group date date_time_picker">
                            {!! Form::input('text',$task['dbName'],'',['class' => 'form-control']) !!}
                            <span class="input-group-addon">
	                  		<span class="glyphicon glyphicon-calendar"></span>
	              		</span>
                        </div>
                    @elseif(isset($task['format']) && $task['format'] == 'date')
                        <div class="input-group date date_picker">
                            {!! Form::input('text',$task['dbName'],'',['class' => 'form-control']) !!}
                            <span class="input-group-addon">
	                  		<span class="glyphicon glyphicon-calendar"></span>
	              		</span>
                        </div>
                    @else
                        {!! Form::input($task['type'],$task['dbName'],Carbon\Carbon::now()->format('Y-d-m'),['class' => 'form-control']) !!}
                    @endif

                @else
                    @if(isset($task['format']) && $task['format'] == 'dateTime')
                        {!! Form::input('text',$task['dbName'],Carbon\Carbon::now()->format('Y-d-m H:i:s'),['class' => 'form-control']) !!}
                    @elseif(isset($task['format']) && $task['format'] == 'date')
                        {!! Form::input('text',$task['dbName'],Carbon\Carbon::now()->format('Y-d-m'),['class' => 'form-control']) !!}
                    @else
                        {!! Form::input($task['type'],$task['dbName'],date('Y-m-d', strtotime($data[$task['dbName']])),['class' => 'form-control']) !!}
                    @endif
                @endif
            </div>

        @elseif($task['type'] == 'editor')
            <!-- Form Input for Editor -->
            <div class="form-group">
                {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                @if(isset($task['message']) && $task['message'] != '')
                    <code>{!! $task['message'] !!}</code>
                @endif
                {!! Form::textarea($task['dbName'],null,['class' => 'form-control', 'id' => 'editor', 'data-id' => $task['dbName']]) !!}
            </div>

        @elseif($task['type'] == 'password')
            <!-- Form Input for password -->
            <div class="form-group">
                {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                @if(isset($task['message']) && $task['message'] != '')
                    <code>{!! $task['message'] !!}</code>
                @endif
                {!! Form::{$task['type']}($task['dbName'],['class' => 'form-control']) !!}
                @if($task['dbName'] == 'confirm_password')
                    <p id="confirm_password_error" class="field_error alert-danger" style="display: none;"> This field is required</p>
                    <p id="not_match_error" class="field_error alert-danger" style="display: none;"> Password does not match</p>
                @endif
            </div>

        @elseif($task['type'] == 'image')
            <!-- Form Input for image -->
            <div class='row'>
                <div class="form-group col-lg-6 col-xs-12">
                    {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                    @if(isset($task['message']) && $task['message'] != '')
                        <code>{!! $task['message'] !!}</code>
                    @endif
                    {!! Form::file($task['dbName'],['class' => '']) !!}
                </div>
                <div class="col-lg-6 col-xs-12">
                    <?php
                    if (!empty($data[$task['dbName']]))
                    {
                        $url_path = url($task['file_path']).'/'.$data[$task['dbName']];
                        $public_path = public_path($task['file_path'].'/'.$data[$task['dbName']]);

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
                </div>
            </div>

        @elseif($task['type'] == 'file')
            <!-- Form Input for file -->
            <div class='row'>
                <div class="form-group col-lg-6 col-xs-12">
                    {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                    @if(isset($task['message']) && $task['message'] != '')
                        <code>{!! $task['message'] !!}</code>
                    @endif
                    {!! Form::file($task['dbName'],['class' => '']) !!}
                </div>
                <div class="col-lg-6 col-xs-12">
                    <?php
                    if (!empty($data[$task['dbName']]))
                    {
                        $url_path = url($task['file_path']).'/'.$data[$task['dbName']];
                        $public_path = public_path($task['file_path'].'/'.$data[$task['dbName']]);

                        if (File::exists($public_path))
                        {
                            echo '<a href="'.$url_path.'" target="_blank" >'.$url_path.'</a>';
                        }
                    }
                    ?>
                </div>
            </div>

        @elseif($task['type'] == 'checkbox')
            <!-- Form Input for checkbox -->
            <div class="form-group">
                {!! Form::label($task['dbName'],$task['title'].' : ') !!}
                @if(isset($task['message']) && $task['message'] != '')
                    <code>{!! $task['message'] !!}</code>
                @endif
                @if(isset($checked) && isset($task['data-toggle']))
                    {!! Form::{$task['type']}($task['dbName'],$task['value'], $checked,['data-toggle'=>$task['data-toggle'], 'id'=>$task['id']]) !!}
                @elseif(isset($checked))
                    {!! Form::{$task['type']}($task['dbName'],$task['value'], $checked) !!}
                @else
                    {!! Form::{$task['type']}($task['dbName'],$task['value']) !!}
                @endif
            </div>


        @elseif($task['type'] == 'hidden')
            <!-- Form hidden -->
            {!! Form::{$task['type']}($task['dbName'], $task['value'],['id' => $task['dbName']]) !!}

        @elseif($task['type'] == 'select')
            <!-- Form select -->
            {!! Form::label($task['dbName'],$task['title'].' : ') !!}
            @if(isset($task['message']) && $task['message'] != '')
                <code>{!! $task['message'] !!}</code>
            @endif
            <div class="form-group">

                @if(isset($select_from_another_table) && $select_from_another_table == true)

                    <select class="form-control" name='{{$selected_value["input_name"]}}'>

                        <option value="">
                            @if(isset($task['defaultOption']) && $task['defaultOption'] != '')
                                {!! $task['defaultOption'] !!}
                            @else
                                {!! $task['title'] !!}
                            @endif
                        </option>

                        @foreach($task['arrayOfData'] as $inner_key => $options_array)
                            <?php
                            $selected = "";
                            if (!empty($selected_value['input_value'])) {
                                if ($options_array['key'] == $selected_value['input_value'] && $selected_value['input_value'] != '')
                                    $selected = "selected";
                            } elseif (!empty(old($task['dbName']))) {
                                $selected = "selected";
                            }
                            ?>
                            <option {!! $selected !!} value="{!! $options_array['key'] !!}">{!! $options_array['value'] !!}</option>
                        @endforeach
                    </select>
                @elseif(isset($task['ajaxEnabled']) && $task['ajaxEnabled'])
                    <select id="{{$task['dbName']}}" class="form-control" name='{{$task['dbName']}}'
                            data-placeholder="Select {!! $task['title'] !!}">
                        <option value="">
                            @if(isset($task['defaultOption']) && $task['defaultOption'] != '')
                                {!! $task['defaultOption'] !!}
                            @else
                                {!! $task['title'] !!}
                            @endif
                        </option>
                        @if(isset($data))
                            <option selected="selected" value="{!! $data[$task['dbName']]['value']!!}">
                                {!! $data[$task['dbName']]['text']!!}
                            </option>
                        @endif

                    </select>
                @else
                    <select id="{{$task['dbName']}}" class="form-control" name='{{$task['dbName']}}'
                            data-placeholder="Select {!! $task['title'] !!}">

                        <option value="">
                            @if(isset($task['defaultOption']) && $task['defaultOption'] != '')
                                {!! $task['defaultOption'] !!}
                            @else
                                {!! $task['title'] !!}
                            @endif
                        </option>

                        @foreach($task['arrayOfData'] as $inner_key => $options_array)
                            <?php

                            $selected = "";
                            if (!empty($data[$task['dbName']])) {
                                if ($options_array['key'] == $data[$task['dbName']] && $data[$task['dbName']] != '')
                                    $selected = "selected";
                            } elseif (!empty(old($task['dbName']))) {
                                $selected = "selected";
                            }
                            ?>
                            <option {!! $selected !!} value="{!! $options_array['key'] !!}">{!! $options_array['value'] !!}</option>
                        @endforeach

                    </select>
                @endif
            </div>

        @endif
    @endif

@endforeach

<!-- Form Input Submit-->
<div class="form-group">
    {!! Form::submit($submitButtonText,['class' => 'btn btn-primary form-control']) !!}
</div>