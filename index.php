<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport"
        content="width=device-width, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0, user-scalable=no">
	<title>이천시 공공데이터 실측</title>
	<style tpye="text/css">
	A:link {text-decoration:none; color:#000000;}
	A:visited {text-decoration:none; color:#000000;}
	A:active {text-decoration:none; color:#000000;}
	A:hover {text-decoration:none; color:#000000;}
	</style>
		<script src="http://code.jquery.com/jquery-latest.min.js"></script>
		<script type="text/javascript"
		src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aaad5d4c64cda78f1f24f008bed01025&libraries=services"></script>
</head>

<style>
	html, body {
        height: 100%;
        margin: 0px;
    }
    .container {
        height: 100%;
        background: #f0e68c;
    }
	.view{
		display: inline;
	}
</style>
<body>

<div id="kakao">
	<h2 style="display:inline"> 
	<a href="http://jyh.kr/kakao/kakao_roadview_search.html" 		style="background-color:ffe812;"  		target="_blank">카카오 로드뷰</a> /
	<!-- <a href="http://jyh.kr/kakao/view/kakao_roadview_log.php" 												target="_blank">로드뷰 로그</a> / -->
	<a href="http://jyh.kr/kakao/view/kakao_upload_gps_log.html" 											target="_blank">로그 직접입력</a> / 
	<a href="http://jyh.kr/naver/naver_streetview_search.html" 							 					target="_blank">네이버 거리뷰</a> / 
	<a href="http://jyh.kr/naver/naver_map_gps_parsing.php" 							 					target="_blank">네이버 GPS 검색</a> / 
	<a href="http://jyh.kr/kakao/view/kakao_progress_log.php" 												target="_blank">전체 조사 현황</a> / 
	<a href="http://jyh.kr/file/" target="_blank">파일저장소</a><hr>

</div>

<div id="map" style="width:98%;height:90%; margin-left:1%; margin-right:10%; border:1px solid black;"></div>
</body>

<script>
	
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
        center: new kakao.maps.LatLng(37.20215449091, 127.5104094269966), // 지도의 중심좌표
        level: 8 // 지도의 확대 레벨
    };
var map = new kakao.maps.Map(mapContainer, mapOption); 



//법정동 geoJSON 받아오기
$.getJSON("/data/icheon_dong.json", function(geoJson){
	var data = geoJson.features;
	var coordinates = [];
	var name = ''
		$.each(data, function(index, val){
			coordinates = val.geometry.coordinates;	//WGS84
			name = val.properties.EMD_NM;			//동(ex: 경기도 이천시 증포동)

			displayDongArea(name, coordinates);
		})
    });

//법정리 geoJSON 받아오기
$.getJSON("/data/icheon_li.json", function(geoJson){
var data = geoJson.features;
var coordinates = [];
var name = ''
	$.each(data, function(index, val){
		coordinates = val.geometry.coordinates;	//WGS84
		name = val.properties.RI_NM;			//동(ex: 경기도 이천시 증포동)

		displayLiArea(name, coordinates);
	})
});

var inprogressDong = ["부발읍", "호법면", "신둔면", "마장면", "고담동"];
var successDong = ["증포동", "진리동", "안흥동", "관고동", "송정동", "중리동", "창전동", "갈산동", "율현동", "사음동", "대월면", "설성면", "백사면", "증일동", "장록동"];
var successLi = ["조읍리", "모전리", "경사리", "도립리", "현방리", "상용리", "내촌리", "사동리", "대흥리", "대대리", "가산리", "제요리", "이평리", "해월리", "덕평리", "송계리", "금당리", "장능리", "대죽리", "수산리", "상봉리", "신필리", "장천리", "행죽리", "암산리", "자석리", "응암리", "송온리", "수정리", "죽당리", "송말리", "백우리", "신대리", "도지리", "우곡리", "신원리", "고백리", "대관리", "무촌리", "초지리", "부필리", "구시리", "도리리", "도암리", "군량리", "장평리", "송라리"];
var polygons = []

//법정동 폴리곤 생성
function displayDongArea(name, coordinates){
	var path = [];
	var points = [];
	var tempSuccessDong = [];

	$.each(coordinates[0], function(index, coordinate){
		var point = new Object();
		point.x = coordinate[1];
		point.y = coordinate[0];
		points.push(point);
		path.push(new daum.maps.LatLng(coordinate[1], coordinate[0]));
	})

	for (var i=0; i<successDong.length; i++){
		if(name == successDong[i]){
			var polygon = new daum.maps.Polygon({
				map: map, // 다각형을 표시할 지도 객체
				path: path,
				strokeWeight: 2,
				strokeColor: '#004c80',
				strokeOpacity: 3,
				fillColor: '#020000',
				fillOpacity: 0.8
			});
		}
	}

	for (var i=0; i<inprogressDong.length; i++){
		if(name == inprogressDong[i]){
			var polygon = new daum.maps.Polygon({
				map: map, // 다각형을 표시할 지도 객체
				path: path,
				strokeWeight: 2,
				strokeColor: '#004c80',
				strokeOpacity: 3,
				fillColor: '#ff0000',
				fillOpacity: 0.5
			});
			// name = name + "<br>(이름)";
		}
	}

	var polygon = new daum.maps.Polygon({
		map: map, // 다각형을 표시할 지도 객체
		path: path,
		strokeWeight: 2,
		strokeColor: '#004c80',
		strokeOpacity: 1,
		// fillColor: '#09f',
		// fillOpacity: 0.1
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
}

function displayLiArea(name, coordinates){
	var path = [];
	var points = [];

	$.each(coordinates[0], function(index, coordinate){
		var point = new Object();
		point.x = coordinate[1];
		point.y = coordinate[0];
		points.push(point);
		path.push(new daum.maps.LatLng(coordinate[1], coordinate[0]));
	})

	// for (i=0; i<successLi.length; i++){
	// 	if(name == successLi[i]){
	// 		var polygon = new daum.maps.Polygon({
	// 			map: map, 
	// 			path: path,
	// 			strokeWeight: 0.3,
	// 			strokeColor: '#ff0f01',
	// 			strokeOpacity: 0.8,
	// 			fillColor: '#020000',
	// 			fillOpacity: 0.75
	// 		});
	// 	}
	// }

	var polygon = new daum.maps.Polygon({
        map: map, 
        path: path,
        strokeWeight: 0.6,
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
</script>

</html>