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
                        <div class="container p-0 my-name-image">
                            @if(!empty($user_data['user']->image))
                            <img class="card-img-top" src="{{ '/storage/' . $user_data['user']->image }} " alt="photo">
                            @else
                            <div class="alternate-img">{{ $user_data['user']->name }}</div>
                            @endif
                            <div class="p-2 bd-highlight my-name">{{ $user_data['user']->name }}<i class="far fa-edit ml-2"></i></div>
                        </div>
                        @if ($user_data['followed'] == false && Auth::user()->id != $user_data['user']->id)
                        <div class="p-2 bd-highlight"><a href="{{ route('user.follow', ['user' => $user_data['user']]) }}">フォローする</a></div>
                        @endif
                        @if ($user_data['followed'] == true && Auth::user()->id != $user_data['user']->id)
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