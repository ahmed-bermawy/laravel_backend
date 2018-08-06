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
    private $view_page;
    private $table_column;
    private $inputs_validation;

    public function __construct()
    {
        $this->create = true;
        $this->view = true;
        $this->delete = true;
        $this->edit = true;
        $this->view_page = true;

        $this->path = 'admin/articles';
        $this->image_path = 'uploads/articles/';
        $this->page_title = 'Articles';
        $this->table_model = new Articles();
        $this->table_name = $this->table_model->TableName();
        $this->table_pk = $this->table_model->TablePK();
        $this->inputs_validation = ['title'  =>'required|min:3'];

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
                'message' => 'Allowed Extinsion:jpeg,png,jpg,gif - Max Size 5MB',
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
        $display['view_page'] = $this->view_page;
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
        $this->validate($request,$this->inputs_validation);
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

        $display['article'] = $article = Articles::where('id',$id)->first()->toArray();
        $display['article_image'] = ArticleImage::select('path as image')->where('article_id',$id)->get()->toArray();
        $display['blueprint'] = Blueprint::select('path as blueprint_image')->where('ordernumber',$article['ordernumber'])->get()->toArray();
        $display['certification'] = Certification::select('name','description','translation_description_us','state','document')->where('article_id',$id)->orderBy('state')->get()->toArray();
        $display['download'] = Download::select('language','path','description','linktext','translation')->where('article_id',$id)->get()->toArray();
        $display['feature'] = Feature::select('name','value','translation_name_us','translation_value_us')->where('article_id',$id)->get()->toArray();
        $display['symbol'] = Symbol::select('image_path as symbol_image','subline','group_name','option_name','tooltip_headline','tooltip_headline_us','tooltip_text','tooltip_text_us','order')->where('article_id',$id)->orderBy('order')->get()->toArray();
        $display['related'] = Related::select('related_article_id','ordernumber')
            ->join('articles', 'related.article_id', '=', 'articles.id')
            ->where('article_id',$id)->get()->toArray();
        $display['category'] = RelCategoryArticle::select('category.*')
            ->join('category', 'rel_category_article.category_id', '=', 'category.id')
            ->where('article_id',$id)->first()->toArray();


        return view('template.backend.article.view')->with($display);
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
