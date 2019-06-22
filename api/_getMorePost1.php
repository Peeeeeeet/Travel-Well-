<?php      

include_once "../functions.php";
/**
 * 实现加载更多 api
 */
  //1.获取参数  post请求

  $cid=$_POST['cid'];  //分类id
 
  $currentPage = $_POST['currentPage'];//当前第几次点击

  $pageSize = $_POST['pageSize']; //请求条数

  //从哪开始取 = (第几次点击 - 1) * 请求条数   offset= (n-1) * pagesize

  $offset = ( $currentPage -1 ) * $pageSize;

  //2.创建连接

  $conn = connect();

  //3.准备sql
  $sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,

  (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
  
  FROM posts p
  
  LEFT JOIN categories c on c.id = p.category_id
  
  LEFT JOIN users u on u.id = p.user_id
  
  WHERE p.category_id = {$cid}
  
 LIMIT {$offset},{$pageSize}";
  //4.执行sql
  $postArr= query($conn,$sql);

  //5.返回数据
  /**
   *    {
   *     "code": 0 失败  1 成功
   *     "msg" :"操作信息
   *     "data":返回数据
   *     }
   */
  $response = ["code"=>0,"msg"=>"操作失败"];
  if($postArr){
    $response["code"]=1;
    $response["msg"]="操作成功";
    $response["data"]=$postArr;
  }


  header('content-type:application/json;charset=utf-8');
  echo json_encode($response);

?>