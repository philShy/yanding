<!doctype html>
<html>
<head>
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta charset="utf-8">
<title>IE升级提示</title>
<link rel="stylesheet" href="scripts/jquery-ui/css/ui-lightness/jquery-ui-1.10.4.custom.css">
<script type="text/javascript" src="scripts/jquery-2.1.1.js"></script>
<script type="text/javascript" src="scripts/browser.js"></script>
<!--[if lte IE 8]>
<script type="text/javascript" src="scripts/jquery-1.6.4.js"></script>
<![endif]-->
<script type="text/javascript" src="scripts/jquery.cookie.js"></script>
<script type="text/javascript" src="scripts/jquery.ui.js"></script>
</head>
<body onload="getTextWidth();">
<script type="text/javascript">					
function getTextWidth(){
	//window load时li为偶数的距离左边40px
	if ($.cookie("ft") == "" || $.cookie("ft")==undefined) {
        if ($.browser.msie && ($.browser.version == "8.0"||$.browser.version == "7.0"||$.browser.version == "6.0") && !$.support.style) {
            var obj = document.createElement("div");
            obj.setAttribute("id", "ietips");
            obj.style.width = "80%";
            obj.style.height = "60%";
            obj.style.font="italic bold 20px arial,serif";;
            $("body").append(obj);
            $("<span><span class='broswertips'>您的IE浏览器版本太低，请将浏览器升级至9.0以上版本，获得更好的浏览体验！</span></span>").appendTo(obj);
            $("#ietips").dialog({
      		  height:"auto",
      	      width: "auto",
      	      position: {my: "center", at: "center",  collision:"fit"},
      	      modal:true,//是否模式对话框
      	      draggable:true,//是否允许拖拽
      	      resizable:true,//是否允许拖动
      	      title:"提示信息：",//对话框标题
      	      show:"slide",
      	      hide:"explode",
      	      buttons: {
      	         "确认升级": function() {
      	        	window.location="https://www.microsoft.com/zh-cn/download/internet-explorer.aspx";
      	         }
      	      },
      	      close: function() {
      	    	window.location.reload();
          	  }
      		});
        }
        $.cookie('ft', 1, {
            expires: -1,
            path: '/'
        }); // 新建cookie
    }
}
</script>
</body>
</html>