<?php    
//移一定要记得 如果要使用session就要先开启            
//先完成登陆的验证 - 除了登录页面都需要做登录的验证
//1.没有isLogin这个key,有isLogin,但是值跟我们在登录时候存储的不一样
  include_once '../functions.php';
  //调用已经封装好的函数
  checkLogin();
?>
<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Dashboard &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
  <link rel="shortcut icon" href="/bitbug_favicon.ico" />

</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <!-- 抽取公共部分 -->
  <?php include_once 'public/_navbar.php' ?>
  
    <div class="container-fluid">
      <div class="jumbotron text-center">
        <h1>分享你的故事</h1>
        <p>Thoughts, stories and ideas.</p>
        <p><a class="btn btn-primary btn-lg" href="post-add.php" role="button">写文章</a></p>
      </div>
      <div class="row">
        <div class="col-md-4">
          <div class="panel panel-default">
            <div class="panel-heading">
              <h3 class="panel-title">站点内容统计：</h3>
            </div>
            <ul class="list-group">
              <li class="list-group-item"><strong>10</strong>篇文章（<strong>2</strong>篇草稿）</li>
              <li class="list-group-item"><strong>6</strong>个分类</li>
              <li class="list-group-item"><strong>5</strong>条评论（<strong>1</strong>条待审核）</li>
            </ul>
          </div>
        </div>
        <div class="col-md-4"></div>
        <div class="col-md-4"></div>
      </div>
    </div>
  </div>
<?php $currentPage="index" ?>
  <!-- 抽取公共部分 -->
<?php include_once 'public/_aside.php' ?>


  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
</body>
</html>
