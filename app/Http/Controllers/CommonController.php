<?php

namespace App\Http\Controllers;

use DB;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;

class CommonController extends Controller
{
    public function toggleActive(Request $request)
    {
    	$id = $request['id'];
    	$this_table_pk = $request['pk'];
		$this_table_name = $request['table'];
		$column_required_to_toggle = $request['col'];

		// Check if the value is NULL
		$check_if_null_value = DB::table($this_table_name)->where($this_table_pk,$id)->first();

		if(empty($check_if_null_value->$column_required_to_toggle))
		{
			//set selected row to 1
			DB::table($this_table_name)->where($this_table_pk, $id)->update([$column_required_to_toggle => 1]);
		}
		else
		{
			//get selected row to update
			DB::statement('update '.$this_table_name.'  set '.$column_required_to_toggle.'  = NOT  '.$column_required_to_toggle.'  where '.$this_table_pk.'  = '.$id.' ');
		}

		//get query after finishing
		$display = DB::table($this_table_name)->where($this_table_pk,$id)->pluck($column_required_to_toggle);
		$array_of_results['returned_array'] = $display;
		$array_of_results['response'] = true;

		return json_encode($array_of_results);
    }

	public function uploadImage(Request $request,$dbTableName,$imageColumn,$id,$path)
	{
		if ($request->hasFile($imageColumn))
		{
			// append timestamp to image name
			$file_name = time().'_'.$request->$imageColumn->getClientOriginalName();
			// move image to folder path
			$request->$imageColumn->move(public_path($path), $file_name);
			// save image
			return DB::table($dbTableName)->where('id', $id)->update([$imageColumn => $file_name]);
		}
	}

	public function updateImage(Request $request,$dbTableName,$imageColumn,$id,$path)
	{
		if ($request->hasFile($imageColumn))
		{
			// append timestamp to image name
			$file_name = time().'_'.$request->$imageColumn->getClientOriginalName();
			// move image to folder path
			$request->$imageColumn->move(public_path($path), $file_name);
			// get item data
			$object = DB::table($dbTableName)->where('id', $id)->first();
			// delete old image file
			if ($object->$imageColumn)
			{
				\File::delete(public_path('uploads/profiles/').$object->$imageColumn);
			}
			// save new image
			return DB::table($dbTableName)->where('id', $id)->update([$imageColumn => $file_name]);
		}
	}
}
