<?php 
function alertMes($mes,$url){
	echo "<script>alert('{$mes}');</script>";
	echo "<script>window.location='{$url}';</script>";
}

function checkBrowser(){
	if((strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 8.0')||strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 7.0')||strpos($_SERVER['HTTP_USER_AGENT'], 'MSIE 6.0'))&&!strpos($_SERVER['HTTP_USER_AGENT'], 'Trident/7.0')) {
		echo '<script type="text/javascript">window.location="ieUpdate.php";</script>';
	}else{
		return ;
	}
}

function get_client_ip(){
	if(getenv('HTTP_CLIENT_IP')) {
		$ip = getenv('HTTP_CLIENT_IP');
	} elseif(getenv('HTTP_X_FORWARDED_FOR')) {
		$ip = getenv('HTTP_X_FORWARDED_FOR');
	} elseif(getenv('REMOTE_ADDR')) {
		$ip = getenv('REMOTE_ADDR');
	} else {
		$ip = $_SERVER['REMOTE_ADDR'];
	}
	return $ip;
}

function getUserName(){
	if(isset($_SESSION['adminName'])){
		$username = $_SESSION['adminName'];
	}elseif(isset($_COOKIE['adminName'])){
		$username = $_COOKIE['adminName'];
	}
	return $username;
}

//导出数据到excel
function export($data,$name="excel",$sheet="excel"){
	require_once '../plugins/PHPExcel/Classes/PHPExcel.php';
	
	$objPHPExcel = new PHPExcel();
	/*以下是一些设置 ，什么作者  标题啊之类的*/
	$objPHPExcel->getProperties()->setCreator(getUserName())
	->setTitle("数据EXCEL导出")
	->setSubject("数据EXCEL导出")
	->setDescription("备份数据")
	->setKeywords("excel")
	->setCategory("result file");
	/*以下就是对处理Excel里的数据， 横着取数据，主要是这一步，其他基本都不要改*/
	
	/*--------------设置表头信息------------------*/
	$objPHPExcel->setActiveSheetIndex(0)
	->setCellValue('A1', 'ID编号')
	->setCellValue('B1', '姓名')
	->setCellValue('C1', '昵称')
	->setCellValue('D1', '邮箱')
	->setCellValue('E1', '手机号码')
	->setCellValue('F1', '固定电话')
	->setCellValue('G1', '公司')
	->setCellValue('H1', '职责')
	->setCellValue('I1', '是否激活')
	->setCellValue('J1', '注册时间');
	foreach($data as $k => $v){
		$num=$k+2;
		if (!empty($v['dutyId'])) {
			$duty = fetchOne("select duty_name from user_duty where id={$v['dutyId']}");
		}
		$objPHPExcel->setActiveSheetIndex(0)
		//Excel的第A列，uid是你查出数组的键值，下面以此类推
		->setCellValue("A".$num, $v['id'])
		->setCellValue("B".$num, $v['user_name'])
		->setCellValue("C".$num, $v['nickname'])
		->setCellValue("D".$num, $v['user_email'])
		->setCellValue("E".$num, $v['user_mobile'])
		->setCellValue("F".$num, $v['user_telephone'])
		->setCellValue("G".$num, $v['company'])
		->setCellValue("H".$num, empty($duty)?"无":"{$duty['duty_name']}")
		->setCellValue("I".$num, $v['active']=="1"?"是":"否")
		->setCellValue("J".$num, date('Y-m-d H:i:s',$v['regtime']));
		unset($duty);
	}
	
	$objPHPExcel->getActiveSheet()->setTitle($sheet);
	$objPHPExcel->setActiveSheetIndex(0);
	header('Content-Type: application/vnd.ms-excel');
	header('Content-Disposition: attachment;filename="'.$name.'.xls"');
	header('Cache-Control: max-age=0');
	$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
	$objWriter->save('php://output');
	exit;

}
