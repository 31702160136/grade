<?php
include_once "./../utils/session_status.php";
include_once "./../handler/handler.php";
include_once "./../boss/boss.php";
boss("out_login");
sessionOutLogin();
succeed("退出登陆成功");
?>