<?php
/**
 * 添加技术文章
 * @return string
 */
function addTech(){
	$arr=$_POST;
	$arr['last_changed']=time();
	$path="./tech";
	$uploadFiles=uploadFile($path);
	$arr['image'] = $uploadFiles[0]['name'];
	$res=insert("technical_article",$arr);
	if($res){
		addOperate(getUserName(),'technical_article','add',getInsertId());
		$mes="<p>添加成功!</p><a href='addTech.php' target='mainFrame'>继续添加</a>|<a href='listTech.php' target='mainFrame'>查看技术文章列表</a>";
	}else{
		$mes="<p>添加失败!</p><a href='addTech.php' target='mainFrame'>重新添加</a>";

	}
	return $mes;
}

function editTech($id){
	$arr=$_POST;
	$arr['last_changed']=time();
	$path="./tech";
	$uploadFiles=uploadFile($path);
	
	if (!empty($uploadFiles)) {
		$arr['image'] = $uploadFiles[0]['name'];
	}
	$tech = getOneTech($id);
	if (!empty($tech['image'])&&!empty($uploadFiles)) {
		if (file_exists("tech/" .$img['image'])) {
			unlink("tech/" .$img['image']);
		}
	}	
	$res=update("technical_article",$arr,"id={$id}");
	
	if($res){
		addOperate(getUserName(),'technical_article','edit',$id);
		$mes="<p>编辑成功!</p><a href='listTech.php' target='mainFrame'>查看技术文章列表</a>";
	}else{
		$mes="<p>编辑失败!</p><a href='listTech.php' target='mainFrame'>重新编辑</a>";

	}
	return $mes;
}
/**
 * 根据技术文章id获得技术文章信息
 * @param int $id
 * @return multitype:
 */
function getOneTech($id){
	$sql="select id,author,title,last_changed,abstract_content,content,view_times,image from technical_article where id={$id}";
	$res = fetchOne($sql);
	return $res;
}

function delTech($id){
	$tech = getOneTech($id);
	if (!empty($tech['image'])) {
		if (file_exists("tech/" .$tech['image'])) {
			unlink("tech/" .$tech['image']);
		}
	}
	$where="id=".$id;
	if(delete("technical_article",$where)){
		addOperate(getUserName(),'technical_article','del',$id);
		$mes="文章删除成功!<br/><a href='listTech.php'>查看技术文章</a>|<a href='addTech.php'>添加技术文章</a>";
	}else{
		$mes="删除失败！<br/><a href='listTech.php'>请重新操作</a>";
	}
	return $mes;
	
}
