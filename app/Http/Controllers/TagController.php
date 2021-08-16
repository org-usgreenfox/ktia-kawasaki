<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\PostTag;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;

class TagController extends Controller
{
    public function tagIndex($tag)
    {   
        // if(!isset($request->tag)){
        //     return redirect('post');
        // }
        // $tag = $request->input('tag');
        
        $field = Tag::query()
            ->where('name', $tag)
            ->get();
        
        $tag_id = $field->pluck('id');
        $ids = DB::table('post_tag')
            ->where('tag_id',$tag_id)
            ->get();

        //post_tag_tableからpost_idを配列に取得
        $post_ids = [];
        Foreach($ids as $id){
            $post_id = $id->post_id;
            array_push($post_ids, $post_id);    
        }

        //配列:$post_idsを使ってposts_tableから投稿を配列:$postsに取得
        $posts = Post::query()
            ->with('tags')
            ->whereIn('id', $post_ids)
            ->get();

        $search = '#'.$tag;
        
        return view('post.index', compact('posts','search'));
    }
}
