# Trvel-Well



## day01

### 01-配置数据

````php
<?php                
/**
 * 数据库主机
 */
define('DB_HOST', '127.0.0.1');

/**
 * 数据库用户名
 */
define('DB_USER', 'root');

/**
 * 数据库密码
 */
define('DB_PASS', 'root');

/**
 * 数据库名称
 */
define('DB_NAME', 'db_baixiu');
?>
````

### 02-封装数据库连接 functions.php

````php
<?php    
include_once 'config.php';           
//连接数据库

  //1 连接

  function connect(){
      $conn = mysqli_connect(DB_HOST,DB_USER,DB_PASS,DB_NAME);
      if(!$conn){
           die('连接失败');
       }
       return $conn;
  }

   //查询
  function query($conn,$sql){
    
       $res=mysqli_query($conn,$sql);
  
       return fetch($res);
}


 //遍历获取数据
function fetch($res){

    while ($row = mysqli_fetch_assoc($res)) {
       
     $arr[]=$row;
    }

    return $arr;
}


?>
````

### 03-动态生成导航

#### 3.1在index.php引入 functions.php

````php
<?php include_once 'functions.php';?>
````

#### 3.2 在_header.php 查询数据 并渲染模板

````php
<?php                
//连接
$conn=connect();

$sql="SELECT * from categories WHERE id !=1";

//执行sql语句

$postArr= query($conn,$sql);

//print_r($postArr);
?>
````

````php
   <ul class="nav">

      <?php foreach ($postArr as $key => $value) { ?>

        <li><a href="javascript:;"><i class="fa <?php echo $value['classname'] ?>"></i><?php echo $value['name'] ?></a></li>
    <?php  } ?>
        <!-- <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li> -->
      </ul>
````

### 04-最新发布

  #### 4.1. 在index.php实现发布

````php
<?php include_once 'functions.php';

//读取数据

 //1 连接数据库

 $conn = connect();

 //准备sql  g  

 $sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
 # 根据文章id到comments表格中查找对应的评论数量
   (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
    FROM posts p
    # 联表查询
   LEFT JOIN categories c on c.id = p.category_id
   LEFT JOIN users u on u.id = p.user_id
   # 筛选一下不展示的分类
   WHERE p.category_id != 1
   # 倒序排列
   order BY p.created desc
   # 限定数量
   LIMIT 5";

 //执行sql

 $newsArr =query($conn,$sql);

?>
````

#### 4.2 模板渲染

````php+HTML
<h3>最新发布</h3>
        <?php                
        foreach ($newsArr as $key => $value) {  ?>
        <div class="entry">
          <div class="head">
            <span class="sort"><?php echo $value['name']; ?></span>
            <a href="javascript:;"><?php echo $value['title'];?></a>
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
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div>
     <?php   } ?>
 </div>
        </div>
````

## day02

### 01-动态跳转界面

#### 1.1在_header.php设置href连接

````php
 <ul class="nav">

      <?php foreach ($postArr as $key => $value) { ?>

        <li><a href="list.php?categoryId=<?php echo $value['id'] ?>"><i class="fa <?php echo $value['classname'] ?>"></i><?php echo $value['name'] ?></a></li>
    <?php  } ?>

      </ul>
````

#### 1.2 在list.php获取数据 并渲染模板

````php
<?php include_once 'functions.php';


$categoryId  =$_GET['categoryId'];

$conn = connect();

$sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
# 根据文章id到comments表格中查找对应的评论数量
  (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
   FROM posts p
   # 联表查询
  LEFT JOIN categories c on c.id = p.category_id
  LEFT JOIN users u on u.id = p.user_id
  # 筛选一下展示的分类
  WHERE p.category_id = {$categoryId}
  # 限定数量
  LIMIT 10";

 $listArr = query($conn,$sql);

 //print_r($listArr);

?>
````

#### 1.3   渲染模板

````php+HTML
<div class="content">
      <div class="panel new">
        <h3><?php echo $listArr[0]['name'] ?></h3>
        <?php                
        foreach ($listArr as $key => $value) {  ?>
        <div class="entry">
          <div class="head">
            <span class="sort"><?php echo $value['name']; ?></span>
            <a href="javascript:;"><?php echo $value['title'];?></a>
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
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div>
     <?php   } ?>
      </div>
    </div>
````

### 02-添加加载更多按钮

#### 2.1在list.php添加

````php+HTML
 <div class="loadmore">
     <span class="btn">加载更多</span>
     </div>
````

#### 2.2在static/assets/css/style.css 添加css

````css
.loadmore {
  text-align: center;
  padding: 50px 0;
}
.loadmore .btn {
  border: 1px solid #ccc;
  border-radius: 7px;
  padding: 10px 20px;
  cursor: pointer;
}
````

#### 2.3添加按钮点击事件  在list.php界面添加



````js
  <script src="static/assets/vendors/jquery/jquery.js"></script>
  <script>
  
  $(function(){
  
  $(".loadmore .btn").on("click",function(){

    
  })
  });
  </script>
````

#### 2.4 创建加载更多 api接口

#### 在根目录创建api文件夹 里面创建 _getMorePost.php

````php
<?php     
  //加载更多的数据 接口
include_once '../functions.php';     

     //获取参数数据
     $categoryId=$_POST['categoryId']; //分类id
     $currentPage=$_POST['currentPage']; //当前请求次数
     $PageSize=$_POST['PageSize']; //每次获取的数量

     //连接数据库
     $conn = connect();

     $offset =($currentPage-1)* $PageSize;    //(n-1)*数量   从哪开始取值
            
     $sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
     # 根据文章id到comments表格中查找对应的评论数量
       (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
        FROM posts p
        # 联表查询
       LEFT JOIN categories c on c.id = p.category_id
       LEFT JOIN users u on u.id = p.user_id
       # 筛选一下展示的分类
       WHERE p.category_id = {$categoryId}
       # 限定数量
      LIMIT {$offset},{$PageSize}";

     $postArr = query($conn,$sql);


     //返回数据
     /**
      *     {
      *        code:0 失败  1 成功
*              msg :提示信息
       *       }

      */

      $response =["code"=>0,"msg"=>"操作失败"];

      if($postArr){
        $response['code']=1;
        $response['msg']="操作成功";
        $response['data']=$postArr;
      }
  
      header('content-type:application/json;charset=utf-8');
      echo json_encode($response);
?>
````

#### 2.5 发送ajax请求

#### 在list.php

````js
  <script src="static/assets/vendors/nprogress/nprogress.js"></script>
  <script>
  $(function(){
   var currentNum=1;
  $(".loadmore .btn").on("click",function(){
    //发送请求
    //获取分类id
      currentNum++;
    var id =location.search.split('=')[1];
    $.ajax({
    type:'post',
    url:'api/_getMorePost.php', 
    datatype:'json', 
    data:{categoryId:id,currentPage:currentNum,PageSize:10},
    success:function(res){
        console.log(res);
                          
    }
    });
    
  })
  });
  </script>
````



####2.6 渲染list.php界面 

   ##### 1.引入模板引擎插件,并生成模板

````js
<script src="static/assets/vendors/art-template/template-web.js"></script>

  <script type="text/template" id="loadmore">
  {{each data  value index}}
  <div class="entry">
          <div class="head">
            <span class="sort">{{value.name}}</span>
            <a href="javascript:;">{{value.title}}</a>
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
              <img src="static/uploads/hots_2.jpg" alt="">
            </a>
          </div>
        </div>
  {{/each}}
  </script>
````

#### 2.7 加载模板数据

````js
success:function(res){
      //  console.log(res);
           if(res.code==1){  //操作成功

      var html =template("loadmore",res);
      $(".loadmore").before(html);
           }   

         var  count=Math.ceil(res.count.num/10);
           if(currentNum==count){
            $(".loadmore").hide();
           }       
    }
````

#### 2.8 解决加载按钮不消失问题

##### 在_getMorePost.php 获取查询分类总记录数

````php
<?php     
  //加载更多的数据 接口
include_once '../functions.php';     

     //获取参数数据
     $categoryId=$_POST['categoryId']; //分类id
     $currentPage=$_POST['currentPage']; //当前请求次数
     $PageSize=$_POST['PageSize']; //每次获取的数量

     //连接数据库
     $conn = connect();

     $offset =($currentPage-1)* $PageSize;    //(n-1)*数量   从哪开始取值
            
     $sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
     # 根据文章id到comments表格中查找对应的评论数量
       (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount
        FROM posts p
        # 联表查询
       LEFT JOIN categories c on c.id = p.category_id
       LEFT JOIN users u on u.id = p.user_id
       # 筛选一下展示的分类
       WHERE p.category_id = {$categoryId}
       # 限定数量
      LIMIT {$offset},{$PageSize}";

     $postArr = query($conn,$sql);



       $numSql="select COUNT(id) as num from posts WHERE category_id={$categoryId}";
       $count = query($conn,$numSql); //获取总记录条数
     //返回数据
     /**
      *     {
      *        code:0 失败  1 成功
*              msg :提示信息
       *       }

      */

      $response =["code"=>0,"msg"=>"操作失败"];

      if($postArr){
        $response['code']=1;
        $response['msg']="操作成功";
        $response['data']=$postArr;
        $response['count']=$count[0];
      }
  
      header('content-type:application/json;charset=utf-8');
      echo json_encode($response);
?>
````

### 03-文章详情

   #### 3.1 文章界面跳转链接 拼接url

#### 首先在 list.php 和 getMorePost.php  sql语句 里面添加  p.id,

````php
 <div class="head">
            <span class="sort"><?php echo $value['name']; ?></span>
            <a href="detail.php?postId=<?php echo $value['id'] ?>"><?php echo $value['title'];?></a>
          </div>
````

#### 3.2 修改 ajax模板 url

````js
<div class="head">
            <span class="sort">{{value.name}}</span>
            <a href="detail.php?postId={{value.id}}">{{value.title}}</a>
          </div>
````

#### 3.2展示文章详情界面

````php
<?php include_once 'functions.php';

//获取postId

$postId= $_GET['postId'];
$conn = connect();

$sql="SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname
   FROM posts p
   # 联表查询
  LEFT JOIN categories c on c.id = p.category_id
  LEFT JOIN users u on u.id = p.user_id
  # 筛选一下展示的分类
  WHERE p.id = {$postId}";

$resArr = query($conn,$sql);

$detailArr=$resArr[0];

//print_r($detailArr);

?>
````

#### 3.3渲染模板界面

````php+HTML
 <div class="article">
        <div class="breadcrumb">
          <dl>
            <dt>当前位置：</dt>
            <dd><a href="javascript:;"><?php echo $detailArr['name'] ?></a></dd>
            <dd><?php echo $detailArr['title'] ?></dd>
          </dl>
        </div>
        <h2 class="title">
          <a href="javascript:;"><?php echo $detailArr['title'] ?></a>
        </h2>
        <div class="meta">
          <span><?php echo $detailArr['nickname'] ?> 发布于 <?php echo $detailArr['created'] ?></span>
          <span>分类: <a href="javascript:;"><?php echo $detailArr['name'] ?></a></span>
          <span>阅读: (<?php echo $detailArr['views'] ?>)</span>
          <span>点赞: (<?php echo $detailArr['likes'] ?>)</span>
        </div>
        <div class="content-detail"> <?php echo $detailArr['content'] ?></div>
      </div>
````

#### 3.4 给文章内容添加css

````css
.content-detail{
  padding-top: 10px;
  text-indent: 2em;
  line-height: 35px;
  font-size: 16px;
}
````

## day03

#### 01-登录

  #### 1.1 修复bug 在functions.php中

````php
 //遍历获取数据
function fetch($res){
    $arr = [];
    while ($row = mysqli_fetch_assoc($res)) {
       
     $arr[]=$row;
    }

    return $arr;
}
````

#### 1.2 在login.php修改样式

````html
 <div class="alert alert-danger" style="display: none;">
        <strong>错误！</strong> <span id="msg"> 用户名或密码错误！</span>
      </div>


<span  id ="btnlogin"class="btn btn-primary btn-block" >登 录</span>
````





#### 1.3 在login.php 发送请求

````php
<script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script>
  $(function(){
  $("#btnlogin").on("click",function() {
    //获取表单数据
   var email=$("#email").val();
   var password=$("#password").val();
   var reg= /\w+[@]\w+[.]\w+/;
   if(!reg.test(email)){
   $("#msg").text("用户名格式错误");
   $(".alert").show();
     return;
   }

   //发送请求

   $.ajax({
   type:'post',
   url:'api/_userLogin.php', 
   datatype:'json', 
   data:{email:email,password:password},
   success:function(res){
       //console.log(res);
       if(res.code==1){
         location.href="index.php";
       }else{
        $("#msg").text("用户名或密码错误");
       $(".alert").show();
       }
                         
   }
   });
  })
  });
  </script>
````

#### 1.4 实现登录接口api  在admin/api/_userLogin.php

````php
<?php include_once '../../functions.php';

//获取参数

$email = $_POST['email'];
$pwd = $_POST['password'];

$conn = connect();
    
$sql="select * from  users where  email ='{$email}'  and   password= '{$pwd}' and status ='activated' ";

$res = query($conn,$sql);

$response =["code"=>0,"msg"=>"登录失败"];
if($res){  //应该登录成功
    $response['code']=1;
    $response['msg']="登录成功";
    session_start();
    $_SESSION['isLogin']=1;
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

#### 1.5 校验登录状态  封装在functions.php  在index.php中调用checkLogin函数

````php
 //验证登录状态
   function checkLogin(){
    session_start();
    if(!isset($_SESSION['isLogin']) || $_SESSION['isLogin']!=1){
      header("Location:login.php");
    }
   }
````

##### 在index.php中调用checkLogin函数

````php

<?php                
include_once '../functions.php';

checkLogin();
?>
````

### 02-导航菜单高亮

#### 2.1 抽离功能模板 在admin\public  创建 _navbar.php 和 _aside.php

####在admin 目录下面 除了login.php 其余全部引入一下代码

````php
  <?php include_once 'public/_navbar.php'?>
  <?php $currentPage="当前界面名字" ?>
  <?php include_once 'public/_aside.php'?>
````

#### 2.2 在aside.php中完成 导航菜单高亮操作

````php
<div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/avatar.jpg">
      <h3 class="name">布头儿</h3>
    </div>
    <ul class="nav">
      <li class="<?php echo $currentPage =="index"? "active":""?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>仪表盘</a>
      </li>
      <li>
      <?php                
          $PageArr=["posts","post-add","categories"];
          $bool=in_array($currentPage,$PageArr);
       //   echo $bool;
      //<a ref="#menu-posts" class="" data-toggle="collapse" aria-expanded="true">
  //   <ul class="collapse in" aria-expanded="true" style="">
        
      ?>
        <a href="#menu-posts" class="<?php echo $bool ? "":"collapsed" ?>" data-toggle="collapse"
        <?php echo $bool ? 'aria-expanded="true"':"" ?>
        >
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo $bool ? "in":""?> "
        <?php echo $bool ? 'aria-expanded="true"':"" ?>
        >
          <li class="<?php echo $currentPage =="posts"? "active":""?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $currentPage =="post-add"? "active":""?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $currentPage =="categories"? "active":""?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php echo $currentPage =="comments"? "active":""?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li class="<?php echo $currentPage =="users"? "active":""?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
      <?php                
       $SetArr=["nav-menus","slides","settings"];
       $bool=in_array($currentPage,$SetArr);
      ?>
        <!-- <a href="#menu-settings" class="collapsed" data-toggle="collapse"> -->
        <a href="#menu-settings" class="<?php echo $bool ? "":"collapsed" ?>" data-toggle="collapse"
        <?php echo $bool ? 'aria-expanded="true"':"" ?>
        >
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <!-- <ul id="menu-settings" class="collapse"> -->
        <ul id="menu-settings" class="collapse <?php echo $bool ? "in":""?> "
        <?php echo $bool ? 'aria-expanded="true"':"" ?>
        >
          <li class="<?php echo $currentPage =="nav-menus"? "active":""?>"><a href="nav-menus.php">导航菜单</a></li>
          <li class="<?php echo $currentPage =="slides"? "active":""?>"><a href="slides.php">图片轮播</a></li>
          <li class="<?php echo $currentPage =="settings"? "active":""?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
````

### 03-实现动态获取头像和昵称

#### 3.0 首先在登录api中存储 用户id

````php
$response =["code"=>0,"msg"=>"登录失败"];
if($res){  //应该登录成功
    $response['code']=1;
    $response['msg']="登录成功";
    session_start();
    $_SESSION['isLogin']=1;
    $_SESSION['userId']=$res[0]['id'];
}
````



#### 3.1在aside.php中发送请求

````php
 <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script>   
  $(function(){
  //动态获取 头像和昵称
  $.ajax({
  type:'post',
  url:'api/_getUserAvator.php', 
  datatype:'json', 
  success:function(res){
          //    console.log(res);
           var profile =$(".profile");
           profile.children('img').attr('src',res.avatar);             
           profile.children('h3').text(res.nickname);             
  }
  });
  });
  
  </script>
````

#### 3.2 实现头像接口_getUserAvatar.php

````php
<?php 

include_once '../../functions.php';
session_start();
$userid=$_SESSION['userId'];
$conn = connect();
$sql="select * from users where id = '{$userid}' ";
$res = query($conn,$sql);

$response=['code'=>0,'msg'=>"操作失败"];
if($res){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['avatar']=$res[0]['avatar'];
    $response['nickname']=$res[0]['nickname'];
}
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

## day04

### 01.实现分类界面表格数据动态展示

   ##### 1.1在categories.php  修改表格结构



````php+HTML
 <div class="form-group">
              <label for="slug">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="类名">
              <p class="help-block">https://zce.me/category/<strong>slug</strong></p>
            </div>
````

````html
  <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
````

````html
<tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>未分类</td>
                <td>uncategorized</td>
                <td>fa-fire</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
````

##### 1.2 发送ajax请求获取分类数据并渲染模板

````php
<script>
  $(function(){   //获取分类数据
  $.ajax({
  type:'post',
  url:'api/_getCategoryData.php', 
  datatype:'json', 
  success:function(res){
        //  console.log(res);
        if(res.code==1){
          var html =template('categorylist',res);
          $('tbody').html(html);
        }
                        
  }
  });
  });
  
  </script>
````

##### 1.3渲染模板

````php+HTML
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script type="text/template" id="categorylist">
  
  {{each data v  i}}
       <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td>{{v.name}}</td>
                <td>{{v.slug}}</td>
                <td>{{v.classname}}</td>
                <td class="text-center">
                  <a href="javascript:;" class="btn btn-info btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
       {{/each}}
  
  </script>
````

##### 1.4实现 数据分类 接口

````php
<?php                
//获取分类数据
include_once '../../functions.php';
$conn = connect();

$sql="select * from categories";

$res = query($conn,$sql);

$response=['code'=>0,'msg'=>"操作失败"];
if($res){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['data']=$res;
  
}
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

### 02-新增分类

#### 2.1 给按钮设置点击事件 并发送请求

````php
<script>
  $(function(){   //获取分类数据


function getCategorylist() {
  $.ajax({
  type:'post',
  url:'api/_getCategoryData.php', 
  datatype:'json', 
  success:function(res){
        //  console.log(res);
        if(res.code==1){
          var html =template('categorylist',res);
          $('tbody').html(html);
        }
                        
  }
  });

}

getCategorylist();
   //添加按钮事件
  $('#btn-add').on('click',function() {
    //1获取数据 并校验
    var name= $('#name').val();
    var slug= $('#slug').val();
    var classname= $('#classname').val();

    if(name==""){
    $('#msg').text("名称不能为空");
    $('.alert').show();
      return;
    }
    if(slug==""){
    $('#msg').text("别名不能为空");
    $('.alert').show();
      return;
    }

    if(classname==""){
    $('#msg').text("类名不能为空");
    $('.alert').show();
      return;
    }
  
    //发送请求
    $.ajax({
      type: "post",
      url: "api/_addCategory.php",
      data: $('#data').serialize(),
      dataType: "json",
      success: function (response) {
        if(response.code==1){
 
          getCategorylist();
          
          $('#name').val("");
         $('#slug').val("");
         $('#classname').val("");
          $('.alert').hide();
        }else{
          $('#msg').text(response.msg);
          $('.alert').show();
        }
        
      }
    });
  })
  });
  
  </script>
````

#### 2.2 实现新增接口 _addcategory.php

````php
<?php                
include_once '../../functions.php';
//1.获取参数

$name =$_POST['name'];
$slug =$_POST['slug'];
$classname =$_POST['classname'];

//2. 连接数据库
$conn = connect();

//2.1
$countSql="select count(*) as count from categories where  name= '{$name}' ";

//判断一下   name 是否存在  存在就不添加 否则就添加
$countRes = query($conn,$countSql);
$count =$countRes[0]['count'];

$response=['code'=>0,'msg'=>"添加失败"];

if($count>0){ //说明数据存在 应该不添加
    $response['msg']="该名称已存在,添加失败";
}else{  //数据不存在  添加
 $addSql ="insert into categories values(null,'{$slug}','{$name}','{$classname}')";
 $addRes=mysqli_query($conn,$addSql);
 if($addRes){

    $response['code']=1;
    $response['msg']="添加成功";
 }
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

### 03-分类编辑

#### 3.1 添加  编辑完成 和取消编辑按钮

````php+HTML
 <div class="form-group">
              <!-- <button class="btn btn-primary" type="submit">添加</button> -->
              <input id="btn-add" type="button" class="btn btn-primary" value="添加" >
              <input  style="display:none" id="btn-edit" type="button" class="btn btn-primary" value="编辑完成" >
              <input style="display:none" id="btn-cancle" type="button" class="btn btn-primary" value="取消编辑" >
            </div>
````

#### 3.2  给按钮添加 .edit  并实现点击事件

````html
 <a href="javascript:;" class="btn btn-info btn-xs edit">编辑</a>
````

#### 3.3 实现编辑 点击事件 并将获取到数据展示出来

````php+HTML
//编辑点击事件
$('tbody').on('click','.edit',function() {
  
  //1 隐藏 显示按钮
   $('#btn-add').hide();
   $('#btn-edit').show();
   $('#btn-cancle').show();
  //2 获取点击编辑按钮对应的数据

   var name =$(this).parents('tr').children().eq(1).text();
   var slug =$(this).parents('tr').children().eq(2).text();
   var classname =$(this).parents('tr').children().eq(3).text();
  //3 将获取数据展示对应目录
          $('#name').val(name);
          $('#slug').val(slug);
          $('#classname').val(classname);
})
````

### 04-点击 编辑完成  更新数据

#### 4.1 添加自定义属性 data-categoryid

````php
<a href="javascript:;" data-categoryid={{v.id}} class="btn btn-info btn-xs edit">编辑</a>
````

#### 4.2  获取分类 并将id存储在  编辑完成按钮里面

````js
//编辑点击事件
$('tbody').on('click','.edit',function() {
  var cid=$(this).attr('data-categoryid'); //获取点击编辑对应的id
  //将id存储在 编辑完成按钮里面
  $('#btn-edit').attr('data-categoryid',cid);
````

#### 4.3注册 编辑完成点击事件 并更新数据

````js
//编辑完成点击事件
$('#btn-edit').on('click',function() {
  //1.获取分类id

  var cid =$(this).attr('data-categoryid');

  //2获取表单数据 并校验
  
   var name= $('#name').val();
    var slug= $('#slug').val();
    var classname= $('#classname').val();
  
     
    if(name==""){
    $('#msg').text("名称不能为空");
    $('.alert').show();
      return;
    }
    if(slug==""){
    $('#msg').text("别名不能为空");
    $('.alert').show();
      return;
    }

    if(classname==""){
    $('#msg').text("类名不能为空");
    $('.alert').show();
      return;
    }

    //发送请求 
    $.ajax({
      type: "post",
      url: "api/_updateCategory.php",
      data: {cid:cid,name:name,slug:slug,classname:classname},
      dataType: "json",
      success: function (response) {
      
      if(response.code==1){  //更新成功
      //1 隐藏 显示按钮
          $('#btn-add').show();
          $('#btn-edit').hide();
          $('#btn-cancle').hide();
          //表格数据为空
          $('#name').val("");
          $('#slug').val("");
          $('#classname').val("");
          //刷新数据
          getCategorylist();

      }
        
      }
    });
  
})
````

#### 4.4 编写 api接口  _updateCategory.php

````php
<?php                
  include_once  '../../functions.php';
   //获取参数
  $cid =$_POST['cid'];
  $name =$_POST['name'];
  $slug =$_POST['slug'];
  $classname =$_POST['classname'];
  

  //连接数据库  编写sql  返回数据

  $conn = connect();

  $updateSql = "update categories set name = '{$name}' , slug='{$slug}' 
  ,classname = '{$classname}' where id = '{$cid}'";

  $updateRes=mysqli_query($conn,$updateSql);

  $response=['code'=>0,'msg'=>"更新失败"];
  if($updateRes){
    $response['code']=1;
    $response['msg']="更新成功";
  }

  header('content-type:application/json;charset=utf-8');
  echo  json_encode($response);
?>
````

### 05-取消编辑按钮

````php
 //取消编辑点击事件
$('#btn-cancle').on('click',function() {
  
  //.先把表格数据情况

         $('#name').val("");
          $('#slug').val("");
          $('#classname').val("");
  //隐藏按钮
  $('#btn-add').show();
   $('#btn-edit').hide();
   $('#btn-cancle').hide();
})
````

#### 06-删除按钮

````php
//删除点击事件
$("tbody").on("click",".del",function() {
  //找到tr
  var row =$(this).parents('tr');
  //获取分类id
  var cid =row.attr("data-categoryid");
  //发送请求
  $.ajax({
    type: "post",
    url: "api/_deleteCategory.php",
    data: {id:cid},
    dataType: "json",
    success: function (response) {
      console.log(response);
      
      if(response.code==1){
        row.remove();
        //刷新
      }
    }
  });
  
})
````



#### 06.1 实现删除接口api _deleteCategory.php

````php
<?php                
include_once '../../functions.php';

//获取参数

$cid =$_POST['id'];

//连接数据库

$conn = connect();

$delSql ="delete from categories where id ='{$cid}' ";

//执行sql

$delRes=mysqli_query($conn,$delSql);


$response=['code'=>0,'msg'=>"删除失败"];

if($delRes){
  $response['code']=1;
  $response['msg']="删除成功";
}

header('content-type:application/json;charset=utf-8');
echo  json_encode($response);
?>
````

#### 07. 全选 和 反选功能

##### 7.1 全选

````php
//全选功能
$('thead input').on('click',function() {
  //获取当前自己的选中状态
  var status= $(this).prop('checked');
  $('tbody input').prop('checked',status);
})
````

##### 7.2反选

````php
$('tbody').on('click','input',function() {
  //获取head
  var all =$('thead input');
  var cks =$('tbody input');


    all.prop("checked",cks.size()==$('tbody input:checked').size());
  
  
})
````

#### 08 展示批量删除按钮

#####01

````php
//全选功能
$('thead input').on('click',function() {
  //获取当前自己的选中状态
  var status= $(this).prop('checked');
  $('tbody input').prop('checked',status);
  if(status){
  $('#delAll').show();
  }else{
    $('#delAll').hide();
  }
})
````

##### 02

````php
//反选功能

$('tbody').on('click','input',function() {
  //获取head
  var all =$('thead input');
  var cks =$('tbody input');
   all.prop("checked",cks.size()==$('tbody input:checked').size());

   if($('tbody input:checked').size() >=2){
   $('#delAll').show();
   }else{
    $('#delAll').hide();
  }
  
})
````

 #### 03 实现删除操作

````php

//批量删除点击事件

$('#delAll').on('click',function(){
//获取选中
var ids=[];
var cks=$('tbody input:checked');
 cks.each(function (index, element) {
  // 获取选中的分类id
  var id =$(element).parents('tr').attr('data-categoryid');
  ids.push(id);
});

  //发送请求
  $.ajax({
    type: "post",
    url: "api/_delAllCategory.php",
    data: {ids:ids},
    dataType: "json",
    success: function (response) {
      if(response.code==1){
        //删除
        cks.parents('tr').remove();
      }
    }
  });


  })
````

#### 04 实现批量删除api _delAllCategory.php

````php
<?php    
//批量删除接口            
include_once '../../functions.php';

$ids=$_POST['ids'];

$conn = connect();

$str = implode(',',$ids);
$sql="delete from categories where id in({$str})";  //in(1,2,3)
$delAllres=mysqli_query($conn,$sql);


$response=['code'=>0,'msg'=>"删除失败"];

if($delAllres){
  $response['code']=1;
  $response['msg']="删除成功";
}

header('content-type:application/json;charset=utf-8');
echo  json_encode($response);
?>
````

## Day05

### 01-获取文章列表

  ##### 1.1 在posts.php 发送请求

````php
  $(function(){
  //获取所有文章列表
  $.ajax({
    type: "post",
    url: "api/_getPostData.php",
    data: {},
    dataType: "json",
    success: function (res) {
      if(res.code==1){
        makeTable(res.data);
      }
    }
  });
````

##### 1.2 编写数据接口 _getPostData.php

````php
<?php   

include_once '../../functions.php';

$conn = connect();

$sql="SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` FROM posts p
left JOIN users u ON u.id = p.user_id
LEFT JOIN categories c ON c.id = p.category_id";

$res = query($conn,$sql);
$response=['code'=>0,'msg'=>"操作失败"];
if($res){
    $response['code']=1;
    $response['msg']="操作成功";
    $response['data']=$res;
}

header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

##### 1.3模板渲染

`````php
var statusData={
  drafted:"草稿",
  published:"已发布",
 trashed:"已作废"
}

//动态生成表格结构

function makeTable(data) {
  $.each(data, function(i, v) {
     var str = '<tr> \
     <td class="text-center"><input type="checkbox"></td>\
    <td>'+v.title+'</td>\
    <td>'+ v.nickname +'</td>\
    <td>'+ v.name +'</td>\
    <td class="text-center">'+ v.created +'</td>\
    <td class="text-center">'+ statusData[v.status] +'</td>\
    <td class="text-center">\
    <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>\
    <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>\
    </td>\
    </tr>';
    $(str).appendTo('tbody');
  });
}
`````

### 02-动态生成分页结构

````php
  //动态生成分页结构
var currentPage = 2;  //当前页
var  pageCount=10;//总页数
var  pageSize =10;//每页的数量
var  start =currentPage -2;
if(start<1){
  start=1;
}
var end =currentPage + 4;
if(end>pageCount){
  end=pageCount;
}

var html='';
if(currentPage!=1){
html+='<li><a href="javascript:;">上一页</a></li>';
}
for (var i = start; i < end; i++) {
  if(currentPage==i){
  html+='<li class="item active"><a href="javascript:;">'+i+'</a></li>';
  }else{
    html+='<li class="item"><a href="javascript:;">'+i+'</a></li>';
  } 
}

if(end!=pageCount){
html+='<li><a href="javascript:;">下一页</a></li>';
}
$('.pagination').html(html);
````

#### 2.2 完善动态分页结构

######2.2.1 给分页按钮设置点击事件 

````php
 //给分页按钮设置点击事件
  $('.pagination').on('click','.item',function () {
       //获取页码数
      currentPage= parseInt($(this).attr('data-page'));
      //发送请求
      $.ajax({
        type: "post",
        url: "api/_getPostData.php",
        data:{currentPage:currentPage,pageSize:pageSize},
        dataType: "json",
        success: function (res) {
        //  console.log(res);
          if(res.code==1){
          pageCount=res.pageCount;
          makePageButton();
          makeTable(res.data);
          }
        }
      });
  });
````

##### 2.2.2 封装分页函数 makePageButton

````php
function makePageButton() {
  var  start =currentPage -2;
if(start<1){
  start=1;
}
var end =currentPage + 4;
if(end>pageCount){
  end=pageCount;
}

var html='';
if(currentPage!=1){
html+='<li class="item" data-page="'+(currentPage-1)+'"><a href="javascript:;">上一页</a></li>';
}
for (var i = start; i < end; i++) {
  if(currentPage==i){
  html+='<li class="item active" data-page="'+i+'"><a href="javascript:;">'+i+'</a></li>';
  }else{
    html+='<li class="item" data-page="'+i+'"><a href="javascript:;">'+i+'</a></li>';
  } 
}

if(end!=pageCount){
html+='<li class="item" data-page="'+(currentPage+1)+'"><a href="javascript:;">下一页</a></li>';
}
$('.pagination').html(html);
}
````

###### 2.2.3 修改api接口_getPostData.php

````php
<?php   

include_once '../../functions.php';
//获取参数

$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];

//计算偏移量  (n-1)*数量

$offset =($currentPage -1 ) * $pageSize;

$conn = connect();

$sql="SELECT p.id,p.title,p.created,p.`status`,u.nickname,c.`name` FROM posts p
left JOIN users u ON u.id = p.user_id
LEFT JOIN categories c ON c.id = p.category_id
limit {$offset},{$pageSize}
";

$res = query($conn,$sql);


$countSql="select count(*) as count from posts";
$countArr = query($conn,$countSql);
$count=$countArr[0]['count'];

$pageCount =ceil($count/$pageSize);

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
````

### 03-筛选功能

####3.1 筛选按钮点击事件

````php
 //筛选的点击事件
   $("#btn-filt").on("click", function () {
      var status =$('#status').val();
      var categoryId =$('#category').val();
      //发送请求
      $.ajax({
        type: "post",
        url: "api/_getPostData.php",
        data:{currentPage:currentPage,pageSize:pageSize,status:status,categoryId:categoryId},
        dataType: "json",
        success: function (res) {
          if(res.code==1){
            makeTable(res.data);
          }
        }
      });
   });
````

#### 3.2 做筛选api接口 _getPostData.php

````php
<?php   

include_once '../../functions.php';
//获取参数

$currentPage=$_POST['currentPage'];
$pageSize=$_POST['pageSize'];
$status=$_POST['status'];
$categoryId=$_POST['categoryId'];

//计算偏移量  (n-1)*数量

$offset =($currentPage -1 ) * $pageSize;

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


$countSql="select count(*) as count from posts";
$countArr = query($conn,$countSql);
$count=$countArr[0]['count'];

$pageCount =ceil($count/$pageSize);

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
````

### 04 图片上传

 #### 4.1 注册点击事件

````php
  $(function(){
    //图片上传
    $('#feature').on('change', function () {
       //获取图片
    //   console.dir(this);
          var file =this.files[0];
          var  data = new FormData();
          data.append('file',file);
          //发送请求
          $.ajax({
               type:'post',
               url:'api/_uploadfile.php',
               data:data,
               dataType:'json',
               contentType:false,
               processData:false,
               success:function(res){
        //    console.log(res);

                  if(res.code==1){
                    //图片回显
                    $('#img').attr('src',res.path).show();
                  }
            
               }
          });
    });
  });
````

#### 4.2 编写api接口  _uploadfile.php

````php
<?php                
//print_r($_FILES);

$file =$_FILES['file'];


$filename=uniqid().strrchr($file['name'],".");

//移动文件
$bool=move_uploaded_file($file['tmp_name'],"../../static/uploads/".$filename);


$response=['code'=>0,'msg'=>"上传失败"];
if($bool){
    $response['code']=1;
    $response['msg']="上传成功";
    $response['path']="/static/uploads/".$filename;

}
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

#### 4.3 图片回显

   ##### 4.3.1  给隐藏图片设置id

````php
<img id=" " class="help-block thumbnail" style="display: none">
````

##### 4.3.2 回显完成

````php
 if(res.code==1){
                    //图片回显
                    $('#img').attr('src',res.path).show();
                  }
````



### 05 富文本

#### 5.1初始化富文本

````php
 //实现 富文本编辑器
  CKEDITOR.replace('content');
````

##### 5.2 保存数据

````php
 //添加功能

   $("#btn-save").on("click", function () {
     //更新CKEDITOR里面的数据到 文本域
     CKEDITOR.instances.content.updateElement();
     var  data=$("#data").serialize();
     //发送请求
     $.ajax({
       type: "post",
       url: "api/_addEditor.php",
       data: data,
       success: function (res) {
         console.log(res);
         
       }
     });
   });
````

## day06

### 01获取评论数据

##### 1.1 发送请求

````php
$(function(){

    var currentPage=1;
    var pageSize=10;
  $.ajax({
    type: "post",
    url: "api/_getComments.php",
    data: {currentPage:currentPage,pageSize:pageSize},
    dataType: "json",
    success: function (res) {
      if(res.code==1){
        var html =template("list",res);
        $('tbody').html(html);
      }
    }
  });
  });
````

##### 1.2 编写api结构_getcomments.php

````php
<?php      
include_once '../../functions.php';          
// 获取从前端得到的当前是第几页，以及每一页取多少条
$currentPage = $_POST['currentPage'];
$pageSize = $_POST['pageSize'];
// 计算出从哪里开始获取数据
$offset = ($currentPage - 1) * $pageSize;
// 连接数据库
$connect = connect();
// sql语句
$sql = "SELECT c.id,c.author,c.content,c.created,c.`status`,p.title FROM comments c
LEFT JOIN posts p on p.id = c.post_id
LIMIT {$offset},{$pageSize}";
// 执行查询
$queryResult = query($connect,$sql);
// 计算最大的页码数
// 最大页码数 = ceil(评论的数据总数 / 每页获取的条数)
// 先说评论的数据总数
$sqlCount = "SELECT count(*) as count FROM comments";
$countArr = query($connect,$sqlCount);
// 取出数据总数
$count = $countArr[0]['count'];
$pageCount = ceil($count / $pageSize);
// 返回数据
$response = ["code"=>0,"msg"=>"操作失败"];
if($queryResult){
  $response['code'] = 1;
  $response['msg'] = "操作成功";
  $response['data'] = $queryResult;
  $response['pageCount'] = $pageCount;
}
// 返回json格式
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

##### 1.3渲染模板

````php
<script type="text/template" id="list">
{{each data v  i}}
 <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>{{v.author}}</td>
            <td style="width:400px;">{{v.content}}</td>
            <td>{{v.title}}</td>
            <td>{{v.created}}</td>
            <td> {{if v.status == "held"}}
              未审核
            {{else if v.status == "approved"}}
              已准许
            {{else if v.status == "rejected"}}
              已拒绝
            {{else if v.status == "trashed"}}
              已删除
            {{/if}}</td>
            <td class="text-center">
              <a href="post-add.php" class="btn btn-warning btn-xs">驳回</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
 {{/each}}


</script>
````

### 02-分页

#### 2.1   引入分页插件

````php
<script src="../static/assets/vendors/twbs-pagination/jquery.twbsPagination.js"></script>
````

#### 2.2 实例化分页插件对象

````php
 $(function(){

    var currentPage=1;
    var pageSize=10;
    var pageCount=0;
  
    function getCommentsData() {
      $.ajax({
    type: "post",
    url: "api/_getComments.php",
    data: {currentPage:currentPage,pageSize:pageSize},
    dataType: "json",
    success: function (res) {
      if(res.code==1){
        var html =template("list",res);
        $('tbody').html(html);
        pageCount=res.pageCount;


            //分页插件
    $('.pagination').twbsPagination({
      totalPages: pageCount,    //总共多少页
      visiblePages: 7,    //你要显示几个按钮
      onPageClick: function (event, page) {
      //发送请求
      currentPage=page;
      getCommentsData();
      }
    });
          }
        }
      });
        }

    getCommentsData();
 

  });
````

#### 2.3 修改分页接口 _getComments.php

````php
<?php      
include_once '../../functions.php';          
// 获取从前端得到的当前是第几页，以及每一页取多少条
$currentPage = $_POST['currentPage'];
$pageSize = $_POST['pageSize'];
// 计算出从哪里开始获取数据
$offset = ($currentPage - 1) * $pageSize;
// 连接数据库
$connect = connect();
// sql语句
$sql = "SELECT c.id,c.author,c.content,c.created,c.`status`,p.title FROM comments c
LEFT JOIN posts p on p.id = c.post_id
LIMIT {$offset},{$pageSize}";
// 执行查询
$queryResult = query($connect,$sql);
// 计算最大的页码数
// 最大页码数 = ceil(评论的数据总数 / 每页获取的条数)
// 先说评论的数据总数
$sqlCount = "SELECT count(*) as count FROM comments";
$countArr = query($connect,$sqlCount);
// 取出数据总数
$count = $countArr[0]['count'];
$pageCount = ceil($count / $pageSize);
// 返回数据
$response = ["code"=>0,"msg"=>"操作失败"];
if($queryResult){
  $response['code'] = 1;
  $response['msg'] = "操作成功";
  $response['data'] = $queryResult;
  $response['pageCount'] = $pageCount;
}
// 返回json格式
header('content-type:application/json;charset=utf-8');
echo json_encode($response);
?>
````

### 03 模块化

#### 3.1 引入 require.js

````php
<script src="../static/assets/vendors/require/require.js" data-main="../static/js/comments.js"></script>
````

#### 3.2 新建comments.js  /static/js/comments.js

````php
/**
 * 入口文件
 * 1.配置模块
 * 2.引入模块
 * 3.实现功能
 */

 require.config({
     // 1.1 声明模块
	// 一共要声明的模块有： jquery,模板引擎,分页插件,bootstrap
	paths : {// 作用是： 声明每个模块的名称和每个模块对应的路径

		// 模块的名字 : 模块对应的js的路径 - 注意路径是不带后缀名
		"jquery" : "/static/assets/vendors/jquery/jquery",
		"template" : "/static/assets/vendors/art-template/template-web",
		"pagination" : "/static/assets/vendors/twbs-pagination/jquery.twbsPagination",
		"bootstrap" : "/static/assets/vendors/bootstrap/js/bootstrap"
	},
	// 1.2 声明模块和模块之间的依赖关系
	shim: {
		// 模块名字
		"pagination" : {
			// deps 声明该模块是依赖哪些模块的
			deps : ["jquery"] // 因为依赖的模块可能有多个，以数组的方式表示
		},
		"bootstrap" : {
			deps : ["jquery"]
		}
	}
 });

 require(["jquery","template","pagination","bootstrap"],function($,template,pagination,bootstrap){
    $(function(){
        var currentPage = 1;
        var pageSize =10;
        var pageCount =10;
    
    function getComment() {
      $.ajax({
             type:'post',
             url:'api/_getComments.php',
             data:{currentPage:currentPage,pageSize:pageSize},
             datatype:"json",
             success:function(res){
           
             if(res.code==1){
               pageCount=res.pageCount;
               var html = template("list",res);
              $('tbody').html(html);
    
              $('.pagination').twbsPagination({
                totalPages: pageCount,
                visiblePages: 7,
                onPageClick: function (event, page) {
                  currentPage=page;
                  getComment();
                }
              });
    
             }
    
             }
        });
    }
    getComment();
    
    
        
      });
 });
````

