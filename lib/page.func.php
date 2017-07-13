<?php 

function showPage($page,$totalPage,$where=null,$sep="&nbsp;"){
	$where=($where==null)?null:"&".$where;
	$url = $_SERVER ['PHP_SELF'];
	$index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
	$last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
	$prevPage=($page>=1)?$page-1:1;
	$nextPage=($Page>=$totalPage)?$totalPage:$page+1;
	$prev = ($page == 1) ? "上一页" : "<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
	$next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
	$str = "总共{$totalPage}页/当前是第{$page}页";
	for($i = 1; $i <= $totalPage; $i ++) {
		//当前页无连接
		if ($page == $i) {
			$p .= "[{$i}]";
		} else {
// 			$p .= "<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
			if ($page-$i>=6&&$i!=1) {//只显示前5个页码
				$p .= "<b>...</b>";
				$i = $page-4;//将页码跳到没有省略号的页码
			}else {
				if ($i>=$page+5&&$i!=$totalPage) {//只显示当前页的后4个页码
					$p .= "<b>...</b>";
					$i = $totalPage;//将页码跳到最后一页
				}
				$p .= "<a href='{$url}?page={$i}{$where}'>[{$i}]</a>";
			}
		}
	}
 	$pageStr=$str.$sep . $index .$sep. $prev.$sep . $p.$sep . $next.$sep . $last;
 	return $pageStr;
}

// function showIndexPage($page,$totalPage,$where=null,$sep="&nbsp;"){
// 	$where=($where==null)?null:"&".$where;
// 	$url = $_SERVER ['PHP_SELF'];
// 	$index = ($page == 1) ? "首页" : "<a href='{$url}?page=1{$where}'>首页</a>";
// 	$last = ($page == $totalPage) ? "尾页" : "<a href='{$url}?page={$totalPage}{$where}'>尾页</a>";
// 	$prevPage=($page>=1)?$page-1:1;
// 	$nextPage=($Page>=$totalPage)?$totalPage:$page+1;
// 	$prev = ($page == 1) ? "上一页" : "<a href='{$url}?page={$prevPage}{$where}'>上一页</a>";
// 	$next = ($page == $totalPage) ? "下一页" : "<a href='{$url}?page={$nextPage}{$where}'>下一页</a>";
// 	$str = "总共{$totalPage}页/当前是第{$page}页";
// 	for($i = $totalPage; $i >= 1; $i --) {
// 		//当前页无连接
// 		if ($page == $i) {
// 			$p .= "<b>{$i}</b>";
// 		} else {
// 			$p .= "<b><a href='{$url}?page={$i}{$where}'>{$i}</a></b>";
// 		}
// 	}
// 	$pageStr=$p.$sep;
// 	return $pageStr;
// }

function newsPage($page,$totalPage,$where=null,$sep="&nbsp;"){
	$where=($where==null)?null:"&".$where;
	$url = $_SERVER ['PHP_SELF'];
// 	$index = ($page == 1) ? "<b>首页</b>" : "<b><a href='{$url}?page=1{$where}'>首页</a></b>";
// 	$last = ($page == $totalPage) ? "<b>尾页<b>" : "<b><a href='{$url}?page={$totalPage}{$where}'>尾页</a></b>";
	$prevPage=($page>=1)?$page-1:1;
	$nextPage=($Page>=$totalPage)?$totalPage:$page+1;
	$prev = ($page == 1) ? "<b>上一页</b>" : "<b><a href='{$url}?page={$prevPage}{$where}'>上一页</a></b>";
	$next = ($page == $totalPage) ? "<b>下一页</b>" : "<b><a href='{$url}?page={$nextPage}{$where}'>下一页</a></b>";
	$str = "共{$totalPage}页";
	for($i = 1; $i <= $totalPage; $i ++) {
		//当前页无连接
		if ($page == $i) {
			$p .= "<b  style='color:#4ca0fa;'>{$i}</b>";
		} else {
			//$p .= "<b><a href='{$url}?page={$i}{$where}'>{$i}</a></b>";
			if ($page-$i>=4&&$i!=1) {//只显示前3个页码
				$p .= "<b>...</b>";
				$i = $page-4;//将页码跳到没有省略号的页码
			}else {
				if ($i>=$page+3&&$i!=$totalPage) {//只显示当前页的后两个页码
					$p .= "<b>...</b>";
					$i = $totalPage;//将页码跳到最后一页
				}
				$p .= "<b><a href='{$url}?page={$i}{$where}'>{$i}</a></b>";
			}
		}
	}
	$pageStr=$sep . $prev.$sep . $p.$sep . $next.$sep  .$str;
	return $pageStr;
}
function marketPage($page,$totalPage,$type,$sep="&nbsp;"){
	$where=($where==null)?null:"&".$where;
	$type = "&type=" .$type;
	$url = $_SERVER ['PHP_SELF'];
	// 	$index = ($page == 1) ? "<b>首页</b>" : "<b><a href='{$url}?page=1{$where}'>首页</a></b>";
	// 	$last = ($page == $totalPage) ? "<b>尾页<b>" : "<b><a href='{$url}?page={$totalPage}{$where}'>尾页</a></b>";
	$prevPage=($page>=1)?$page-1:1;
	$nextPage=($Page>=$totalPage)?$totalPage:$page+1;
	$prev = ($page == 1) ? "<b>上一页</b>" : "<b><a href='{$url}?page1={$prevPage}{$where}{$type}'>上一页</a></b>";
	$next = ($page == $totalPage) ? "<b>下一页</b>" : "<b><a href='{$url}?page1={$nextPage}{$where}{$type}'>下一页</a></b>";
	$str = "共{$totalPage}页";
	for($i = 1; $i <= $totalPage; $i ++) {
		//当前页无连接
		if ($page == $i) {
			$p .= "<b  style='color:#4ca0fa;'>{$i}</b>";
		} else {
			$p .= "<b><a href='{$url}?page1={$i}{$where}{$type}'>{$i}</a></b>";
		}
	}
	$pageStr=$sep . $prev.$sep . $p.$sep . $next.$sep  .$str;
	return $pageStr;
}



