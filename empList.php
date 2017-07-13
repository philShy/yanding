<?php 
require_once 'include.php';
//得到数据库中所有商品
$sql = "select id,position,location,num,duty,requirement,startDate,endDate from employee";
$totalRows=getResultNum($sql);
$pageSize=4;
$totalPage=ceil($totalRows/$pageSize);
$page = $_REQUEST['page']?(int)$_REQUEST['page']:1;
if($page<1||$page==null||!is_numeric($page))$page=1;
if($page>=$totalPage)$page=$totalPage;
$offset=($page-1)*$pageSize;
$sql = "select id,position,location,num,duty,requirement,startDate,endDate from employee limit {$offset},{$pageSize}";
$rows=fetchAll($sql);
?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-招聘信息</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="emp_list_top"></div>
	<div class="emp_list_content">
		<div class="emp_list_left">
			<div class="elf_top">
				<img alt="" src="images/emp/emp_ltop.png">
			</div>
			<div class="lemp_menu">
				<ul id="emp_menu">
					<li class="elf_center check" onclick="thisMenu(0)">人才招聘</li>
					<li class="elf_center" onclick="thisMenu(1)">人才理念</li>
				</ul>
			</div>
			<div class="elf_bottom">
				<img alt="" src="images/emp/emp_lbottom.png">
			</div>
		</div>
		<div class="emp_list_right">
			<div class="emp_list_title">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<span>&gt;&gt;&nbsp;诚聘英才</span>
				<span class="person_emp" id="span0">&gt;&gt;&nbsp;人才招聘</span>
				<span class="person_idea" id="span1" style="display:none">&gt;&gt;&nbsp;人才理念</span>
			</div>
			
			
			<div class="emp_list" id="emp0">
				<ul id="meau">
					<?php $i=0;?>
					<?php foreach ($rows as $row):?>
					<li onclick="thisAction(<?php echo $i;?>)">
						<span class="ePosition" id="position<?php echo $i;?>"><?php echo $row['position'];?></span>
						<span class="eNum" id="num<?php echo $i;?>">( <?php echo $row['num'];?>人 )</span>
						<span class="eLocation" id="location<?php echo $i;?>" style="display: none;"><?php echo $row['location'];?></span>
						<span class="eDate" id="date<?php echo $i;?>"><?php echo date('Y-m-d',$row['startDate']);?>--<?php echo date('Y-m-d',$row['endDate']);?></span>
					</li>
					<div class="emp_li_content" id="div<?php echo $i;?>">
						<h3>岗位职责：</h3>
						<div class="emp_duty"><?php echo $row['duty'];?></div>
						<h3>任职要求：</h3>
						<div class="emp_duty"><?php echo $row['requirement'];?></div>
					</div>
					<?php $i++;?>
					<?php endforeach;?>
				</ul>
				<?php if($totalRows>$pageSize):?>
	        	<div class="news_page" style="width:880px;height:88px;">
	        		<?php echo newsPage($page, $totalPage);?>
	        	</div>
	       		 <?php endif;?>  
			</div>
			
			<div class="emp_idea" id="emp1"  style="display:none">
				<div class="emp_idea_content">
					<h4>人才要求：诚信、激情、奉献、团队、创新、进取。</h4>
					<h4>人才理念：用人为贤、用人不疑、知人善用、量才适用。</h4>
					<h4>用人准则：培养现有人才，吸引急需人才，储备未来人才，重奖有功人才。</h4>
					<h4>人才战略：立足中国大展宏图，开拓视野在国际上一争高下。广纳英才，携手开创研鼎未来。</h4>
				</div>
				<div class="emp_idea_img">
					<img alt="" src="images/emp/emp_idea.png">
				</div>
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
	
<script type="text/javascript">
//点击菜单颜色变化，并跳转到响应的页面
function thisAction(id){
    var thisAction= document.getElementById("meau").getElementsByTagName("li");
    for(i=0;i<thisAction.length;i++){
        if(i==id){
            //li背景图片由原点变为小人
        	thisAction[i].style.background="url(images/emp/emp_man.png) left center no-repeat";

            //职位字体颜色变化，距离左边的边距变化
        	var posInfo = document.getElementById('position' + (i));
        	posInfo.style.color="#faa64c";
        	posInfo.style.paddingLeft="30px";

        	//日期后面的图片变化
        	var dateInfo = document.getElementById('date' + (i));
        	dateInfo.style.background="url(images/emp/emp_uarrow.png) right center no-repeat";

        	//工作地点显示
        	var locInfo = document.getElementById('location' + (i));
        	locInfo.style.display = 'block';
        	
        	//岗位职责和任职要求显示
        	var divInfo = document.getElementById('div' + (i));
        	divInfo.style.display = 'block';

        	//招聘人数显示
        	var numInfo = document.getElementById('num' + (i));
        	numInfo.style.display = 'block';
        }
        else{
        	thisAction[i].style.background="url(images/emp/emp_dot.png) left center no-repeat";

        	var posInfo = document.getElementById('position' + (i));
        	posInfo.style.color="#333333";
        	
        	var dateInfo = document.getElementById('date' + (i));
        	dateInfo.style.background="url(images/emp/emp_darrow.png) right center no-repeat";

        	var locInfo = document.getElementById('location' + (i));
        	locInfo.style.display = 'none';
        	
        	var divInfo = document.getElementById('div' + (i));
        	divInfo.style.display = 'none';

        	//招聘人数不显示
        	var numInfo = document.getElementById('num' + (i));
        	numInfo.style.display = 'none';
        }
    }
}

//点击左侧菜单
function thisMenu(id){
    var thisMenu = document.getElementById("emp_menu").getElementsByTagName("li");
    for(i=0;i<thisMenu.length;i++){
        if(i==id){
        	thisMenu[i].style.color="#333333";
        	thisMenu[i].style.borderRight="3px solid #4ba0fa";
        }
        else{
        	thisMenu[i].style.color="#808080";
        	thisMenu[i].style.borderRight="none";
        }

		var empInfo = document.getElementById('emp' + (i));
		empInfo.style.display = 'none';

		var spanInfo = document.getElementById('span' + (i));
		spanInfo.style.display = 'none';
    }
	var div = document.getElementById('emp' + id);
	div.style.display = 'block';
	var span = document.getElementById('span' + id);
	span.style.display = 'block';
}
</script>
</body>
</html>