<?php                
include_once "../../functions.php";      
$email = $_POST["email"];

$conn = connect();
$sql = "select * from users where email = '{$email}' ";
$queryRes = query($conn,$sql);
//5.返回数据
$response = ["code"=>0,"msg"=>"操作失败"];
// print_r($queryRes);
if($queryRes){
  $response["code"]=1;
  $response["msg"]="操作成功";
  $response["avatar"]=$queryRes[0]['avatar'];

}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>