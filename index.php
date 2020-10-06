<h2><a href="http://jyh.kr/naver_streetview_search2.html" target="_blank">네이버 거리뷰 (신기능)</a><hr>
<!------------------------------------------------------------------------------------------------------------------------------------------------>
<h2>네이버 거리뷰 GPS 추출</h2>
<form method="post">
<input tabindex="1" style="width: 960px;" type="text" placeholder="https://map.naver.com/v5/?c=" name="a"/>
<button tabindex="2" type="submit">입력</button>
</form>


<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["a"])
{
	$cmd = "python3 /home/a/api/a.py \"" . ($_POST["a"]) . "\"";
	exec($cmd, $out, $ret);
	echo($out[0]);

	$geocode = explode("\t", $out[0]);
	
	$x = $geocode[1];
	$y = $geocode[2];


}else{
	echo "Bad Reqeust";
}
?>

<br>
<button id="copyBtn_1">복사하기</button>
<button id="kakao_map_search_1">카카오맵 검색</button>
<button id="naver_map_search_1">네이버맵 검색</button>

<hr>
<!------------------------------------------------------------------------------------------------------------------------------------------------>

<h2>네이버 위성 GPS 추출</h3> 
<form method="post">
<input tabindex="3" style="width: 960px;" type="text" placeholder="https://map.naver.com/v5/api/geocode?=" name="b">
<button tabindex="4" type="submit">입력</button>
</form>


<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["b"])
{
	$cmd = "python3 /home/a/api/b.py \"" . ($_POST["b"]) . "\"";
	exec($cmd, $out, $ret);
	echo($out[0]);
	$geocode = explode("\t", $out[0]);

	$x = $geocode[1];
	$y = $geocode[2];
}else{
	echo "Bad Reqeust";
}
?>

<br>
<button id="copyBtn_2">복사하기</button>
<button id="kakao_map_search_2">카카오맵 검색</button>

<hr>



<!------------------------------------------------------------------------------------------------------------------------------------------------>
<h2>카카오 로드뷰 GPS 추출</h3> 
<form method="post">
<input tabindex="5" style="width: 960px;" type="text" placeholder="https://rv.maps.daum.net/roadview-search/searchNodeInfo?SEARCH_TYPE=2" name="c">
<button tabindex="6" type="submit">입력</button>
</form>

<?php
ini_set('display_errors', 1);
error_reporting(E_ERROR);
if($_SERVER["REQUEST_METHOD"] == "POST" && $_POST["c"])
{
	$cmd = "python3 /home/a/api/c.py \"" . ($_POST["c"]) . "\"";
	exec($cmd, $out, $ret);
	echo($out[0]);
	$geocode = explode("\t", $out[0]);

	$x = $geocode[1];
	$y = $geocode[2];
}else{
	echo "Bad Reqeust";
}
?>
<br>
<button id="copyBtn_3">복사하기</button>
<button id="kakao_map_search_3">카카오맵 검색</button>
<hr>
<h2><a href="https://www.google.com/maps/d/edit?mid=1nCYCZ_-6lWQn6ml7qjVDGh0OHAA0WfZO&usp=sharing" target="_blank">9월 23일 진행상황</a><br><br>

<!--전체 진행상황-->
<hr>
<h2>이천시 행정 구역</h2>
<strong>
<font color ="black">검정(미진행) / </font> 
<font color ="blue">파랑(진행중) / </font>
<font color ="red">빨강(완료) </font>
</strong><br><br>

<!-- 읍 구역 -->
읍 : 
<font color = "black">장호원읍</font>,
<strong><font color = "blue">부발읍(정인혜)</font></strong><br><br>

<!-- 면 구역 -->
면 : 
<font color = "black">신둔면</font>,
<strong><font color = "blue">백사면(홍진우)</font></strong>,
<font color = "black">호법면</font>,
<font color = "black">마장면</font>,
<strong><font color = "blue">대월면(김은혜)</font></strong>,
<font color = "black">모가면</font></strong>, 
<strong><font color = "blue">설성면(김진수)</font></strong>, 
<font color = "black">율면</font><br><br>

<!-- 동 구역 -->
동 : 
<strong><font color = "red">창전동</font></strong>, 
<strong><font color = "red">증포동</font></strong>, 
<strong><font color = "red">중리동</font></strong>, 
<strong><font color = "blue">관고동(정영현)</font></strong>
<strong><font color = "red">진리동</font></strong>, 
<strong><font color = "red">율현동</font></strong>, 
<strong><font color = "red">안흥동</font></strong>, 
<strong><font color = "red">갈산동</font></strong>, 
<strong><font color = "red">송정동</font></strong>, 
<br><br>

<hr>

<h2><a href="http://jyh.kr/file/" target="_blank">파일 저장소</a> &nbsp&nbsp&nbsp
</h2><br>



<script>
//카카오맵 이동
var x = '<?=$x?>';
var y = '<?=$y?>';
kakao_url = "http://jyh.kr/kakao_map_search.php?&Lat="+x+"&Lon="+y
naver_url = "http://jyh.kr/naver_map_search.php?&Lat="+x+"&Lon="+y

var kakaoBtn = document.getElementById("kakao_map_search_1");
kakaoBtn.addEventListener("click", function(){
	var win = window.open(kakao_url);
	win.focus();
});

var kakaoBtn = document.getElementById("kakao_map_search_2");
kakaoBtn.addEventListener("click", function(){
	var win = window.open(kakao_url);
	win.focus();
});

var kakaoBtn = document.getElementById("kakao_map_search_3");
kakaoBtn.addEventListener("click", function(){
	var win = window.open(kakao_url);
	win.focus();
});

var naverBtn = document.getElementById("naver_map_search_1");
naverBtn.addEventListener("click", function(){
	var win = window.open(naver_url);
	win.focus();
});

//////////////////////////////////////////
		

var copyBtn_1 = document.getElementById("copyBtn_1");
// 버튼 클릭 이벤트
copyBtn_1.addEventListener("click", function(){
		// 복사할 텍스트를 변수에 할당해줍니다.
		var geo_code = '<?=$out[0]?>';
		
		// input text 태그를 생성해줍니다.
		var createInput = document.createElement("input");
		createInput.setAttribute("type", "geo_code");
		
		// 가상으로 가져올 태그에 만들어준 input 태그를 붙여줍니다.
		document.getElementById("copyBtn_1").appendChild(createInput);
		
		// 만든 input 태그의 value 값에 복사할 텍스트 값을 넣어줍니다.
		createInput.value = geo_code;
		
		// 복사 기능을 수행한 후
		createInput.select();
		document.execCommand('copy');
		// 가상으로 붙여주었던 input 태그를 제거해줍니다.
		document.getElementById("copyBtn_1").removeChild(createInput);
		});

var copyBtn_2 = document.getElementById("copyBtn_2");
copyBtn_2.addEventListener("click", function(){
		var geo_code = '<?=$out[0]?>';
		var createInput = document.createElement("input");
		createInput.setAttribute("type", "geo_code");
		document.getElementById("copyBtn_2").appendChild(createInput);
		createInput.value = geo_code;
		createInput.select();
		document.execCommand('copy');
		document.getElementById("copyBtn_2").removeChild(createInput);
		});

var copyBtn_3 = document.getElementById("copyBtn_3");
copyBtn_3.addEventListener("click", function(){
		var geo_code = '<?=$out[0]?>';
		var createInput = document.createElement("input");
		createInput.setAttribute("type", "geo_code");
		document.getElementById("copyBtn_3").appendChild(createInput);
		createInput.value = geo_code;
		createInput.select();
		document.execCommand('copy');
		document.getElementById("copyBtn_3").removeChild(createInput);
		});

</script>
