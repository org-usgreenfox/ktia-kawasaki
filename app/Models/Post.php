<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Review;
use Illuminate\Support\Facades\DB;

class Post extends Model
{
    use HasFactory;

    public function tags()
    {
        return $this->belongsToMany(Tag::class);
    }

    public function reviews() 
    {
        return $this->hasMany(Review::class);
    }

    public function showPost($id)
    {
        $post = Post::find($id);
        $reviews = Post::find($id)->reviews;
        
        foreach($reviews as $review) {
            // dd($review['user_id']);
            $review['user_name'] = DB::table('users')->where('id', $review->user_id)->select('name')->first()->name;
            $review['user_id'] = DB::table('users')->where('id', $review->user_id)->select('id')->first()->id;
        }
        
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
        
        
        $post_data = array(
            "post" => $post,
            "tags" => $tags,
            "rev_comment" => $rev_comment,
            "reviews" => $reviews,
        );

            return $post_data;

    }

}
