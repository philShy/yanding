<?php
require_once 'include.php';
session_unset();
session_destroy();

echo "<script>alert('退出成功');location.href='index.php';</script>";