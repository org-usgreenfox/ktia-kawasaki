<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // フォロワー→フォロー
    public function followUsers()
    {
        return $this->belongsToMany('App\Models\User', 'follow_users', 'followed_user_id', 'following_user_id');
    }

    // フォロー→フォロワー
    public function follows()
    {
        return $this->belongsToMany('App\Models\User', 'follow_users', 'following_user_id', 'followed_user_id');
    }

    public function showUser($id)
    {
        
        $user = User::find($id);
        $followers = DB::table('follow_users')->where('followed_user_id', $id)->get();
        $follows = DB::table('follow_users')->where('following_user_id', $id)->get();
        $follower_count = count($followers);
        $follow_count = count($follows);
        
        $followed = false;
        foreach ($followers as $follower) 
        {
            
            if ($follower->following_user_id == Auth::id())
            {
                $followed = true;
            }
        }
        $user_data = array(
            "user" => $user,
            "followed" => $followed,
            "follower_count" => $follower_count,
            "follow_count" => $follow_count,
        );
        return $user_data;
    }
}
