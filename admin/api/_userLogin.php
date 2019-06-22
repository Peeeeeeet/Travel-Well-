<?php               
include_once "../../functions.php" ;
//完成用户的请求
/**
 * 
 */
//1.获取邮箱和密码
//email:xxx,password:xxx
$email = $_POST["email"];
$password = $_POST["password"];
//2.根据邮箱和密码到数据库查找有没有对应的数据
//2.1连接数据库
$conn = connect();
//2.2准备sql语句
$sql = "SELECT * from users WHERE email='{$email}' and `password` ='{$password}' and `status`='activated'";
//2.3执行语句 获取数据
$queryResult = query($conn,$sql);
//3判断查询结果是不是有数据
$response = ["code"=>0,"msg"=>"登录失败"];

if($queryResult){
    $response['code']=1;
    $response['msg']="登录成功";
    session_start();
    $_SESSION["isLogin"]=1;
    $_SESSION["user_id"]=$queryResult[0]["id"];
  }

  header('content-type:application/json;charset=utf-8');
  echo json_encode($response);

?>