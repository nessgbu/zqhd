<?php
function get_php_file($filename) {
    return trim(substr(file_get_contents($filename), 15));
}
function set_php_file($filename, $content) {
    $fp = fopen($filename, "w");
    fwrite($fp, "<?php exit();?>" . $content);
    fclose($fp);
}
function wxGetCode($appid,$scope)
{
	// $redirect_uri = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'].$_SERVER['QUERY_STRING']);
	$redirect_uri = urlencode('http://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
	$url = "https://open.weixin.qq.com/connect/oauth2/authorize?appid=$appid&redirect_uri=$redirect_uri&response_type=code&scope=$scope&state=STATE#wechat_redirect";
	header("Location:$url");
	exit;
}

function wxGetUserFollowState($openid){
	$config = config('xcxconf');
    $appid = $config['appid'];
    $secret = $config['secret'];
    $accessToken = wxGetAccessTokenByCgiBin($appid,$secret);

    $url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$accessToken&openid=$openid";

    $jsonRes = curlGet($url);
    $res = json_decode($jsonRes);
    return $res;
}

function wxGetAccessToken($appid,$secret,$code)
{
	$url = "https://api.weixin.qq.com/sns/oauth2/access_token?appid=$appid&secret=$secret&code=$code&grant_type=authorization_code";
	$jsonRes = curlGet($url);
	$res = json_decode($jsonRes);
	return $res;
}

function wxGetUserInfoByOpenid($openid,$access_token,$lang = 'zh_CN')
{
	$url = "https://api.weixin.qq.com/sns/userinfo?access_token=$access_token&openid=$openid&lang=$lang";
	$jsonRes = curlGet($url);
	$res = json_decode($jsonRes);
	return $res;
}
function wxGetUserOpenId()
{
	$config = config('xcxconf');
	$appid = $config['appid'];
	$secret = $config['secret'];
	$scope = 'snsapi_base';
	$getcode = input('get.code');
	if (!isset($getcode)) {
		wxGetCode($appid,$scope);
		return false;
	}else{
		$code = input('get.code');
		$res = wxGetAccessToken($appid,$secret,$code);
		return $res->openid;
	}
}
function wxGetUserInfo()
{
	$config = config('xcxconf');
	$appid = $config['appid'];
	$secret = $config['secret'];
	$scope = 'snsapi_userinfo';
	$getcode = input('get.code');
	if (!isset($getcode)) {
		wxGetCode($appid,$scope);
		return false;
	}else{
		$code = input('get.code');
		$res = wxGetAccessToken($appid,$secret,$code);
		$access_token = $res->access_token;
		$openid = $res->openid;
		$res = wxGetUserInfoByOpenid($openid,$access_token);
		return $res;
	}
}

function wxGetAccessTokenByCgiBin($appid,$secret)
{
	$data = json_decode(get_php_file("cgi_bin_access_token.php"));
	if ($data && $data->expire_time > time()) {
		return $data->access_token;
	}else{
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$secret";
		$jsonRes = curlGet($url);
		$res = json_decode($jsonRes);
		$newData['access_token'] = $res->access_token;
		$newData['expire_time'] = time()+7000;
		set_php_file("cgi_bin_access_token.php", json_encode($newData));
		return $newData['access_token'];
	}
}
function wxGetUserInfoByOpenidByCgiBin($openid = '')
{
	$config = config('xcxconf');
	if (!$openid) {
		$openid = wxGetUserOpenId();
	}
	$access_token = wxGetAccessTokenByCgiBin($config['appid'],$config['secret']);
	$url = "https://api.weixin.qq.com/cgi-bin/user/info?access_token=$access_token&openid=$openid&lang=zh_CN";
	$jsonRes = curlGet($url);
	$res = json_decode($jsonRes);
	return $res;
}
function sendTemplateMessage($data)
{
	$config = config('xcxconf');
	$access_token = wxGetAccessTokenByCgiBin($config['appid'],$config['secret']);
	$url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=$access_token";
	$post = array(
		'touser' => $data['open_id'],//这个是openid
		'template_id' => $data['type'],//模板ID号
		'url' => $data['truckid'],//跳转地址
		'data' => $data['msg'],
	);
	$jsonRes = curlPost($url,json_encode($post));
	$res = json_decode($jsonRes);
	// var_dump($res);
}
function TMJ_wxGetUserInfo()
{
  if(I('get.openid')){
        $userinfo = I('get.');
        $userinfo = json_decode(json_encode($userinfo));
        return $userinfo;
    }else{
        $url = "http://tplib.jctmj.net/WxdkDemo/index/index?url=".$_SERVER['REQUEST_SCHEME']."://".$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI'];
        header("Location: ".$url);
    }
}
?>