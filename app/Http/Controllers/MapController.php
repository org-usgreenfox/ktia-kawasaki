<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Post;


class MapController extends Controller
{
    public function mapIndex(Request $request)
    {
        $posts = DB::table('posts')
            ->select('id','store_name','address')
            ->get();
        return view('map.index',compact('posts'));
    }

    public function mapShow($id)
    {
        $post = Post::find($id);
        dd($post);
        return view('map.show',compact('post'));
    }
}
