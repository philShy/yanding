<?php
/**
 * 添加新闻
 * @return string
 */
function addNews(){
	$arr=$_POST;
	$arr['last_changed']=time();
	if (empty($arr['author'])) {
		$arr['author'] = "52rd";
	}
	$path="./news";
	$uploadFiles=uploadFile($path);
	$arr['image1'] = $uploadFiles[0]['name'];
	$arr['image2'] = $uploadFiles[1]['name']; 
	$res=insert("news",$arr);
	if($res){
		addOperate(getUserName(),'news','add',getInsertId());
		$mes="<p>添加成功!</p><a href='addNews.php' target='mainFrame'>继续添加</a>|<a href='listNews.php' target='mainFrame'>查看新闻列表</a>";
	}else{
		$mes="<p>添加失败!</p><a href='addNews.php' target='mainFrame'>重新添加</a>";

	}
	return $mes;
}

function editNews($id){
	$arr=$_POST;
	$arr['last_changed']=time();
	if (empty($arr['author'])) {
		$arr['author'] = "52rd";
	}
	$path="./news";
	$uploadFiles=uploadFile($path);
	$news = getOneNews($id);
	if (empty($news['image1'])) {
		$arr['image1'] = $uploadFiles[0]['name'];
	}
	$res=update("news",$arr,"id={$id}");
	
	if($res){
		addOperate(getUserName(),'news','edit',$id);
		$mes="<p>编辑成功!</p><a href='listNews.php' target='mainFrame'>查看新闻列表</a>";
	}else{
		$mes="<p>编辑失败!</p><a href='listNews.php' target='mainFrame'>重新编辑</a>";

	}
	return $mes;
}
/**
 * 根据新闻id获得新闻信息
 * @param int $id
 * @return multitype:
 */
function getOneNews($id){
	$sql="select id,author,title,last_changed,abstract_content,content,image1,view_times from news where id={$id}";
	$res = fetchOne($sql);
	return $res;
}

function delNews($id){
	$news = getOneNews($id);
	if (!empty($news['image1'])) {
		if (file_exists("news/" .$news['image1'])) {
			unlink("news/" .$news['image1']);
		}
	}
	$where="id=".$id;
	if(delete("news",$where)){
		addOperate(getUserName(),'news','del',$id);
		$mes="新闻删除成功!<br/><a href='listNews.php'>查看新闻</a>|<a href='addNews.php'>添加新闻</a>";
	}else{
		$mes="删除失败！<br/><a href='listNews.php'>请重新操作</a>";
	}
	return $mes;
	
}

function delUnableNewsImg(){
	$sql = "select image1 from news";
	$images = fetchAll($sql);
	$filenames = scandir("./news");
	if ($images) {
		foreach ($images as $image){
			$images1[] = $image['image1'];
		}
	}
	foreach ($filenames as $filename){
		if ($filename!="."&&$filename!="..") {
			if (!in_array($filename, $images1)) {
				unlink("./news/".$filename);
			}
		}
	}
	return "<script>window.location='listNews.php'</script>";
}