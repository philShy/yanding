<?php 
require_once 'include.php';
//得到数据库中所有品牌

$sql="select id,bra_cName from brand_cate where bra_img !='' order by bra_cName asc";

$totalRows=getResultNum($sql);
$pageSize=10;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select id,bra_cName,bra_img,bra_desc from brand_cate where bra_img !=''  order by bra_cName asc limit {$offset},{$pageSize}";
$braCates=fetchAll($sql);

//得到数据库中所有客户信息
$clients = getAllClient();

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-关于我们</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>

</head>
<body>
	<?php include 'head.php';?>
	<div class="abo_list_top"></div>
	<div class="abo_list_content" style="overflow:hidden;">
		<div class="abo_list_left">
			<div class="alf_top" style="position:absolute;">
				<img alt="" src="images/about/abo_ltop.png" style="position:absolute;z-index:9000;">
			</div>
			<div class="labo_menu">
				<ul id="abo_menu">
					<li id="btn0" class="alf_center check" onclick="thisMenu(0)" style="color: #333333;">公司介绍</li>
					<li id="btn1" class="alf_center" onclick="thisMenu(1)">分销的品牌</li>
					<li id="btn2" class="alf_center" onclick="thisMenu(2)">我们的客户</li>
					<li id="btn3" class="alf_center" onclick="thisMenu(3)">合作的网站</li>
				</ul>
			</div>
			<div class="labo_bottom">
				<img alt="" src="images/news/news_lbottom.png">
			</div>
		</div>
		
		<div class="abo_list_right">
			<div class="abo_list_title">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<span style="display:block;width:100px;">&gt;&gt;&nbsp;关于我们</span>
				<span id="span0">&gt;&gt;&nbsp;公司介绍</span>
				<span id="span1" style="display:none">&gt;&gt;&nbsp;分销的品牌</span>
				<span id="span2" style="display:none">&gt;&gt;&nbsp;我们的客户</span>
				<span id="span3" style="display:none">&gt;&gt;&nbsp;合作的网站</span>
			</div>
			
			
			<div class="abo_introduce" id="abo0">
				<div class="intr_img">
					<img alt="" src="images/about/abo_intro.png">
				</div>
				
				<div class="intr_content">
					<p>
						上海研鼎信息技术有限公司成立于2005年，公司总部位于中国硅谷之称的张江高科技园区，在北京的顺义设立有分公司，在深圳有销售团队。
						目前主营业务分别是我爱研发网（www.52RD.com）和研鼎商城（www.rduby.com）两个网站，以及Randn品牌的实验室设备。 52RD
						是国内领先的技术工程师门户网站，拥有国内最大的工程师社群。RDBUY是国内领先的测试测量仪器设备分销商，为工程师提供一流的产品和服务。
						Randn是研发设计制造为一体的专业为定制实验室设备仪器的品牌，为全国各大实验室提供高效的仪器设备。
					</p>
					<h3>我们为业内工程师提供的服务包含：</h3>
					<p>1、业内资讯：最新的业内资讯，包含专业人士的网评；</p>
				    <p>2、52RD研发论坛：互动的交流、资源共享平台；</p>
				    <p>3、R&D Blog：专业的技术人博客/空间；</p>
				    <p>4、研发求职：为业内工程师搭建的便捷求职系统；</p>
				    <p>5、52RD.net：研发资源/网址导航。</p>
				    <p>6、《研发专辑》杂志：免费送读的行业杂志媒体</p>
				    <h3>我们为业内的企业提供的服务包含：</h3>
				    <p>1、企业产品供需平台：为企业产品打开销路，为企业提供完善的在线服务；</p>
      				<p>2、企业人才招聘系统：为企业提供快捷的人才招聘服务；</p>
				    
				</div>
			</div>
			
			<div class="abo_brand" id="abo1"  style="display:none">
				<div class="client_desc">按照字母先后顺序排列</div>
				<ul>
					<?php foreach ($braCates as $braCate):?>
					<li>
						<a href="productBrand.php?bra_cId=<?php echo $braCate['id'];?>">
							<img alt="" src="admin/braCate/<?php echo $braCate['bra_img'];?>">
							<span><?php echo strlen($braCate['bra_desc'])>200?msubstr($braCate['bra_desc'],0,200):$braCate['bra_desc'];?></span>
						</a>
					</li>
					<?php endforeach;?>
				</ul>
				<?php if($totalRows>$pageSize):?>
	        	<div class="news_page">
	        		<?php echo newsPage($page, $totalPage,'id=1');?>
	        	</div>
			    <?php endif;?> 
			</div>
			
			<div class="abo_client" id="abo2"  style="display:none">
				<div class="client_desc">按照字母先后顺序排列</div>
				<ul>
				<?php foreach ($clients as $client):?>
					<li>
						<img alt="<?php echo $client['client_name'];?>" src="admin/client/<?php echo $client['client_img'];?>">
					</li>
				<?php endforeach;?>
				</ul>
					
			</div>
			
			<div class="abo_sites" id="abo3"  style="display:none">
				<div class="rd_sites">
					<div class="rd_sites_title">
						<a href="http://www.52rd.com/" target="_blank"><img alt="" src="images/52rd.jpg"></a>
					</div>
					<p>
						关于52RD.com 我爱研发网（52RD.com）是上海研鼎信息技术有限公司旗下网站，致力于为技术人员提供丰富的网上研发资源，
						以技术工程师适合的形式及熟悉的语言传递市场和产品信息及技术情报，为研发人员提供和分析最新行业咨询和技术趋势。透过商业和
						技术性活动、杂志及电子商务产品，为中国技术工程师提供领先竞争所需的商业及技术资讯，并一直居于领导地位。
					</p>
					<h3>我们为业内工程师提供的服务包含：</h3>
					<p>1、业内资讯：最新的业内资讯，包含专业人士的网评；</p>
				    <p>2、52RD研发论坛：互动的交流、资源共享平台；</p>
				    <p>3、R&D Blog：专业的技术人博客/空间；</p>
				    <p>4、研发求职：为业内工程师搭建的便捷求职系统；</p>
				    <p>5、52RD.net：研发资源/网址导航。</p>
				    <p>6、《研发专辑》杂志：免费送读的行业杂志媒体</p>
				    <h3>我们为业内的企业提供的服务包含：</h3>
				    <p>1、企业产品供需平台：为企业产品打开销路，为企业提供完善的在线服务；</p>
      				<p>2、企业人才招聘系统：为企业提供快捷的人才招聘服务；</p>
				</div>
				<div class="rd_sites">
					<div class="rd_sites_title">
						<a href="http://www.rdbuy.com/" target="_blank"><img alt="" src="images/rdbuy_new.png"></a>
					</div>
					<p>
						研鼎商城（rdbuy.com）是上海研鼎信息技术有限公司旗下网站，致力于为科技产业的公司和科研机构提供丰富的一站式工程师网上
						购物平台，为工程师提供和分析最新的实验室测试测量仪器设备。 RDbuy.com 代理分销国内外众多测试测量提供商的产品，比如
						Agilent、Fluke、Tektronix、Anritsu、等等。同时我们是日本DNP、壶板电机，美国Imatest、Xrite，德国
						Image Engineer、法国DXO在中国的一级代理商和独家技术服务商。 我们可以为企业提供音频，影像，射频，信号等完整测
						试解决方案，我们不仅仅是分销仪器，而且能为企业工程师提供技术咨询和方案集成。我们可以在企业刚规划实验室就开始介入，可
						以承接实验室的建设。从2005年开始，我们一直努力的服务国内科技行业，赢得了众多客户的认可和赞扬。
					</p>
				</div>
				
			</div>
			
		</div>
	</div>
	
	<?php include 'bottom.php';?>
<script type="text/javascript">
window.onload = function (){
	thisMenu(<?php echo empty($_REQUEST['id'])?0:$_REQUEST['id'];?>);
}
//点击左侧菜单
function thisMenu(id){
    var thisMenu = document.getElementById("abo_menu").getElementsByTagName("li");
    for(i=0;i<thisMenu.length;i++){
        if(i==id){
        	thisMenu[i].style.color="#333333";
        	thisMenu[i].style.borderRight="3px solid #4ba0fa";
        }
        else{
        	thisMenu[i].style.color="#808080";
        	thisMenu[i].style.borderRight="none";
        }

		var aboInfo = document.getElementById('abo' + (i));
		aboInfo.style.display = 'none';

		var spanInfo = document.getElementById('span' + (i));
		spanInfo.style.display = 'none';
    }
	var div = document.getElementById('abo' + id);
	div.style.display = 'block';
	var span = document.getElementById('span' + id);
	span.style.display = 'block';
}

</script>
</body>
</html>