<?php
/**
 * 添加用户的操作
 * @return string
 */
function addUser($arr){
	if(insert("user",$arr)){
		$email['title'] = "会员注册成功 - 上海研鼎信息技术有限公司欢迎您";
		$email['content'] = "亲爱的".$arr['nickname']."：<br/>
			感谢您在我站注册了新帐号。<br/>
			请点击链接激活您的帐号。<br/><a href='http://www.yandingtech.com/active.php?verify=".$arr['token']."' target='_blank'>http://www.yandingtech.com/active.php?verify=".$arr['token']."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接30分钟内有效。<br/>
			如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'></p>
		";
		$email['user_email'] = $arr['user_email'];
		$res = regMail($email);
		$mes = 1;
	}else{
		$mes = -1;
	}
	return $mes;
}

/**
 * 重新发送邮件操作
 * @return string
 */
function resetMail($arr){
	$user = fetchOne("select id,user_email,nickname,token from user where user_email='{$arr['user_email']}'");
	$user['regtime'] = time();
	$user['token'] = md5($user['user_email'] .$user['regtime']); //创建用于激活识别码
	$user['token_exptime'] = time()+30*60;//过期时间为30分钟后
	if(update('user', $user ,"id={$user['id']}")){
		$email['title'] = "重新设置您的密码";
		$email['user_email'] = $user['user_email'];
		$email['content'] = "亲爱的".$user['nickname']."：<br/>
			请点击链接设置密码。<br/><a href='http://www.yandingtech.com/active.php?verify=".$user['token']."' target='_blank'>http://www.yandingtech.com/active.php?verify=".$user['token']."</a><br/>如果以上链接无法点击，请将它复制到你的浏览器地址栏中进入访问，该链接30分钟内有效。<br/>
			如果此次激活请求非你本人所发，请忽略本邮件。<br/><p style='text-align:right'></p>
		";
		$res = regMail($email);
		$mes = 1;
	}else{
		$mes = 1;
	}
	return $mes;
}

/**
 * 注册邮件
 * @param array $arr
 * @return boolean
 */
function regMail($email){
	$mail = new MySendMail();
	//$mail->setServer("smtp@126.com", "XXXXX@126.com", "XXXXX"); //设置smtp服务器，普通连接方式
	$mail->setServer("smtp.exmail.qq.com", "webmaster@rdbuy.com", "YanDingWeb2016", 465, true); //设置smtp服务器，到服务器的SSL连接
	$mail->setFrom("webmaster@rdbuy.com"); //设置发件人
	$mail->setReceiver("{$email['user_email']}"); //设置收件人，多个收件人，调用多次
	// $mail->setCc("XXXX"); //设置抄送，多个抄送，调用多次
	// $mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
	// $mail->addAttachment("XXXX"); //添加附件，多个附件，调用多次
	$mail->setMail("{$email['title']}", "<b>{$email['content']}</b>"); //设置邮件主题、内容
	$result = $mail->sendMail(); //发送
	return $result;
}

/**
 * 导出用户信息
 */
function exportUser(){
	$name='用户列表';    //生成的Excel文件文件名
	$sheet = "user";  //生成excel的sheet名
	$sql = "select * from user where 1";
	$data = fetchAll($sql);
	$res=export($data,$name,$sheet);
}



