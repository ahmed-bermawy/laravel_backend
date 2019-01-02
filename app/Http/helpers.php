<?php
/*This Function has no longer use
* since 4/5/2016
* Ahmed Bremawy
*/
function delete_form($routeParams, $lable = 'X')
{
  $form = Form::open(['method'=>'DELETE','class'=>'delete_form','style' => 'float: right','url' => $routeParams]);

  $form .= Form::submit($lable,['class' => 'btn btn-danger delete_submit_btn']);

  return $form .= Form::close();
}

function sort_by($path,$column)
{
  return Html::linkRoute($path, $column, array('sortBy'=>$column));
}

function get_value_from_array($searchFor,$arrayOfData)
{
  $result_value = false;
  for($i=0;$i<sizeof($arrayOfData);$i++):
    if($arrayOfData[$i]['key'] == $searchFor)
    {
      $result_value = $arrayOfData[$i]['value'];
      break;
      return $result_value;
    }
  endfor;
  if(!$result_value) $result_value = "( N/A )";
  return $result_value;
}//ENd of get_value_from_arrayOfData

/**
 * return yes / no valuse for drop down menu in select form
 * @return [type] [boolean]
 */
function active_values()
{
  return array(array('key'=>0,'value'=>'No'),array('key'=>1,'value'=>'Yes'));
}
/**
 * This Function is show pop up window
 * to alert the user if he want to delete or not
 *
 * @param  [type] $path [path for the current page]
 * @return [type]       [pop up window]
 */
function delete_pop_up_window($path)
{
  $display = '<!-- Delete Pop up Window -->
    <div class="modal fade" id="delete" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close cancel_delete" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete?</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete the highlighted row?</p>
            <input type="hidden" name="row_id" id="row_id" value=""/>
            <input type="hidden" name="path" id="path" value="'.$path.'" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn delete_row btn-default" data-dismiss="modal">Yes</button>
            <button type="button" class="btn cancel_delete btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>';

  return $display;

}

/**
 * This Function is show pop up window
 * to alert the user if he want to delete or not
 *
 * @param  [type] $path [path for the current page]
 * @return [type]       [pop up window]
 */
function delete_pop_up_window_for_retailer($path)
{
  $display = '<!-- Delete Pop up Window -->
    <div class="modal fade" id="delete" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close cancel_delete" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Delete?</h4>
          </div>
          <div class="modal-body">
            <p>Are you sure you want to delete the highlighted row?</p>
            <input type="hidden" name="row_id" id="row_id" value=""/>
            <input type="hidden" name="retailer_id" id="retailer_id" value=""/>
            <input type="hidden" name="path" id="path" value="'.$path.'" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn delete_row_for_retailer btn-default" data-dismiss="modal">Yes</button>
            <button type="button" class="btn cancel_delete btn-default" data-dismiss="modal">No</button>
          </div>
        </div>
      </div>
    </div>
  </div>';

  return $display;

}

function change_password_pop_up_window()
{
  $display = '<!-- Change Password Pop up Window -->
    <div class="modal fade" id="popup" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Change Password</h4>
          </div>
          <div class="modal-body">
            <p>You are about to change password for email : <strong id="email"></strong></p>
            <input type="hidden" name="row_id" id="row_id" value=""/>
            '.\Form::label('password','Password').'
            '.\Form::password('password',['class' => 'form-control']).'
            <p id="password_error" class="field_error alert-danger" > This field is required</p>
            '.\Form::label('confirm_password','Confirm Password').'
            '.\Form::password('confirm_password',['class' => 'form-control']).'
            <p id="confirm_password_error" class="field_error alert-danger"> This field is required</p>
            <p id="not_match_error" class="field_error alert-danger"> Password not matched</p>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <p id="success" class="alert-success"></p>
            <p id="fail" class="alert-danger"></p>
            
            <button type="button" class="btn btn-primary submit_change_password">submit</button>
            <button type="button" class="btn btn-default close_popup" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>';

  return $display;

}

function validate_code_pop_up_window()
{
  $display = '<!-- Validate Code Pop up Window -->
    <div class="modal fade" id="validate" role="dialog">
      <div class="modal-dialog modal-md">
        <div class="modal-content">
          <div class="modal-header">
            <button type="button" class="close" data-dismiss="modal">&times;</button>
            <h4 class="modal-title">Activation Code</h4>
          </div>
          <div class="modal-body">
            <p>Please Enter The Activation Code</p>
            <input type="hidden" name="user_id" id="user_id" value=""/>
            '.\Form::label('code','Validation Code').'
            '.\Form::text('code').'
            <p id="code_error" class="field_error alert-danger" > This field is required</p>
          </div>
          <div class="modal-footer" style="text-align: center;">
            <p id="success" class="alert-success"></p>
            <p id="fail" class="alert-danger"></p>
            
            <button type="button" class="btn btn-primary submit_validate_account">submit</button>
            <button type="button" class="btn btn-default close_popup" data-dismiss="modal">Cancel</button>
          </div>
        </div>
      </div>
    </div>';

  return $display;

}

/**
 * [message_pop_up_window description]
 * @param  [text] $message [call back message]
 * @return [html code]     [pop up window]
 */
function message_pop_up_window($message)
{
  $display = '
  <a class="popup_message" id="popup_message" data-toggle="modal" data-target="#message" href="#"></a>
  <div class="modal fade" id="message" role="dialog">
      <div class="modal-dialog modal-md">
          <div class="modal-content">
            <div class="modal-header">
              <button type="button" class="close" data-dismiss="modal">&times;</button>
              <h4 class="modal-title">Messsage </h4>
            </div>
            <div class="modal-body">
              <p>'.$message.'</p>
            </div>
          </div>
      </div>
    </div>';
  return $display;
}

/**
 * Check if the user logged in to backend is
 * admin or super admin.
 * @return [type] [description]
 */
function adminOnly()
{
  if(roles() == 'super_admin' || roles() == 'admin')
  {
    return true;
  }
  else
  {
    return false;
  }
}

/**
 * Check what is the roles
 * for the backend user
 * @return [type] [description]
 */
function roles()
{
  $auth = \Auth::User();
  if ($auth)
  {
    $user = \Sentinel::findById($auth->id);

    if($user->hasAccess(['super_admin']))
    {
      $role = 'super_admin';
    }
    elseif ($user->hasAccess(['admin']))
    {
      $role = 'admin';
    }
    elseif ($user->hasAccess(['editor']))
    {
      $role = 'editor';
    }
    elseif ($user->hasAccess(['contributor']))
    {
      $role = 'contributor';
    }
    else
    {
      $role = 'subscriber';
    }
  }
  else
  {
    $role = 'guest';
  }

  return $role;
}

/**
 * Check what is the roles
 * for the backend user
 * @return [type] [description]
 */
function slug($text)
{
  // replace non letter or digits by -
  $text = preg_replace('~[^\pL\d]+~u', '-', $text);

  // transliterate
  $text = iconv('utf-8', 'us-ascii//TRANSLIT', $text);

  // remove unwanted characters
  $text = preg_replace('~[^-\w]+~', '', $text);

  // trim
  $text = trim($text, '-');

  // remove duplicate -
  $text = preg_replace('~-+~', '-', $text);

  // lowercase
  $text = strtolower($text);

  if (empty($text)) {
    return 'n-a';
  }

  return $text;
}

function multiKeyExists(array $arr, $key)
{
  // is in base array?
  if (array_key_exists($key, $arr))
  {
    return true;
  }

  // check arrays contained in this array
  foreach ($arr as $element)
  {
    if (is_array($element))
    {
      if (multiKeyExists($element, $key))
      {
        return true;
      }
    }
  }
  return false;
}


/**
 * [message_pop_up_window description]
 * @param  [text] $message [call back message]
 * @return [html code]     [pop up window]
 */
function create_table($table_id,$table_name,$header_array,$body_array)
{
  $display = '';
  $display .= '<h3 class="text-center">'.$table_name.'<span style="font-size: 18px;" class="float-right">Total Result: '.count($body_array).'</span></h3>';
  $display .= '<table id="'.$table_id.'" class="tablesorter table table-striped data-table" ><thead><tr>';
  foreach ($header_array as $row)
  {
    if($row['canView'] == true)
    {
      $display .='<th>'.$row['title'].'</th>';
    }
  }
  $display .= '</tr></thead><tbody>';
  foreach($body_array as $key=>$record)
  {
    $display .= '<tr>';
    foreach($header_array as $row)
    {
      if($row['canView'] == true)
      {
        if($row['type'] == 'date')
        {
          if(empty($record[$row['dbName']]))
          {
            $display .='<td><p>'.$record[$row['dbName']] .'</p></td>';
          }
          else
          {
            $display .='<td><p>'.date('Y/m/d H:i:s', substr($record[$row['dbName']], 0, -3)) .'</p></td>';
          }
        }
        elseif ($row['type'] == 'text')
        {
          $display .= '<td><p>'.$record[$row['dbName']].'</p></td>';
        }
        else
        {
          $display .= '<td><p>'.$record[$row['dbName']].'</p></td>';
        }
      }//end check if canView == true
    }//end second foreach
    $display .= '</tr>';
  } //end first foreach
  $display .= '</tbody></table>';
  return $display;
}

function create_table_single_row($table_id,$table_name,$header_array,$body_array)
{
  $display = '';
  $display .= '<h3 class="text-center">'.$table_name.'<span style="font-size: 18px;" class="float-right">Total Result: '.count($body_array).'</span></h3>';
  $display .= '<table id="'.$table_id.'" class="tablesorter table table-striped data-table" ><thead><tr>';
  foreach ($header_array as $row)
  {
    if($row['canView'] == true)
    {
      $display .='<th>'.$row['title'].'</th>';
    }
  }
  $display .= '</tr></thead><tbody>';
  $display .= '<tr>';
  foreach($body_array as $key=>$record)
  {
    $display .= '<td><p>'.$record.'</p></td>';
  } //end first foreach
  $display .= '</tr>';
  $display .= '</tbody></table>';
  return $display;
}

function create_form($submitButtonText,$header_array,$body_array ='',$selected_values ='')
{
  $display = '';
  foreach ($header_array as $task)
  {
    //Form Input for Text, Textarea and Email
    if($task['type'] == 'text' || $task['type'] == 'textarea' || $task['type'] == 'email' )
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= Form::$task['type']($task['dbName'],null,['class' => 'form-control', 'data-id' => $task['dbName']]);

      $display .= '</div>';
    }
    //Form Input for Date
    elseif($task['type'] == 'date')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      if(empty($data[$task['dbName']]))
      {
        if (isset($task['format']) && $task['format'] == 'dateTime')
        {
          $display .= '<div class="input-group date date_time_picker">';
          $display .= Form::input('text',$task['dbName'],$task['defaultOption'],['class' => 'form-control']);
          $display .= '<span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>';
        }
        else
        {
          $display .= Form::input($task['type'],$task['dbName'],Carbon\Carbon::now()->format('Y-d-m'),['class' => 'form-control']);
        }
      }
      else
      {
        if(isset($task['format']) && $task['format'] == 'dateTime')
        {
          $display .= Form::input('text',$task['dbName'],Carbon\Carbon::now()->format('Y-d-m H:i:s'),['class' => 'form-control']);
        }
        else
        {
          $display .= Form::input($task['type'],$task['dbName'],Carbon\Carbon::now()->format('Y-d-m'),['class' => 'form-control']);
        }
      }
      $display .= '</div>';
    }
    //Form Input for password
    elseif($task['type'] == 'password')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= Form::$task['type']($task['dbName'],['class' => 'form-control']);

      $display .= '</div>';
    }
    //Form Checkbox
    elseif($task['type'] == 'checkbox')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= Form::$task['type']($task['dbName'],$task['value']);

      $display .= '</div>';
    }
    //Form Radio
    elseif($task['type'] == 'radio')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';
      $display .= '<br>';
      foreach($task['arrayOfData'] as $inner_key => $options_array)
      {
        $checked = false;
        if(!empty($selected_values['input_value']))
        {
          if($options_array['key'] == $selected_values['input_value'] && $selected_values['input_value'] != '')
            $checked = true;
        }
        elseif(!empty(old($task['dbName'])))
        {
          $checked = true;
        }
        elseif (isset($options_array['checked']) && $options_array['checked'] == 1)
        {
          $checked = true;
        }

        $display .= Form::radio($task['dbName'], $options_array['key'] , $checked, ['class' => $task['dbName']]);
        $display .= Form::label($options_array['value'] ," ".$options_array['value'], ['class' => 'radio_label'] );
        $display .= '<br>';
      }

      $display .= '</div>';
    }
    //Form hidden
    elseif($task['type'] == 'hidden')
    {
      $display .= Form::$task['type']($task['dbName'], $task['value'],['id' => $task['dbName']]);
    }
    //Form select
    elseif($task['type'] == 'select')
    {
      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= '<div class="form-group">';

      if(isset($selected_values) && $selected_values != '')
      {
        $display .= '<select class="form-control" id="'.$task['dbName'].'" name="'.$task['dbName'].'">';

        //$display .= '<option value="">'.$task['title'].'</option>';

        foreach($task['arrayOfData'] as $inner_key => $options_array)
        {
          $selected = "";
          if(!empty($selected_values['input_value']))
          {
            if($options_array['key'] == $selected_values['input_value'] && $selected_values['input_value'] != '')
              $selected = "selected";
          }
          elseif(!empty(old($task['dbName'])))
          {
            $selected = "selected";
          }

          $display .= '<option '. $selected.' value="'. $options_array['key'] .'">'. $options_array['value'].'</option>';
        }
        $display .= '</select>';
      }
      else
      {
        $display .= '<select class="form-control" id="'.$task['dbName'].'" name="'.$task['dbName'].'">';

        if (isset($task['defaultOption']) && $task['defaultOption'] != '')
        {
          $display .= '<option value="">'.$task['defaultOption'].'</option>';
        }
        else
        {
          $display .= '<option value="">'.$task['title'].'</option>';
        }

        foreach($task['arrayOfData'] as $inner_key => $options_array)
        {
          $selected = "";
          if(!empty($data[$task['dbName']]))
          {
            if($options_array['key'] == $data[$task['dbName']] && $data[$task['dbName']] != '')
              $selected = "selected";
          }
          elseif(!empty(old($task['dbName'])))
          {
            $selected = "selected";
          }

          $display .= '<option '. $selected .' value="'. $options_array['key'] .'">'. $options_array['value'] .'</option>';
        }

        $display .= '</select>';
      }

      $display .= '</div>';
    }
  }//End for each


  // Form Input Submit
  $display .= '<div class="form-group">';
  $display .= Form::submit($submitButtonText,['class' => 'btn btn-primary form-control','id'=>'submit_btn']);
  $display .= '</div>';

  return $display;
}

function create_custom_form($header_array,$body_array ='',$selected_values ='')
{
  $display = '';
  foreach ($header_array as $task)
  {
    // Add id to input
    if (isset($task['id']))
    {
      $id = $task['id'];
    }
    else
    {
      $id = $task['dbName'];
    }
    //Form Input for Text, Textarea and Email
    if($task['type'] == 'text' || $task['type'] == 'textarea' || $task['type'] == 'email' )
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= Form::$task['type']($task['dbName'],null,['class' => 'form-control', 'data-id' => $task['dbName'], 'id' => $id]);

      $display .= '</div>';
    }
    //Form Input for Date
    elseif($task['type'] == 'date')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      if(empty($data[$task['dbName']]))
      {
        if (isset($task['format']) && $task['format'] == 'dateTime')
        {
          $display .= '<div class="input-group date date_time_picker">';
          $display .= Form::input('text',$task['dbName'],$task['defaultOption'],['class' => 'form-control', 'id' => $id]);
          $display .= '<span class="input-group-addon">
                  <span class="glyphicon glyphicon-calendar"></span>
              </span>
          </div>';
        }
        else
        {
          $display .= Form::input($task['type'],$task['dbName'],Carbon\Carbon::now()->format('Y-d-m'),['class' => 'form-control', 'id' => $id]);
        }
      }
      else
      {
        if(isset($task['format']) && $task['format'] == 'dateTime')
        {
          $display .= Form::input('text',$task['dbName'],Carbon\Carbon::now()->format('Y-d-m H:i:s'),['class' => 'form-control', 'id' => $id]);
        }
        else
        {
          $display .= Form::input($task['type'],$task['dbName'],Carbon\Carbon::now()->format('Y-d-m'),['class' => 'form-control', 'id' => $id]);
        }
      }
      $display .= '</div>';
    }
    //Form Input for password
    elseif($task['type'] == 'password')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= Form::$task['type']($task['dbName'],['class' => 'form-control', 'id' => $id]);

      $display .= '</div>';
    }
    //Form Checkbox
    elseif($task['type'] == 'checkbox')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= Form::$task['type']($task['dbName'],$task['value'],['class' => 'form-control', 'id' => $id]);

      $display .= '</div>';
    }
    //Form Radio
    elseif($task['type'] == 'radio')
    {
      $display .= '<div class="form-group">';

      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';
      $display .= '<br>';
      foreach($task['arrayOfData'] as $inner_key => $options_array)
      {
        $checked = false;
        if(!empty($selected_values['input_value']))
        {
          if($options_array['key'] == $selected_values['input_value'] && $selected_values['input_value'] != '')
            $checked = true;
        }
        elseif(!empty(old($task['dbName'])))
        {
          $checked = true;
        }
        elseif (isset($options_array['checked']) && $options_array['checked'] == 1)
        {
          $checked = true;
        }

        $display .= Form::radio($task['dbName'], $options_array['key'] , $checked, ['class' => $task['dbName'], 'id' => $id]);
        $display .= Form::label($options_array['value'] ," ".$options_array['value'], ['class' => 'radio_label'] );
        $display .= '<br>';
      }

      $display .= '</div>';
    }
    //Form hidden
    elseif($task['type'] == 'hidden')
    {
      $display .= Form::$task['type']($task['dbName'], $task['value'],['id' => $id]);
    }
    //Form select
    elseif($task['type'] == 'select')
    {
      $display .= Form::label($task['dbName'],$task['title'].' : ');
      if($task['message'] != '')
        $display .= '<code>'. $task['message'] .'</code>';

      $display .= '<div class="form-group">';

      if(isset($selected_values) && $selected_values != '')
      {
        $display .= '<select class="form-control '.$task['dbName'].'" id="'.$id.'" name="'.$task['dbName'].'">';

        //$display .= '<option value="">'.$task['title'].'</option>';

        foreach($task['arrayOfData'] as $inner_key => $options_array)
        {
          $selected = "";
          if(!empty($selected_values['input_value']))
          {
            if($options_array['key'] == $selected_values['input_value'] && $selected_values['input_value'] != '')
              $selected = "selected";
          }
          elseif(!empty(old($task['dbName'])))
          {
            $selected = "selected";
          }

          $display .= '<option '. $selected.' value="'. $options_array['key'] .'">'. $options_array['value'].'</option>';
        }
        $display .= '</select>';
      }
      else
      {
        $display .= '<select class="form-control '.$task['dbName'].'" id="'.$id.'" name="'.$task['dbName'].'">';

        if (isset($task['defaultOption']) && $task['defaultOption'] != '')
        {
          $display .= '<option value="">'.$task['defaultOption'].'</option>';
        }
        else
        {
          $display .= '<option value="">'.$task['title'].'</option>';
        }

        foreach($task['arrayOfData'] as $inner_key => $options_array)
        {
          $selected = "";
          if(!empty($data[$task['dbName']]))
          {
            if($options_array['key'] == $data[$task['dbName']] && $data[$task['dbName']] != '')
              $selected = "selected";
          }
          elseif(!empty(old($task['dbName'])))
          {
            $selected = "selected";
          }

          $display .= '<option '. $selected .' value="'. $options_array['key'] .'">'. $options_array['value'] .'</option>';
        }

        $display .= '</select>';
      }

      $display .= '</div>';
    }
  }//End for each

  return $display;
}

function create_custom_form_submit_button($title,$id)
{
  $display = '';
  // Form Input Submit
  $display .= '<div class="form-group">';
  $display .= Form::submit($title,['class' => 'btn btn-primary form-control','id'=>$id]);
  $display .= '</div>';

  return $display;
}

/**
 * Multi-array search
 *
 * @param array $array
 * @param array $search
 * @return array
 */
function multi_array_search($array, $search)
{

  // Create the result array
  $result = array();

  // Iterate over each array element
  foreach ($array as $key => $value)
  {

    // Iterate over each search condition
    foreach ($search as $k => $v)
    {

      // If the array element does not meet the search condition then continue to the next element
      if (!isset($value[$k]) || $value[$k] != $v)
      {
        continue 2;
      }

    }

    // Add the array element's key to the result array
    $result[] = $key;

  }

  // Return the result array
  return $result;

}