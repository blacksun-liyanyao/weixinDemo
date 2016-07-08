<?php
// 本类由系统自动生成，仅供测试用途
class IndexAction extends Action {
    public function index(){
	//获得参数 signature nonce token timestamp echostr
		$nonce     = $_GET['nonce'];
		$token     = 'metalyun';
		$timestamp = $_GET['timestamp'];
		$echostr   = $_GET['echostr'];
		$signature = $_GET['signature'];
		//形成数组，然后按字典序排序
		$array = array();
		$array = array($nonce, $timestamp, $token);
		sort($array);
		//拼接成字符串,sha1加密 ，然后与signature进行校验
		$str = sha1( implode( $array ) );
		if( $str  == $signature && $echostr ){
			//第一次接入weixin api接口的时候
			echo  $echostr;
			exit;
		}else{
			$this->reponseMsg();
		}
	}
	public function sucai(){
		header("Content-type: text/html; charset=utf-8"); 
		$url = "https://api.weixin.qq.com/cgi-bin/material/batchget_material?access_token=dzKb4A2lzlyqgrJQDS5SwkNKulC-1KmBfCxbvm_jiVpimBXpwagGPdoh0ZK-W7Y64qpLFeRj6N3lF5Ps_z5rEkJ0JlMUP0dNTKg9FopB63kKVPaAJANYS";
		$params ='{
						"type":"news",
						"offset":0,
						"count":20
						}';
		$indexModel = new IndexModel;
		$result = $indexModel->sendpost($url,$params);
		$res_code = json_decode($result,true);
		dump($res_code);
	}
	public function buttons(){
		header("Content-type: text/html; charset=utf-8"); 
		$button = '{
				     "button":[
				     {	
				          "type":"view",
			              "name":"关于魅拓",
			              "url":"http://www.metalyun.com/ThinkPHP/imooc.php/Product/product"
				      },
				      {	
				          "type":"view",
				          "name":"掌上商城",
				          "url":"http://mp.weixin.qq.com/bizmall/mallshelf?id=&t=mall/list&biz=MzIyODAxNzAxNw==&shelf_id=2&showwxpaytitle=1&uin=MTA1NDgzMzU4MA%3D%3D&key=ff7411024a07f3ebdf3532dba40f3145bbc1915a7b982428f9b61b819526f2066dd24e0985f8b1f014b52ce55b81b057&devicetype=android-18&version=26030735&lang=zh_CN&pass_ticket=M4tmB0R4Av3Ab4oT9Mba80wQpgEtcpQ6vKPCwWNv666vPYYvEaacC0TbGeVSvVjZ"
				      },
				       {
			           "name":"加入魅拓",
			           "sub_button":[
			           {	
			                 "type": "media_id", 
					          "name": "我是工厂", 
					          "media_id": "7P-PTiwKcgB4oc0HaQdf5ifT4NLTtGwghMgUdKwCovc"
			            },
			            {
			               "type": "media_id", 
					          "name": "我是商家", 
					          "media_id": "7P-PTiwKcgB4oc0HaQdf5hcyTIPGnlobl0ub1uou56E"
			            },
			            {
			               "type": "media_id", 
					          "name": "我是设计", 
					          "media_id": "7P-PTiwKcgB4oc0HaQdf5gtP7ZoUpLWZdWazDnMW3uw"
			            },
			            {
			               "type": "media_id", 
					          "name": "我要应聘", 
					          "media_id": "7P-PTiwKcgB4oc0HaQdf5rTPd6oxtMc5RNWuonJVLsU"
			            }]
				     ]
				 }';
				 $url = "https://api.weixin.qq.com/cgi-bin/menu/create?access_token=dzKb4A2lzlyqgrJQDS5SwkNKulC-1KmBfCxbvm_jiVpimBXpwagGPdoh0ZK-W7Y64qpLFeRj6N3lF5Ps_z5rEkJ0JlMUP0dNTKg9FopB63kKVPaAJANYS";
				 $indexModel = new IndexModel;
				$result = $indexModel->sendpost($url,$button);
				 $res = json_decode($result,true);
				 dump($res);
	}
	public function reponseMsg(){
		//1.获取到微信推送过来post数据（xml格式）
		$postArr = $GLOBALS['HTTP_RAW_POST_DATA'];
		$postObj = simplexml_load_string( $postArr );
		if( strtolower( $postObj->MsgType) == 'event'){
			//如果是关注 subscribe 事件
			if( strtolower($postObj->Event == 'subscribe') ){
				//回复用户消息(纯文本格式)	
				$content = "感谢您关注魅拓微信，在这里可以查看魅拓动态，购买只为您提供的掌上商城产品精选。未来还将提供更多功能与服务，12月22日开始内测，即刻发送“用户”或“设计师”则可获得相应内测资格，赶快行动吧~~
";
				$indexModel = new IndexModel();
				$indexModel->responseText($postObj, $content);
			}
		}
		//2.处理消息类型，并设置回复类型和内容
		if( strtolower($postObj->MsgType) == 'text' && trim($postObj->Content)=='tuwen2' ){
			$arr = array(
				array(
					'title'=>'imooc',
					'description'=>"imooc is very cool",
					'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
					'url'=>'http://www.imooc.com',
				),
				array(
					'title'=>'hao123',
					'description'=>"hao123 is very cool",
					'picUrl'=>'https://www.baidu.com/img/bdlogo.png',
					'url'=>'http://www.hao123.com',
				),
				array(
					'title'=>'qq',
					'description'=>"qq is very cool",
					'picUrl'=>'http://www.imooc.com/static/img/common/logo.png',
					'url'=>'http://www.qq.com',
				)
			);
			$indexModel = new IndexModel;
			$indexModel->responseNews($postObj,$arr);
		}else{
			// switch( trim($postObj->Content) ){
			// 	case 1:
			// 		$content = '您输入的数字是1';
			// 	break;
			// 	case 2:
			// 		$content = '您输入的数字是2';
			// 	break;
			// 	case 3:
			// 		$content = '您输入的数字是3';
			// 	break;
			// 	case 4:
			// 		$content = "<a href='http://www.imooc.com'>慕课</a>";
			// 	break;
			// 	case '英文':
			// 		$content = 'imooc is ok';
			// 	break;
			// 	default:
			// 		$content = '没有找到相关信息';
			// 	break;
			// }	
			// $ch = curl_init();
		 //    $url = 'http://apis.baidu.com/apistore/weatherservice/cityname?cityname='.$postObj->Content;
		 //    $header = array(
		 //        'apikey: 51798d43eb21be05e053896f21793f01',
		 //    );
		 //    // 添加apikey到header
		 //    curl_setopt($ch, CURLOPT_HTTPHEADER  , $header);
		 //    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
		 //    // 执行HTTP请求
		 //    curl_setopt($ch , CURLOPT_URL , $url);
		 //    $res = curl_exec($ch);
		 //    $arr = json_decode($res,true);
		 //    $content = $arr['retData']['city']."\n".$arr['retData']['weather']."\n"
		 //    .$arr['retData']['temp']."度";
			// $indexModel = new IndexModel;
			// $indexModel->responseText($postObj,$content);
		}//if end
	}
	function getWxAccessToken(){
		//1.请求url地址
		$appid = 'wxaa40a8579e58adb2';
		$appsecret =  '43902108883dd247f1a46c9bff16e012';
		$url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=".$appid."&secret=".$appsecret;
		//2初始化
		$ch = curl_init();
		//3.设置参数
		curl_setopt($ch , CURLOPT_URL, $url);
		curl_setopt($ch , CURLOPT_RETURNTRANSFER, 1);
		//4.调用接口 
		$res = curl_exec($ch);
		//5.关闭curl
		curl_close( $ch );
		if( curl_errno($ch) ){
			var_dump( curl_error($ch) );
		}
		$arr = json_decode($res, true);
		var_dump( $arr );
	}	

	function getWxServerIp(){
		$accessToken = "JgozJaeTW7nJgRrD9mh6mnNrH5kLMIeLIIDup3cr1xYtr2donjFtPZOov8-y10V8rj0ajK4n4Yv9sW5YbDUXTW41_UeM9R8tn-3V3zz5vGwAQMfAHALBX";
		$url = "https://api.weixin.qq.com/cgi-bin/getcallbackip?access_token=".$accessToken;
		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		$res = curl_exec($ch);
		curl_close($ch);
		if(curl_errno($ch)){
			var_dump(curl_error($ch));
		}
		$arr = json_decode($res,true);
		echo "<pre>";
		var_dump( $arr );
		echo "</pre>";
	}
}
	//当微信用户发送imooc，公众账号回复‘imooc is very good'
		/*<xml>
<ToUserName><![CDATA[toUser]]></ToUserName>
<FromUserName><![CDATA[fromUser]]></FromUserName>
<CreateTime>12345678</CreateTime>
<MsgType><![CDATA[text]]></MsgType>
<Content><![CDATA[你好]]></Content>
</xml>*/
// 		if(strtolower($postObj->MsgType) == 'text'){
// 			switch( trim($postObj->Content) ){
// 				case 1:
// 					$content = '您输入的数字是1';
// 				break;
// 				case 2:
// 					$content = '您输入的数字是2';
// 				break;
// 				case 3:
// 					$content = '您输入的数字是3';
// 				break;
// 				case 4:
// 					$content = "<a href='http://www.imooc.com'>慕课</a>";
// 				break;
// 				case '英文':
// 					$content = 'imooc is ok';
// 				break;

// 			}	
// 				$template = "<xml>
// 							<ToUserName><![CDATA[%s]]></ToUserName>
// 							<FromUserName><![CDATA[%s]]></FromUserName>
// 							<CreateTime>%s</CreateTime>
// 							<MsgType><![CDATA[%s]]></MsgType>
// 							<Content><![CDATA[%s]]></Content>
// 							</xml>";
// //注意模板中的中括号 不能少 也不能多
// 				$fromUser = $postObj->ToUserName;
// 				$toUser   = $postObj->FromUserName; 
// 				$time     = time();
// 				// $content  = '18723180099';
// 				$msgType  = 'text';
// 				echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
			
// 		}
