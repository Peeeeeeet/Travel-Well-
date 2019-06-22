<?php   
include_once '../../functions.php';

//删除对应的id的分类数据

//获取要删除的数据的id
$id = $_POST["id"];
//连接数据库
$conn = connect();
//sql语句
$sql="delete from users where id ='{$id}'";
//执行
$result=mysqli_query($conn,$sql);
//把结果返回给前端

$response = ['code'=>0,'msg'=>'操作失败'];
if($result){
    $response['code']= 1;
    $response['msg']= '操作成功';
}

//将数据以json格式返回前端
header("connect-type:application/json");
echo json_encode($response);
?>