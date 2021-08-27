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
                <div class="card-header d-flex justify-content-between">
                    @if (isset($search))
                    <i class="fas fa-search mr-1"></i>{{ $search }}
                    @else
                    {{ 'Hello!!' }}
                    @endif
                    <div class="dropdown">
                        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                            Sort
                        </button>
                        <ul class="dropdown-menu" aria-labelledby="dropdownMenuButton">
                            <li><a id="by-newest" class="dropdown-item" href="#">Newest</a></li>
                            <li><a id="by-oldest" class="dropdown-item" href="#">Oldest</a></li>                           
                            <li><a id="by-nearest" class="dropdown-item" href="#">Nearest</a></li>
                        </ul>
                    </div>
                </div>
                <div class="card-body p-1">
                    @if (session('status'))
                        <div class="alert alert-success" role="alert">
                            {{ session('status') }}
                        </div>
                    @endif
                    <div class="container p-0">
                        <div class="d-flex flex-row flex-wrap">
                        @foreach($posts as $post)
                        <div class="box p-2 w-33" id="store-article{{ $post['id'] }}">
                            <div class="card mb-2">
                                <!-- 実際にウェブサイトで画像を表示するにはpublicとstorageをリンクさせる必要がある
                                $ php artisan storage:link でpublic内にstorageのリンクを作ることができる -->
                                @if(!empty($post->image))
                                <img class="card-img-top" src="{{ '/storage/' . $post->image }} " alt="photo">
                                @endif
                                <div class="card-body px-2 pt-2 pb-0">
                                    <h5 class="card-title">{{ $post->store_name }}</h5>
                                    <p id="store{{ $post->id }}distance">---</p>
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
@section('script')

<script defer>
    <?php 
    $json_posts = json_encode( $posts , JSON_HEX_TAG | JSON_HEX_AMP | JSON_HEX_APOS | JSON_HEX_QUOT);
    ?>
'use strict';

const R = Math.PI / 180;


function distance(lat1, lng1, lat2, lng2) {
  lat1 *= R;
  lng1 *= R;
  lat2 *= R;
  lng2 *= R;
  return 6371 * Math.acos(Math.cos(lat1) * Math.cos(lat2) * Math.cos(lng2 - lng1) + Math.sin(lat1) * Math.sin(lat2));
}

function initMap() {
    const js_posts = JSON.parse('<?php echo $json_posts; ?>');
    const currentPosition = [];
    const nearest_sort_button = document.getElementById("by-nearest");
    if (navigator.geolocation) {
            // 現在地を取得
            navigator.geolocation.getCurrentPosition(
                // 取得成功した場合
                function(position) {
                    // 緯度・経度を変数に格納
                    const latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    currentPosition['lat'] = latLng.lat();
                    currentPosition['lng'] = latLng.lng();
                    
                },
                // 取得失敗した場合
                function(error) {
                    // エラーメッセージを表示
                    switch (error.code) {
                        case 1: // PERMISSION_DENIED
                            nearest_sort_button.remove()
                            alert("位置情報の利用が許可されていません");    
                            break;
                        case 2: // POSITION_UNAVAILABLE
                            nearest_sort_button.remove()
                            alert("現在位置が取得できませんでした");
                            break;
                        case 3: // TIMEOUT
                            nearest_sort_button.remove()
                            alert("タイムアウトになりました");
                            break;
                        default:
                            nearest_sort_button.remove()
                            alert("その他のエラー(エラーコード:" + error.code + ")");
                            break;
                    }
                }
            ); //getCurrentPosition
        } else {
            nearest_sort_button.remove()
            alert("この端末では位置情報が取得できません。");
        }


    js_posts.forEach(function(post){    
        const geocoder = new google.maps.Geocoder();
        geocoder.geocode(
            {
                'address' : post['address'],
                'language' : 'ja',
                'region' : 'jp'
            },
            function(results, status) {
                if (status == google.maps.GeocoderStatus.OK && results[0].geometry) {
                    const latLng = results[0].geometry.location;   
                    const storeLat = latLng.lat();
                    const storeLng = latLng.lng(); 
                    post['distanceToStore'] =  distance(currentPosition['lat'],currentPosition['lng'],storeLat,storeLng);
                    post['distanceToStore'] = Math.floor(post['distanceToStore'] * 10) / 10 ;
                    document.getElementById("store" + post['id'] + "distance").textContent = "現在地から" + post['distanceToStore'] + 'km'; 
                    console.log(post['distanceToStore']); 
                    if (isNaN(post['distanceToStore'])){
                        document.getElementById("store" + post['id'] + "distance").textContent = "---";
                    }  
                } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                    alert(post['name'] + "の住所が見つかりませんでした。");
                } else if (status == google.maps.GeocoderStatus.ERROR) {
                    alert("サーバ接続に失敗しました。");
                } else if (status == google.maps.GeocoderStatus.INVALID_REQUEST) {
                    alert("リクエストが無効でした。");
                } else if (status == google.maps.GeocoderStatus.OVER_QUERY_LIMIT) {
                    alert("リクエストの制限回数を超えました。");
                } else if (status == google.maps.GeocoderStatus.REQUEST_DENIED) {
                    alert("サービスが使えない状態でした。");
                } else if (status == google.maps.GeocoderStatus.UNKNOWN_ERROR) {
                    alert("原因不明のエラーが発生しました。");
                }
            } //function(results, status)
        )
    })

    const nearestButton = document.getElementById('by-nearest');
    const newestButton = document.getElementById('by-newest');
    const oldestButton = document.getElementById('by-oldest');
    
    nearestButton.addEventListener('click', event => {
        js_posts.forEach(function(post) {
            document.getElementById("store-article" + post['id']).style.order = post['distanceToStore'] * 10;
        })
    })

    newestButton.addEventListener('click', event => {
        js_posts.forEach(function(post) {
            document.getElementById("store-article" + post['id']).style.order = 0;
        })
        
    })
    
    oldestButton.addEventListener('click', event => {
        let i = js_posts.length;
        js_posts.forEach(function(post,) {
            document.getElementById("store-article" + post['id']).style.order = i;
            i--;
        })
        
        

    })
}
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" defer></script>
@endsection


