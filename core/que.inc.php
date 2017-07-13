<?php
/**
 * 添加提问信息的操作
 * @return string
 */
function addQues(){
	$arr=$_POST;
	$arr['time'] = time();
	if(insert("question",$arr)){
		$res = sendMail($arr);
		addOperate(getUserName(),'question','add',getInsertId());
		alertMes("提交成功", "../contactUs.php");
	}else{
		alertMes("提交失败", "../contactUs.php");
	}
}

/**
 *删除提问信息
 * @param string $where
 * @return string
 */
function delQues($id){
	$where="id=".$id;
	if(delete("question",$where)){
		addOperate(getUserName(),'question','del',$id);
		$mes="删除成功!<br/><a href='listQue.php'>查看提问信息</a>";
	}else{
		$mes="删除失败！<br/><a href='listQue.php'>请重新操作</a>";
	}
	return $mes;

}
/**
 * 发送邮件
 * @param array $arr
 * @return boolean
 */
function sendMail($arr){
	$content = "咨询时间：" .date("Y-m-d H:i:s",$arr['time']) ."<br>".
			   "姓名：{$arr['username']}<br>
				电话：{$arr['phone']}<br>
				电子邮箱:{$arr['email']}<br>
				公司名称：{$arr['company']}<br>
				地址：{$arr['address']}<br>
				商品名称：{$arr['pName']}<br>
				具体要求：{$arr['remark']}	            
	";
	$mail = new MySendMail();
	//$mail->setServer("smtp@126.com", "XXXXX@126.com", "XXXXX"); //设置smtp服务器，普通连接方式
	$mail->setServer("smtp.exmail.qq.com", "webmaster@rdbuy.com", "YanDingWeb2016", 465, true); //设置smtp服务器，到服务器的SSL连接
	$mail->setFrom("webmaster@rdbuy.com"); //设置发件人
	$mail->setReceiver("sales@rdbuy.com"); //设置收件人，多个收件人，调用多次
	// $mail->setCc("XXXX"); //设置抄送，多个抄送，调用多次
	// $mail->setBcc("XXXXX"); //设置秘密抄送，多个秘密抄送，调用多次
	// $mail->addAttachment("XXXX"); //添加附件，多个附件，调用多次
	$mail->setMail("联系我们：{$arr['username']}提问", "<b>{$content}</b>"); //设置邮件主题、内容
	$result = $mail->sendMail(); //发送
	return $result;
}