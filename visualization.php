<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>데일리 로드뷰</title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=xbdzrxswyq&submodules=panorama,geocoder,drawing"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
</head>

<body>
    <div id="map" style="width:100%;height:800px;"></div>
    1. 실시간으로 업데이트 됩니다. (새로고침 필요)<br>
    2. 현재 페이지에 보이는 기록은 오늘 기준입니다.<br>
    3. jyh.kr 최상단의 네이버 거리뷰를 사용했을 때 생성되는 로그입니다.<br>
</body>

<?php
    $file_name = date("Ymd");
    $file_name = 'streetview/' + (string)$file_name."gps.log";

    $f = fopen($file_name, "r");

    $gps_logs = fread($f, filesize($file_name));
    fclose($f);

    $gps_array = explode("\n", $gps_logs);
?>

<script>


//맵 옵션 정의
var mapOptions = {
    center: new naver.maps.LatLng(37.272211, 127.435087),
    zoom: 11
};

//맵 생성
var map = new naver.maps.Map('map', mapOptions);

//geoJson 렌더링
$.ajax({
        url: 'icheon.json',
        success: startDataLayer
    });

    var tooltip = $('<div style="position:absolute;z-index:1000;padding:5px 10px;background-color:#fff;border:solid 2px #000;font-size:14px;pointer-events:none;display:none;"></div>');
    tooltip.appendTo(map.getPanes().floatPane);

    function startDataLayer(geojson) {
        map.data.addGeoJson(geojson);

        map.data.setStyle(function (feature) {
            var styleOptions = {
                fillColor: '#ff0000',
                fillOpacity: 0.0001,
                strokeColor: '#ff0000',
                strokeWeight: 2,
                strokeOpacity: 0.4
            };

            if (feature.getProperty('focus')) {
                styleOptions.fillOpacity = 0.6;
                styleOptions.fillColor = '#0f0';
                styleOptions.strokeColor = '#0f0';
                styleOptions.strokeWeight = 4;
                styleOptions.strokeOpacity = 1;
            }

            return styleOptions;
        });
 
        map.data.addListener('click', function (e) {
            var feature = e.feature;

            if (feature.getProperty('focus') !== true) {
                feature.setProperty('focus', true);
            } else {
                feature.setProperty('focus', false);
            }
        });


        map.data.addListener('mouseover', function (e) {
            var feature = e.feature,
                regionName = feature.getProperty('adm_nm');

            tooltip.css({
                display: '',
                left: e.offset.x,
                top: e.offset.y
            }).text(regionName);

            map.data.overrideStyle(feature, {
                fillOpacity: 0.05,
                strokeWeight: 4,
                strokeOpacity: 1
            });
        });

        map.data.addListener('mouseout', function (e) {
            tooltip.hide().empty();
            map.data.revertStyle();
        });
    }

//php에서 GPS 로그 받아오기
var gps_array = <?php echo json_encode($gps_array);?>

//마커 생성
for (var i=0; i<gps_array.length; i++){
    if (gps_array[i] != ""){
        gps = gps_array[i].split(',');
        var marker = new naver.maps.Marker({
            position: new naver.maps.LatLng(gps[0], gps[1]),
            map: map
        });
    }
}


</script>
</html>