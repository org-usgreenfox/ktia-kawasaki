@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-4 col-sm-12">
            <div class="card mb-2">
                <div class="card-body">
                @auth 
                    <a href="{{ route('post.create') }}">
                        <button type="button" class="btn btn-dark btn-block">Post new Store</button>
                    </a>
                @else
                    <p>ログインしてお店をシェアしよう！</p>
                    <div class="row">
                    @if (Route::has('login'))
                        <div class="col-lg-5 text-center btn btn-light mx-2 mt-2">
                            <a class="nav-link" href="{{ route('login') }}">{{ __('Login') }}</a>
                        </div>
                    @endif

                    @if (Route::has('register'))
                        <div class="col-lg-5 text-center btn btn-light mx-2 mt-2">
                            <a class="nav-link" href="{{ route('register') }}">{{ __('Register') }}</a>
                        </div>
                    @endif
                    </div>
                @endauth
                </div>
            </div>

            <div class="card mb-2">
                <!-- <div class="card-header"></div> -->
                <div class="card-body">
                    <form method="POST" action="{{ route('post.search') }}" class="mb-3">
                        @csrf
                        <div class="row p-2">
                            <div class="form-group col-8 p-1 m-0">
                                <!-- <label>Search Word</label> -->
                                <input type="text" class="form-control" name="keyword" id="keyword" placeholder="keyword">
                            </div>
                            <div class="col-4 p-1 m-0">
                                <button type="submit" name="send" class="btn btn-dark btn-block">
                                    <i class="fas fa-search"></i>
                                </button>
                            </div>
                        </div>
                    </form>
                    <a href="{{ route('map.index') }}" target="_blank">
                        <button type="button" class="btn btn-dark btn-block p-1 mt-1"><i class="fas fa-map-marked-alt mr-2"></i>周辺のお店を探す</button>
                    </a>
                </div>
            </div>
        </div>
        <div class="col-md-8 col-sm-12">
            <div class="card">
                <div class="card-header">
                    @if (isset($search))
                    <i class="fas fa-search mr-1"></i>{{ $search }}
                    @else
                    {{ 'Hello!!' }}
                    @endif
                </div>
                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container">
                        <div class="row">
                        @foreach($posts as $post)
                        <div class="box p-2 col-4">
                            <div class="card mb-2">
                                <!-- 実際にウェブサイトで画像を表示するにはpublicとstorageをリンクさせる必要がある
                                $ php artisan storage:link でpublic内にstorageのリンクを作ることができる -->
                                @if(!empty($post->image))
                                <img class="card-img-top" src="{{ '/storage/' . $post->image }} " alt="photo">
                                @endif
                                <div class="card-body px-2 pt-2 pb-0">
                                    <h5 class="card-title">{{ $post->store_name }}</h5>
                                        @if(!empty($post->comment))
                                            @foreach($post->tags as $tag)
                                            <a class="small" href="{{ route('tag.index', ['tag' => $tag->name ]) }}">#{{ $tag->name }}</a>
                                            @endforeach
                                        @endif
                                    <div class="container d-flex justify-content-end align-items-center p-1 mt-2">
                                        @if(!empty($post->store_url))
                                        <a href="{{ $post->store_url }}" class="text-secondary d-inline mr-2" target="_blank" style="line-height: 1;"><i class="fas fa-home fs-2"></i></a>
                                        @endif
                                        @if(!empty($post->sns_url))
                                        <a href="{{ $post->sns_url }}" class="text-secondary d-inline mr-2" target="_blank" style="line-height: 1;"><i class="fab fa-instagram fs-2"></i></a>
                                        @endif
                                        <a href="{{ route('post.show', ['post' => $post->id]) }}" class="">more</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
