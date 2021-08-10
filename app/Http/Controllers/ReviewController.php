<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Review;
use App\Models\Post;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\PostController;

class ReviewController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($id)
    {
        return view('review.create', compact('id'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $review = new Review;

        $image = $request->file('image');
        // 画像がアップロードされていればstorageに保存
        // 実際にウェブサイトで画像を表示するにはpublicとstorageをリンクさせる必要がある
        // $ php artisan storage:link でpublic内にstorageのリンクを作ることができる
        if ($request->hasFile('image')) {
            $path = \Storage::put('/public', $image);
            $path = explode('/', $path);
        } else {
            $path = null;
        }

        $review->title = $request->input('title');
        $review->comment = $request->input('comment');
        $review->image = $path[1];
        $review->user_id = Auth::id();
        $review->post_id = $request->post_id;
       

        $review->save();

        $post = new Post;
        $show_post = $post->showPost($request->post_id);
        return view('post.show',compact('show_post'));
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
