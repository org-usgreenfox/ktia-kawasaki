@extends('layouts.app')

@section('content')
<div class="container" id="target" style="width: 750px; height: 550px;"></div>
@endsection

@section('script')
<script defer>
     function initMap() {
      'use strict';
      var map;
      var target = document.getElementById('target');
      const post = @json($post);
      var centerGeocoder = new google.maps.Geocoder();
      var latLng = [];
      var marker = [];
      var infoWindow = [];
      centerGeocoder.geocode(
        {
          address: post['address']
        },
        function(results, status) {
            if (status == google.maps.GeocoderStatus.OK && results[0].geometry) {
            latLng = results[0].geometry.location;
            marker = new google.maps.Marker({
                position: latLng,
                map: map,
            });
            var mapOptions = {
                zoom: 14, // 拡大倍率
                center: latLng // 緯度・経度
            };
            // マップオブジェクト作成
            map = new google.maps.Map(
                target, // マップを表示する要素
                mapOptions // マップオプション
            );
        
            } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                alert("住所が見つかりませんでした。");
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
        } // function(results, status)
      ); // geocode
        // 店舗リストのマーカーを取得、表示する
        @foreach($posts as $post)
        var markers = @json($post);
        var geocoder = new google.maps.Geocoder();
        var infoWindow = [];
            (function () {　//即時関数　これがないとinfoWindowがうまく表示できない
            geocoder.geocode(
                {
                    address: markers['address']
                },
                function(results, status) {
                    if (status == google.maps.GeocoderStatus.OK && results[0].geometry) {
                        latLng = results[0].geometry.location;
                        marker = new google.maps.Marker({
                            position: latLng,
                            map: map,
                        });

                        var markerLink = '<a href="{{ route('post.show',['post' => $post->id]) }}">{{$post->store_name}}</a>';
                        addListenerPoint(
                            marker,
                            markerLink
                            );

                    } else if (status == google.maps.GeocoderStatus.ZERO_RESULTS) {
                        alert("住所が見つかりませんでした。");
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
            ); //geocoder
            }) ();
        @endforeach
        function addListenerPoint(m_marker,m_content){
            google.maps.event.addListener(m_marker, 'click', function(event) {
                var infoWindow = new google.maps.InfoWindow({
                    content: m_content
                });
                infoWindow.open(map, m_marker);
            });
        }
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" async defer></script>
@endsection