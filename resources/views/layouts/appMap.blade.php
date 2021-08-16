@extends('layouts.app')

@section('content')
<div class="card">
    <div class="container " id="target" style="width: 100%; height: 550px;"></div>
</div>
@endsection

@section('script')
<script defer>
    function initMap() {
        'use strict';

        const target = document.getElementById('target');
        let latLng = [];
        let marker = [];

        function createCurrentMap() {
            @yield('scriptA')
        }
        
        function createStoreMarker(map) {
            let geocoder = new google.maps.Geocoder();
            let markers;
            let infoWindow;
            let markerLink;
            @foreach($posts as $post)
                markers = @json($post);
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
                            markerLink = '<a href="{{ route('post.show',['post' => $post->id]) }}">{{$post->store_name}}</a>';
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
                    infoWindow = new google.maps.InfoWindow({
                        content: m_content
                    });
                    infoWindow.open(map, m_marker);
                });
            } 
        } // function creataStoreMarker()

        createCurrentMap().then((m) => createStoreMarker(m));
    } 
</script>
<script src="https://maps.googleapis.com/maps/api/js?language=ja&region=JP&key=AIzaSyB1mp7xlyXS_pjA6QredHZ80UyE7TDIaWs&callback=initMap" async defer></script>
@endsection('script')