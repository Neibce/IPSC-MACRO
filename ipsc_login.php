<?php
header("Pragma: no-cache");
header("Cache-Control: no-cache,must-revalidate");

function login($id, $pw){
  $curl = curl_init();

  curl_setopt_array($curl, array(
    CURLOPT_URL => "https://sso.ipacademy.net/usrLogin.do",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_HEADER => 1,
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_FRESH_CONNECT => TRUE,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_POSTFIELDS => "sso.FU=%2Fservlet%2FMainController%3Fsd%3DIP%26aspseq%3D1588%26CT%3D5&sso.ID={$id}&sso.PU=https%3A%2F%2Fwww.ipacademy.net%2Fservlet%2FLoginController%3Fcmd%3D1&sso.PW={$pw}&sso.SU=https%3A%2F%2Fdchs.ipacademy.net%2Fservlet%2FLoginController%3Fcmd%3D1%26sd%3DIP%26aspseq%3D1588%26CT%3D5&x=28&y=30",
	  CURLOPT_HTTPHEADER => array(
	    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
	    "accept-encoding: gzip, deflate, br",
	    "accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7",
	    "cache-control: no-cache",
	    "content-type: application/x-www-form-urlencoded",
	    "cookie: __utmz=220622919.1522686914.1.1.utmcsr=blog.naver.com|utmccn=(referral)|utmcmd=referral|utmcct=/PostView.nhn; __utma=220622919.595398913.1522686914.1526827557.1527221497.7; B2BDOMAIN=2387cae80c2cfca85d93e024d58424d97e3ba560a216b8f8ad8d9a0bb74d0bb0; __utmt=1; __utmc=220622919; WMONID=QaA2A2bLRNt; __utmb=220622919.21.10.1527221497",
	    "origin: https://dchs.ipacademy.net",
	    "postman-token: 35ade906-4d09-0d34-e0fd-8d56a1db3f77",
	    "referer: https://dchs.ipacademy.net/servlet/MainController",
	    "upgrade-insecure-requests: 1",
	    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  return $response;
	}
}
function get_reg($num){
	switch ($num) {
		case '6':
			return "/sjsGoMoveCourse\('frm_main','1588','11636','188881','(.*)','.','',''\)/";
			break;
		case '7':
			return "/sjsGoMoveCourse\('frm_main','1588','11637','188883','(.*)','.','',''\)/";
			break;
		case '8':
			return "/sjsGoMoveCourse\('frm_main','1588','11638','188885','(.*)','.','',''\)/";
			break;
	}
}

function get_usr_num($num, $sid){
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://dchs.ipacademy.net/servlet/UsrKisuController?cmd=4&sd=IP&ms=816&md=IP_YBMYP&aspseq=1588&CT=5#",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_FRESH_CONNECT => TRUE,
	  CURLOPT_HTTPHEADER => array(
	    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
	    "accept-encoding: gzip, deflate, br",
	    "accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7",
	    "cache-control: no-cache",
	    "cookie: __utmz=220622919.1522686914.1.1.utmcsr=blog.naver.com|utmccn=(referral)|utmcmd=referral|utmcct=/PostView.nhn; WMONID=5FVd0GFvKXC; B2BDOMAIN=2387cae80c2cfca85d93e024d58424d97e3ba560a216b8f8ad8d9a0bb74d0bb0;{$sid}__utma=220622919.595398913.1522686914.1526827557.1527221497.7; __utmc=220622919; __utmt=1; __utmb=220622919.7.10.1527221497; ContentLogSeq=86234919",
	    "postman-token: 6e7841da-16e7-35b1-f18e-f07382e96170",
	    "upgrade-insecure-requests: 1",
	    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/67.0.3396.79 Safari/537.36",
	    "x-devtools-emulate-network-conditions-client-id: DD7F627A42CA309DD732621367EAE4B8"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);

	$matches = array();
	preg_match(get_reg($num), $response, $matches);
	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  return $matches[1];
	}
}

function get_orig_url($class_num, $num, $usr_num){
	switch ($class_num) {
		case "6":
			return "https://dchs.ipacademy.net/servlet/ContentStudyController?cmd=10&sd=IP&ms=816&md=null&STUDMODE=STUDY&contentSeq=945&contentType=D&itemId=0000000000000000000{$num}&lectseq=188881&kisuseq=11636&applyseq={$usr_num}";
			break;
		case "7":
			return "https://dchs.ipacademy.net/servlet/ContentStudyController?cmd=10&sd=IP&ms=816&md=null&STUDMODE=STUDY&contentSeq=996&contentType=D&itemId=0000000000000000000{$num}&lectseq=188883&kisuseq=11637&applyseq={$usr_num}";
			break;
		case "8":
			return "https://dchs.ipacademy.net/servlet/ContentStudyController?cmd=10&sd=IP&ms=816&md=IP_YBMYP&STUDMODE=STUDY&contentSeq=1000&contentType=D&itemId=0000000000000000000{$num}&lectseq=188885&kisuseq=11638&applyseq={$usr_num}";
			break;
	}
  
}

function get_page_location($class_num, $num, $page_num){
	if ($page_num < 10)
		$page_num = "0{$page_num}";
	switch ($class_num) {
		case "6":
			return "https://dchs.ipacademy.net/Files/LectureContents2/C0000000945/0{$num}_index.html";
			break;
		case "7":
			return "https://dchs.ipacademy.net/Files/LectureContents2/C0000000996/0{$num}/0{$num}_{$page_num}.html";
			break;
		case "8":
			return "https://dchs.ipacademy.net/Files/LectureContents2/C0000001000/0{$num}/html/0{$num}_{$page_num}.html";
		break;
	}
}

function get_max_num($class_num){
	switch ($class_num) {
		case "6":
			return 9;
			break;
		case "7":
			return 3;
			break;
		case "8":
			return 3;
			break;
	}
}

function get_max_page($class_num, $num){
	$max_page = array(
		array(1, 1, 1, 1, 1, 1, 1, 1, 1),
		array(8, 8, 8),
		array(7, 7, 7)
	);

	return $max_page[$class_num - 6][$num - 1];
}

function ipsc_study($class_num, $sid){
	$usr_num = get_usr_num($class_num, $sid);
	$max_num = get_max_num($class_num);

	for($num = 1; $num <= $max_num; $num++){
		$max_page_num = get_max_page($class_num, $num);

		for($page_num = 1; $page_num <= $max_page_num; $page_num++){
			ob_echo("## {$num}/{$max_num}강 {$page_num}/{$max_page_num}페이지 진행 중...");
			ipsc_study_1(get_orig_url($class_num, $num, $usr_num), $sid);
			ipsc_study_2(get_page_location($class_num, $num, $page_num), $page_num, $sid);
			ipsc_study_3($page_num, $sid);
			ipsc_study_4($page_num, $sid);
		}
	}
}

function ipsc_study_1($orig_url, $sid) {
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => $orig_url,
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "GET",
	  CURLOPT_FRESH_CONNECT => TRUE,
	  CURLOPT_HTTPHEADER => array(
	    "accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,image/apng,*/*;q=0.8",
	    "accept-encoding: gzip, deflate, br",
	    "accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7",
	    "cache-control: no-cache",
	    "cookie: __utmz=220622919.1522686914.1.1.utmcsr=blog.naver.com|utmccn=(referral)|utmcmd=referral|utmcct=/PostView.nhn; WMONID=5FVd0GFvKXC; B2BDOMAIN=2387cae80c2cfca85d93e024d58424d97e3ba560a216b8f8ad8d9a0bb74d0bb0;{$sid}__utma=220622919.595398913.1522686914.1526827557.1527221497.7; __utmc=220622919; __utmt=1; __utmb=220622919.7.10.1527221497; ContentLogSeq=86234919",
	    "postman-token: 2c8e9b67-b20b-2e26-6e66-13cb8bf74baf",
	    "referer: https://dchs.ipacademy.net/servlet/CourseController?cmd=6&flag=1",
	    "upgrade-insecure-requests: 1",
	    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	$info = curl_getinfo($curl);

	curl_close($curl);

	if ($err) {
	  return 0;
	} else {
  	ob_echo($info['total_time']. 'sec<br>'. $info['url']);
	}
}

function ipsc_study_2($page_location, $page_num, $sid){
	$page_num = (string)$page_num;
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://dchs.ipacademy.net/servlet/ContentStudyController?cmd=11&WType=SET_STUDYPAGE&CurrentPageNum={$page_num}&PageLocation={$page_location}",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_FRESH_CONNECT => TRUE,
	  CURLOPT_HTTPHEADER => array(
	    "accept: */*",
	    "accept-encoding: gzip, deflate, br",
	    "accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7",
	    "cache-control: no-cache",
	    "cookie: __utmz=220622919.1522686914.1.1.utmcsr=blog.naver.com|utmccn=(referral)|utmcmd=referral|utmcct=/PostView.nhn; WMONID=5FVd0GFvKXC; B2BDOMAIN=2387cae80c2cfca85d93e024d58424d97e3ba560a216b8f8ad8d9a0bb74d0bb0;{$sid}__utma=220622919.595398913.1522686914.1526827557.1527221497.7; __utmc=220622919; __utmt=1; __utmb=220622919.7.10.1527221497; ContentLogSeq=86234919",
	    "origin: https://dchs.ipacademy.net",
	    "postman-token: 662a5400-f98b-a3ae-4359-576495743c4a",
	    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	$info = curl_getinfo($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  ob_echo($info['total_time']. 'sec<br>'. $info['url']);
	}
}

function ipsc_study_3($page_num, $sid){
	$page_num = (string)$page_num;
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://dchs.ipacademy.net/servlet/ContentStudyController?cmd=11&WType=SET_SESSIONTIME&CurrentPageNum={$page_num}&SessionTime=10000",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_FRESH_CONNECT => TRUE,
	  CURLOPT_HTTPHEADER => array(
	    "accept: */*",
	    "accept-encoding: gzip, deflate, br",
	    "accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7",
	    "cache-control: no-cache",
	    "cookie: __utmz=220622919.1522686914.1.1.utmcsr=blog.naver.com|utmccn=(referral)|utmcmd=referral|utmcct=/PostView.nhn; WMONID=5FVd0GFvKXC; B2BDOMAIN=2387cae80c2cfca85d93e024d58424d97e3ba560a216b8f8ad8d9a0bb74d0bb0;{$sid}__utma=220622919.595398913.1522686914.1526827557.1527221497.7; __utmc=220622919; __utmt=1; __utmb=220622919.7.10.1527221497; ContentLogSeq=86234919",
	    "origin: https://dchs.ipacademy.net",
	    "postman-token: 64bdc797-f2a3-a3ec-cf81-eee1d9f229cb",
	    "referer: https://dchs.ipacademy.net/Files/LectureContents2/C0000000938/02/02_01.html",
	    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	$info = curl_getinfo($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  ob_echo($info['total_time']. 'sec<br>'. $info['url']);
	}
}

function ipsc_study_4($page_num, $sid){
	$page_num = (string)$page_num;
	$curl = curl_init();

	curl_setopt_array($curl, array(
	  CURLOPT_URL => "https://dchs.ipacademy.net/servlet/ContentStudyController?cmd=11&WType=SET_PAGESTUDYSTATUS&CurrentPageNum={$page_num}&StudStatus=C",
	  CURLOPT_RETURNTRANSFER => true,
	  CURLOPT_ENCODING => "",
	  CURLOPT_MAXREDIRS => 10,
	  CURLOPT_TIMEOUT => 30,
	  CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
	  CURLOPT_CUSTOMREQUEST => "POST",
	  CURLOPT_FRESH_CONNECT => TRUE,
	  CURLOPT_HTTPHEADER => array(
	    "accept: */*",
	    "accept-encoding: gzip, deflate, br",
	    "accept-language: ko-KR,ko;q=0.9,en-US;q=0.8,en;q=0.7",
	    "cache-control: no-cache",
	    "cookie: __utmz=220622919.1522686914.1.1.utmcsr=blog.naver.com|utmccn=(referral)|utmcmd=referral|utmcct=/PostView.nhn; WMONID=5FVd0GFvKXC; B2BDOMAIN=2387cae80c2cfca85d93e024d58424d97e3ba560a216b8f8ad8d9a0bb74d0bb0;{$sid}__utma=220622919.595398913.1522686914.1526827557.1527221497.7; __utmc=220622919; __utmt=1; __utmb=220622919.7.10.1527221497; ContentLogSeq=86234919",
	    "origin: https://dchs.ipacademy.net",
	    "postman-token: 6b6ca3e1-6db0-e2e0-6952-8a83630d2136",
	    "referer: https://dchs.ipacademy.net/Files/LectureContents2/C0000000938/02/02_01.html",
	    "user-agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/66.0.3359.181 Safari/537.36"
	  ),
	));

	$response = curl_exec($curl);
	$err = curl_error($curl);
	$info = curl_getinfo($curl);

	curl_close($curl);

	if ($err) {
	  echo "cURL Error #:" . $err;
	} else {
	  ob_echo($info['total_time']. 'sec<br>'. $info['url']);
	}
}

function get_study_name($num){
	switch ($num) {
		case '6':
			return "[6월] 발명과 창의성(9)";
			break;
		case '7':
			return "[7월] 세상을 바꾼 발명(3)";
			break;
		case '8':
			return "[8월] 저작권과 친구될래요(3)";
		break;
	}
}

function ob_echo($string){
	echo $string;
	echo "<br>";
	echo "<script>document.body.scrollTop = document.body.scrollHeight;</script>";
	echo str_pad('', 4096);

	ob_flush();
	flush();
}

if(!isset($_POST["form_id"]) || !isset($_POST["form_pw"]) || !isset($_POST["class"])){
	echo "ERROR.";
	ob_echo("<br><span onClick=\"window.parent.location.reload()\" style=\"color: blue; cursor: pointer\">뒤로가기</span>");
	exit();
}

ob_start();
ob_echo("<style type=\"text/css\">@import url('https://fonts.googleapis.com/css?family=Nanum+Gothic+Coding&subset=korean');body{font-family: 'NanumSquare', sans-serif;overflow-x: hidden;}::-webkit-scrollbar{width: 10px;}::-webkit-scrollbar-track{background: #f0f0f0;}::-webkit-scrollbar-thumb{background: #ccc;}::-webkit-scrollbar-thumb:hover {background: #999;}</style>");
ob_echo("## IPSC MACRO 18.06.16 ##");
ob_echo("## (c) 2018 Yang-Jun-Young ##");
ob_echo("#");
ob_echo("** 새로고침 혹은 페이지 이동 시 정상 작동하지 않을 수 있습니다.");
ob_echo("#");
ob_echo("** 계정 정보는 어떠한 곳에도 저장되지 않습니다.");
ob_echo("#");
ob_echo("## 로그인 시도 중...");

$c_response = login($_POST["form_id"], $_POST["form_pw"]);

if(stristr($c_response, "document.redirect.submit();")) {
	ob_echo("## 로그인 성공.");

	preg_match_all('/^Set-Cookie:\s*([^;]*)/mi', $c_response, $matches);
	$cookies = array();
	foreach($matches[1] as $item) {
	    parse_str($item, $cookie);
	    $cookies = array_merge($cookies, $cookie);
	}
	$sid = "ssoUK={$cookies['ssoUK']}; sso.ID={$cookies['sso_ID']}; JSESSIONID={$cookies['JSESSIONID']};";

	ob_echo("#");
	ob_echo("## 작업을 시작합니다.");
	ob_echo("## 선택한 강좌: ".get_study_name($_POST["class"]));
	ob_echo("## 작업 진행 중에 창을 닫을 경우 작업이 중단 될 수 있습니다.");
	ob_echo("#");
	sleep(4);

	ipsc_study($_POST["class"], $sid);

	ob_echo("#");
	ob_echo("## 작업을 완료했습니다.");
	ob_echo("## 창을 닫으셔도 됩니다.");
	ob_echo("<span onClick=\"window.parent.location.reload()\" style=\"color: blue; cursor: pointer\">뒤로가기</span>");
} else {
	ob_echo("** 아이디 혹은 비밀번호가 일치하지 않습니다.");
	ob_echo("<span onClick=\"window.parent.location.reload()\" style=\"color: blue; cursor: pointer\">뒤로가기</span>");
}
ob_end_flush();