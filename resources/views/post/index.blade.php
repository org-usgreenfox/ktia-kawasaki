@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Hello Beer!!</div>

                <div class="card-body">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif

                    @auth 
                    <a href="{{ route('post.create') }}">
                        <button type="button" class="btn btn-dark btn-block">create new Store</button>
                    </a>
                    @endauth
                    <a href="{{ route('map.index') }}" target="_blank">
                        <button type="button" class="btn btn-dark btn-block mt-1">map</button>
                    </a>
                </div>
                <div class="container">
                    <div class="row">
                        @foreach($posts as $post)
                        <div class="box p-2 col-4">
                            <div class="card">
                                <!-- 実際にウェブサイトで画像を表示するにはpublicとstorageをリンクさせる必要がある
                                $ php artisan storage:link でpublic内にstorageのリンクを作ることができる -->
                                @if(!empty($post->image))
                                <img src="{{ '/storage/' . $post->image }} " class="card-img-top" alt="photo">
                                @endif
                                <div class="card-body p-2">
                                    <h5 class="card-title font-weight-bold">{{ $post->store_name }}</h5>
                                    <div class="container px-1 font-weight-light modal-open">
                                        @if(!empty($post->comment))
                                        <p class="mb-0" style="font-size: 10px; height: 3rem; display: -webkit-box; -webkit-box-orient: vertical; -webkit-line-clamp: 3;">{{ $post->comment }}</p>
                                        @endif
                                    </div>
                                    <div class="container d-flex justify-content-end p-0 align-items-end mt-1">
                                        @if(!empty($post->store_url))
                                        <a href="{{ $post->store_url }}" class="text-secondary d-inline mr-1" target="_blank" style="line-height: 1;"><i class="fas fa-home fs-2"></i></a>
                                        @endif
                                        @if(!empty($post->sns_url))
                                        <a href="{{ $post->sns_url }}" class="text-secondary d-inline mr-1" target="_blank" style="line-height: 1;"><i class="fab fa-instagram fs-2"></i></a>
                                        @endif
                                        <a href="{{ route('post.show', ['post' => $post->id]) }}" class="btn btn-dark p-1" style="font-size: 1px;">more</a>
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
@endsection
