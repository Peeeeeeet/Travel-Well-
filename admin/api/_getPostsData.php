<?php                
include_once "../../functions.php";

$pageSize = $_POST['pageSize'];  //每页数量
$currentPage= $_POST['currentPage']; //当前页
$status=$_POST['status'];
$categoryId=$_POST['categoryId'];


$offset= ($currentPage -1 ) * $pageSize;

$conn = connect();
$where =" where 1=1 ";

if($status!="all"){
    $where.=" and p.`status`= '{$status}'";
}

if($categoryId !="all"){
    $where.=" and p.category_id= '{$categoryId}'";
}

$sql="SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` FROM posts p
left JOIN users u ON u.id = p.user_id
LEFT JOIN categories c ON c.id = p.category_id" . $where ."limit {$offset},{$pageSize}";

$res = query($conn,$sql);

$countSql="select count(*) as count from posts p" .$where;


$countArr = query($conn,$countSql);

$count= $countArr[0]['count'];

$pageCount=ceil($count/$pageSize);

$response=['code'=>0,'msg'=>"操作失败"];
if($res){
  $response['code']=1;
  $response['msg']="操作成功";
  $response['data']=$res;
  $response['pageCount']=$pageCount;
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>