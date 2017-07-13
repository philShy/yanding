<?php 
require_once 'include.php';

$bra_cId = $_REQUEST['bra_cId'];
$small_cId = $_REQUEST['small_cId'];
$where = $page_where ="";
$small_cate = array();
if (!empty($bra_cId)) {
	$where .= " and p.bra_cId={$bra_cId}";
	$page_where .= "bra_cId={$bra_cId}&"; 
}
if (!empty($small_cId)) {
	$small_cate = getSmallCateById($small_cId);
	$where .= " and p.small_cId={$small_cId}";
	$page_where .= "small_cId={$small_cId}";
}
//得到该品牌的信息
$bra_cate = getBraCateById($bra_cId);
//根据品牌id获得该品牌下的产品的小分类
$smallCates = getSmallCateByBraId($bra_cId);
//根据品牌id获得相应的产品
$sql ="select p.id,p.pNum,p.pAbstract,p.pName,p.small_cId,p.bra_cId,sc.small_cName,bc.bra_cName
from product p join small_cate sc on p.small_cId=sc.id
join brand_cate bc on p.bra_cId= bc.id where 1 {$where}";

$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select p.id,p.pNum,p.pAbstract,p.pName,p.small_cId,p.bra_cId,sc.small_cName,bc.bra_cName
from product p join small_cate sc on p.small_cId=sc.id
join brand_cate bc on p.bra_cId= bc.id where 1 {$where} limit {$offset},{$pageSize}";

$proInfo = fetchAll($sql);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-品牌分类信息</title>
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
			<a href="productBrand.php?bra_cId=<?php echo $bra_cId?>"><span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $bra_cate['bra_cName'];?></span></a>
			<?php if (!empty($small_cate)) :?>
			<span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $small_cate['small_cName'];?></span>
			<?php endif;?>
		</div>
		
	</div>
	<div class="proCla_list_top" style="background-image:url(images/product/proBra_banner.png)"></div>
	
	<div class="proCla">
		<div class="proCla_lefMenu">
			<ul id="menu">
				<li class="proCla_bigli">
					<a href="productBrand.php?bra_cId=<?php echo $bra_cId?>" class="proCla_biga">
						<span style="width:30px;height:30px;margin:15px 0 5px 15px;"><img alt="" src="images/product/proBra_lef.png"></span>
						<span class="proCla_bigCN" style="border-left: none;"><?php echo $bra_cate['bra_cName'];?></span>
					</a>
				</li>
				<?php $i=0;?>
				<?php foreach ($smallCates as $smallCate):?>
				<?php $count = getNumBySmaByBra($bra_cId,$smallCate['small_cId']);?>
				<li class="proBrali">
					<a href="productBrand.php?bra_cId=<?php echo $bra_cId?>&small_cId=<?php echo $smallCate['small_cId'];?>" class="proBra_a" 
					<?php echo $smallCate['small_cId']==$small_cId?"style='text-shadow:#0a67ca 8px 8px 3px;'":null;?>
					>
						<span class="line_span"></span>
						<spans><?php echo $smallCate['small_cName'];?></span>
						<span>[<?php echo $count;?>]</span>
					</a>
				</li>
				<?php $i++;?>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="proCla_rigMenu">
			<form action="productClassify.php?big_cId=<?php echo $_REQUEST['big_cId'];?>&small_cId=<?php echo $_REQUEST['small_cId'];?>" method="post">
				<div class="proCla_rigTitle">产品</div>
				<div class="proCla_rigBrand">
					<div class="proCla_content" style="top:0;">
						<ul>
							<?php foreach ($proInfo as $pro):?>
							<li>
								<a href="proDetails.php?id=<?php echo $pro['id'];?>">
									<?php $proImg=getProImgById($pro['id']);?>
									<div class="proCla_searchImg"><span></span><img alt="" src="admin/uploads/<?php echo $proImg['albumPath'];?>"></div>
									<div class="proCla_searchDesc">
										<h3>商品名称：<?php echo $pro['pName'];?></h3>
										<span>厂   商：<?php echo $pro['bra_cName'];?></span>
										<span>统   称：<?php echo $pro['pNum'];?></span>
										<div class="proCla_abstract">
											<span>简  介：<?php echo strlen($pro['pAbstract'])>100?msubstr($pro['pAbstract'],0,100):$pro['pAbstract'];?></span>
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
</body>
</html>