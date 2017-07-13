<?php 
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if (!empty($_REQUEST['down_cate'])) {
	$where .= " and down_cate ={$_REQUEST['down_cate']}";
	$page_where .= "down_cate={$_REQUEST['down_cate']}&";
}
if (!empty($_REQUEST['pNum'])) {
	$where .= " and pNum like '%{$_REQUEST['pNum']}%'";
	$page_where .= "pNum={$_REQUEST['pNum']}&";
}
if (!empty($_REQUEST['tech_title'])) {
	$where .= " and tech_title like '%{$_REQUEST['tech_title']}%'";
	$page_where .= "tech_title={$_REQUEST['tech_title']}&";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select * from download where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select * from download where 1 {$where} order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);

$class = array(
		0=>(array('value'=>'0','name'=>'-请选择-')),
		1=>(array('value'=>'1','name'=>'产品')),
		2=>(array('value'=>'2','name'=>'技术文章')),
		3=>(array('value'=>'3','name'=>'售后服务')),
);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
<script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
</head>
<body>
<div class="details">
   <div class="details_operation clearfix">
       <div class="bui_select">
          <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addDown()">
       </div>
       
       <div class="fr">
		   <div class="text">
				<span>下载类别：</span>
				<div class="bui_select">
					<select name="down_cate" id="down_cate" class="select">
					<?php foreach ($class as $_class):?>
						<option value="<?php echo $_class['value']?>" <?php echo $_class['value']==$_REQUEST['down_cate']?"selected='selected'":null;?>><?php echo $_class['name'];?></option>
					<?php endforeach;?>
					</select>
				</div>
			</div>
			<div class="text">
				<span>产品统称</span> 
				<input type="text" value="<?php echo $_REQUEST['pNum'];?>" class="search" id="pNum">
			</div>
			<div class="text">
				<span>技术文章名称</span> 
				<input type="text" value="<?php echo $_REQUEST['tech_title'];?>" class="search" id="tech_title">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div> 
	                    
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
      <thead>
          <tr>
             <th width="10%">编号</th>
             <th width="10%">下载内容分类</th>
             <th width="10%">产品分类</th>
             <th width="10%">产品统称</th>
             <th width="15%">品牌名称</th>
             <th width="15%">软件对应百度云链接</th>
             <th width="10%">软件对应百度云密码</th>
             <th width="15%">技术文章标题</th>
             <th width="10%">售后服务类型</th>
             <th width="15%">文件名称</th>
             <th width="15%">上传时间</th>
             <th>操作</th>
          </tr>
      </thead>
      <tbody>
       <?php  foreach($rows as $row):?>
         <tr>
         <!--这里的id和for里面的c1 需要循环出来-->
             <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
             <td>
             <?php 
             if ($row['down_cate']==1) {
             	echo "产品";
             }elseif ($row['down_cate']==2){
             	echo "技术文章";
             }elseif ($row['down_cate']==3) {
             	echo "售后服务";
             }else {
             	echo "无";
             }
             
             ?>
             </td>
             <td>
             <?php 
             if ($row['product']==1) {
             	echo "文档";
             }elseif ($row['product']==2) {
             	echo "软件";
             }else {
             	echo "无";
             }
             ?>
             </td>
             <td><?php echo $row['pNum'];?></td>
             <td><?php echo $row['bra_cName'];?></td>
             <td><?php echo $row['soft_link'];?></td>
             <td><?php echo $row['soft_password'];?></td>
             <td><?php echo $row['tech_title'];?></td>
             <td>
             <?php 
             if ($row['service']==1) {
             	echo "服务流程";
             }elseif ($row['service']==2) {
             	echo "定期校准";
             }else {
             	echo "无";
             }
             ?>
             </td>
             <td>
             <?php 
             $file = getFileByDid($row['id']);
             if (!empty($file)):
             ?>
             <ul>
             	<?php foreach ($file as $_file):?>
             	<li><?php echo $_file['filePath'];?></li>
             	<?php endforeach;?>
             </ul>
             <?php
             else : 
             	echo "无";
	         endif;
             ?>
             </td>
             <td><?php echo date("Y-m-d H:i:s",$row['pubTime']);?></td>
             <td align="center"><input type="button" value="修改" class="btn" onclick="editDown(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"  onclick="delDown(<?php echo $row['id'];?>)"></td>
         </tr>
         <?php endforeach;?>
         <?php if($totalRows>$pageSize):?>
         <tr>
             <td colspan="12"><?php echo showPage($page, $totalPage,$page_where);?></td>
         </tr>
             <?php endif;?>
      </tbody>
  </table>
</div>
<script type="text/javascript">
	function editDown(id){
		window.location="editDown.php?id="+id;
	}
	function delDown(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delDown&id="+id;
		}
	}
	function addDown(){
		window.location="addDown.php";
	}
	function search(){
		var down_cate=document.getElementById("down_cate").value;
		var pNum=document.getElementById("pNum").value;
		var tech_title=document.getElementById("tech_title").value;
		window.location="listDown.php?down_cate="+down_cate+"&pNum="+pNum+"&tech_title="+tech_title;
	}
</script>
</body>
</html>