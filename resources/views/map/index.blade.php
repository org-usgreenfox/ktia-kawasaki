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
      var map;
      var tokyo = {lat: 35.681167, lng: 139.767052};
      var marker;

      map = new google.maps.Map(target, {
        center: tokyo,
        disableDefaultUI: true,
        zoomControl: true,
        zoom: 8
      });

      marker = new google.maps.Marker({
        position: tokyo,
        map: map,
        title: 'Tokyo!',

        // animation: google.maps.Animation.BOUNCE
        // animation: google.maps.Animation.DROP
      });

    }
  </script>
</body>
</html>