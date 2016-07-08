<?php
class IndexModel{
	//回复多图文类型的微信消息
	public function responseNews($postObj ,$arr){
		$toUser = $postObj->FromUserName;
		$fromUser = $postObj->ToUserName;
		$template = "<xml>
					<ToUserName><![CDATA[%s]]></ToUserName>
					<FromUserName><![CDATA[%s]]></FromUserName>
					<CreateTime>%s</CreateTime>
					<MsgType><![CDATA[%s]]></MsgType>
					<ArticleCount>".count($arr)."</ArticleCount>
					<Articles>";
		foreach($arr as $k=>$v){
			$template .="<item>
						<Title><![CDATA[".$v['title']."]]></Title> 
						<Description><![CDATA[".$v['description']."]]></Description>
						<PicUrl><![CDATA[".$v['picUrl']."]]></PicUrl>
						<Url><![CDATA[".$v['url']."]]></Url>
						</item>";
		}
		
		$template .="</Articles>
					</xml> ";
		echo sprintf($template, $toUser, $fromUser, time(), 'news');
	}

	// 回复单文本
	public function responseText($postObj,$content){
		$template = "<xml>
		<ToUserName><![CDATA[%s]]></ToUserName>
		<FromUserName><![CDATA[%s]]></FromUserName>
		<CreateTime>%s</CreateTime>
		<MsgType><![CDATA[%s]]></MsgType>
		<Content><![CDATA[%s]]></Content>
		</xml>";
		//注意模板中的中括号 不能少 也不能多
		$fromUser = $postObj->ToUserName;
		$toUser   = $postObj->FromUserName; 
		$time     = time();
		$msgType  = 'text';
		echo sprintf($template, $toUser, $fromUser, $time, $msgType, $content);
	}

	//回复微信用户的关注事件
	public function responseSubscribe($postObj, $arr){
		
		$this->responseNews($postObj,$arr);
	}
	public function sendpost($url ,$params, $header = array()){
		$ch = curl_init();	// 初始化CURL句柄
        curl_setopt($ch, CURLOPT_URL, $url);	//设置请求的URL
        curl_setopt($ch, CURLOPT_POST, 1);	//启用POST提交
        curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);		// 设为TRUE把curl_exec()结果转化为字串，而不是直接输出
        $postdata = $params;		//请求参数数组转化为以‘&’分隔的字符串
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);	//设置POST提交的请求参数
        curl_setopt($ch,CURLOPT_HTTPHEADER,$header);	//设置HTTP头信息
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);	//设置超时时间15秒
        $response = curl_exec($ch);	//执行预定义的CURL
        curl_close($ch);	//关闭CURL
        return $response;
	}
	//回复纯文本
}