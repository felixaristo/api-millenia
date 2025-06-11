<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Banner;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class BannerController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public $baseFolder = 'banner';

    public function __construct()
    {
        //
    }

    public function create(Request $request)
    {
        $banner = new Banner();
        $filename = time() . '.jpg';
        $banner->image = $filename;
        $banner->article = $request->input('article');
        $banner->order = $request->input('order');
        $banner->save();
        
        // upload
        $upload = $this->upload($request->file('image'), $filename);

        if($upload){
            return response()->json(["code" => 200, "message" => "Banner successfully created!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Banner upload trouble, please contact Administrator!"]);
        }
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        // upload
        $upload = $this->upload($request->file('image'), $banner->image);
        
        $banner->image = $upload;
        $banner->article = $request->input('article');
        $banner->order = $request->input('order');
        $banner->save();

        if($upload){
            return response()->json(["code" => 200, "message" => "Banner successfully updated!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Banner update trouble, please contact Administrator!"]);
        }
    }

    public function delete(Request $request, $id)
    {
        $banner = Banner::find($id);
        
        $filename = $banner->image;
        $path = getcwd() . '/' . $this->baseFolder;
        if (file_exists($path . '/' . $filename)) {
            unlink($path . '/' . $filename);
        }

        if($banner->delete()){
            return response()->json(["code" => 200, "message" => "Banner successfully deleted!"]);
        }else{
            return response()->json(["code" => 400, "message" => "Banner delete trouble, please contact Administrator!"]);
        }
    }

    public function list(Request $request, $page, $limit)
    {
        $start = $limit * ($page-1);
        
                        
        if($page != '0' && $limit != '0'){
            $banner = Banner::select('banner.id', 'banner.image', 'banner.article', 'article.title')
                    ->join('article', 'article.id', '=', 'banner.article')
                    ->offset($start)
                    ->limit($limit)
                    ->orderBy('order', 'ASC')
                    ->get();
        }else{
            $banner = Banner::select('id', 'image', 'article')
                    ->orderBy('order', 'ASC')
                    ->get();
        }
                        
        foreach($banner as $d){
            $d->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $d->image;
        }
        return response()->json(["status" => "success", "data" => $banner]);
    }

    public function detail(Request $request, $id)
    {
        $banner = Banner::find($id);
        // $banner->delete();
        $banner->image = str_replace('index.php', '', url()) . $this->baseFolder . '/' . $banner->image;
        return response()->json(["status" => "success", "data" => $banner]);
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
