<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Validator;

class ApiValidateController extends Controller
{
    public function validateRequired($values)
    {
        foreach($values as $row)
        {
            if(!$row['value'])
            {
                return response()->json(['STATUS_CODE' => 422, 'STATUS_DESCRIPTION' => 'Parameter "'.$row["key"].'" is required'], 422);
            }
        }
    }

    public function validateImage($input, $rules)
    {
        // pass the input and rules into the validator
        $validator = Validator::make($input, $rules);
        $key = key($rules);
        // Check to see if validation fails or passes
        if ($validator->fails())
        {
            return response()->json(['STATUS_CODE' => 422, 'STATUS_DESCRIPTION' => $validator->errors()->getMessages()[$key][0]], 422);
        }
    }
}