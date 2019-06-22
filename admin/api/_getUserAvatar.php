<?php     
include_once "../../functions.php";           
//1.根据用户的id 去查询
session_start();
$userid= $_SESSION["user_id"];
//2.创建连接
$conn = connect();
//3.准备sql
$sql="select * from users where id = '{$userid}' ";
//4.执行sql
$queryRes = query($conn,$sql);
//5.返回数据
$response = ["code"=>0,"msg"=>"操作失败"];
 //print_r($queryRes);
if($queryRes){
  $response["code"]=1;
  $response["msg"]="操作成功";
  $response["data"]=$queryRes[0];
  $response["nickname"]=$queryRes[0]['nickname'];
  $response["avatar"]=$queryRes[0]['avatar'];

}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>