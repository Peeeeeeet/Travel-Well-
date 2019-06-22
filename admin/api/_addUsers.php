<?php                
include_once '../../functions.php';
//print_r($_FILES);
//1.获取参数
// print_r($_POST);
$slug =$_POST['slug'];
$email =$_POST['email'];
$nickname =$_POST['nickname'];
$password =$_POST['password'];
$imgPath = $_POST['imgPath'];
$status = $_POST['status'];



$conn = connect();

$countSql = "SELECT count(*)as count FROM users WHERE `email` = '{$email}' ";

$countResult = query($conn,$countSql);


//判断一下   name 是否存在  存在就不添加 否则就添加
$count =$countResult[0]['count'];

$response=['code'=>0,'msg'=>"添加失败"];

if($count>0){ //说明数据存在 应该不添加
    $response['msg']="该名称已存在,添加失败";
}else{  //数据不存在  添加
 //$addSql ="insert into users values(null,'{$slug}','{$email}','{$nickname}','{$password}')";
 $addSql ="insert into users(id,slug, email, nickname,password,avatar,status) values(null,'{$slug}','{$email}','{$nickname}','{$password}','{$imgPath}','{$status}')";

 $addRes=mysqli_query($conn,$addSql);

 if($addRes){
    $response['code']=1;
    $response['msg']="添加成功";
 }
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);

?>