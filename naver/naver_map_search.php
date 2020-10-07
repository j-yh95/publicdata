<!DOCTYPE html>
<html>

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport"
    content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
  <title>네이버 지도 검색</title>
  <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=xbdzrxswyq&submodules=geocoder"></script>
</head>

<body>
  <div id="map" style="width:100%;height:700px;"></div>
  <script>
    var lat = '<?= $_GET["Lat"]?>';
    var lon = '<?= $_GET["Lon"]?>';

    //네이버맵 띄우기
    var map = new naver.maps.Map("map", {
      center: new naver.maps.LatLng(lat, lon), //GET 인자
      zoom: 21
    }),
      infoWindow = null;

      //
      function initGeocoder() {
      if (!map.isStyleMapReady) {
        return;
      }

      var latlng = map.getCenter();
      infoWindow = new naver.maps.InfoWindow({
        content: ''
      });
      map.addListener('click', function (e) {
        var latlng = e.coord;
        console.log('LatLng: ' + latlng.toString());
      });
      
      var position = new naver.maps.LatLng(latlng);
      var marker = new naver.maps.Marker({
          position: position,
          map: map
      });

      

naver.maps.Event.addListener(map, 'click', function(e) {
    marker.setPosition(e.coord);
});

    }

    naver.maps.onJSContentLoaded = initGeocoder;
    naver.maps.Event.once(map, 'init_stylemap', initGeocoder);
  </script>

</body>

</html>