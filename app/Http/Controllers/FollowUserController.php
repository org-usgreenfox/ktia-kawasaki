<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\FollowUser;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class FollowUserController extends Controller
{
    public function follow(User $user) {
        if(Auth::user()->id != $user->id){
            $follow = FollowUser::firstOrCreate([
                'following_user_id' => Auth::user()->id,
                'followed_user_id' => $user->id,
            ]);
            
            $followCount = count(FollowUser::where('followed_user_id', $user->id)->get());
        }

        $id = $user->id;
        $user = new User;
        $user_data = $user->showUser($id);
        $auth = Auth::user();
        
        return view('user.show',compact('user_data', 'auth'));
    }

    public function unfollow(User $user) {
        $follow = FollowUser::where('following_user_id', Auth::user()->id)->where('followed_user_id', $user->id)->first();
        if($follow)
        {
            $follow->delete();
        }
        $followCount = count(FollowUser::where('followed_user_id', $user->id)->get());

        $id = $user->id;
        $user = new User;
        $user_data = $user->showUser($id);
        $auth = Auth::user();
        
        return view('user.show',compact('user_data', 'auth'));
    }

    public function showFollowed(User $user) {
        $followed_ids = FollowUser::where('followed_user_id', $user->id)->get();
        $followed_users = [];
        foreach ($followed_ids as $followed_id){
            $user = User::find($followed_id['following_user_id']);
            array_push($followed_users, $user);
        }
        // dd($followed_users[0]['name']);
        return view('user.showFollowed',compact('followed_users'));
    }
    
    public function showFollowing(User $user) {
        $following_ids = FollowUser::where('following_user_id', $user->id)->get();
        $following_users = [];
        foreach ($following_ids as $following_id){
            $user = User::find($following_id['followed_user_id']);
            array_push($following_users, $user);
        }
        // dd($following_users[0]['name']);
        return view('user.showFollowing',compact('following_users'));
    }
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
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
