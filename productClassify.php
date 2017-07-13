<?php 
require_once 'include.php';
//得到数据库中所有商品分类
$bigCates = getAllBigCate();
$cou_bigCates = count($bigCates);
$big_cId = $_REQUEST['big_cId'];
$small_cId = $_REQUEST['small_cId'];
$i=1;
foreach ($bigCates as $bigCate){
	if ($big_cId==$bigCate['id']) {
		$big_Cates[0] = $bigCate;
	}else {
		$big_Cates[$i] = $bigCate;
		$i++;
	}
}
ksort($big_Cates);

$search = $total_brand = $big_cate = $small_cate = array();

$where1 = $where = $page_where = "";
$bra_cId = array();
if (!empty($_POST['selectedBra'])&&is_array($_POST['selectedBra'])) {
	$bra_cId_str = implode(",", $_POST['selectedBra']);
	$where1 .= " and bra_cId in (" .$bra_cId_str .")";
	$page_where .="bra_cId={$bra_cId_str}&";
	$bra_cId = $_POST['selectedBra'];
}elseif (!empty($_REQUEST['bra_cId'])) {
	$where1 .= " and bra_cId in (" .$_REQUEST['bra_cId'] .")";
	$page_where .="bra_cId={$_REQUEST['bra_cId']}&";
	$bra_cId = explode(",", $_REQUEST['bra_cId']);
}
if (!empty($small_cId)) {
	$where .= " and p.small_cId={$small_cId}";
	$big_cate = getBigCateBySmallCid($small_cId);
	$page_where .="small_cId={$small_cId}&big_cId={$big_cate['id']}&";
	$small_cate = getSmallCateById($small_cId);
}else {
	$where .= " and p.big_cId={$big_cId}";
	$page_where .= "big_cId={$big_cId}";
	$big_cate = getBigCateById($big_cId);
}
$sql = "select p.id,p.big_cId,p.small_cId,p.bra_cId,p.pName,p.pNum,p.pDesc,p.pStandard,p.pAbstract,
bi.big_cName,s.small_cName,br.bra_cName from product as p
join big_cate bi on p.big_cId=bi.id
join small_cate s on p.small_cId=s.id
join brand_cate br on p.bra_cId=br.id
where 1 {$where} {$where1}";
// var_dump($sql);
$totalRows=getResultNum($sql);
$pageSize=9;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select p.id,p.big_cId,p.small_cId,p.bra_cId,p.pName,p.pNum,p.pDesc,p.pStandard,p.pAbstract,
bi.big_cName,s.small_cName,br.bra_cName from product as p
join big_cate bi on p.big_cId=bi.id
join small_cate s on p.small_cId=s.id
join brand_cate br on p.bra_cId=br.id
where 1 {$where} {$where1} limit {$offset},{$pageSize}";
$search = fetchAll($sql);

$total_brand = fetchAll("select distinct(p.bra_cId),br.bra_cName
from product as p join brand_cate br
on p.bra_cId=br.id where 1 {$where} order by br.bra_cName asc");

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-产品分类信息</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="prCla_title">
		<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
		<a href="productList.php"><span>&gt;&gt;&nbsp;&nbsp;我们的产品</span></a>
		<div class="proBraTitle">
			<a href="productClassify.php?big_cId=<?php echo $big_cId;?>"><span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $big_cate['big_cName'];?></span></a>
			<?php if (!empty($small_cate)) :?>
			<span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $small_cate['small_cName'];?></span>
			<?php endif;?>
		</div>
	</div>
	<div class="proCla_list_top" id="proCla_list_top"></div>
	
	<div class="proCla">
		<div class="proCla_lefMenu">
			<ul id="menu">
				<?php $i=0;?>
				<?php foreach ($big_Cates as $bigCate):?>
				<li class="proCla_bigli">
					<a href="productClassify.php?big_cId=<?php echo $bigCate['id'];?>" class="proCla_biga">
						<span><img alt="" src="admin/bigCate/<?php echo $bigCate['albumPath'];?>"></span>
						<span class="proCla_bigCN"><?php echo $bigCate['big_cName'];?></span>
					</a>
					<ul class="proCla_smaul" <?php  echo ($_REQUEST['big_cId']==$bigCate['id'])?"style='display: block;'":"style='display: none;'"?> id="ul<?php echo $i;?>">
						<?php $smallCates = getSmallCateByBigCId($bigCate['id']);
							foreach ($smallCates as $smallCate):
						?>
						<li><a href="productClassify.php?small_cId=<?php echo $smallCate['id'];?>&big_cId=<?php echo $bigCate['id'];?>" 
						<?php echo $smallCate['id']==$_REQUEST['small_cId']?"style='color:#4ca0fa;'":null;?>
						><?php echo $smallCate['small_cName'];?></a></li>

						<?php endforeach;?>
					</ul>
				</li>
				<?php $i++;?>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="proCla_rigMenu">
			<form action="productClassify.php?big_cId=<?php echo $_REQUEST['big_cId'];?>&small_cId=<?php echo $_REQUEST['small_cId'];?>" method="post">
				<div class="proCla_rigTitle">选择品牌</div>
				<div class="proCla_rigBrand">
					<div id="checkboxSel" style="display: none">
						<ul class="proCla_rigBraUl">
						<?php foreach ($total_brand as $_total_brand):?>
							<li>
								<input type="checkbox" value=<?php echo $_total_brand['bra_cId'];?> name="selectedBra[]" <?php echo in_array($_total_brand['bra_cId'], $bra_cId)?"checked='checked'":null;?> >
								<label class="label"><?php echo $_total_brand['bra_cName'];?></label>
							</li>
						<?php endforeach;?>
						</ul>
						<div class="proCla_BraConfirm" <?php echo empty($total_brand)?"style='display: none;'":"style='display: block;'"?>>
							<input type="submit" value="确  认">
						</div>
					</div>
					<div id="radioSel" style="overflow: hidden;">
						<ul class="proCla_rigBraUl">
						<?php foreach ($total_brand as $_total_brand):?>
							<li>
								<a href="productClassify.php?small_cId=<?php echo $small_cId;?>&big_cId=<?php echo $big_cId;?>&bra_cId=<?php echo $_total_brand['bra_cId']?>" style="color:<?php echo in_array($_total_brand['bra_cId'], $bra_cId)?"#4ca0fa":"#656565";?>"><?php echo $_total_brand['bra_cName'];?></a>
							</li>
						<?php endforeach;?>
						</ul>
						<div class="cutCheckbox" onclick="cutCheckbox();">+多选</div>
					</div>
					
					<div class="proCla_content">
						<ul>
							<?php foreach ($search as $_search):?>
							<li>
								<a href="proDetails.php?id=<?php echo $_search['id'];?>">
									<?php $proImg=getProImgById($_search['id']);?>
									<div class="proCla_searchImg"><span></span><img alt="" src="admin/uploads/<?php echo $proImg['albumPath'];?>"></div>
									<div class="proCla_searchDesc">
										<h3>商品名称：<?php echo $_search['pName'];?></h3>
										<span>厂   商：<?php echo $_search['bra_cName'];?></span>
										<span>统   称：<?php echo $_search['pNum'];?></span>
										<div class="proCla_abstract">
											<span>简  介：<?php echo $_search['pAbstract'];?></span>
										</div>
									</div>
								</a>
							</li>
							<?php endforeach;?> 
						</ul>
						<?php if($totalRows>$pageSize):?>
			        	<div class="news_page">
			        		<?php echo newsPage($page, $totalPage,$page_where);?>
			        	</div>
			       		<?php endif;?> 
					</div>
				</div>
			</form>
		</div>
	
	</div>
	
	<?php include 'bottom.php';?>
	
	<script type="text/javascript">
		window.onload = function (){
			var topImg = document.getElementById("proCla_list_top");
			topImg.style.backgroundImage = "url(images/product/proCla_banner/<?php echo $_REQUEST['big_cId']?>.png)";
		}
		function cutCheckbox(){
			checkboxSel = document.getElementById("checkboxSel");
			radioSel = document.getElementById("radioSel");
			checkboxSel.style.display = "block";
			radioSel.style.display = "none";
		}
	</script>
</body>
</html>