<?php 
/**
 * 添加商品
 * @return string
 */
function addPro(){
	$arr=$_POST;
	$arr['pAbstract'] = addcslashes($arr['pAbstract'],"'");
	$arr['pDesc'] = addcslashes($arr['pDesc'],"'");
	$arr['pStandard'] = addcslashes($arr['pStandard'],"'");
	$mod = array();
	if (!empty($arr['model'])) {
		$length = count($arr['model']);
		$key=0;
		for ($i = 0; $i < $length; $i++) {
			if (!empty($arr['model'][$i])&&!empty($arr['partNum'][$i])) {
				$mod[$key]['model'] = $arr['model'][$i];
				$mod[$key]['partNum'] = $arr['partNum'][$i];
				$key++;
			}
		}
	}
	unset($arr['model']);
	unset($arr['partNum']);
	if (!empty($arr['small_cId'])) {
		$arr['big_cId'] = substr($arr['small_cId'], 0,3);
		$arr['small_cId'] = substr($arr['small_cId'], 3,3);
	}
	$show = fetchOne("select id from product where pShow={$arr['pShow']}");
	$recommend = fetchOne("select id from product where pRecommend={$arr['pRecommend']}");
	$arr['pubTime']=time();
	$path="./uploads";
	$uploadFiles=uploadFile($path);
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach($uploadFiles as $key=>$uploadFile){
			thumb($path."/".$uploadFile['name'],$path ."/image_50/".$uploadFile['name'],50,50);
		}
	}
	$res=insert("product",$arr);
	$pid=getInsertId();
	if (!empty($arr['pShow'])&&!empty($show)&&res) {
		update("product", array("pShow"=>0),"id={$show['id']}");
	}
	if (!empty($arr['pRecommend'])&&!empty($recommend)&&res) {
		update("product", array("pRecommend"=>0),"id={$recommend['id']}");
	}
	if($res&&$pid){
		foreach($uploadFiles as $uploadFile){
			$arrImg = fetchOne("select max(arrange) maxArr from album where pid={$pid}");
			if (empty($arrImg['maxArr'])) {
				$maxImg = 0;
			}else {
				$maxImg = $arrImg['maxArr'];
			}
			$arr1['pid']=$pid;
			$arr1['albumPath']=$uploadFile['name'];
			$arr1['arrange'] = $maxImg+1;
			addAlbum($arr1);
		}
		//验证输入的型号和料号是否已经存在
		$message = '';
		foreach ($mod as $_mod){
			$arrange = fetchOne("select max(arrange) maxArr from model where pid={$pid}");
			if (empty($arrange['maxArr'])) {
				$max = 0;
			}else {
				$max = $arrange['maxArr'];
			}
			$result = getModel($_mod['model'], $_mod['partNum']);
			if ($result==-4) {
				$message .= "型号为{$_mod['model']}的记录未添加成功，该型号已经存在<br>";
			}elseif ($result == -5) {
				$message .= "料号为{$_mod['partNum']}的记录未添加成功，该料号已经存在<br>";
			}else {
				$_mod['pid'] = $pid;
				$_mod['arrange'] = $max+1;
				addModel($_mod);
			}
		}
		addOperate(getUserName(),'product','add',$pid);
		$mes="<p>商品添加成功!</p><a href='addPro.php' target='mainFrame'>继续添加</a>|<a href='listPro.php' target='mainFrame'>查看商品列表</a><p>{$message}</p>";
	}else{
		foreach($uploadFiles as $uploadFile){
			if(file_exists($path ."/" .$uploadFile['name'])){
				unlink($path ."/" .$uploadFile['name']);
			}
			if(file_exists($path ."/image_50/".$uploadFile['name'])){
				unlink($path ."/image_50/".$uploadFile['name']);
			}
		}
		$mes="<p>添加失败!</p><a href='addPro.php' target='mainFrame'>重新添加</a>";
		
	}
	return $mes;
}



/**
 * 根据商品id得到该商品对应的图片
 * @param unknown $id
 * @return multitype:
 */
function getImgsByProId($id){
	$sql = "select * from album a where a.pid={$id} order by arrange asc";
	$rows = fetchAll($sql);
	return $rows;
}

/**
 * 根据商品id得到商品信息
 * @param int $id
 * @return multitype:
 */
function getProById($id){
	$sql = "select p.id,p.pName,p.pNum,p.rePNum,p.price,p.pAbstract,p.pDesc,
	p.pStandard,p.pubTime,p.pShow,p.pRecommend,p.big_cId,p.small_cId,p.bra_cId,p.view_times,
        bi.big_cName,s.small_cName,br.bra_cName from product as p 
		join big_cate bi on p.big_cId=bi.id 
		join small_cate s on p.small_cId=s.id
        join brand_cate br on p.bra_cId=br.id 
		where p.id={$id}";
	$row = fetchOne($sql);
	return $row;
}

function editPro($id){
	$arr=$_POST;
	$arr['pAbstract'] = addcslashes($arr['pAbstract'],"'");
	$arr['pDesc'] = addcslashes($arr['pDesc'],"'");
	$arr['pStandard'] = addcslashes($arr['pStandard'],"'");
	if (!empty($arr['model'])) {
		$length = count($arr['model']);
		$keyU = $keyA = 0;
		for ($i = 0; $i < $length; $i++) {
			if (!empty($arr['model'][$i])&&!empty($arr['partNum'][$i])) {
				$model = fetchOne("select id from model where pid={$id} and (model='{$arr['model'][$i]}' or partNum='{$arr['partNum'][$i]}')");
				if (!empty($model)) {
					$model_update[$keyU]['model'] = $arr['model'][$i];
				    $model_update[$keyU]['partNum'] = $arr['partNum'][$i];
				    $model_update[$keyU]['id'] = $model['id'];
				    $keyU++;
				}else {
					$model_add[$keyA]['model'] = $arr['model'][$i];
				    $model_add[$keyA]['partNum'] = $arr['partNum'][$i];
				    $keyA++;
				}
			}
		}
	}
	unset($arr['model']);
	unset($arr['partNum']);
	if (!empty($arr['small_cId'])&&strlen($arr['small_cId'])==6) {
		$arr['big_cId'] = substr($arr['small_cId'], 0,3);
		$arr['small_cId'] = substr($arr['small_cId'], 3,3);
	}
	if (!empty($arr['pShow'])) {
		$show = fetchOne("select id from product where pShow={$arr['pShow']}");
		if (!empty($show)) {
			update("product", array("pShow"=>0),"id={$show['id']}");
		}
	}
	if (!empty($arr['pRecommend'])) {
		$recommend = fetchOne("select id from product where pRecommend={$arr['pRecommend']}");
		if (!empty($recommend)) {
			update("product", array("pRecommend"=>0),"id={$recommend['id']}");
		}
	}
	$path="./uploads";
	$uploadFiles=uploadFile($path);
	if(is_array($uploadFiles)&&$uploadFiles){
		foreach($uploadFiles as $key=>$uploadFile){
			thumb($path."/".$uploadFile['name'],$path ."/image_50/".$uploadFile['name'],50,50);
		}
	}
	$res=update("product",$arr,"id={$id}");
	$pid=$id;
	if($pid&&$res){
		if (is_array($uploadFiles)&&$uploadFiles) {
			foreach($uploadFiles as $uploadFile){
				$arrImg = fetchOne("select max(arrange) maxArr from album where pid={$pid}");
				if (empty($arrImg['maxArr'])) {
					$maxImg = 0;
				}else {
					$maxImg = $arrImg['maxArr'];
				}
				$arr1['pid']=$pid;
				$arr1['albumPath']=$uploadFile['name'];
				$arr1['arrange'] = $maxImg+1;
				addAlbum($arr1);
			}
		}
		//验证输入的型号和料号是否已经存在
		$message = '';
		foreach ($model_update as $_mod_update){
			//$result = getModel($_mod['model'], $_mod['partNum']);
			$result= update('model',$_mod_update,"id={$_mod_update['id']}");
			if (!$result) {
				$message .= "型号为{$_mod_update['model']}的记录未更新成功<br>";
			}else {
				$message .= "型号为{$_mod_update['model']}的记录更新成功<br>";
			}
		}
		foreach ($model_add as $_mod_add){
			$result = getModel($_mod_add['model'], $_mod_add['partNum']);
			$arrange = fetchOne("select max(arrange) maxArr from model where pid={$pid}");
			if (empty($arrange['maxArr'])) {
				$max = 0;
			}else {
				$max = $arrange['maxArr'];
			}
			if ($result==-4) {
				$message .= "型号为{$_mod_add['model']}的记录未添加成功，该型号已经存在<br>";
			}elseif ($result == -5) {
				$message .= "料号为{$_mod_add['partNum']}的记录未添加成功，该料号已经存在<br>";
			}else {
				$_mod_add['pid'] = $pid;
				$_mod_add['arrange'] = $max+1;
				$result_add = addModel($_mod_add);
				if ($result_add) {
					$message .= "型号为{$_mod_add['model']}的记录添加成功<br>";
				}else {
					$message .= "型号为{$_mod_add['model']}的记录未添加成功<br>";
				}
			}
		}
		addOperate(getUserName(),'product','edit',$pid);
		$mes="<p>编辑成功!</p><a href='listPro.php' target='mainFrame'>查看商品列表</a><p>{$message}</p>";
	}else{
		if (is_array($uploadFiles)&&$uploadFiles) {
			foreach($uploadFiles as $uploadFile){
				if (file_exists("uploads/" .$uploadFile['albumPath'])) {
					unlink("uploads/" .$uploadFile['albumPath']);
				}
				if(file_exists("../image_50/".$uploadFile['name'])){
					unlink($path ."/image_50/".$uploadFile['name']);
				}
			}
		}
		$mes="<p>编辑失败!</p><a href='listPro.php' target='mainFrame'>重新编辑</a>";
		
	}
	return $mes;
}

function delPro($id){
	$res = delete("product","id={$id}");
	$proImgs = getImgsByProId($id);
	if ($proImgs&&is_array($proImgs)) {
		foreach ($proImgs as $proImg){
			if (file_exists("uploads/" .$proImg['albumPath'])) {	
				unlink("uploads/" .$proImg['albumPath']);
			}
			if (file_exists("uploads/image_50/" .$proImg['albumPath'])) {
				unlink("uploads/image_50/" .$proImg['albumPath']);
			}
		}
	}
	$where1 = "pid={$id}";
	$res1 = delete('album',$where1);
	$res2 = delete("model",$where1);
	if ($res) {
		addOperate(getUserName(),'product','del',$id);
		$mes = "删除成功！<br/><a href='listPro.php' target='mainFrame'>查看商品列表</a>";
	}else {
		$mes = "删除失败！<br/><a href='listPro.php' target='mainFrame'>重新删除</a>";
	}
	return $mes;
}

/**
 * 检查小分类下是否有产品
 * @param unknown $cid
 * @return multitype:
 */
function checkProExist($small_cId){
	$sql= "select * from product where small_cId={$small_cId}";
	$rows = fetchAll($sql);
	return $rows;
}

/**
 *得到商品ID和商品名称
 * @return array
 */
function getProInfo(){
	$sql="select id,pName from product order by id asc";
	$rows=fetchAll($sql);
	return $rows;
}

/**
 *根据商品id得到商品图片
 * @param int $id
 * @return array
 */
function getAllImgByProId($id){
	$sql="select a.albumPath from imooc_album a where pid={$id}";
	$rows=fetchAll($sql);
	return $rows;
}

function getSmallCateByBraId($bra_cId){
	$sql = "select distinct(p.small_cId),p.bra_cId,sc.small_cName from product p join small_cate sc on p.small_cId=sc.id where p.bra_cId={$bra_cId}";
	$rows=fetchAll($sql);
	return $rows;
}

function getNumBySmaByBra($bra_cId,$small_cId){
	$sql = "select count(id) as count from product where bra_cId={$bra_cId} and small_cId={$small_cId}";
	$row = fetchOne($sql);
	return $row['count'];
}





