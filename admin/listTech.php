<?php 
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if (!empty($_REQUEST['title'])) {
	$where .= "where title like '%{$_REQUEST['title']}%'";
	$page_where .= "title={$_REQUEST['title']}";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select id,title,author,image from technical_article {$where}";
$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,title,author,image,last_changed from technical_article {$where} order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
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
          <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addTech()">
       </div>
       
       <div class="fr">
			<div class="text">
				<span>技术文章标题</span> 
				<input type="text" value="<?php echo $_REQUEST['title'];?>" class="search" id="title">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div> 
	                    
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
      <thead>
          <tr>
             <th width="10%">编号</th>
             <th width="10%">发布人</th>
             <th width="30%">技术文章标题</th>
             <th width="15%">最后更新时间</th>
             <th width="10%">图片</th>
             <th>操作</th>
          </tr>
      </thead>
      <tbody>
       <?php  foreach($rows as $row):?>
         <tr>
         <!--这里的id和for里面的c1 需要循环出来-->
             <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
             <td><?php echo $row['author'];?></td>
             <td><?php echo $row['title'];?></td>
             <td><?php echo date("Y-m-d",$row['last_changed']);?></td>
             <td style="text-align: center;">
            	 <?php echo "<img src='tech/{$row['image']}' alt='' style='max-height:70px;max-width:70px;'/>";?>
             </td>
             <td align="center"><input type="button" value="修改" class="btn" onclick="editTech(<?php echo $row['id'];?>)"><input type="button" value="删除" class="btn"  onclick="delTech(<?php echo $row['id'];?>)"></td>
         </tr>
         <?php endforeach;?>
         <?php if($totalRows>$pageSize):?>
         <tr>
             <td colspan="6"><?php echo showPage($page, $totalPage,$page_where);?></td>
         </tr>
             <?php endif;?>
      </tbody>
  </table>
</div>
<script type="text/javascript">
	function editTech(id){
		window.location="editTech.php?id="+id;
	}
	function delTech(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delTech&id="+id;
		}
	}
	function addTech(){
		window.location="addTech.php";
	}
	function search(){
		var title=document.getElementById("title").value;
		window.location="listTech.php?title="+title;
	}
</script>
</body>
</html>