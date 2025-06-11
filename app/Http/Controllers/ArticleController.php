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
    public $baseFolder = 'public/article';

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
        if($request->file('image')){
            $upload = $this->upload($request->file('image'), $article->image);
            $article->image = $upload;
        }
        
        $article->author = $request->input('author');
        $article->description = $request->input('description');
        $article->content = $request->input('content');
        $article->is_deleted = 0;
        $article->save();

        // if($upload){
            return response()->json(["code" => 200, "message" => "Article successfully updated!"]);
        // }else{
        //     return response()->json(["code" => 400, "message" => "Article update trouble, please contact Administrator!"]);
        // }
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
        
        if($page != '0' && $limit != '0'){
            $article = Article::select('article.id', 'article.title', 'article.description', 'article.image', 'user.username as author', 'article.content', 'article.created_at')
                        ->join('user', 'user.id', '=', 'article.author')
                        ->where("article.is_deleted", "=", 0)
                        ->orderBy('article.id', 'DESC')
                        ->offset($start)
                        ->limit($limit)
                        ->get();
        }else{
            $article = Article::select('article.id', 'article.title')
                        ->where("article.is_deleted", "=", 0)
                        ->orderBy('article.id', 'DESC')
                        ->get();
        }

        foreach($article as $d){
            if(isset($d->image)){
                $d->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $d->image;
                $d->author = ucfirst($d->author);
                $temp = strval($d->created_at);
                $d->created_string = explode('T', $temp)[0];
            }
        }
        return response()->json(["status" => "success", "data" => $article]);
    }

    public function detail(Request $request, $id)
    {
        $article = Article::select('article.id', 'article.title', 'article.description', 'article.image', 'user.username as author', 'article.content', 'article.created_at')
                        ->join('user', 'user.id', '=', 'article.author')
                        ->where("article.id", "=", $id)
                        ->get();
        $article = $article[0];
        $article->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $article->image;
        $article->author = ucfirst($article->author);
        $temp = strval($article->created_at);
        $article->created_string = explode('T', $temp)[0];
        return response()->json(["status" => "success", "data" => $article]);
    }

    public function other(Request $request, $id)
    {
        $article = Article::select('article.id', 'article.title', 'article.description', 'article.image', 'user.username as author', 'article.content', 'article.created_at')
                        ->join('user', 'user.id', '=', 'article.author')
                        ->where("article.id", "!=", $id)
                        ->orderBy('article.id', 'DESC')
                        ->get();
        
        foreach($article as $d){
            $d->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $d->image;
            $d->author = ucfirst($d->author);
            $temp = strval($d->created_at);
            $d->created_string = explode('T', $temp)[0];
        }
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
