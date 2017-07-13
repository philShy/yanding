<?php 
require_once '../include.php';
checkLogined();

$where = $page_where = "";
if (!empty($_REQUEST['bra_cName'])) {
	$where .= "where bra_cName like '%{$_REQUEST['bra_cName']}%'";
	$page_where .= "bra_cName={$_REQUEST['bra_cName']}";
}
$page=$_REQUEST['page']?(int)$_REQUEST['page']:1;
$sql="select id,bra_cName from brand_cate {$where}";
$totalRows=getResultNum($sql);
$pageSize=12;
$totalPage=ceil($totalRows/$pageSize);
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql="select id,bra_cName,bra_img,bra_desc from brand_cate {$where} order by id asc limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
if(!$rows){
	alertMes("sorry,没有分类,请添加!","addBraCate.php");
	exit;
}

?>
<!doctype html>
<html>
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Insert title here</title>
<link rel="stylesheet" href="styles/backstage.css">
<link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css" />
<script src="scripts/jquery-ui/js/jquery-1.10.2.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.js"></script>
<script src="scripts/jquery-ui/js/jquery-ui-1.10.4.custom.min.js"></script>
</head>
<body>
<div class="details">
   <div class="details_operation clearfix">
       <div class="bui_select">
          <input type="button" value="添&nbsp;&nbsp;加" class="add"  onclick="addBraCate()">
       </div>
       <div class="fr">
			<div class="text">
				<span>品牌名称</span> 
				<input type="text" value="<?php echo $_REQUEST['bra_cName'];?>" class="search" id="bra_cName">
			</div>
			<div class="fr"><input type="button" value="搜索" class="btn" onclick="search()"> </div>
		</div>                     
   </div>
   <!--表格-->
   <table class="table" cellspacing="0" cellpadding="0">
      <thead>
          <tr>
             <th width="15%">编号</th>
             <th width="30%">品牌名称</th>
             <th width="20%">品牌图片</th>
             <th>操作</th>
          </tr>
      </thead>
      <tbody>
       <?php  foreach($rows as $row):?>
         <tr>
         <!--这里的id和for里面的c1 需要循环出来-->
             <td><input type="checkbox" id="c1" class="check"><label for="c1" class="label"><?php echo $row['id'];?></label></td>
             <td><?php echo $row['bra_cName'];?></td>
             <td><img style="width: 50px;height:33px;" alt="" src="braCate/<?php echo $row['bra_img'];?>"></td>
             
             <td align="center">
	             <input type="button" value="详情" class="btn" onclick="showDetail(<?php echo $row['id'];?>,'<?php echo $row['bra_cName'];?>')">
	             <input type="button" value="修改" class="btn" onclick="editBraCate(<?php echo $row['id'];?>)">
	             <input type="button" value="删除" class="btn"  onclick="delBraCate(<?php echo $row['id'];?>)">
	             <div id="showDetail<?php echo $row['id'];?>" style="display: none;">
							<table class="table" cellspacing="0" cellpadding="0">
								<tr>
									<td width="20%" align="right">品牌编号</td>
									<td><?php echo $row['id'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">品牌名称</td>
									<td><?php echo $row['bra_cName'];?></td>
								</tr>
								<tr>
									<td width="20%" align="right">品牌图片</td>
									<td><img style="width: 50px;height:33px;" alt="" src="braCate/<?php echo $row['bra_img'];?>"></td>
								</tr>
							</table>
							
			                <span style="display: block; width: 80%;font-size:12px;"> <h3>品牌描述</h3>
			                	<?php echo $row['bra_desc'];?>
			                </span>
						</div>
             </td>
         </tr>
         <?php endforeach;?>
         <?php if($totalRows>$pageSize):?>
         <tr>
             <td colspan="4"><?php echo showPage($page, $totalPage,$page_where);?></td>
         </tr>
             <?php endif;?>
      </tbody>
  </table>
</div>
<script type="text/javascript">
function showDetail(id,t){
	$("#showDetail"+id).dialog({
		  height:"auto",
	      width: "auto",
	      position: {my: "center", at: "center",  collision:"fit"},
	      modal:false,//是否模式对话框
	      draggable:true,//是否允许拖拽
	      resizable:true,//是否允许拖动
	      title:"品牌名称："+t,//对话框标题
	      show:"slide",
	      hide:"explode"
	});
}
	function editBraCate(id){
		window.location="editBraCate.php?id="+id;
	}
	function delBraCate(id){
		if(window.confirm("您确定要删除吗？删除之后不能恢复哦！！！")){
			window.location="doAdminAction.php?act=delBraCate&id="+id;
		}
	}
	function addBraCate(){
		window.location="addBraCate.php";
	}

	function search(){
		var bra_cName=document.getElementById("bra_cName").value;
		window.location="listBraCate.php?bra_cName="+bra_cName;
	}
</script>
</body>
</html>