<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<title>카카오 로드뷰</title>
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css">
	<style>

	</style>
</head>

<?php
$logDirectory = "data/log/roadview_log/";
$fileArray = scandir($logDirectory, 1);
foreach($fileArray as $value){
	echo "$value<br>";
}
?>
<body>
</body>

<script type="text/javascript"src="//dapi.kakao.com/v2/maps/sdk.js?appkey=aaad5d4c64cda78f1f24f008bed01025&libraries=services"></script>
<script type="text/javascript"src="https://openapi.map.naver.com/openapi/v3/maps.js?ncpClientId=xbdzrxswyq&submodules=panorama"></script>
<script src="http://code.jquery.com/jquery-latest.min.js"></script>

<script>
	var fileArray = <?php echo json_encode($fileArray);?>;
	console.log(fileArray);

	fileArray = for()

</script>
</html>