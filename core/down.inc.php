<?php
//添加下载信息
function addDown(){
	$arr=$_POST;
// 	var_dump($arr);
	$arr['pubTime']=time();
	$pNum = implode("','", explode(",", $arr['pNum']));
	if ($arr['down_cate']==1) {
		if ($arr['product']==0) {
			return alertMes("下载内容分类为产品时，产品类型必须选择一项", "addDown.php");
		}else {
			if (empty($pNum)) {
				return alertMes("下载内容分类为产品时，对应产品型号不能为空", "addDown.php");
			}else {
				//判断商品是否属于同一个品牌
				$bra = fetchAll("select distinct(bra_cName) from product p join brand_cate b on p.bra_cId=b.id where p.pNum in ('{$pNum}')");
				if (count($bra)>1) {
					return alertMes("产品属于不同的品牌，请分开添加", "addDown.php");
				}elseif (count($bra)==0){
					return alertMes("产品不存在", "addDown.php");
				}else {
					$arr['bra_cName'] = $bra[0]['bra_cName'];
				}
			}
		}
	}elseif ($arr['down_cate']==2&&empty($arr['tech_title'])){
		return alertMes("下载内容分类为技术文章时，技术文章名称不能为空", "addDown.php");
	}elseif ($arr['down_cate']==3&&$arr['service']==0){
		return alertMes("下载内容分类为售后服务时，售后服务类型必须选择一项", "addDown.php");
	}

	$path="../file";
	$uploadFiles=uploadDown($path);
	
	$res=insert("download",$arr);
	$did=getInsertId();
	
	if($res&&$did){
		foreach($uploadFiles as $uploadFile){
			$arr1['did']=$did;
			$arr1['filePath']=$uploadFile['name'];
			addFile($arr1);
		}
		addOperate(getUserName(),'download','add',$did);
		$mes="<p>添加成功!</p><a href='addDown.php' target='mainFrame'>继续添加</a>|<a href='listDown.php' target='mainFrame'>查看下载文件列表</a>";
	}
	else{
		foreach($uploadFiles as $uploadFile){
			if(file_exists($path ."/".$uploadFile['name'])){
				unlink($path ."/" .$uploadFile['name']);
			}
		}
		$mes="<p>添加失败!</p><a href='addDown.php' target='mainFrame'>重新添加</a>";

	}
	return $mes;
}

/**
 * 删除下载信息
 * @param int $id
 * @return string
 */
function delDown($id){
	$res = delete("download","id={$id}");
	$files = getFileByDid($id);
	if ($files&&is_array($files)) {
		foreach ($files as $file){
			if (file_exists("../file/" .$file['filePath'])) {
				unlink("../file/" .$file['filePath']);
			}
		}
	}
	$where1 = "did={$id}";
	$res1 = delete('file',$where1);
	if ($res) {
		addOperate(getUserName(),'download','del',$id);
		$mes = "删除成功！<br/><a href='listDown.php' target='mainFrame'>查看下载列表</a>";
	}else {
		$mes = "删除失败！<br/><a href='listDown.php' target='mainFrame'>重新删除</a>";
	}
	return $mes;
	
}

function getDownById($id){
	$down = fetchOne("select * from download where id={$id}");
	return $down;
}

function editDown($id){
	$arr=$_POST;
	$arr['pubTime']=time();
	$pNum = implode("','", explode(",", $arr['pNum']));
	if ($arr['down_cate']==1) {
		if ($arr['product']==0) {
			return alertMes("下载内容分类为产品时，产品类型必须选择一项", "addDown.php");
		}else {
			if (empty($pNum)) {
				return alertMes("下载内容分类为产品时，对应产品型号不能为空", "addDown.php");
			}else {
				//判断商品是否属于同一个品牌
				$bra = fetchAll("select distinct(bra_cName) from product p join brand_cate b on p.bra_cId=b.id where p.pNum in ('{$pNum}')");
				if (count($bra)>1) {
					return alertMes("产品属于不同的品牌，请分开添加", "addDown.php");
				}elseif (count($bra)==0){
					return alertMes("产品不存在", "addDown.php");
				}else {
					$arr['bra_cName'] = $bra[0]['bra_cName'];
				}
			}
		}
	}elseif ($arr['down_cate']==2&&empty($arr['tech_title'])){
		return alertMes("下载内容分类为技术文章时，技术文章名称不能为空", "addDown.php");
	}elseif ($arr['down_cate']==3&&$arr['service']==0){
		return alertMes("下载内容分类为售后服务时，售后服务类型必须选择一项", "addDown.php");
	}
	
	$path="../file";
	$uploadFiles=uploadDown($path);
	
	
	$res=update("download",$arr,"id={$id}");
	$did=$id;
	if($res&&$did){
		if (is_array($uploadFiles)&&$uploadFiles) {
			foreach($uploadFiles as $uploadFile){
				$arr1['did']=$did;
				$arr1['filePath']=$uploadFile['name'];
				addFile($arr1);
			}
		}
		addOperate(getUserName(),'download','edit',$did);
		$mes="<p>编辑成功!</p><a href='listDown.php' target='mainFrame'>查看下载列表</a>";
	}else{
		if (is_array($uploadFiles)&&$uploadFiles) {
			foreach($uploadFiles as $uploadFile){
				if(file_exists($path ."/" .$uploadFile['name'])){
					unlink($path ."/" .$uploadFile['name']);
				}
			}
			$mes="<p>编辑失败!</p><a href='listDown.php' target='mainFrame'>重新编辑</a>";
		}
	}
	return $mes;
}

/**
 * 根据品牌名称获得对应的产品软件信息
 * @param unknown $bra_cName
 * @return Ambigous <multitype:, unknown>
 */
function getDownSoftByBra($bra_cName,$search){
	$pNum = fetchAll("select pNum,soft_password,soft_link from download where down_cate=1 and product=2 and bra_cName='{$bra_cName}'");
// 	var_dump($pNum);
	$soft = $soft1 = array();
	foreach ($pNum as $_pNum){
		$num = implode("','", explode(",", $_pNum['pNum']));
		$where = "";
		if (!empty($search)) {
			$where .= "and pName like '%{$search}%'";
		}
		$soft1 = fetchAll("select p.pName from product p join download d on p.pNum in('{$num}') {$where}");

		foreach ($soft1 as $_soft1){
			$v = implode(",", $_soft1);
			$temp[] = $v;
		}
		$temp = array_unique($temp);
		foreach ($temp as $_temp){
			$temp1['soft_password'] = $_pNum['soft_password'];
			$temp1['soft_link'] = $_pNum['soft_link'];
			$temp1['pName'] = $_temp;
			$soft[] = $temp1;

		}
		unset($temp);
	}
	return $soft;
}

/**
 * 根据品牌名称获得对应的产品文档信息
 * @param unknown $bra_cName
 */
function getFileByBra($bra_cName,$search){
	$where = "";
	if (!empty($search)) {
		$where .=" and filePath like '%{$search}%'";
	}
	$sql = "select f.filePath from file f join download d on f.did=d.id where down_cate=1 and product=1 and bra_cName='{$bra_cName}' {$where}";
	$file = fetchAll($sql);
	return $file;
}