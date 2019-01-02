<?php

namespace App\Http\Controllers;

use DB;
use App\User;
use App\Models\Roles;
use App\Models\RoleUsers;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class AdminsController extends Controller
{
    private $path;
    private $page_title;
    private $table_name;
    private $table_pk;
    private $image_path;
    private $table_model;
    private $inputs_validation;
    private $inputs_edit_validation;
    private $inputs_validation_messages;
    private $table_column;

    public function __construct()
    {
        $this->path = 'backend/admins/';
        $this->image_path = 'uploads/profiles/';
        $this->page_title = 'Admin';
        $this->table_model = new User();
        $this->table_name = $this->table_model->TableName();
        $this->table_pk = $this->table_model->TablePK();
        //$this->user_role = roles();

        $this->roles_table_model = new Roles();
        $this->roles_table_name = $this->roles_table_model->TableName();
        $this->roles_table_pk = $this->roles_table_model->TablePK();

        $this->role_users_table_model = new RoleUsers();
        $this->role_users_table_name = $this->role_users_table_model->TableName();
        $this->role_users_table_pk = $this->role_users_table_model->TablePK();

        $roles_query = DB::select('select '.$this->roles_table_pk.' as "key", name as "value" from '.$this->roles_table_name.' order by '.$this->roles_table_pk);
        $roles_values = json_decode(json_encode($roles_query),true);

        $this->inputs_validation = ['first_name'=>'required|min:3','last_name'  =>'required|min:3','email' =>'required|email','password' =>'required','roles'=>'required','image' => 'image|mimes:jpeg,png,jpg|max:2048'];
        $this->inputs_edit_validation = ['first_name'=>'required|min:3','last_name'  =>'required|min:3','roles'=>'required','image' => 'image|mimes:jpeg,png,jpg|max:2048'];
        $this->inputs_validation_messages = ['image.mimes' =>'Allowed Extensions:jpeg,png,jpg', 'image.max' => 'Max Size 2MB' ];

        $this->table_column = [
            [
                'dbName' => 'first_name',
                'title' => 'First Name',
                'type' => 'text',
                'canView' => true,
                'message' => 'Required',
            ],
            [
                'dbName' => 'last_name',
                'title' => 'Last Name',
                'type' => 'text',
                'canView' => true,
                'message' => 'Required',
            ],
            [
                'dbName' => 'email',
                'title' => 'Email',
                'type' => 'text',
                'canView' => true,
                'canEdit' => false,
                'message' => 'Required',
            ],
            [
                'dbName' => 'password',
                'title' => 'Admin Password',
                'type' => 'password',
                'canView' => false,
                'canEdit' => false,
                'message' => 'Required',
            ],
            [
                'dbName' => 'roles',
                'title' => 'Roles',
                'type' => 'select',
                'canView' => false,
                //'canOrder' => false,
                'canSearch' => false,
                'message' => 'Required',
                'arrayOfData' => $roles_values,
            ],
            [
                'dbName' => 'image',
                'title' => 'Profile Image',
                'type' => 'image',
                'canView' => true,
                'canEdit' => true,
                'file_path' => 'uploads/profiles',
                'message' => 'Allowed Extinsion:jpeg,png,jpg,gif - Max Size 2MB',
            ],
            [
                'dbName' => 'id',
                'title' => 'Change Password',
                'type' => 'popup',
                'canView' => true,
                'message' => 'Change Password',
                'value' => 'email',
            ],

        ];
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $display['path'] = $this->path;
        $display['page_title'] = $this->page_title;
        $display['table_name'] = $this->table_name;
        $display['table_pk'] = $this->table_pk;
        $display['header'] = $this->table_column;
        $display['message'] = session('message');
        //Search on database
        $keyword = $request->input('q');
        if ($keyword)
        {
            $display['array'] = $this->table_model->SearchByKeyword($keyword)->orderBy($this->table_pk, 'desc')->get();
        }
        else
        {
            $display['array'] = $this->table_model->orderBy($this->table_pk, 'desc')->paginate(20);
            $display['total_result'] = $this->table_model->count();
        }

        return view('template.backend.index')->with($display);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(adminOnly() == false)
        {
            return Redirect::to('/');
        }

        $display['path'] = $this->path;
        $display['page_title'] = $this->page_title.' | Create';
        $display['page_name'] = $this->page_title;
        $display['table_name'] = $this->table_name;
        $display['tasks'] = $this->table_column;
        return view('template.backend.create')->with($display);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request,$this->inputs_validation,$this->inputs_validation_messages);

        $user = \Sentinel::findByCredentials(['email' => $request->email]);

        if ($user)
        {
            return Redirect::back()->withErrors(['Email Already Exist Please Try Another Email']);
        }

        $user = \Sentinel::registerAndActivate($request->all());
        $role_id = $request['roles'];
        $role = \Sentinel::findRoleById($role_id);
        $role->users()->attach($user);

        $common = New CommonController();
        $common->uploadImage($request,$this->table_name,'image',$user->id,$this->image_path);

        return Redirect::to($this->path);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        if(adminOnly() == false)
        {
            return Redirect::to('/');
        }

        // this for select from another
        // table the assign value
        // for select drop down menu
        $get_data = DB::table($this->role_users_table_name)->where($this->role_users_table_pk,$id)->first();
        if(!empty($get_data))
        {
            $value = $get_data->role_id;
        }
        else
        {
            $value = '';
        }

        $display['select_from_another_table'] = true;
        $display['selected_value'] = ['input_name'=>'roles','input_value'=>$value];

        $display['path'] = $this->path;
        $display['page_title'] = $this->page_title.' | Update';
        $display['table_pk'] = $this->table_pk;
        $display['page_name'] = $this->page_title;
        $display['table_name'] = $this->table_name;
        $display['tasks'] = $this->table_column;
        $display['data'] = $this->table_model->findOrFail($id);
        return view('template.backend.edit')->with($display);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request,$this->inputs_edit_validation,$this->inputs_validation_messages);
        $data = $this->table_model->findOrFail($id);

        $user = \Sentinel::findByCredentials(['email' => $request->email]);

        if ($user)
        {
            return Redirect::to($this->path)->with('message', 'Email Already Exist Please Try Another Email');
        }

        // $result = $request->all();
        // $new_password = bcrypt($result['password']);

        // $replacements = array('password'=> $new_password);
        // $new_array = array_replace($result, $replacements);

        //check if user have roles
        $check_user_roles = DB::table($this->role_users_table_name)->where($this->role_users_table_pk, $id)->first();
        if (empty($check_user_roles))
        {
            DB::table($this->role_users_table_name)->insert(['role_id' => $request['roles'], $this->role_users_table_pk=> $id]);
        }
        else
        {
            DB::table($this->role_users_table_name)->where($this->role_users_table_pk, $id)->update(['role_id' => $request['roles']]);
        }

        $data->update($request->all());

        $common = New CommonController();
        $common->updateImage($request,$this->table_name,'image',$id,$this->image_path);

        return Redirect::to($this->path);
    }

    /**
     * Chnage password for Admin
     * @param  Request $request [id, password]
     * @return [type]           [json array]
     */
    public function changePassword(Request $request)
    {
        $id = $request['id'];
        $password = $request['password'];

        $isFound = DB::table($this->table_name)->where('id', $id)->first();
        if($isFound)
        {
            $new_password = bcrypt($password);
            DB::table($this->table_name)->where('id', $id)->update(['password' => $new_password]);

            return json_encode(['msg' => 'Password Changed Successfully', 'status' => 'success']);
        }
        else
        {
            return json_encode(['msg' => 'Failed Changing Password', 'status' => 'failed']);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $data = $this->table_model->find($id);
        $check_user_roles = DB::table($this->role_users_table_name)->where($this->role_users_table_pk, $id)->first();

        if($data)
        {
            if ($data->image)
            {
                \File::delete(public_path('uploads/profiles/').$data->image);
            }
            $data->delete();

            if ($check_user_roles)
            {
                DB::table($this->role_users_table_name)->where($this->role_users_table_pk,$id)->delete();
            }
            return json_encode(['msg' => 'Row Deleted', 'status' => 'success']);
        }
        else
        {
            return json_encode(['msg' => 'Failed Deleting Row', 'status' => 'failed']);
        }
    }
}
