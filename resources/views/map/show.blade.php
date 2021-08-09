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
      const marker = @json($post);
      var centerGeocoder = new google.maps.Geocoder();
      centerGeocoder.geocode(
        {
          address: marker['address']
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

                  var mapOptions = {
                      zoom: 14, // 拡大倍率
                      center: position // 緯度・経度
                  };
                  // マップオブジェクト作成
                  map = new google.maps.Map(
                      target, // マップを表示する要素
                      mapOptions // マップオプション
                  );
                  var marker = new google.maps.Marker({
                      position: position,
                      map: map,                    
                  });
        }
      );
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
  }
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" async defer></script>
@endsection