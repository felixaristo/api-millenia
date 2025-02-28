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
    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $article = new Article();

        $article->title = $request->input('title');
        $article->image = $request->input('image');
        $article->author = $request->input('author');
        $article->description = $request->input('description');
        $article->content = $request->input('content');
        $article->is_deleted = 0;

        $article->save();

        return response()->json("created");
    }

    public function update(Request $request, $id)
    {
        $article = Article::find($id);

        $article->title = $request->input('title');
        $article->image = $request->input('image');
        $article->author = $request->input('author');
        $article->description = $request->input('description');
        $article->content = $request->input('content');

        $article->save();

        return response()->json(["status" => "updated", "data" => $article]);
    }

    public function delete(Request $request, $id)
    {
        $article = Article::find($id);
        $article->delete();

        return response()->json(["status" => "deleted"]);
    }

    public function list(Request $request, $page, $limit)
    {
        $start = $limit * ($page-1);
        $article = Article::select('title', 'description')
                        ->where("is_deleted", "=", 0)
                        ->offset($start)
                        ->limit($limit)
                        ->get();
        return response()->json(["status" => "success", "data" => $article]);
    }

    public function detail(Request $request, $id)
    {
        $article = Article::find($id);
        // $article->delete();
        return response()->json(["status" => "success", "data" => $article]);
    }
}
