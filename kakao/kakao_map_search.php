<!DOCTYPE html>

<html>
<head>
<meta charset="utf-8">
<title>카카오맵 검색</title>
</head>
<body>
<div id="map" style="width:100%;height:700px;"></div>
<div id="clickLatlng"></div>
<script type="text/javascript" src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aaad5d4c64cda78f1f24f008bed01025&libraries=services"></script>
<button id="copyBtn_1">복사하기</button>
<script>
var lat = '<?= $_GET["Lat"]?>';
var lon = '<?= $_GET["Lon"]?>';
var mapContainer = document.getElementById('map'), // 지도를 표시할 div 
    mapOption = { 
center: new kakao.maps.LatLng(lat, lon), // 지도의 중심좌표
	level: 1 // 지도의 확대 레벨
    };

var map = new kakao.maps.Map(mapContainer, mapOption); // 지도를 생성합니다

// 지도를 클릭한 위치에 표출할 마커입니다
var marker = new kakao.maps.Marker({ 
		// 지도 중심좌표에 마커를 생성합니다 
position: map.getCenter() 
}); 
// 지도에 마커를 표시합니다
marker.setMap(map);

//GPS 좌표 동 변환
var geocoder = new kakao.maps.services.Geocoder();

// 지도에 클릭 이벤트를 등록합니다
// 지도를 클릭하면 마지막 파라미터로 넘어온 함수를 호출합니다
kakao.maps.event.addListener(map, 'click', function(mouseEvent) {        
		// 클릭한 위도, 경도 정보를 가져옵니다 
		var latlng = mouseEvent.latLng; 

		// 마커 위치를 클릭한 위치로 옮깁니다
		marker.setPosition(latlng);

		var message = latlng.getLat() + '\t';
		message += latlng.getLng();

		// GPS좌표를 변환
		var coord = new kakao.maps.LatLng(latlng.getLat(), latlng.getLng());
		var callback = function(result, status) {
		if (status === kakao.maps.services.Status.OK) {
		addr = result[0].address.address_name;
		}
		gps = addr + '\t' + message;
		var resultDiv = document.getElementById('clickLatlng'); 
		resultDiv.innerHTML = gps;

		
		//복사하기 이벤트
		var copyBtn_1 = document.getElementById("copyBtn_1");
		copyBtn_1.addEventListener("click", function(){
				// input text 태그를 생성해줍니다.
				var createInput = document.createElement("input");
				createInput.setAttribute("type", "gps");

				// 가상으로 가져올 태그에 만들어준 input 태그를 붙여줍니다.
				document.getElementById("copyBtn_1").appendChild(createInput);

				// 만든 input 태그의 value 값에 복사할 텍스트 값을 넣어줍니다.
				createInput.value = gps;

				// 복사 기능을 수행한 후
				createInput.select();
				document.execCommand('copy');
				// 가상으로 붙여주었던 input 태그를 제거해줍니다.
				document.getElementById("copyBtn_1").removeChild(createInput);
				});
		};
		//변환 끝
		geocoder.coord2Address(coord.getLng(), coord.getLat(), callback);
});

</script>
</body>
</html>
