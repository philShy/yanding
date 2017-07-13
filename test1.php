<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml"> <head>
<title> New Document </title>
<style type="text/css">
#commentPager{font:12px/16px arial}
#commentPager span{float:left;margin:0px 3px;}
#commentPager a{float:left;margin:0 3px;border:1px solid #ddd;padding:3px 7px; text-decoration:none;color:#666}
#commentPager a.curr,#commentPager a:hover{color:#fff;background:#05c}
</style>
</head>

<body>
<div id="commentPager">

</div>
</body><script type="text/javascript">

setCommentPage(1,60)

function setCommentPage(pageIndex,pageCount)
{
	var temp="";
	if (pageCount != 1)
	{
		if(pageIndex!=1)
		{
			//上一页不启用
			var k=pageIndex-1;
			temp +="<a id='comment"+ k+ "'href='javascript:void(0)' onclick='setCommentPage("+ k+ ","+ pageCount+")'>";
			temp +="上一页</a>";
		}
		for (i = 1; i <= pageCount;i++)
		{
		if (i == pageIndex)//当前页
		{
		temp +="<a id='comment"+ i+ "' class='curr' href='javascript:void(0)' onclick='setCommentPage("+ i+ ","+ pageCount+")'>";
				temp +=i+"</a>";
		}
		else
		{
		if(pageIndex-i>=4&&i!=1)  //只显示当前页前三个页码
		{
		temp+="<span>...</span>";
		i=pageIndex-4;//将页码跳到没有省略的页码
		}
		else
		{
		if(i>=pageIndex+3&&i!=pageCount)  //只显示当前页的后两个页码
			{
					temp+="<span>...</span>";
			i=pageCount;  //将页码跳到最后一页
		}
		temp +="<a id='comment"+ i+ "' href='javascript:void(0)' onclick='setCommentPage("+ i+ ","+ pageCount+")'>";
		temp +=i+"</a>";
		}
		}
		}
		if(pageIndex!=pageCount)
			{
				//下一页不启用
						var k=pageIndex+1;
				temp +="<a id='comment"+ k
				+ "'href='javascript:void(0)' onclick='setCommentPage("+ k+ ","+ pageCount+")'>";
            temp +="下一页</a>";
        }
		}
		document.getElementById("commentPager").innerHTML=temp;
}
</script>
</html>
