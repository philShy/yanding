<?php 
require_once 'include.php';
checkBrowser();
$proLis = fetchAll("select id,pName from product where big_cId=43");
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>ceshi</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/slider.js"></script>
<style tyle="text/css">
.flexslider {
    height: 434px;
    width: 1200px;
}
.slides {
    height: 434px;
    width: 1200px;
}
.flexslider .slides li {
    float: left;
    height: 434px;
    margin-right: 30px;
    width: 380px;
}
.flexslider .slides li a {
    display: block;
    height: 434px;
    width: 380px;
}
.flexslider .slides li a img{
    height: 434px;
    width: 380px;
}
</style>
</head>

<body>
	<div id="banner_tabs" class="flexslider">
		<ul class="slides">
		  <?php foreach ($proLis as $pro):
		  $proImg = fetchOne("select albumPath from album where pid={$pro['id']} order by arrange asc limit 1");
		  ?>
		  <li class="product_conLi"><a><img src="admin/uploads/<?php echo $proImg['albumPath'];?>" alt="" width="200"></a></li>
		  <?php endforeach;?>
		</ul>
		<ul class="flex-direction-nav">
			<li><a class="flex-prev" href="javascript:;">Previous</a></li>
			<li><a class="flex-next" href="javascript:;">Next</a></li>
		</ul>
	</div>
	
	<?php include 'bottom.php';?>
</body>
<script type="text/javascript">
//轮播
$(function() {
	var bannerSlider = new Slider($('#banner_tabs'), {
		time: 5000,
		delay: 400,
		event: 'hover',
		auto: true,
		mode: 'fade',
		controller: $('#bannerCtrl'),
		activeControllerCls: 'active'
	});
	$('#banner_tabs .flex-prev').click(function() {
		bannerSlider.prev()
	});
	$('#banner_tabs .flex-next').click(function() {
		bannerSlider.next()
	});
})	
	$(function(){
		for(var i=0;i<3;i++){
			if(i%3==2){
				$(".product_conLi").eq(i).css("margin-right","0");
			}
		}
	})
	</script>
</html>
