<?php
require_once 'string.func.php';
//通过GD库做验证码
//创建画布
function verifyImage($type = 1,$length = 4,$pixel = 0,$line = 0,$sess_name = "verify"){
	$width = 80;
	$height = 28;
	$image = imagecreatetruecolor($width, $height);
	$white = imagecolorallocate($image, 255, 255, 255);
	$black = imagecolorallocate($image, 0, 0, 0);
	//用填充矩形填充画布
	imagefilledrectangle($image, 1, 1, $width-2, $height-2, $white);
	
	$chars = buildRandomString($type,$length);
	
	$_SESSION[$sess_name] = $chars;
	$fontfiles = array("SIMYOU.TTF","GB18030.TTF","GB2312.TTF","LZXYBKT.TTF","YLQJHT.TTF");
	for ($i=0;$i<$length;$i++){
		$size = mt_rand(14,18);
		$angle = mt_rand(-15, 15);
		$x = 5+$i*$size;
		$y = mt_rand(20, 26);
		$color = imagecolorallocate($image, mt_rand(50, 90), mt_rand(80, 200), mt_rand(90, 180));
		$fontfile = "../fonts/" .$fontfiles[mt_rand(0, count($fontfiles)-1)];
		$text = substr($chars, $i,1);
		imagettftext($image, $size, $angle, $x, $y, $color, $fontfile, $text);
	} 
	if ($pixel) {
		for ($i=0;$i<$pixel;$i++){
			imagesetpixel($image, mt_rand(0,$width-1), mt_rand(0, $height-1),$black);
		}
	}
	if ($line){
		for ($i=0;$i<$line;$i++){
			imageline($image, mt_rand(0,$width-1), mt_rand(0, $height-1), mt_rand(0,$width-1), mt_rand(0, $height-1), $color);
		}
	}
	
	header("content-type:image/gif");
	imagegif($image);
	imagedestroy($image);
}

/**
 * 生成相应的缩略图
 * @param string $filename
 * @param string $destination
 * @param int $dst_w
 * @param int $dst_h
 * @param bool $isReservedSource
 * @param number $scale
 * @return string
 */
function thumb($filename,$destination=null,$dst_w=null,$dst_h=null,$isReservedSource=true,$scale=0.5){
	list($src_w,$src_h,$imagetype) = getimagesize($filename);
	if (is_null($dst_w)||is_null($dst_h)) {
		$dst_w = ceil($src_w*$scale);
		$dst_h = ceil($src_h*$scale);
	}
	$mime = image_type_to_mime_type($imagetype);
	$createFun = str_replace("/", "createfrom", $mime);
	$outFun = str_replace("/", null, $mime);
	$src_image = $createFun($filename);
	$dst_image = imagecreatetruecolor($dst_w, $dst_h);
	imagecopyresampled($dst_image, $src_image, 0, 0, 0, 0, $dst_w, $dst_h, $src_w, $src_h);
	//image_50/sddsfdasdfa.jpg
	if ($destination&&!file_exists(dirname($destination))) {
		mkdir(dirname($destination),0777,true);
	}
	$dstFilename = $destination==null?getUniName() ."." .getExt($filename):$destination;
	$outFun($dst_image,$dstFilename);
	imagedestroy($src_image);
	imagedestroy($dst_image);
	if (!$isReservedSource) {
		unlink($filename);
	}
	return $dstFilename;
}

/**
 *添加文字水印
 * @param string $filename
 * @param string $text
 * @param string  $fontfile
 */
function waterText($filename,$text="yanding.com",$fontfile="SIMYOU.TTF"){
	$fileInfo = getimagesize ( $filename );//获得图片信息，长、宽、格式
// 	var_dump($fileInfo);
	$mime = $fileInfo ['mime'];//输出"image/jpeg"
	$createFun = str_replace ( "/", "createfrom", $mime );//imagecreatefromjpeg
// 	var_dump($createFun);
	$outFun = str_replace ( "/", null, $mime );//imagejpeg
// 	var_dump($outFun);
	$image = $createFun ( $filename );//由文件或 URL创建一个新图象。
// 	var_dump($image);
	$color = imagecolorallocatealpha ( $image, 255, 0, 0, 80 );//为一幅图像分配颜色 + alpha(透明度0-127)
	$fontfile = "../fonts/{$fontfile}";
	imagettftext ( $image, 24, 0, 5, 30, $color, $fontfile, $text );//用XX字体向图像写入文本
	$outFun ( $image, $filename );//输出图象到浏览器或文件。
	imagedestroy ( $image );
}

/**
 *添加图片水印
 * @param string $dstFile
 * @param string $srcFile
 * @param int $pct
 */
function waterPic($dstFile,$srcFile="../images/logo1.png",$pct=80){
	$srcFileInfo = getimagesize ( $srcFile );
	$src_w = $srcFileInfo [0];
	$src_h = $srcFileInfo [1];
	$dstFileInfo = getimagesize ( $dstFile );
	$srcMime = $srcFileInfo ['mime'];
	$dstMime = $dstFileInfo ['mime'];
	$createSrcFun = str_replace ( "/", "createfrom", $srcMime );
	$createDstFun = str_replace ( "/", "createfrom", $dstMime );
	$outDstFun = str_replace ( "/", null, $dstMime );
	$dst_im = $createDstFun ( $dstFile );
	$src_im = $createSrcFun ( $srcFile );
	imagecopymerge_alpha ( $dst_im, $src_im, 0, 0, 0, 0, $src_w, $src_h, $pct );//拷贝并合并图像的一部分
	//	header ( "content-type:" . $dstMime );
	$outDstFun ( $dst_im, $dstFile );
	imagedestroy ( $src_im );
	imagedestroy ( $dst_im );
}

function imagecopymerge_alpha($dst_im, $src_im, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $pct){
	$opacity=$pct;
	// getting the watermark width
	$w = imagesx($src_im);
	// getting the watermark height
	$h = imagesy($src_im);
	 
	// creating a cut resource
	$cut = imagecreatetruecolor($src_w, $src_h);
	// copying that section of the background to the cut
	imagecopy($cut, $dst_im, 0, 0, $dst_x, $dst_y, $src_w, $src_h);
	// inverting the opacity
	//$opacity = 100 - $opacity;
	 
	// placing the watermark now
	imagecopy($cut, $src_im, 0, 0, $src_x, $src_y, $src_w, $src_h);
	imagecopymerge($dst_im, $cut, $dst_x, $dst_y, $src_x, $src_y, $src_w, $src_h, $opacity);
}














