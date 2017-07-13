<?php ;
header("content-type:text/html;charset=utf-8");
date_default_timezone_set("PRC");
session_start();
define("ROOT",dirname(__FILE__));
set_include_path("".PATH_SEPARATOR.ROOT. "./lib".PATH_SEPARATOR.ROOT. "./core".PATH_SEPARATOR.ROOT ."/configs".PATH_SEPARATOR.get_include_path());
require_once 'common.func.php';
require_once 'mysql.func.php';
require_once 'image.func.php';
require_once 'page.func.php';
require_once 'upload.func.php';
require_once 'download.func.php';
require_once 'mail.func.php';
require_once 'admin.inc.php';
require_once 'bigCate.inc.php';
require_once 'smallCate.inc.php';
require_once 'braCate.inc.php';
require_once 'pro.inc.php';
require_once 'album.inc.php';
require_once 'news.inc.php';
require_once 'emp.inc.php';
require_once 'que.inc.php';
require_once 'technical.inc.php';
require_once 'down.inc.php';
require_once 'file.inc.php';
require_once 'market.inc.php';
require_once 'model.inc.php';
require_once 'client.inc.php';
require_once 'operate.inc.php';
require_once 'user.inc.php';
require_once 'configs.php';
connect();
if (!APP_BUG) {
	error_reporting(E_ALL || ~E_NOTICE);
}







