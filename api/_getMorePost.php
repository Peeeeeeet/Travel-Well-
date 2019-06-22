<?php  

require_once '../functions.php';
/**
 * 实现加载更多api
 */
//1.获取必要的参数
    $categoryID = $_POST["categoryID"]; //分类ID
    $currentPage = $_POST["currentPage"];//当前第几次点击
    $pageSize = $_POST["pageSize"];//请求的条数
    //从哪里开始取 = (第几次点击-1） * 请求条数 
    $offset = ($currentPage-1) * $pageSize; 
//2.查询数据库
$conn = connect();

$sql="SELECT p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,

(SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount

FROM posts p

LEFT JOIN categories c on c.id = p.category_id

LEFT JOIN users u on u.id = p.user_id

WHERE p.category_id = {$categoryID}

LIMIT {$offset},{$pageSize}";
  //执行sql语句 
 $postArr = query($conn,$sql);


 //准备总共有多少条数据的sql
$countSql = "select count(id) as total from posts where category_id = {$categoryID}";
$countArr = query($conn,$countSql);
 //print_r($countArr);
$count=$countArr[0]['total'];
//计算总共能点几次
$total=ceil($count / $pageSize);
//  print($total);

//返回数据
/**
 * {
 * "code":0 失败  1成功
 * "msg": 操作信息
 * "data":返回数据
 * }
 */
$response = ["code"=>0,"msg"=>"操作失败"];

if($postArr){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['data']=$postArr;
    $response["total"]=$total;
  }

  header('content-type:application/json;charset=utf-8');
  echo json_encode($response);

?>

