<?php 
require_once 'include.php';
checkBrowser();
//得到数据库中所有商品分类
$bigCates = getAllBigCate();
$cou_bigCates = count($bigCates);
$pid = $_REQUEST['id'];
$proInfo = getProById($pid);

$i=1;
foreach ($bigCates as $bigCate){
	if ($proInfo['big_cId']==$bigCate['id']) {
		$big_Cates[0] = $bigCate;
	}else {
		$big_Cates[$i] = $bigCate;
		$i++;
	}
}
ksort($big_Cates);

//点击量+1
update("product", array("view_times"=>$proInfo['view_times']+1),"id={$pid}");

$download = fetchAll("select id,pNum from download where down_cate=1 and pNum is not null");
$down_id = array();
foreach ($download as $down){
	$pNum = explode(",", $down['pNum']);
	if (in_array($proInfo['pNum'], $pNum)) {
		$down_id[] = $down['id'];
	}
}
$did = implode(",", $down_id);
$file = fetchAll("select filePath from file where did in ({$did})");

$rePnum = implode("','", explode(",", $proInfo['rePNum']));

$sql = "select id,pName from product where pNum in ('{$rePnum}')";

$rePro = fetchAll($sql);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-产品详细信息</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<link type="text/css" rel="stylesheet" href="plugins/lightbox/css/lightbox.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
<script type="text/javascript" src="plugins/lightbox/js/lightbox.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="prCla_title">
		<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
		<a href="productList.php"><span>&gt;&gt;&nbsp;&nbsp;我们的产品</span></a>
		<div class="proBraTitle">
			<a href="productClassify.php?big_cId=<?php echo $proInfo['big_cId'];?>"><span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $proInfo['big_cName'];?></span></a>
			<a href="productClassify.php?small_cId=<?php echo $proInfo['small_cId'];?>&big_cId=<?php echo $proInfo['big_cId'];?>"><span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $proInfo['small_cName'];?></span></a>
			<span>&nbsp;&nbsp;&gt;&gt;&nbsp;&nbsp;<?php echo $proInfo['pName'];?></span>
		</div>
	</div>
	<div class="proCla_list_top" id="proCla_list_top"></div>
	
	<div class="proDetail"   style="overflow: hidden">
		<div class="proDetail_lefMenu">
			<ul id="menu" >
				<?php $i=0;?>
				<?php foreach ($big_Cates as $bigCate):?>
				<li class="proDetail_bigli">
					<a href="productClassify.php?big_cId=<?php echo $bigCate['id'];?>" class="proDetail_biga"  style="position: absoluet;z-index:999;">
						<span><img alt="" src="admin/bigCate/<?php echo $bigCate['albumPath'];?>"></span>
						<span class="proDetail_bigCN"><?php echo $bigCate['big_cName'];?></span>
					</a>
					<ul class="proDetail_smaul" <?php  echo ($proInfo['big_cId']==$bigCate['id'])?"style='display: block;'":"style='display: none;'"?> id="ul<?php echo $i;?>">
						<?php $smallCates = getSmallCateByBigCId($bigCate['id']);
							foreach ($smallCates as $smallCate):
						?>
						<li><a href="productClassify.php?small_cId=<?php echo $smallCate['id'];?>&big_cId=<?php echo $bigCate['id'];?>" 
						<?php echo $smallCate['id']==$proInfo['small_cId']?"style='color:#4ca0fa;background-color:#f5f5f5'":null;?>
						><?php echo $smallCate['small_cName'];?></a></li>

						<?php endforeach;?>
					</ul>
				</li>
				<?php $i++;?>
				<?php endforeach;?>
			</ul>
		</div>
		<div class="proDetail_rigMenu">
			<div class="proDetail_rigTitle"><?php echo $proInfo['pName'];?></div>
			<div class="proDetail_rigTop" style="overflow:hidden;">
			<?php 
				$imgs = getImgsByProId($proInfo['id']);
				$models = getModelsByPid($proInfo['id']);
			?>
				<div class="proDetail_imgs">
					<div class="proDetail_bigImg" id="proDetail_bigImg">
						<?php $i=0;?>
						<?php foreach ($imgs as $img):?>
							<a href="admin/uploads/<?php echo $img['albumPath'];?>" rel="lightbox[roadtrip]" id="biga<?php echo $i;?>"><img alt="" src="admin/uploads/<?php echo $img['albumPath'];?>"></a>
						<?php 
						$i++;
						endforeach;
						?>
					</div>
					<ul id="detail_ul" style="overflow: hidden;">
					<?php $i=0;?>
					<?php foreach ($imgs as $img):?>
						<li onmouseover="changeImg(<?php echo $i;?>)"><a href="admin/uploads/<?php echo $img['albumPath'];?>" data-lightbox="example-set"><img alt="" src="admin/uploads/<?php echo $img['albumPath'];?>" id="img<?php echo $i;?>"></a></li>
					<?php 
					$i++;
					endforeach;
					?>
					</ul>
				</div>
				<div class="proDetail_param">
					<h3>产品参数</h3>
					<table>
						<tr>
							<td colspan="3" style="font-size:24px;" class="proDetail_lastd"><?php echo $proInfo['pName'];?></td>
						</tr>
						<tr>
							<td>厂商</td>
							<td>商品统称</td>
							<td class="proDetail_lastd">在线咨询</td>
						</tr>
						<tr class="proDetail_lastr">
							<td><?php echo $proInfo['bra_cName'];?></td>
							<td><?php echo $proInfo['pNum'];?></td>
							<td class="proDetail_lastd">
							<a target="_blank" href="http://wpa.qq.com/msgrd?v=3&uin=1925316533&site=qq&menu=yes">
								<img border="0" src="images/product/proDetail_qq.png" alt="点击这里给我发消息" title="点击这里给我发消息">
							</a>
							</td>
						</tr>
					</table>
					<div class="proDetail_times">
						<div class="proDetail_model">
							<h4>商品型号：</h4>
							<select id="model1" onchange="model1()">
								<option value="-1" selected="selected">--请选择--</option>
								<?php foreach ($models as $model):?>
								<option value="<?php echo $model['id'];?>"><?php echo $model['model'];?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="proDetail_model">
							<h4>厂商料号：</h4>
							<select id="model2" onchange="model2()">
								<option value="-1" selected="selected">--请选择--</option>
								<?php foreach ($models as $model):?>
								<option value="<?php echo $model['id'];?>"><?php echo $model['partNum'];?></option>
								<?php endforeach;?>
							</select>
						</div>
						<div class="proDetail_time">
							阅读次数：<?php echo $proInfo['view_times'];?>
						</div>
					</div>
				</div>
			</div>
			
			<div class="proDetail_rigBot">
				<div class="proDetail_rigBotTil">
					<ul>
						<li id="li0" onmouseover="changeContent(0)" style="color:#fff;background:url(images/product/proDetail_menu.png) center center no-repeat;">产品介绍</li>
						<li id="li1" onmouseover="changeContent(1)">规格参数</li>
						<li id="li2" onmouseover="changeContent(2)">资料下载</li>
						<li id="li3" onmouseover="changeContent(3)">相关产品</li>
					</ul>
				</div>
				
				<div class="proDetail_rigProIntro" id="content0">
					<?php echo $proInfo['pDesc'];?>
				</div>
				
				<div class="proDetail_rigParam" style="display:none" id="content1">
					<?php echo $proInfo['pStandard'];?>
				</div>
				
				<div class="proDetail_rigDown" style="display:none" id="content2">
					<ul>
						<?php foreach ($file as $_file):
						$size = filesize(iconv('utf-8','gbk', dirname(__FILE__)."/file/{$_file['filePath']}"));
						$fileSize = sprintf("%.2f",$size/1024/1024);
						?>
						<li><?php echo explode(".",$_file['filePath'])[0];?>&nbsp;&nbsp;<?php echo $fileSize;?>M&nbsp;&nbsp;<a href="download.php?filename=<?php echo $_file['filePath'];?>">1&nbsp;&nbsp;&nbsp;&nbsp;1</a></li>
						<?php endforeach;?>
					</ul>
				</div>
				
				<div class="proDetail_rigRel" style="display:none" id="content3">
					<ul>
						<?php foreach ($rePro as $_rePro):
							$proImg=getProImgById($_rePro['id']);
						?>
						<li>
							<div>
								<a href="proDetails.php?id=<?php echo $_rePro['id'];?>"target="_blank">
									<img src="admin/uploads/<?php echo $proImg['albumPath'];?>" alt="">
								</a>
								<div  class="proDetail_rigName">
									<h6><?php echo $_rePro['pName'];?></h6>
								</div>
							</div>
						</li>
						<?php endforeach;?>
					</ul>
				</div>
			</div>
			
		</div>
	
	</div>
	
	<?php include 'bottom.php';?>
	
	<script type="text/javascript" charset="utf-8">
	window.onload = function (){
		var biga0 = document.getElementById("biga0");
		biga0.style.display = "block";

		var topImg = document.getElementById("proCla_list_top");
		topImg.style.backgroundImage = "url(images/product/proCla_banner/<?php echo $proInfo['big_cId']?>.png)";
	}
	function changeImg(id){
		var bigImg = document.getElementById("proDetail_bigImg").getElementsByTagName("a");
	    for(i=0;i<bigImg.length;i++){
	        if(i==id){
	        	bigImg[i].style.display="block";
	        }
	        else{
	        	bigImg[i].style.display = 'none';
	        }
	    }
	}
	function changeContent(id){
		for(i=0;i<4;i++){
			var menuInfo = document.getElementById('content' + (i));
			menuInfo.style.display = 'none';

			var liInfo = document.getElementById('li' + (i));
			liInfo.style.color = "#b2b2b2";
			liInfo.style.backgroundcolor = "#f1f1f1";
			liInfo.style.background = "";
		}
		var menuInfo = document.getElementById('content' + (id));
		menuInfo.style.display = 'block';

		var liInfo = document.getElementById('li' + (id));
		liInfo.style.color = "#fff"
		liInfo.style.background = "url(images/product/proDetail_menu.png)";
	}
	function model1(){
		var model1 = document.getElementById("model1");
		
		var model2 = document.getElementById("model2");
		var value1 = document.getElementById("model1").value;
		for(var i=0; i<model2.options.length; i++){
	        if(model2.options[i].value == value1){  
	        	model2.options[i].selected = "selected";
	        }else{
	        	model2.options[i].selected = ""; 
		    }  
	    }  
	}
	function model2(){
		var value2 = document.getElementById("model2").value;
		var model1 = document.getElementById("model1");
		for(var i=0; i<model1.options.length; i++){
	        if(model1.options[i].value == value2){  
	        	model1.options[i].selected = "selected";
	        }else{
	        	model1.options[i].selected = ""; 
		    }  
	    }  
	}
	</script>
</body>
</html>