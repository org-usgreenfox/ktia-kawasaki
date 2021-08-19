@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Bar info</div>

                <div class="card-body">
                    @if (session('status'))
                    <div class="alert alert-success" role="alert">
                        {{ session('status') }}
                    </div>
                    @endif

                    <div class="d-flex flex-column bd-highlight mb-3">
                        <div class="p-2 bd-highlight">{{ $user_data['user']->name }}</div>
                        @if ($user_data['followed'] == false && $auth->id != $user_data['user']->id)
                        <div class="p-2 bd-highlight"><a href="{{ route('user.follow', ['user' => $user_data['user']]) }}">フォローする</a></div>
                        @endif
                        @if ($user_data['followed'] == true && $auth->id != $user_data['user']->id)
                        <div class="p-2 bd-highlight"><a href="{{ route('user.unfollow', ['user' => $user_data['user']]) }}">フォロー解除</a></div>
                        @endif
                        @if ($user_data['follow_count'] != 0)
                        <div class="p-2 bd-highlight"><a href="{{ route('user.following', ['user' => $user_data['user']->id]) }}">フォロー {{ $user_data['follow_count'] }} 人</a></div>
                        @else
                        <div class="p-2 bd-highlight">フォロー {{ $user_data['follow_count'] }} 人</div>
                        @endif
                        @if ($user_data['follower_count'] != 0)
                        <div class="p-2 bd-highlight"><a href="{{ route('user.followed', ['user' => $user_data['user']->id]) }}">フォロワー {{ $user_data['follower_count'] }} 人</a> </div>
                        @else
                        <div class="p-2 bd-highlight">フォロワー {{ $user_data['follower_count'] }} 人</div>
                        @endif
                    </div>
                    


                   

                </div>
            </div>         
            
            
        </div>
    </div>
</div>
@endsection