<?php
require_once '../include.php';
checkLogined();
$model = $_POST['model'];
$partNum = $_POST['partNum'];
if (empty($model)&&empty($partNum)) {
	echo -1;
}elseif (empty($model)&&!empty($partNum)) {
	echo -2;
}elseif (!empty($model)&&empty($partNum)) {
	echo -3;
}elseif (!empty($model)&&!empty($partNum)) {
	echo getModel($model, $partNum);
}