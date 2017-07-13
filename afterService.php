<?php 
require_once 'include.php';
//得到数据库中所有服务流程单
$process = fetchAll("select f.filePath from file f join download d on f.did=d.id where d.down_cate=3 and d.service=1");
//得到数据库中所有定期校准单
$calibration = fetchAll("select f.filePath from file f join download d on f.did=d.id where d.down_cate=3 and d.service=2");

?>
<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>研鼎-售后服务与支持</title>
<link type="text/css" rel="stylesheet" href="styles/reset.css">
<link type="text/css" rel="stylesheet" href="styles/main.css">
<script type="text/javascript" src="scripts/search.js"></script>
</head>
<body>
	<?php include 'head.php';?>
	<div class="after_list_top"></div>
	<div class="after_list_content" style="overflow: hidden">
		<div class="after_list_left">
			<div class="elf_top" style="position:absolute;">
				<img alt="" src="images/service/after_ltop.png" style="position:absolute;z-index:9000;">
			</div>
			<div class="lafter_menu">
				<ul id="emp_menu">
					<li class="elf_center check" onclick="thisMenu(0)">服务流程</li>
					<li class="elf_center" onclick="thisMenu(1)">定期校准</li>
				</ul>
			</div>
			<div class="lafter_bottom">
				<img alt="" src="images/news/news_lbottom.png">
			</div>
		</div>
		<div class="after_list_right">
			<div class="emp_list_title">
				<a href="index.php"><img alt="" src="images/news/news_rtop.png"></a>
				<a href="serviceList.php"><span style="width: 115px;">&gt;&gt;&nbsp;我们的服务</span></a>
				<span class="person_emp" id="span0">&gt;&gt;&nbsp;服务流程</span>
				<span class="person_idea" id="span1" style="display:none">&gt;&gt;&nbsp;定期校准</span>
			</div>
			
			<div class="after_process" id="emp0">
				<p style="padding-left: 0">研鼎维修服务中心成立于2012年，地点在上海的张江高科技园区，负责研鼎销售的产品的维修与校准服务。</p>
				<h4>维修流程</h4>
				<ul>
					<li><h5>1. 电话邮件联系</h5>
						<div>客户电话/邮件联系维修中心<br>
						电话:<em style="color:#4ba0fa">021-60497127</em>&nbsp;&nbsp;&nbsp;&nbsp;邮件:<em style="color:#4ba0fa">support@rdbuy.com</em>
						</div>
					</li>
					<li><h5>2. 产品支持状态</h5>
						<div>提供产品名称、型号和序列号，以查询是否在保修期内</div>
					</li>
					<li><h5>3. 诊断测试 </h5>
						<div>研鼎工程师或者原厂工程师确认问题原因，无法客户现场解决的问题需要以原包装或者可靠的保证快递给研鼎维修中心。</div>
					</li>
					<li><h5>4. 报价 </h5>
						<div>测试完毕，若产生费用，维修中心将提供<<维修报价单>>。客户确认<<维修报价单>>并签字回传报价单，仪器反厂维修。</div>
					</li>
					<li><h5>5. 测试完成，款到发货 </h5>
						<div>仪器完成测试，通知客户付款。我们收到客户维修全款后，维修中心安排发货，邮寄发票</div>
					</li>
					<li><h5>6. 售后服务完成 </h5>
						<div></div>
					</li>
				</ul>
				<h4>保修服务</h4>
				<p>
				保修期是自仪器购买日起一年。如购买了《延保服务合同》，保修期自动延长到合同终止。</p>
				<p>保修期内我们将提供免费维修。但保修服务不包括以下情况：</p>
				<ul>
					<li><h5>1. 不小心使用造成的损坏，如摔坏或渗液腐蚀等；</h5></li>
					<li><h5>2. 不当使用造成的损坏（不按照操作说明书使用）；</h5></li>
					<li><h5>3. 在《产品用户手册或说明书》所述温度、湿度的条件外过冷过热进行操作或存储仪器而造成的故障;</h5></li>
					<li><h5>4. 由于非经我司授权和认可的拆机、维修或改造而造成的问题；</h5></li>
					<li><h5>5. 由于不可抗力和意外（如自然灾害、火灾等）造成的故障和损坏；</h5></li>
					<li><h5>6. 易耗品（如光源、图卡、玻璃、电池等）的消耗；</h5></li>
					<li><h5>7. 校准服务。</li>
				</ul>
				<!--  
				<h4>保修期表格单下载</h4>
				<ul class="after_guarantee"  style="overflow: hidden">
					<?php foreach ($process as $proce):?>
					<li>《<?php echo explode(".",$proce['filePath'])[0];?>》<a href="download.php?filename=<?php echo $proce['filePath'];?>">下载</a></li>
					<?php endforeach;?>
				</ul>
				-->
			</div>
			
			<div class="after_process" id="emp1"  style="display:none">
				<h4>什么是校准？</h4>
				<p>简言之，校准是对仪器设备进行调整以使其达到厂商产品出厂规格的过程。校准有时候也 可以定义为发布产品认证数据。这些数据包括报告或校准证书，它们向最终用户保证产品符合规格并且还可能符合外部标准。</p>
				<div></div>
				<p>一般情况下，应该至少一年执行一次再校准。当然，在非常频繁的或者重要的应用中，再校准频率也可以更高。</p>
				<h4>我司的校准服务</h4>
				<p>如您需要对设备仪器进行校准服务，可以发邮件到<em style="color:#4ba0fa">support@rdbuy.com</em>，请您在邮件中注明产品名称、产品序列号（SN号）、购买日期等信息，以及相关联系方式。
我司同事会及时联系您，并给出具体产品的校准方案。
				</p>
				
				<!--  
				<h4>维修单下载</h4>
				
				<ul class="after_guarantee"  style="overflow: hidden">
					<?php foreach ($calibration as $cali):?>
					<li>《<?php echo explode(".",$cali['filePath'])[0];?>》<a href="download.php?filename=<?php echo $cali['filePath'];?>">下载</a></li>
					<?php endforeach;?>
				</ul>
				-->
			</div>
		</div>
	</div>
	<?php include 'bottom.php';?>
<script type="text/javascript">
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