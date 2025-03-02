<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Article;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ArticleController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $baseFolder = 'article';

    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $article = new Article();
        $filename = time() . '.jpg';
        $article->title = $request->input('title');
        $article->image = $filename;
        $article->author = $request->input('author');
        $article->description = $request->input('description');
        $article->content = $request->input('content');
        $article->is_deleted = 0;
        $article->save();
        
        // upload
        $upload = $this->upload($request->file('image'), $filename);

        if($upload){
            return response()->json(["code" => 200, "message" => "Article successfully created!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Article upload trouble, please contact Administrator!"]);
        }
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        $article->title = $request->input('title');
        
        // upload
        $upload = $this->upload($request->file('image'), $article->image);
        
        $article->image = $upload;
        $article->author = $request->input('author');
        $article->description = $request->input('description');
        $article->content = $request->input('content');
        $article->is_deleted = 0;
        $article->save();

        if($upload){
            return response()->json(["code" => 200, "message" => "Article successfully updated!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Article update trouble, please contact Administrator!"]);
        }
    }

    public function delete(Request $request, $id)
    {
        $article = Article::find($id);
        
        $filename = $article->image;
        $path = getcwd() . '/' . $this->baseFolder;
        if (file_exists($path . '/' . $filename)) {
            unlink($path . '/' . $filename);
        }

        if($article->delete()){
            return response()->json(["code" => 200, "message" => "Article successfully deleted!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Article delete trouble, please contact Administrator!"]);
        }
    }

    public function list(Request $request, $page, $limit)
    {
        $start = $limit * ($page-1);
        $article = Article::select('id', 'title', 'description', 'image', 'author', 'content', 'created_at')
                        ->where("is_deleted", "=", 0)
                        ->offset($start)
                        ->limit($limit)
                        ->get();
        foreach($article as $d){
            $d->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $d->image;
        }
        return response()->json(["status" => "success", "data" => $article]);
    }

    public function detail(Request $request, $id)
    {
        $article = Article::find($id);
        // $article->delete();
        $article->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $article->image;
        return response()->json(["status" => "success", "data" => $article]);
    }

    public function upload($file, $filename){
        $path = getcwd() . '/' . $this->baseFolder;
        if (file_exists($path . '/' . $filename)) {
            unlink($path . '/' . $filename);
            $filename = time() . '.jpg';
        }
        if($file->move($path, $filename)){
            return $filename;
        }else{
            return 0;
        }
    }
}
