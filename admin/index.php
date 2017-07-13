<?php 
require_once '../include.php';
checkLogined();
if(isset($_SESSION['adminId'])){
	$adminId = $_SESSION['adminId'];
}elseif(isset($_COOKIE['adminId'])){
	$adminId = $_COOKIE['adminId'];
}
$user = getAdminById($adminId);
?>
<!doctype html>
<html>
<head>
<meta charset="utf-8">
<title>研鼎后台</title>
<link rel="stylesheet" href="styles/backstage.css">
</head>

<body>
    <div class="head">
            <div class="logo fl"><a href="#"><img alt="" src="images/logo.png"></a></div>
            <h3 class="head_text fr">研鼎信息技术有限公司后台管理系统</h3>
    </div>
    <div class="operation_user clearfix">
       <!--   <div class="link fl"><a href="#">慕课</a><span>&gt;&gt;</span><a href="#">商品管理</a><span>&gt;&gt;</span>商品修改</div>-->
        <div class="link fr">
            <b>欢迎您
            <?php 
				if(isset($_SESSION['adminName'])){
					echo $_SESSION['adminName'];
				}elseif(isset($_COOKIE['adminName'])){
					echo $_COOKIE['adminName'];
				}
            ?>
            
            </b>&nbsp;&nbsp;&nbsp;&nbsp;<a href="http:/www.yandingtech.com/index.php" target="_blank" class="icon icon_i">首页</a><span></span><a href="http://www.yandingtech.com/admin/index.php" class="icon icon_n">刷新</a><span></span><a href="doAdminAction.php?act=logout" class="icon icon_e">退出</a>
        </div>
    </div>
    <div class="content clearfix">
        <div class="main">
            <!--右侧内容-->
            <div class="cont">
                <div class="title">后台管理</div>
      	 		<!-- 嵌套网页开始 -->         
                <iframe src="main.php"  frameborder="0" name="mainFrame" width="100%" height="900px"></iframe>
                <!-- 嵌套网页结束 -->   
            </div>
        </div>
        <!--左侧列表-->
        <div class="menu">
            <div class="cont">
                <div class="title">管理员</div>
                <ul class="mList">
                    <li>
                        <h3><span onclick="show('menu1','change1')" id="change1">+</span>商品管理</h3>
                        <dl id="menu1" style="display:none;">
                        	<dd><a href="addPro.php" target="mainFrame">添加商品</a></dd>
                            <dd><a href="listPro.php" target="mainFrame">商品列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu2','change2')" id="change2">+</span>商品大类管理</h3>
                        <dl id="menu2" style="display:none;">
                        <?php if($user['limits']==1):?>
                        	<dd><a href="addBigCate.php" target="mainFrame">添加商品大类</a></dd>
                        <?php endif;?>
                            <dd><a href="listBigCate.php" target="mainFrame">商品大类列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu3','change3')" id="change3">+</span>商品小类管理</h3>
                        <dl id="menu3" style="display:none;">
                        	<?php if($user['limits']==1):?>
                        	<dd><a href="addSmallCate.php" target="mainFrame">添加商品小类</a></dd>
                        	<?php endif;?>
                            <dd><a href="listSmallCate.php" target="mainFrame">商品小类列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span  onclick="show('menu4','change4')" id="change4" >+</span>品牌分类管理</h3>
                        <dl id="menu4" style="display:none;">
                            <dd><a href="addBraCate.php" target="mainFrame">添加品牌分类</a></dd>
                            <dd><a href="listBraCate.php" target="mainFrame">品牌分类列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu5','change5')" id="change5">+</span>商品图片管理</h3>
                        <dl id="menu5" style="display:none;">
                            <dd><a href="listProImgs.php" target="mainFrame">商品图片列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu6','change6')" id="change6">+</span>型号/料号管理</h3>
                        <dl id="menu6" style="display:none;">
                            <dd><a href="listModels.php" target="mainFrame">型号/料号列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu7','change7')" id="change7">+</span>新闻管理</h3>
                        <dl id="menu7" style="display:none;">
                        	<dd><a href="addNews.php" target="mainFrame">添加新闻</a></dd>
                            <dd><a href="listNews.php" target="mainFrame">新闻列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu8','change8')" id="change8">+</span>招聘信息管理</h3>
                        <dl id="menu8" style="display:none;">
                        	<dd><a href="addEmp.php" target="mainFrame">添加招聘信息</a></dd>
                            <dd><a href="listEmp.php" target="mainFrame">招聘信息列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu9','change9')" id="change9">+</span>下载管理</h3>
                        <dl id="menu9" style="display:none;">
                        	<dd><a href="addDown.php" target="mainFrame">添加下载内容</a></dd>
                            <dd><a href="listDown.php" target="mainFrame">下载列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu10','change10')" id="change10">+</span>技术文章管理</h3>
                        <dl id="menu10" style="display:none;">
                        	<dd><a href="addTech.php" target="mainFrame">添加技术文章</a></dd>
                            <dd><a href="listTech.php" target="mainFrame">技术文章列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu11','change11')" id="change11">+</span>管理员管理</h3>
                        <dl id="menu11" style="display:none;">
                        <?php if($user['limits']==1):?>
                        	<dd><a href="addAdmin.php" target="mainFrame">添加管理员</a></dd>
                        <?php endif;?>
                            <dd><a href="listAdmin.php" target="mainFrame">管理员列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu12','change12')" id="change12">+</span>客户提问</h3>
                        <dl id="menu12" style="display:none;">
                            <dd><a href="listQue.php" target="mainFrame">客户提问列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu13','change13')" id="change13">+</span>市场活动</h3>
                        <dl id="menu13" style="display:none;">
                        	<dd><a href="addMarket.php" target="mainFrame">添加市场活动</a></dd>
                            <dd><a href="listMarket.php" target="mainFrame">市场活动列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu14','change14')" id="change14">+</span>我们的客户</h3>
                        <dl id="menu14" style="display:none;">
                        	<dd><a href="addClient.php" target="mainFrame">添加客户</a></dd>
                            <dd><a href="listClient.php" target="mainFrame">客户列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu15','change15')" id="change15">+</span>操作记录</h3>
                        <dl id="menu15" style="display:none;">
                            <dd><a href="listOperation.php" target="mainFrame">操作记录列表</a></dd>
                        </dl>
                    </li>
                    <li>
                        <h3><span onclick="show('menu16','change16')" id="change16">+</span>用户管理</h3>
                        <dl id="menu16" style="display:none;">
                            <dd><a href="listUser.php" target="mainFrame">用户列表</a></dd>
                        </dl>
                    </li>                    
                </ul>
            </div>
        </div>

    </div>
    <script type="text/javascript">
    	function show(num,change){
	    		var menu=document.getElementById(num);
	    		var change=document.getElementById(change);
	    		if(change.innerHTML=="+"){
	    				change.innerHTML="-";
	        	}else{
						change.innerHTML="+";
	            }
    		    if(menu.style.display=='none'){
    	             menu.style.display='';
    		    }else{
    		         menu.style.display='none';
    		    }
        }
    </script>
</body>
</html>