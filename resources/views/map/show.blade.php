@extends('layouts.appMap')

@section('scriptA')
    const post = @json($post);
    const centerGeocoder = new google.maps.Geocoder();
    return new Promise((resolve, reject) => {
        centerGeocoder.geocode(
            {
            address: post['address']
            },
            function(results, status) {
                if (status == google.maps.GeocoderStatus.OK && results[0].geometry) {
                latLng = results[0].geometry.location;
                const mapOptions = {
                    zoom: 14, // 拡大倍率
                    center: latLng // 緯度・経度
                };
                // マップオブジェクト作成
                const map = new google.maps.Map(
                    target, // マップを表示する要素
                    mapOptions // マップオプション
                    );
                marker = new google.maps.Marker({
                    position: latLng,
                    map: map,
                });
                resolve(map);
            
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
    }); // return new Promise((resolve, reject) => { ... });
@endsection('scriptA')