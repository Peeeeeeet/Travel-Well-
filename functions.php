<?php                
include_once "config.php";
/*
    检查登录状态
    先完成登陆的验证 - 除了登录页面都需要做登录的验证
    没有isLogin这个key,有isLogin,但是值跟我们在登录时候存储的不一样
 */
function checkLogin(){
    session_start();
    if(!isset($_SESSION["isLogin"]) || $_SESSION["isLogin"] != 1){
        header("Location:login.php");
      }
}
//1.创建链接
function connect(){
    $conn = mysqli_connect(DB_HOST,DB_USER,DB_PWD,DB_NAME);

    if(!$conn){
        die("数据库连接失败");
    }
    return $conn;
}

//2. 执行查询
function query($conn,$sql){
    $res = mysqli_query($conn,$sql);
    return fetch($res);
}
//3.循环数组
function fetch($res){
    $arr=[];
    
    while($row = mysqli_fetch_assoc($res)){
        $arr[]=$row;
    }
    return $arr;
}
?>