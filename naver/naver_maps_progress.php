<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
    <title>전체 조사현황</title>
    <script type="text/javascript" src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=xbdzrxswyq&submodules=panorama,geocoder,drawing"></script>
    <script src="http://code.jquery.com/jquery-latest.min.js"></script>
    <style type="text/css">
    html,
    body {
        margin: 0;
        height: 100%;
        overflow: hidden;
    }
    #map {
        width: 100%;
        height: 100%;
        float: left;    
        }
</style>
</head>
<body>
    <div id="map" style="width:100%;height:100%;"></div>
</body>

<!--GPS 데이터 가져오기-->
<?php
    $file_name = '/var/www/html/data/log/progress_log/2020_10_07_progress.log';
    $f = fopen($file_name, "r");
    $gps_logs = fread($f, filesize($file_name));
    fclose($f);
    $gps_array = explode("\n", $gps_logs);
    $unique_gps_array = array_unique($gps_array);
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
        url: '/data/icheon.json',
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

        map.data.addListener('rightclick', function (e) {
            var latlng = e.coord;
            var gps = document.getElementById('gps');
                gps.innerHTML = latlng._lat + " " + latlng._lng;
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

var unique_gps_array = [];
	$.each(gps_array, function(i, el){
		if($.inArray(el, unique_gps_array) === -1) unique_gps_array.push(el);
	});

//마커 생성
for (var i=0; i<unique_gps_array.length; i++){
    if (unique_gps_array[i] != ""){
        gps = unique_gps_array[i].split(',');
        var marker = new naver.maps.Marker({
            position: new naver.maps.LatLng(gps[0], gps[1]),
            map: map
        });
    }
}


</script>
</html>