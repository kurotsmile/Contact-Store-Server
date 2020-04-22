<?php
session_start();
include "config.php";
include "data.php";
include "function.php";

$view='home';

if(isset($_GET['view'])){
    $view=$_GET['view'];
}

if(isset($_POST['view'])){
    $view=$_POST['view'];
}

if(isset($_GET['log_out'])){
    unset($_SESSION['login']);
}

if(isset($_POST['username'])){
    $user_name=$_POST['username'];
    $user_pass=$_POST['passsword'];
}

$query_login=mysql_query("SELECT * FROM  `carrotsy_work`.`work_user` WHERE `user_name` = '$user_name' AND `user_pass` = '$user_pass' LIMIT 1");
if(mysql_num_rows($query_login)){
    $_SESSION['login']='1';
}
?>
<html>
<head>
    <link rel="icon" href="<?php echo $url;?>/image/icon.ico" type="image/gif" sizes="16x16"/>
    <title>Liên hệ</title>
    <meta charset="utf-8"/>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <link rel="stylesheet" href="<?php echo $url;?>/fonts/css/fontawesome-all.css"/>
    <link rel="stylesheet" href="<?php echo $url;?>/style.css"/>
    <script src="<?php echo $url;?>/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script>
</head>
<body>
<?php
if(isset($_SESSION['login'])){
?>
<ul id="menu_home">
    <li <?php if($view=='home'){?>class="active"<?php }?>><a href="<?php echo $url?>?view=home"><i class="fa fa-home" aria-hidden="true"></i> Tổng quang</a></li>
    <li <?php if($view=='data_user'){?>class="active"<?php }?>><a href="<?php echo $url?>?view=data_user"><i class="fa fa-user" aria-hidden="true"></i> Dữ liệu người dùng</a></li>
    <li <?php if($view=='field'){?>class="active"<?php }?>><a href="<?php echo $url?>?view=field"><i class="fa fa-address-card" aria-hidden="true"></i> Thuộc tính mở rộng</a></li>
    <li <?php if($view=='key_lang'){?>class="active"<?php }?>><a href="<?php echo $url?>?view=key_lang"><i class="fas fa-language"></i> Từ khóa ngôn ngữ</a></li>
    <li <?php if($view=='manager_country'){?>class="active"<?php }?>><a href="<?php echo $url?>?view=manager_country"><i class="fas fa-globe"></i> Quốc gia triển khai</a></li>
    <li <?php if($view=='tool'){?>class="active"<?php }?>><a href="<?php echo $url?>?view=tool"><i class="fas fa-wrench"></i> Công cụ</a></li>
    <li style="float: right;"><a href="<?php echo $url;?>?log_out=1"><i class="fa fa-user" aria-hidden="true"></i> Đăng xuất</a></li>
</ul>
<ul id="menu_work">
<?php
$query_list_app=mysql_query("SELECT * FROM carrotsy_work.`work_app` WHERE `id` != '$app_id'");
while($item_app=mysql_fetch_array($query_list_app)){
?>
    <li><a href="<?php echo $item_app['url'] ?>" target="_blank"><img src="<?php echo $url_work;?>/img.php?url=avatar_app/<?php echo $item_app['id'];?>.png&size=18&type=app"  title="<?php echo $item_app['nam']; ?>" /> <span class="name"><?php echo $item_app['name']; ?></span></a></li>
<?php
}
?>
</ul>
<?php
    include 'page_'.$view.'.php';
}else{
   include "page_login.php"; 
}
?>
</body>
</html>