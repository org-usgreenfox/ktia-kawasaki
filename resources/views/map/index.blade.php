@extends('layouts.app')

@section('content')
<div class="container" id="target" style="width: 550px; height: 550px;"></div>
@endsection

@section('script')
<script defer>
     function initMap() {
        'use strict';
        var map;
        var target = document.getElementById('target');
        
        if (navigator.geolocation) {
            // 現在地を取得
            navigator.geolocation.getCurrentPosition(
                // 取得成功した場合
                function(position) {
                    // 緯度・経度を変数に格納
                    var mapLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    // マップオプションを変数に格納
                    var mapOptions = {
                        zoom: 6, // 拡大倍率
                        center: mapLatLng // 緯度・経度
                    };
                    // マップオブジェクト作成
                    map = new google.maps.Map(
                        target, // マップを表示する要素
                        mapOptions // マップオプション
                    );
                    //　マップに現在地マーカーを表示する
                    var marker = new google.maps.Marker({
                        map: map, // 対象の地図オブジェクト
                        position: mapLatLng // 緯度・経度
                    });
                    // 店舗リストのマーカーを取得、表示する
                    const markers = @json($posts);
                    var geocoder = new google.maps.Geocoder();
                    for (var i in markers) {
                        geocoder.geocode(
                            {
                                address: markers[i]['address']
                            },
                            function(results, status) {
                                if (status == google.maps.GeocoderStatus.OK && results[0].geometry) {
                                    var lat = results[0].geometry.location.lat();
                                    var lng = results[0].geometry.location.lng();

                                    var position = {
                                        lat: lat,
                                        lng: lng
                                    }; //latに変数lat, lngに変数lngを代入

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

                                var marker = new google.maps.Marker({
                                    position: position,
                                    map: map,
                                });
                            } //function(results, status)
                        ); //geocoder
                    } //for
                },
                // 取得失敗した場合
                function(error) {
                    // エラーメッセージを表示
                    switch (error.code) {
                        case 1: // PERMISSION_DENIED
                            alert("位置情報の利用が許可されていません");    
                            break;
                        case 2: // POSITION_UNAVAILABLE
                            alert("現在位置が取得できませんでした");
                            break;
                        case 3: // TIMEOUT
                            alert("タイムアウトになりました");
                            break;
                        default:
                            alert("その他のエラー(エラーコード:" + error.code + ")");
                            break;
                    }
                }
            ); //getCurrentPosition
        // Geolocation APIに対応していない
        } else {
            alert("この端末では位置情報が取得できません");
            var position = {
            lat: 34.6524992,
            lng: 135.5063058
            };//通天閣
            var map = new google.maps.Map(target, {
                center: position,
                disableDefaultUI: true,
                zoomControl: true,
                zoom: 6
            });
        } 
    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" async defer></script>
@endsection