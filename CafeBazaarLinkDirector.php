<?php
	$packagename = '';
	if(isset($_POST['packagename'])){
		$packagename = $_POST['packagename'];
	}else if (isset($_GET['packagename'])){
		$packagename = $_GET['packagename'];
	}else if ($argc > 0 && isset($argv[1])){
		$packagename = $argv[1];
	}
	if($packagename == null && $packagename == ""){
		echo 'err';
		return;
	}
	
	if (preg_match("/\?id=(.+)/", $packagename)>0){
		preg_match("/\?id=(.+)/", $packagename, $mat);
		$packagename = $mat[1];
	}
	if (preg_match("/\/app\/(.+)\//", $packagename)>0){
		preg_match("/\/app\/(.+)\//", $packagename, $mat);
		$packagename = $mat[1];
	}
	echo $packagename . "\r\n";
    function hashed($package) {
	$hash = '{"7cc78271-e338-4edc-849c-b105c5d51ba5":["getAppDownloadInfo","' . $package . '"' . ',19]}';
	return sha1($hash);
	}

	function do_post_request($url, $data, $optional_headers = null)
	{
		$params = array('http' => array(
			'method' => 'POST',
		'content' => $data
		));
		if ($optional_headers !== null) {
			$params['http']['header'] = $optional_headers;
		}
		$ctx = stream_context_create($params);
		$fp = @fopen($url, 'rb', false, $ctx);
		if (!$fp) {
			throw new Exception("Problem with $url, $php_errormsg");
		}
		$response = @stream_get_contents($fp);
		if ($response === false) {
			throw new Exception("Problem reading data from $url, $php_errormsg");
		}
		return $response;
	}
	function current_millis() {
    list($usec, $sec) = explode(" ", microtime());
    return round(((float)$usec + (float)$sec) * 1000);
	}
	$send = '{"id":1,"hash":"' . hashed($packagename) .'","packed":"HQBMr5rno5A\/hS+Y+wb+ihMyCz4vw1ULz5utB48p9klixLTh+qOG9faHLleadUFYGs2oKL78Iqf53ArgKUTAfL\/Ygn1VeOwY7iT3Me9aBXU=","iv":"KzjF2UgHRyTzgilHjnss8O1pi7FdA7GxpT83T64krKuylzoMulsoQ7JJNP1c7880hRK3xJ2mjk5Qbp3fy5nNbyVsMZAMm0R7HlOediyU4mJ0ZoQ\/6\/ltQoenjyw4u0Ln5SzcsWNM\/yL4wcsEcMHeaf9kKpneD+yyLKmGjVH1Svk=","p2":"So8LNPDT5f4WheoJw91BSrZXSxGNFMRgZx5BS6XghENwz8UZGK76IhB6tuFezciqFbap6oKSdRRHtAeZqySrKwBReICJ\/ro5DsHmZ3NpAx0JbVwIiTQieHO2\/CKp0c5ScYH++5Hlhk7h\/64NSvZth4tyPzf3IS5AqAD4hRPR8BQ=","p1":"p3FANlcTCqaRQ3pAIpTxbHUTr\/s\/GT6hQw0SNEciRVTkWtIfwowK3LLkJwUgtrfr+tA9B5ct1CfW1Zj4fIccNLXeSD+fEnuRvYt62PY7F3b9bEwZGMk+2yjYz+wUBolOt7PtP9ZD\/v6xGDmplnjEaYC3Aqs6cbIWtN5lOckTI4s=","enc_resp":false,"method":"getAppDownloadInfo","non_enc_params":"{\"device\":{\"mn\":260,\"abi\":\"x86\",\"sd\":19,\"bv\":\"7.11.4\",\"us\":{},\"cid\":0,\"lac\":0,\"ct\":\"\",\"id\":\"OswwS2hbSD2wqw-5rWMumg\",\"dd\":\"hlteatt\",\"co\":\"\",\"mc\":310,\"dm\":\"samsung\",\"do\":\"SAMSUNG-SM-N900A\",\"dpi\":240,\"abi2\":\"armeabi-v7a\",\"sz\":\"l\",\"dp\":\"hlteuc\",\"bc\":701104,\"pr\":\"\"},\"referer\":{\"name\":\"page_top-grossing|!EX!None_experiment|!VA!None_variation|0\"}}","params":[]}';
	$ch = curl_init();
	curl_setopt($ch, CURLOPT_URL, 'http://ad.cafebazaar.ir/json/getAppDownloadInfo');
	curl_setopt($ch, CURLOPT_USERAGENT,'Mozilla/5.0 (Windows NT 10.0; Win64; x64; rv:48.0) Gecko/20100101 Firefox/48.0');
	curl_setopt($ch, CURLOPT_POST, true);
	curl_setopt($ch, CURLOPT_HTTPHEADER, array(
    'Content-Type: application/x-www-form-urlencoded; charset=UTF-8',
    'Connection: Keep-Alive',
	'Expect:'
	));
	curl_setopt($ch, CURLOPT_POSTFIELDS, $send);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	$answer = curl_exec($ch);
	if (curl_error($ch)) {
    echo curl_error($ch);
	}
	echo $answer . "\r\n";
    $json = json_decode($answer);
	$name = $json->result->t;
	$addresses = $json->result->cp;
	echo $addresses[0] . 'apks/' . $name . '.apk?rand=' . current_millis();
?>
