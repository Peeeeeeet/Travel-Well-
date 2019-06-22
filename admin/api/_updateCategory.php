<?php   
include_once '../../functions.php';         
//获取id
 //获取参数
 $cid =$_POST['cid'];
 $name =$_POST['name'];
 $slug =$_POST['slug'];
 $classname =$_POST['classname'];

//连接数据库
$conn = connect();
//sql语句
$updateSql = "update categories set name = '{$name}' , slug='{$slug}' ,classname = '{$classname}' where id = '{$cid}'";

//执行sql语句
$updateRes=mysqli_query($conn,$updateSql);

//把结果返回给前端

$response = ['code'=>0,'msg'=>'操作失败'];
if($updateRes){
    $response['code']= 1;
    $response['msg']= '操作成功';
}

//将数据以json格式返回前端
header("connect-type:application/json");
echo json_encode($response);
?>