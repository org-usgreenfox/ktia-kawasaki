@extends('layouts.appMap')

@section('scriptA')
    return new Promise((resolve, reject) => {
        if (navigator.geolocation) {
            // 現在地を取得
            navigator.geolocation.getCurrentPosition(
                // 取得成功した場合
                function(position) {
                    // 緯度・経度を変数に格納
                    latLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
                    // マップオプションを変数に格納
                    const mapOptions = {
                        zoom: 12, // 拡大倍率
                        center: latLng // 緯度・経度
                    };
                    // マップオブジェクト作成
                    const map = new google.maps.Map(
                        target, // マップを表示する要素
                        mapOptions // マップオプション
                    );
                    //　マップに現在地マーカーを表示する
                    marker = new google.maps.Marker({
                        map: map, // 対象の地図オブジェクト
                        position: latLng, // 緯度・経度
                        icon: "/img/mapPin.png",
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
            ); //getCurrentPosition
        } else {
            alert("この端末では位置情報が取得できません。");
        }
    }); // return new Promise ((resolve, reject) => { ... });
@endsection('scriptA')