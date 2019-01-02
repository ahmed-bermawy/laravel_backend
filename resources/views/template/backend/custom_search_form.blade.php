<div style='border: 4px solid #a1a1a1;margin-top:5px;padding: 10px;border-radius:10px;'>
	<form action="" class='custom_search' method="get">
	@foreach ($tasks as $task)
		@if(isset($task['canSearch']) && $task['canSearch'] == true)
			@if ($task['type'] == 'text')
				<!-- Form Input for Text and Textarea-->
					<div class="form-group col-lg-1-7 col-md-3 col-sm-3">
						{!! Form::{$task['type']}($task['dbName'],Input::get($task['dbName']) ,['class' => 'form-control', 'id' => $task['dbName'], 'placeholder'=>$task['title'], 'data-id' => $task['dbName']]) !!}
					</div>

			@elseif($task['type'] == 'date')
				<!-- Form Input for Date -->
					<div class="form-group col-lg-4 col-md-4 col-sm-6">
					@if(Input::get($task['dbName']))
						<!-- Carbon\Carbon::parse(Input::get($task['dbName']))->format('m/d/Y') -->
							@if(isset($task['format']) && $task['format'] == 'dateTime')
								<div class="input-group date date_time_picker">
									{!! Form::input('text',$task['dbName'],'',['class' => 'form-control','placeholder'=>$task['title']]) !!}
									<span class="input-group-addon">
		                  		<span class="glyphicon glyphicon-calendar"></span>
		              		</span>
								</div>
							@else
								{!! Form::label($task['dbName'],$task['title'].' : ') !!}
								{!! Form::input($task['type'],$task['dbName'],Input::get($task['dbName']),['class' => 'form-control','placeholder'=>$task['title']]) !!}
							@endif
						@else
							@if(isset($task['format']) && $task['format'] == 'dateTime')
								<div class="input-group date date_time_picker">
									{!! Form::input('text',$task['dbName'],'',['class' => 'form-control','placeholder'=>$task['title']]) !!}
									<span class="input-group-addon">
		                  		<span class="glyphicon glyphicon-calendar"></span>
		              		</span>
								</div>
							@else
								{!! Form::label($task['dbName'],$task['title'].' : ') !!}
								{!! Form::input($task['type'],$task['dbName'],Input::get($task['dbName']),['class' => 'form-control','placeholder'=>$task['title']]) !!}
							@endif
						@endif
					</div>

			@elseif($task['type'] == 'hidden')
				<!-- Form hidden -->
				{!! Form::{$task['type']}($task['dbName'], $task['value']) !!}

			@elseif($task['type'] == 'select')

				<!-- Form Select -->
					<div class="form-group col-lg-3 col-md-5 col-sm-6" >
						<select id='{{$task['dbName']}}' class="form-control" name='{{$task['dbName']}}'>
							<option value="">{!! $task['title'] !!}</option>
							@if(isset($task['arrayOfData']))
								@foreach($task['arrayOfData'] as $inner_key => $options_array)
									<?php
									$selected = "";
									if($options_array['key'] == Input::get($task['dbName']) && Input::get($task['dbName']) != '')
										$selected = "selected";
									?>
									<option {!! $selected !!} value="{!! $options_array['key'] !!}">{!! $options_array['value'] !!}</option>
								@endforeach
							@elseif(!isset($task['arrayOfData']) && $task['dbName'] == 'roles' && isset($roles_for_search_input))
								@foreach($roles_for_search_input as $single_role)
									<option value="{!! $single_role['slug'] !!}">{!! $single_role['name'] !!}</option>
								@endforeach
							@endif
						</select>
					</div>

				@endif
			@endif

		@endforeach
		<div class="clear"></div>

		<div class="row">
			<div class="col-lg-12">
				<div class="text-center">
					{!! Form::submit('Search',['class' => 'btn btn-primary btn-lg']) !!}
				</div>
			</div>
		</div>
	</form>
</div>
