<?php 
require_once 'include.php';
checkBrowser();
$braCate_soft = fetchAll("select distinct(bra_cName) from download where down_cate=1 and product=2 order by bra_cName");

$braCate_doc = fetchAll("select distinct(bra_cName) from download where down_cate=1 and product=1 order by bra_cName");

$search = $_REQUEST['search'];

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-资料下载</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.js"></script>
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body onload="getTextWidth();">
	<?php include 'head.php';?>
	<div class="down_list_top"></div>
	<div class="after_list_content" style="overflow: hidden">
		<div class="after_list_left" style="height:792px;">
			<div class="elf_top" style="position:absolute;">
				<img alt="" src="images/service/down_ltop.png" style="position:absolute;z-index:9000;">
			</div>
			<div class="lafter_menu">
				<ul id="emp_menu">
					<li class="elf_center check" onclick="thisMenu(0)">软件下载</li>
					<li class="elf_center" onclick="thisMenu(1)">产品文档下载</li>
				</ul>
			</div>
			<div class="lafter_bottom" style="height:250px">
				<img alt="" src="images/emp/emp_lbottom.png">
			</div>
		</div>
		<div class="down_list_right">
			<div class="down_list_title">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<a href="serviceList.php"><span style="width: 115px;">&gt;&gt;&nbsp;我们的服务</span></a>
				<span class="person_emp" id="span0" style="left:120px;">&gt;&gt;&nbsp;软件下载</span>
				<span class="person_idea" id="span1" style="display:none;width:160px;left:120px;">&gt;&gt;&nbsp;产品文档下载</span>
				<form target="_blank" method="get" action="downloadList.php">
					<input maxlength="20" size="15" name="search" placeholder="请输入关键字" value="<?php echo $search;?>" class="down_search_text">
					<input type="submit" value="" class="down_submit">
				</form>
			</div>
			
			<div class="downlist_soft" id="down0">
				<div class="downlist_soft_title">
					<h3>软件下载</h3>
					<span>在使用以下软件时，请阅读附带的说明书，然后下载软件。</span>
					<span>若下载安装后仍旧不能正常使用，请与我们的相关工作人员取得联系，他们会及时解答您的问题。</span>
				</div>
				
				<div class="downlist_soft_content">
				<?php foreach ($braCate_soft as $soft):?>
					<h3><?php echo $soft['bra_cName'];?></h3><span class="downlist_soft_black"></span>
					<ul style="overflow: hidden;" class="downlist_soft_ul">
						<?php $softFile = getDownSoftByBra($soft['bra_cName'],$search);
							foreach ($softFile as $_soft):
						?>
						<li><div class="downlist_soft_name"><?php echo $_soft['pName'];?></div>(<?php echo $_soft['soft_password'];?>)
							<?php if(!empty($_SESSION['userId'])):?>
							<a href="<?php echo $_soft['soft_link'];?>">下载</a>
							<?php else :?>
							<a href="<?php echo '#';?>" onclick="logTips()">下载</a>	
							<?php endif;?>
						</li>
						<?php endforeach;?>
					</ul>
				
				
				<?php endforeach;?>
				</div>
			
			</div>
			
			<div id="down1" class="downlist_doc" style="display: none;">
				<div class="downlist_soft_title">
					<h3 style="background:url(images/service/down_docLable.png) 350px center no-repeat;">使用说明书下载</h3>
					<span>在使用以下设备时，请阅读附带的说明书，然后进行操作。</span>
					<span>若按照说明书操作，设备不能正常工作，请与我们的相关工作人员取得联系，他们会及时解答您的问题。</span>
				</div>
				<div class="downlist_soft_content">
				<?php foreach ($braCate_doc as $doc):?>
					<h3><?php echo $doc['bra_cName'];?></h3><span class="downlist_soft_black"></span>
					<ul style="overflow: hidden;" class="downlist_soft_ul">
						<?php $docFile = getFileByBra($doc['bra_cName'],$search);
							foreach ($docFile as $file):
							$size = filesize(iconv('utf-8','gbk', dirname(__FILE__)."/file/{$file['filePath']}"));
							$fileSize = sprintf("%.2f",$size/1024/1024);
						?>
						<li><div class="downlist_soft_name"><?php echo explode(".",$file['filePath'])[0];?></div>(<?php echo $fileSize;?>M)<a href="download.php?filename=<?php echo $file['filePath'];?>">下载</a></li>
						<?php endforeach;?>
					</ul>
				
				<?php endforeach;?>
				</div>
			
			</div>
			
		</div>
	</div>
	
	<?php include 'bottom.php';?>
	
<script type="text/javascript">
$(function() {
    $( document ).tooltip({
      track: true
    });
  });
function logTips(){
	alert("下载软件，请先登录");
	window.location="userAccounts.php?act=log";
}						
function getTextWidth(){
	//window load时li为偶数的距离左边40px
	var downUl=document.getElementsByClassName("downlist_soft_ul");
	for(var i=0;i<downUl.length;i++){
		var downLi = downUl[i].getElementsByTagName("li");
		for(var j=0;j<downLi.length;j++){
			if(j%2==1){
				downLi[j].style.cssText = "margin-left:70px;";
			}
		}
	}
	//window load时设置文档名称超过指定宽度时，用...表示，鼠标放上去弹出框显示文档全名
	var proName=document.getElementsByClassName("downlist_soft_name");
    for(var i=0;i<proName.length;i++){
    	width = proName[i].scrollWidth;
    	text = proName[i].innerHTML;
    	if(width>280){
			proName[i].style.cssText="width:280px;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;";
			proName[i].title = text;
		} 
    }
}

//点击左侧菜单
function thisMenu(id){
    var thisMenu = document.getElementById("emp_menu").getElementsByTagName("li");
    for(i=0;i<thisMenu.length;i++){
    	var downInfo = document.getElementById('down' + (i));
		var spanInfo = document.getElementById('span' + (i));
        if(i==id){
        	thisMenu[i].style.color="#333333";
        	thisMenu[i].style.borderRight="3px solid #4ba0fa";
        	downInfo.style.display = 'block';
        	spanInfo.style.display = 'block';
        	getTextWidth();
        }
        else{
        	thisMenu[i].style.color="#808080";
        	thisMenu[i].style.borderRight="none";
        	downInfo.style.display = 'none';
        	spanInfo.style.display = 'none';
        }
    }
}
</script>
</body>
</html>