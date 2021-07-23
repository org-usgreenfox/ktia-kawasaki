<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\PostForm;

class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = DB::table('posts')
            ->select('id','store_name','store_url','sns_url')
            ->get();

        return view('post.index', compact('posts'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('post.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostForm $request)
    {
        $post = new Post;
        
        // preg_match_allを使用して#タグのついた文字列を取得している
        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->comment, $match);
        $tags = [];
        // $matchの中でも#が付いていない方を使用する(配列番号で言うと1)
        foreach($match[1] as $tag) {
            // firstOrCreateで重複を防ぎながらタグを作成している。
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags, $record);
        }

        $tags_id = [];
        foreach($tags as $tag) {
            array_push($tags_id, $tag->id);
        }
        // dd($tags_id);


        //$new_post->content = $request->content;
        //$new_post->save();
        //タグはpostがsaveされた後にattachするように。
        //$new_post->tags()->attach($tags_id);


        $post->store_name = $request->input('store_name');
        $post->address = $request->input('address');
        $post->store_url = $request->input('store_url');
        $post->sns_url = $request->input('sns_url');
        $post->comment = $request->input('comment');

        $post->save();
        $post->tags()->attach($tags_id);
        return redirect('post');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $post = Post::find($id);
        
        $tag_collection = $post->tags;

        $tags = [];
        foreach($tag_collection as $tag){
            $tag_name = $tag->name;
            array_push($tags, $tag_name);
        }

        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $post->comment, $match);
        $rev_comment = $post->comment;

        foreach($match[0] as $str){
            $rev_comment = str_replace($str, '', $rev_comment);
        }

        return view('post.show',compact('post', 'tags','rev_comment'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $post = Post::find($id);

        return view('post.edit',compact('post'));
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
        $post = Post::find($id);

        preg_match_all('/#([a-zA-z0-9０-９ぁ-んァ-ヶー一-龠]+)/u', $request->comment, $match);
        
        $tags = [];
        foreach($match[1] as $tag){
            $record = Tag::firstOrCreate(['name' => $tag]);
            array_push($tags,$record);
        }

        $tags_id = [];
        foreach($tags as $tag){
            array_push($tags_id, $tag->id);
        }

        $post->tags()->sync($tags_id);

        $post->store_name = $request->input('store_name');
        $post->address = $request->input('address');
        $post->store_url = $request->input('store_url');
        $post->sns_url = $request->input('sns_url');
        $post->comment = $request->input('comment');

        $post->save();
        return redirect('post');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $store = Post::find($id);
        $store->delete();

        return redirect('post');

    }
}
