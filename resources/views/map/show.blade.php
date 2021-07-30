
<!DOCTYPE html>
<html lang="ja">
<head>
  <meta charset="utf-8">
  <title>My Map</title>
  <style>
    #target {
      width: 550px;
      height: 550px;
    }
  </style>
</head>
<body>
  <div id="target"></div>
  <script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" async defer></script>
  <script>
  function initMap() {
      'use strict';

      var target = document.getElementById('target');
      var position = {lat: 34.6524992, lng: 135.5063058}; //tutenkaku
      var map;

      if (navigator.geolocation) {
        // 現在地を取得
        navigator.geolocation.getCurrentPosition(
          // 取得成功した場合
          function(position) {
            // 緯度・経度を変数に格納
            var mapLatLng = new google.maps.LatLng(position.coords.latitude, position.coords.longitude);
            // マップオプションを変数に格納
            var mapOptions = {
              zoom : 6,          // 拡大倍率
              center : mapLatLng  // 緯度・経度
            };
            // マップオブジェクト作成
            map = new google.maps.Map(
              target, // マップを表示する要素
              mapOptions         // マップオプション
            );
            //　マップにマーカーを表示する
            var marker = new google.maps.Marker({
              map : map,             // 対象の地図オブジェクト
              position : mapLatLng   // 緯度・経度
            });
          },
          // 取得失敗した場合
          function(error) {
            // エラーメッセージを表示
            switch(error.code) {
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
                alert("その他のエラー(エラーコード:"+error.code+")");
                break;
            }
          }
        );
      // Geolocation APIに対応していない
      } else {
        alert("この端末では位置情報が取得できません");
        var map = new google.maps.Map(target, {  //位置情報が取得できない場合は通天閣を中心にmap生成
        center: position,
        disableDefaultUI: true,
        zoomControl: true,
        zoom: 6
      });
      }

        const markers = @json($posts);
        var geocoder = new google.maps.Geocoder();
        console.log('');

        for (var i in markers) {
            geocoder.geocode(  //第１引数：住所（address）、第２引数：コールバック関数
                {
                    address: markers[i]['address']
                },
                function (results, status) {  
                    if (status == google.maps.GeocoderStatus.OK && results[0].geometry) {
                        var lat = results[0].geometry.location.lat();
                        var lng = results[0].geometry.location.lng();

                        var position =  {lat: lat, lng: lng}; //latに変数lat, lngに変数lngを代入
                        console.log(position);
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

                    var marker = new google.maps.Marker({　//マーカーを作成
                    position: position,
                    map: map,
                    });
                } //function(results, status)
            ); //geocoder
        } 
    }  
 
    // function initMap() {
    //   'use strict';

    //   var target = document.getElementById('target');
    //   var map;
    //   var position = {lat: 35.681167, lng: 139.767052}; //tokyo
    //   var marker;
    //   var markers = [ // マーカーを立てる場所名・緯度・経度
    //        {
    //             name: '小川町駅',
    //         lat: 35.6951212,
    //             lng: 139.76610649999998
    //     }, {
    //             name: '淡路町駅',
    //         lat: 35.69496,
    //           lng: 139.76746000000003
    //     }, {
    //             name: '御茶ノ水駅',
    //             lat: 35.6993529,
    //             lng: 139.76526949999993
    //     }, {
    //             name: '神保町駅',
    //         lat: 35.695932,
    //         lng: 139.75762699999996
    //     }, {
    //             name: '新御茶ノ水駅',
    //           lat: 35.696932,
    //         lng: 139.76543200000003
    //     }
    //     ];

    //   map = new google.maps.Map(target, {
    //     center: position,
    //     disableDefaultUI: true,
    //     zoomControl: true,
    //     zoom: 8
    //   });

    //   marker = new google.maps.Marker({
    //     position: position,
    //     map: map,
    //     title: 'Tokyo!',

        
    //   });
    //   console.log('hoge');
    //   // マーカー毎の処理
    //   for (let i = 0; i < markers.length; i++) {
    //           let markerLatLng = new google.maps.LatLng({lat: markers[i]['lat'], lng: markers[i]['lng']}); // 緯度経度のデータ作成
    //           marker[i] = new google.maps.Marker({ // マーカーの追加
    //           position: markerLatLng, // マーカーを立てる位置を指定
    //               map: map // マーカーを立てる地図を指定
    //         });
    //   }

    // }
  </script>
</body>
</html>