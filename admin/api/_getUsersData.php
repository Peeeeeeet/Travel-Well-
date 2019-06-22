<?php   
include_once '../../functions.php';             
//连接数据库
$conn = connect();
//sql语句
$sql = "select * from users";
//
$queryResult = query($conn,$sql);

//
$response = ["code"=>0,"msg"=>"操作失败"];
if($queryResult){
    $response["code"]=1;
    $response["msg"]="操作成功";
    $response["data"]=$queryResult;
  
  }
  
  header('content-type:application/json;charset=utf-8');
  echo json_encode($response);
?>