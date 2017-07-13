<?php 
require_once 'include.php';
checkBrowser();
$search = $_REQUEST['search'];
$bra_cId = $_REQUEST['bra_cId'];

// $braCates = getAllBraCate();

$where = $page_where = "";
if (!empty($bra_cId)) {
	$braCate = getBraCateById($bra_cId);
	$where .= " and p.bra_cId={$bra_cId}";
	$page_where .= "bra_cId={$bra_cId}&";
}

if ($search!="") {
	$where .= " and (p.pName like '%{$search}%' or p.pNum like '%{$search}%' 
	            or bi.big_cName like '%{$search}%' or s.small_cName like '%{$search}%' or br.bra_cName like '%{$search}%')";
	$page_where .= "search={$search}&";
}else {
	alertMes("sorry,没有输入查询条件，请先输入!","productList.php");
}


$braCates = fetchAll("select distinct(p.bra_cId),br.bra_cName from product as p
join big_cate bi on p.big_cId=bi.id
join small_cate s on p.small_cId=s.id
join brand_cate br on p.bra_cId=br.id
where 1 {$where}");

$sql = "select p.id,p.big_cId,p.small_cId,p.bra_cId,p.pName,p.pNum,p.pDesc,p.pStandard,p.pAbstract,
bi.big_cName,s.small_cName,br.bra_cName from product as p
join big_cate bi on p.big_cId=bi.id
join small_cate s on p.small_cId=s.id
join brand_cate br on p.bra_cId=br.id
where 1 {$where}";
$totalRows=getResultNum($sql);
$pageSize=7;
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
where 1 {$where} limit {$offset},{$pageSize}";
$proInfo = fetchAll($sql);

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-产品搜索</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>

<body>
	<?php include 'head.php';?>
	<div class="first_proLis" style="overflow:hidden">
		<a href="index.php">
			<img alt="" src="images/news/news_rtop.png">
		</a>
		<a href="productList.php"><span>&gt;&gt;&nbsp;&nbsp;我们的产品</span></a>
	</div>
	
	<div class="second_proLis">
		<div class="second_proLis_lef">
			<div><img alt="" src="images/product_index.png"></div>
		</div>
		<div class="second_proLis_rig">
			<div class="proLis_banner"><a href="serviceList.php" target="_blank"><img alt="" src="images/product/service.jpg"></a></div>
			<div class="proLis_banner"><a href="contactUs.php" target="_blank"><img alt="" src="images/product/refer.jpg"></a></div>
			<div class="proLis_banner"><a href="downloadList.php" target="_blank"><img alt="" src="images/product/download.jpg"></a></div>
			
			<div class="proLis_barcode">
				<div style="margin-left: 10px;"><img class="proLis_rdbuy" alt="" src="images/rdbuy_barcode.jpg"><span>研发商城</span></div>
				<div><img class="proLis_52rd" alt="" src="images/52rd_barcode.jpg"><span>我爱研发网</span></div>
				<div class="sweep_div"><img class="proLis_sweep" alt="" src="images/product/sweep.jpg"><span>扫一扫</span><span>加关注</span></div>
			</div>
		</div>
	</div>
	
	<div class="third_proLis">
		<div class="third_proLis_lef">
			<div class="third_proLis_btil">
				<div style="font-weight: bold;width:140px;">搜索结果</div>
				<?php if (!empty($bra_cId)):?>
				<div class="proSearch_bra">
					<a href="productSearch.php?search=<?php echo $search;?>">品牌:<?php echo $braCate['bra_cName'];?> <span>x</span><a></a>
				</div>
				<?php endif;?>
			</div>
			
			<div class="third_proLis_content">
				<div class="proSea_content">
					<ul>
						<?php if (empty($proInfo)):?>
						<div class="proSea_noContent">没有发现记录!</div>
						<?php endif;?>
						<?php foreach ($proInfo as $_search):?>
						<li>
							<a href="proDetails.php?id=<?php echo $_search['id'];?>">
								<?php $proImg=getProImgById($_search['id']);?>
								<div class="proCla_searchImg"><span></span><img alt="" src="admin/uploads/<?php echo $proImg['albumPath'];?>"></div>
								<div class="proSea_searchDesc">
									<h3>商品名称：<?php echo $_search['pName'];?></h3>
									<span>厂   商：<?php echo $_search['bra_cName'];?></span>
									<span>统   称：<?php echo $_search['pNum'];?></span>
									<div class="proSea_abstract">
										<span>简  介：<?php echo strlen($_search['pAbstract'])>100?msubstr($_search['pAbstract'],0,100):$_search['pAbstract'];?></span>
									</div>
								</div>
							</a>
						</li>
						<?php endforeach;?> 
					</ul>
					<?php if($totalRows>$pageSize):?>
		        	<div class="news_page" style="width:840px;">
		        		<?php echo newsPage($page, $totalPage,$page_where);?>
		        	</div>
		       		<?php endif;?> 
	       		</div>
			</div>
		</div>
		
		<div class="third_proLis_rig">
			<div class="proSeach">
				<form target="_blank" method="get" action="productSearch.php">
					<input maxlength="20" size="15" name="search" placeholder="产品搜索" value=<?php echo $search;?> class="proSeach_text">
					<input type="submit" value="搜索" class="proSeach_submit">
				</form>
			</div>
			<div class="proLisBra_title">品牌搜索</div>
			<div class="proLisBra_search">
				<div class="proLisBra_input">
					<input type="text" name="search"  placeholder="请输入品牌" id="braSearch" value="<?php echo $braCate['bra_cName'];?>"/>
				</div>
				<div id="reqbef">
					<ul class="proLisBra_ul">
						<?php foreach ($braCates as $bra):?>
						<li><a href="productSearch.php?bra_cId=<?php echo $bra['bra_cId'];?>&search=<?php echo $search?>"><?php echo $bra['bra_cName'];?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<div id="norequest"></div>
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
	<script type="text/javascript">
	
		$(function () {
		var bind_name = 'input';
      	//火狐浏览器
      	if(navigator.userAgent.indexOf("Firefox") != -1){
      	    bind_name = 'keyup';
        }
      	//IE浏览器
      	if (navigator.userAgent.indexOf("MSIE") != -1){
        	bind_name = 'propertychange';
      	}
        $("#braSearch").bind(bind_name, function () {
            $.ajax({
                url:"checkSearchBra.php",
                data: { bra: $("#braSearch").val(),search:<?php echo json_encode($search);?> },
                dataType:"json",
                type:"post",
                async:false,
                error:function(data){
                	alert("请求失败");
                },
                success: function (data) {
                	$("#reqbef").css('display','block'); 
               	 	$("#norequest").html('');
               	 	$("#reqbef ul").empty();
                     if($("#searchBra").val()==''){
                    	 <?php foreach ($braCates as $braCate):?> 
                    	 $("#reqbef ul").append("<li><a href='productSearch.php?bra_cId=<?php echo $braCate['id'];?>&search=<?php echo $search;?>'><?php echo $braCate['bra_cName'];?></a></li>");
                    	 <?php endforeach;?>
                     }else{
	                     if(data) { 
	     					$.each(data,function(index,term){
	     						$("#reqbef ul").append("<li><a href='productSearch.php?bra_cId="+term.bra_cId+"&search=<?php echo $search;?>'>"+term.bra_cName+"</a></li>");
	     					})
	                     }else{
	                    	$("#reqbef").css('display','none'); 
							$("#norequest").html("没有找到相应内容");
	                     }
	                }
                }
            });
        })
    });
	</script>
	</body>

</html>
