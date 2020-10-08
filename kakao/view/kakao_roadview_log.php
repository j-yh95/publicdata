<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>카카오 로드뷰</title>

	<style>
	html, body {
	margin: 0;
	height: 100%;
	overflow: auto;
	}
	#mapWrapper{z-index: 4; position:absolute; width: 100%;}
	#map{z-index: 5; position:absolute; bottom: 0;}	
</style>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aaad5d4c64cda78f1f24f008bed01025&libraries=services"></script>
</head>


<?php
    $file_name = date("Ymd");
    $file_name = '/var/www/html/data/log/roadview_log/'.(string)$file_name."total_gps.log";
    $file_server_path = realpath(__FILE__);

    $f = fopen($file_name, "r");
    $gps_logs = fread($f, filesize($file_name));
    fclose($f);

    $gps_array = explode("\n", $gps_logs);
?>


<body>
<div id="map" style="width:100%;height:100%;"></div>
<script>
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
	mapCenter = new kakao.maps.LatLng(37.272211, 127.435087), // 지도의 가운데 좌표
	mapOption = {
		center: mapCenter, // 지도의 중심좌표
		level: 7 // 지도의 확대 레벨
	};

// 지도를 표시할 div와  지도 옵션으로  지도를 생성합니다
var map = new kakao.maps.Map(mapContainer, mapOption);
var marker = new kakao.maps.Marker();
var polygons = []

//행정동 폴리곤
$.getJSON("/data/icheon.json", function(geoJson){
	var data = geoJson.features;
	var coordinates = [];
	var name = ''
		$.each(data, function(index, val){
			coordinates = val.geometry.coordinates;	//WGS84
			name = val.properties.adm_nm;			//동(ex: 경기도 이천시 증포동)

			displayArea(name, coordinates);
		})
    });

function displayArea(name, coordinates){
	var path = [];
	var points = [];

	$.each(coordinates[0], function(index, coordinate){
		var point = new Object();
		point.x = coordinate[1];
		point.y = coordinate[0];
		points.push(point);
		path.push(new daum.maps.LatLng(coordinate[1], coordinate[0]));
	})

	var polygon = new daum.maps.Polygon({
        map: map, // 다각형을 표시할 지도 객체
        path: path,
        strokeWeight: 2,
        strokeColor: '#004c80',
        strokeOpacity: 0.8,
        fillColor: '#09f',
        fillOpacity: 0.1
	});

	polygons.push(polygon);

	//행정구역에 행정동명 표시
	var polygon_center = centeroid(points);
	name = name.replace("경기도 이천시 ", "");

	var content = '<div class ="label" style ="color:black; font-weight:bold";><span class="left" ></span><span class="center">' + name + '</span><span class="right"></span></div>';
	var position = new kakao.maps.LatLng(polygon_center['Ha'], polygon_center['Ga']);  
	var customOverlay = new kakao.maps.CustomOverlay({
	    position: position,
    	content: content   
	});

	customOverlay.setMap(map);

    kakao.maps.event.addListener(polygon, 'mouseover', function(mouseEvent) {
        polygon.setOptions({fillColor: '#fff'});
    });
    kakao.maps.event.addListener(polygon, 'mouseout', function() {
        polygon.setOptions({fillColor: '#09f'});
    }); 
}

function centeroid(points){
	var i, j, len, p1, p2, f, area, x, y;

	area = x = y = 0

	for (i=0, len = points.length, j= len - 1; i < len; j = i++){
		p1 = points[i];
		p2 = points[j];

		f = p1.y * p2.x - p2.y * p1.x;
		x += (p1.x + p2.x) * f;
		y += (p1.y + p2.y) * f;
		area += f * 3;
	}return new kakao.maps.LatLng(x / area, y / area);
}

var gps_array = <?php echo json_encode($gps_array);?>
//마커 생성

total_marker();

function total_marker(){
    for (var i=0; i<gps_array.length; i++){
        if (gps_array[i] != ""){
            gps = gps_array[i].split(',');
			var markerPosition = new kakao.maps.LatLng(gps[1], gps[2]);
			var marker = new kakao.maps.Marker({
				position: markerPosition
				});
			marker.setMap(map);
        }
    }
}


</script>
</body>
</html>
