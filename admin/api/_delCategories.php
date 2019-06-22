<?php   
include_once '../../functions.php';

//删除多个

//获取要删除的数据的id
$ids = $_POST["ids"];
//连接数据库
$conn = connect();
//$str = implode(',',$ids);
//$str = implode(',',$ids);
//sql语句
$sql=" DELETE FROM categories WHERE id in ('".implode("','",$ids)."') ";
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
