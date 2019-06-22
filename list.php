<?php                
include_once 'functions.php';
/*
根据分类id对文章数据进行查询，动态生成文章列表
1.获取分类id
2根据分类id查询数据库
3.动态生成结构
*/
//1.获取分类id
$categoryId = $_GET["categoryId"];
//2根据分类id查询数据库
$conn = connect();
$sql = "SELECT p.id,p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
# 根据文章id到comments表格中查找对应的评论数量
(SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount FROM posts p
  # 联表查询
  LEFT JOIN categories c on c.id = p.category_id
  LEFT JOIN users u on u.id = p.user_id
  # 筛选一下不展示的分类
  WHERE p.category_id = {$categoryId}
  # 倒序排列
  order BY p.created desc
  # 限定数量
  LIMIT 10";
$listArr = query($conn,$sql);
//print_r($listArr);

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
      <div class="panel new">
        <h3><?php echo $listArr[0]['name'] ?></h3>

        <?php                
        foreach ($listArr as $value) { ?>
         <div class="entry">
          <div class="head">
            <span class="sort"><?php echo $value['name']; ?></span>
            <a href="detail.php?postId=<?php echo $value['id'] ?>"><?php echo $value['title'];?></a>
          </div>
          <div class="main">
            <p class="info"><?php echo $value['nickname'] ; ?> 发表于 <?php echo $value['created'] ; ?></p>
            <p class="brief"><?php echo $value['content'] ; ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php echo $value['views'] ; ?>)</span>
              <span class="comment">评论(<?php echo $value['commentsCount'] ; ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php echo $value['likes'] ; ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value['name'] ; ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="<?php echo $value['feature'] ?>" alt="">
            </a>
          </div>
          
        </div>
          <?php  } ?>
          
     <div class="loadmore">
     <span class="btn">加载更多</span>
     </div>
      </div>
    </div>
    <div class="footer">
      <p>© 2016 XIU主题演示 本站主题由 themebetter 提供</p>
    </div>
  </div>
  <script src="./static/assets/vendors/jquery/jquery.min.js"></script>
  <script src="./static/assets/vendors/nprogress/nprogress.js"></script>
  <script src="./static/assets/vendors/art-template/template-web.js"></script>
  <script type="text/template" id="entry">
    {{each data as value index}}
    <div class="entry">
          <div class="head">
          <span class="sort"><?php  echo $value['name'] ?></span>
            <a href="detail.php?postId={{value.id}}">{{value.title}}</a>
          </div>
          <div class="main">
            <p class="info">{{value.nickname}} 发表于 {{value.created}}</p>
            <p class="brief">{{value.content}}</p>
            <p class="extra">
              <span class="reading">阅读({{value.views}})</span>
              <span class="comment">评论({{value.commentsCount}})</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞({{value.likes}})</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span>{{value.name}}</span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="<?php echo $value['feature'] ?>" alt="">
            </a>
          </div>
        </div>
    {{/each}}

  </script>
  <script>
    $(function(){
    //1.给加载更多添加点击事件
    var currentPage = 1;
    $(".loadmore .btn").on("click",function () {
       var categoryID = location.search.split("=")[1];
       currentPage ++ ;
    //   console.log(currentPage);
      $.ajax({
        type: "post",
        url: "api/_getMorePost.php",
        data:{
        categoryID:categoryID,
        currentPage:currentPage,
        pageSize:10
        },
        dataType: "json",
        success: function (response) {
          if(response.code == 1){  //成功
          var  html =template("entry",response);
       
          $(".loadmore").before(html);
         if(currentPage==response.total){ 
          $(".loadmore").hide();
         }  
        }  
        }
      });
      
      
    })
   
  });
  </script>
</body>
</html>