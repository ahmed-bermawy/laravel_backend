<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Models\Articles;
use App\Models\ArticleTranslation;
use App\Http\Controllers\ApiValidateController;

class ApiController extends Controller
{
    private $path;
    private $validator;
    private $articles_model;

    public function __construct()
    {
        $this->articles_model = new Articles();
        // Init the validator class
        $this->validator = new ApiValidateController();
    }

    public function getArticle(Request $request)
    {
        $country = $request->input('country');
        $language = $request->input('language');
        $articleId = $request->input('articleID');

        //Validate Required Inputs
        $inputs = [
            ["key" => "language", "value" => $language],
            ["key" => "articleID", "value" => $articleId],
        ];

        // return error for required inputs are missing
        $error_required = $this->validator->validateRequired($inputs);
        if ($error_required) return $error_required;

        $article = $this->articles_model->getArticle($articleId,$language,$country);

        return response()->json(['status_code' => 200, 'article' => $article], 200);

    }

}
