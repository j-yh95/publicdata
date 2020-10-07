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

<script>
//카카오맵 이동
var x = '<?=$x?>';
var y = '<?=$y?>';
kakao_url = "http://jyh.kr/kakao/kakao_map_search.php?&Lat="+x+"&Lon="+y
naver_url = "http://jyh.kr/naver/naver_map_search.php?&Lat="+x+"&Lon="+y

var kakaoBtn = document.getElementById("kakao_map_search_1");
kakaoBtn.addEventListener("click", function(){
	var win = window.open(kakao_url);
	win.focus();
});

var naverBtn = document.getElementById("naver_map_search_1");
naverBtn.addEventListener("click", function(){
	var win = window.open(naver_url);
	win.focus();
});

var copyBtn_1 = document.getElementById("copyBtn_1");
// 버튼 클릭 이벤트
copyBtn_1.addEventListener("click", function(){
		var geo_code = '<?=$out[0]?>';
		var createInput = document.createElement("input");
		createInput.setAttribute("type", "geo_code");
		document.getElementById("copyBtn_1").appendChild(createInput);
		createInput.value = geo_code;
		createInput.select();
		document.execCommand('copy');
		document.getElementById("copyBtn_1").removeChild(createInput);
		});
</script>
