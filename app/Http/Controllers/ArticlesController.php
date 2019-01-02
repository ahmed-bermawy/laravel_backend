<?php

namespace App\Http\Controllers;

use DB;
use App\Models\Articles;
use App\Models\ArticleTranslation;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redirect;
use App\Http\Controllers\Controller;

class ArticlesController extends Controller
{
    private $create;
    private $view;
    private $delete;
    private $edit;
    private $path;
    private $image_path;
    private $page_title;
    private $table_name;
    private $table_pk;
    private $table_model;
    private $table_column;
    private $inputs_validation;
    private $inputs_validation_messages;

    public function __construct()
    {
        $this->create = true;
        $this->view = true;
        $this->delete = true;
        $this->edit = true;

        $this->path = 'backend/articles/';
        $this->image_path = 'uploads/articles/';
        $this->page_title = 'Articles';
        $this->table_model = new Articles();
        $this->table_name = $this->table_model->TableName();
        $this->table_pk = $this->table_model->TablePK();
        $this->inputs_validation = ['title' =>'required|min:3','image' => 'image|mimes:jpeg,png,jpg|max:1024'];
        $this->inputs_validation_messages = ['image.mimes' =>'Allowed Extensions:jpeg,png,jpg', 'image.max' => 'Max Size 1MB' ];

        $this->table_column = [
            [
                'dbName' => 'title',
                'title' => 'Title',
                'type' => 'text',
                'canView' => true,
                'message' => 'Required',
            ],
            [
                'dbName' => 'author',
                'title' => 'Author',
                'type' => 'text',
                'canView' => true,
                'message' => '',
            ],
            [
                'dbName' => 'short_description',
                'title' => 'Short Description',
                'type' => 'textarea',
                'canView' => true,
                'canEdit' => true,
                'message' => '',
            ],
            [
                'dbName' => 'long_description',
                'title' => 'Long Description',
                'type' => 'editor',
                'canView' => true,
                'canEdit' => true,
                'message' => '',
            ],
            [
                'dbName' => 'published_at',
                'title' => 'published Date',
                'type' => 'date',
                'canView' => true,
                'canEdit' => true,
                'message' => '',
            ],
            [
                'dbName' => 'image',
                'title' => 'Image',
                'type' => 'image',
                'canView' => true,
                'canEdit' => true,
                'file_path' => $this->image_path,
                'message' => 'Allowed Extensions:jpeg,png,jpg - Max Size 1MB',
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
        $display['create'] = $this->create;
        $display['delete'] = $this->delete;
        $display['edit'] = $this->edit;
        $display['view'] = $this->view;
        $display['message'] = session('message');
        //Search on database
        $keyword = $request->input('q');
        if ($keyword)
        {
            $display['array'] = $this->table_model->SearchByKeyword($keyword)->orderBy($this->table_pk, 'desc')->get();
            $display['total_result'] = count($display['array']);
        }
        else
        {
            $display['array'] = DB::table($this->table_name)->orderBy($this->table_pk, 'desc')->paginate(20);
            $display['total_result'] = DB::table($this->table_name)->orderBy($this->table_pk, 'desc')->count();
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
        $article = $this->table_model->create($request->all());

        $common = New CommonController();
        $common->uploadImage($request,$this->table_name,'image',$article->id,$this->image_path);

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
        $display['path'] = $this->path;
        $display['page_name'] = $this->page_title;
        $display['parent_page'] = $this->page_title;
        $display['page_title'] = $this->page_title . ' | Details';
        $display['array'] = $article = Articles::where('id',$id)->first()->toArray();
        $display['array']['image'] = $this->image_path.$display['array']['image'];

        return view('template.backend.view')->with($display);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
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
        $data = $this->table_model->findOrFail($id);
        $this->validate($request,$this->inputs_validation,$this->inputs_validation_messages);
        $data->update($request->all());
        
        $common = New CommonController();
        $common->updateImage($request,$this->table_name,'image',$id,$this->image_path);

        return Redirect::to($this->path);
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
        if($data)
        {
            $data->delete();
            return json_encode(['msg' => 'Row Deleted', 'status' => 'success']);
        }
        else
        {
            return json_encode(['msg' => 'Failed Deleting Row', 'status' => 'failed']);
        }
    }
}
