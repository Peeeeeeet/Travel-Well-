<?php                
include_once 'functions.php';
$postId =$_GET['postId'];
$conn = connect();
$sql =  "SELECT p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
# 根据文章id到comments表格中查找对应的评论数量
(SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount FROM posts p
  # 联表查询
  LEFT JOIN categories c on c.id = p.category_id
  LEFT JOIN users u on u.id = p.user_id
  # 筛选一下不展示的分类
  WHERE p.id = {$postId}";
//执行sql
$detailArr = query($conn,$sql);
$postArr = $detailArr[0];
//print_r($postArr);
?>


<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>TrvalWell-爱旅行，爱生活!</title>
  <link rel="stylesheet" href="static/assets/css/style.css">
  <link rel="stylesheet" href="static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="shortcut icon" href="/bitbug_favicon.ico" />

</head>
<body>
  <div class="wrapper">
    <div class="topnav">
      <ul>
        <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li>
      </ul>
    </div>
    <?php include_once 'public/_header.php'?>
    <?php include_once 'public/_aside.php'?>
    <div class="content">
    <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <dd><a href="javascript:;"><?php echo $postArr['name'] ?></a></dd>
            <dd><?php echo $postArr['title']?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php echo $postArr['title'] ?></a>
        </h2>
        <div class="meta">
          <span><?php echo $postArr['nickname'] ?> 发布于 <?php echo $postArr['created'] ?></span>
          <span>分类: <a href="javascript:;"><?php echo $postArr['name'] ?></a></span>
          <span>阅读: (<?php echo $postArr['views'] ?>)</span>
          <span>点赞: (<?php echo $postArr['likes'] ?>)</span>
        </div>
        <div class="content-detail"><?php echo $postArr['content'] ?></div>
      </div>
      <div class="panel hots">
        <h3>热门推荐</h3>
        <ul>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/juhua.jpg" alt="">
              <span>开封菊花展</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/door.jpg" alt="">
              <span>黄河水利职业技术学院</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/budala.jpg" alt="">
              <span>西藏布达拉宫！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/lijiang1.jpg" alt="">
              <span>实在太美了！丽江古城欢迎你</span>
            </a>
          </li>
        </ul>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
</body>
</html>
