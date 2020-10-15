<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<title>전체 조사 현황</title>
	<style>
		html,
		body {
			margin: 0;
			height: 100%;
			overflow: auto;
		}
		#mapWrapper {
			z-index: 4;
			position: absolute;
			width: 100%;
		}
		#map {
			z-index: 5;
			position: absolute;
			bottom: 0;
		}
	</style>
	<script src="http://code.jquery.com/jquery-latest.min.js"></script>
	<script type="text/javascript"
		src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aaad5d4c64cda78f1f24f008bed01025&libraries=services"></script>
</head>

<?php
    $file_name = '/var/www/html/data/log/progress_log/2020_10_07_progress.log';
    $f = fopen($file_name, "r");
    $gps_logs = fread($f, filesize($file_name));
    fclose($f);
    $gps_array = explode("\n", $gps_logs);
    $unique_gps_array = array_unique($gps_array);
?>

<body>
	<div id="map" style="width:100%;height:100%;"></div>
	<script>
		// 카카오 지도 생성
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

//법정동 폴리곤
$.getJSON("/data/icheon_li.json", function(geoJson){
	var data = geoJson.features;
	var coordinates = [];
	var name = ''
		$.each(data, function(index, val){
			coordinates = val.geometry.coordinates;	//WGS84
			name = val.properties.RI_NM;			//동(ex: 경기도 이천시 증포동)
			displayArea(name, coordinates);
		})
    });
	
//법정리 폴리곤
$.getJSON("/data/icheon_dong.json", function(geoJson){
var data = geoJson.features;
var coordinates = [];
var name = ''
	$.each(data, function(index, val){
		coordinates = val.geometry.coordinates;	//WGS84
		name = val.properties.EMD_NM;			//동(ex: 경기도 이천시 증포동)
		displayArea2(name, coordinates);
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
        strokeWeight: 0.5,
        strokeColor: '#ff0f01',
        strokeOpacity: 0.8,
        fillColor: '#09f',
        fillOpacity: 0
	});

	polygons.push(polygon);

	//법정리에 법정리명 표시
	var polygon_center = centeroid(points);
	var content = '<div class ="label" style ="color:white; font-size: small; background-color: rgba( 10, 10, 10, 0.3 );><span class="left"></span><span class="center">' + name + '</span><span class="right"></span></div>';
	var position = new kakao.maps.LatLng(polygon_center['Ha'], polygon_center['Ga']);  
	var customOverlay = new kakao.maps.CustomOverlay({
	    position: position,
    	content: content   
	});
	customOverlay.setMap(map);
}
function displayArea2(name, coordinates){
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

	//법정동명 표시
	var polygon_center = centeroid(points);

	var content = '<div class ="label" style ="color:black; font-weight:bold; background-color: rgba( 255, 255, 0, 0.3 );><span class="left"></span><span class="center">' + name + '</span><span class="right"></span></div>';
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

// var markers = [];
// var gps_array = <?php echo json_encode($gps_array);?>

// create_marker(gps_array);

// function create_marker(gps_array) {
// 	var unique_gps_array = [];
// 	$.each(gps_array, function(i, el){
// 		if($.inArray(el, unique_gps_array) === -1) unique_gps_array.push(el);
// 	});
	
// 	for (var i = 0; i < unique_gps_array.length; i++) {
// 		if (unique_gps_array[i] != "") {
// 			gps = unique_gps_array[i].split(',');
// 			var markerPosition = new kakao.maps.LatLng(gps[0], gps[1]);
// 			var marker = new kakao.maps.Marker({
// 				map: map, // 마커를 표시할 지도
// 				position: markerPosition // 마커의 위치
// 			});
// 			markers.push(marker);
// 		}
// 	}
// }

	</script>
</body>

</html>