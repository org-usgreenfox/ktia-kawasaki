@extends('layouts.app')

@section('content')
<div id="target" style="width: 550px; height: 550px;"></div>
@endsection

@section('script')
<script defer>
    function initMap() {
        'use strict';

        var target = document.getElementById('target');
        var position = {
            lat: 34.6524992,
            lng: 135.5063058
        }; //tutenkaku
        var map;

        function createCurrentMap() {
            return new Promise((resolve, reject) => {
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
                            //　マップにマーカーを表示する
                            var marker = new google.maps.Marker({
                                map: map, // 対象の地図オブジェクト
                                position: mapLatLng // 緯度・経度
                            });
                            resolve(map);
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
                    );
                    // Geolocation APIに対応していない
                } else {
                    alert("この端末では位置情報が取得できません");
                    var map = new google.maps.Map(target, { //位置情報が取得できない場合は通天閣を中心にmap生成
                        center: position,
                        disableDefaultUI: true,
                        zoomControl: true,
                        zoom: 6
                    });
                }

            })
        }

        const markers = @json($posts);
        var geocoder = new google.maps.Geocoder();

        function createStoreMarker(map) {
            for (var i in markers) {
                geocoder.geocode( //第１引数：住所（address）、第２引数：コールバック関数
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
                        console.log(map);
                        var marker = new google.maps.Marker({ //マーカーを作成
                            position: position,
                            map: map,
                        });
                    } //function(results, status)
                ); //geocoder
            }
        }

        createCurrentMap().then((m) => createStoreMarker(m));

    }
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" async defer></script>
@endsection