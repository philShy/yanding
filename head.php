<?php 
require_once 'include.php';
//得到数据库中所有商品大分类
$bigCates = getAllBigCate();
?>
<div class="headerBar">
	<div class="menu_bar">
		<div class="menuBar">
			<div class="tel">
				<?php if ((!isset($_SESSION['nickname'])||empty($_SESSION['nickname']))&&(!isset($_COOKIE['nickname'])||empty($_COOKIE['nickname']))) :?>
				<span>
				<a href="userAccounts.php?act=log">登录</a>&nbsp;&nbsp;|&nbsp;&nbsp;<a href="userAccounts.php?act=reg">注册</a>
				</span>
				<?php else:?>
				<span class="logSpan">
					<?php echo empty($_COOKIE['nickname'])?$_SESSION['nickname']:$_COOKIE['nickname'];?>
					<ul class="logUl">
						<li class="editUserInfo"><a href="editUserInfo.php">修改个人资料</a></li>
						<li class="editUserPwd"><a href="resetMail.php">修改密码</a></li>
						<li class="userLogout"><a href="doLogout.php">退出</a></li>
					</ul>
				</span>
				<?php endif;?>
				
			</div>
			<div class="top_menu fr">
				<ul>
					<li><a href="index.php">网站首页</a></li>
					<li><a href="contactUs.php">联系我们</a></li>
					<li><a href="newsList.php">公司新闻</a></li>
					<li><a href="empList.php">诚聘英才</a></li>
					<span class="index_search" onclick="search()"></span>
				</ul>
			</div>
		</div>
	</div>
	<div class="index_search_div" id="index_search" style="display: none">
		<form target="_blank" method="get" action="productSearch.php">
			<input maxlength="20" size="15" name="search" placeholder="产品搜索" class="index_search_text">
			<input type="submit" value="搜索" class="index_submit">
		</form>
	</div>
	<div class="logo_bar">
		<div class="logoBar">
			<ul class="nav">
				<li>
					<a href="aboutUs.php">关于我们</a>
					<ul class="subnav sub_about">
						<li><a href="aboutUs.php?id=0">公司介绍</a></li>
						<li><a href="aboutUs.php?id=1">分销的品牌</a></li>
						<li><a href="aboutUs.php?id=2">我们的客户</a></li>
						<li><a href="aboutUs.php?id=3">合作的网站</a></li>
					</ul>
				</li>
				<li>
					<a href="serviceList.php">我们的服务</a>
					<ul class="subnav sub_service">
						<li><a href="technicalList.php">技术文章与白皮书</a></li>
						<li><a href="downloadList.php">资料下载</a></li>
						<li><a href="afterService.php">售后服务与支持</a></li>
						<li><a href="marketAct.php">市场活动</a></li>
					</ul>
				</li>
				<li>
					<a href="productList.php">我们的产品</a>
					<ul class="sub_pro subnav">
					<?php foreach ($bigCates as $bigCate):?>
						<li><a href="productClassify.php?big_cId=<?php echo $bigCate['id'];?>"><?php echo $bigCate['big_cName'];?></a></li>
					<?php endforeach;?>
					</ul>
				</li>
			</ul>
		</div>
	</div>
</div>

