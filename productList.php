<?php 
require_once 'include.php';
checkBrowser();
//得到数据库中所有商品分类
$bigCates = getAllBigCate();
$braCates = getAllBraCate();
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-产品列表</title>
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
				<div style="width:630px;">产品分类</div>
				<div class="proLis_search">
					<form target="_blank" method="get" action="productSearch.php">
					<input maxlength="20" size="15" name="search" placeholder="产品搜索" class="proLis_search_text">
					<input type="submit" value="" class="proLis_submit">
					</form>
				</div>
			</div>
			
			<div class="third_proLis_content">
				<ul>
					<?php foreach ($bigCates as $bigCate):?>
					<li class="proLis_bigli">
						<a href="productClassify.php?big_cId=<?php echo $bigCate['id'];?>" class="proLis_biga">
							<span><img alt="" src="admin/bigCate/<?php echo $bigCate['albumPath'];?>"></span>
							<span class="proLis_bigCN"><?php echo $bigCate['big_cName'];?></span>
						</a>
						<ul class="proLis_smaul">
							<?php $smallCates = getSmallCateByBigCId($bigCate['id']);
								foreach ($smallCates as $smallCate):
							?>
							<li><a href="productClassify.php?small_cId=<?php echo $smallCate['id'];?>&big_cId=<?php echo $bigCate['id'];?>">&gt;&gt;&nbsp;<?php echo $smallCate['small_cName'];?></a></li>
							<?php endforeach;?>
						</ul>
					</li>
					<?php endforeach;?>
				</ul>
			</div>
		</div>
		
		<div class="third_proLis_rig">
			<div class="proLisBra_title">品牌搜索</div>
			<div class="proLisBra_search">
				<div class="proLisBra_input">
					<input type="text" name="search"  placeholder="请输入品牌" id="searchBra"/>
				</div>
				<div id="reqbef">
					<ul class="proLisBra_ul">
						<?php foreach ($braCates as $braCate):?>
						<li><a href="productBrand.php?bra_cId=<?php echo $braCate['id'];?>"><?php echo $braCate['bra_cName'];?></a></li>
						<?php endforeach;?>
					</ul>
				</div>
				<div id="norequest"></div>
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
	<script type="text/javascript">
	$(function(){
		for(var i=0;i<16;i++){
			if(i%3==2){
				$(".proLis_bigli").eq(i).css("margin-right","0");
			}
		}

		
      	var bind_name = 'input';
      	//火狐浏览器
      	if(navigator.userAgent.indexOf("Firefox") != -1){
      		var bind_name = 'keyup';
        }
      	//IE浏览器
      	if (navigator.userAgent.indexOf("MSIE") != -1){
        	bind_name = 'propertychange';
      	}	
      $("#searchBra").bind(bind_name, function () {
          $.ajax({
              url:"checkBra.php",
              data: { bra: $("#searchBra").val() },
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
                  	 $("#reqbef ul").append("<li><a href='productBrand.php?bra_cId=<?php echo $braCate['id'];?>'><?php echo $braCate['bra_cName'];?></a></li>");
                  	 <?php endforeach;?>
                   }else{
	                     if(data) { 
	     					$.each(data,function(index,term){
	     						$("#reqbef ul").append("<li><a href='productBrand.php?bra_cId="+term.id+"'>"+term.bra_cName+"</a></li>");
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
