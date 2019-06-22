<?php 
// 引入代码实际就是把代码放到这个页面中重新执行一次
require_once 'functions.php';
/*
  最新发布的功能
  1.连接数据库
  2.准备sql
  3.获取数据
 */
//1.连接数据库
$conn = connect();
//2.sql语句
$sql = "SELECT p.title,p.created,p.content,p.views,p.likes,p.feature,c.`name`,u.nickname,
        # 根据文章id到comments表格中查找对应的评论数量
        (SELECT count(id) FROM comments WHERE post_id = p.id) as commentsCount FROM posts p
          # 联表查询
          LEFT JOIN categories c on c.id = p.category_id
          LEFT JOIN users u on u.id = p.user_id
          # 筛选一下不展示的分类
          WHERE p.category_id != 1
          # 倒序排列
          order BY p.created desc
          # 限定数量
          LIMIT 5";
//3.获取数据
$indexArr = query($conn,$sql);
//print_r($indexArr);

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
      <div class="swipe">
        <ul class="swipe-wrapper">
          <li>
            <a href="#">
              <img src="static/uploads/sildebali.jpg">
              <span>艺术之都巴黎</span>
            </a>
          </li>
          <li>
            <a href="#">
              <img src="static/uploads/ljlb.jpg">
              <span>惹人向往的古城丽江</span>
            </a>
          </li>
          <li>
            <a href="#">
              <img src="static/uploads/slide_1.jpg">
              <span>XIU主题演示</span>
            </a>
          </li>
          <li>
            <a href="#">
              <img src="static/uploads/slide_2.jpg">
              <span>XIU主题演示</span>
            </a>
          </li>
        </ul>
        <p class="cursor"><span class="active"></span><span></span><span></span><span></span></p>
        <a href="javascript:;" class="arrow prev"><i class="fa fa-chevron-left"></i></a>
        <a href="javascript:;" class="arrow next"><i class="fa fa-chevron-right"></i></a>
      </div>
      <div class="panel focus">
        <h3>焦点关注</h3>
        <ul>
          <li class="large">
            <a href="javascript:;">
              <img src="static/uploads/yese.jpg" alt="">
              <span>开封古城夜景</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/04.jpg" alt="">
              <span>夕阳下，大雁排着队形飞过</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/05.jpg" alt="">
              <span>你想去吗？临海民宿美如画</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/07.jpg" alt="">
              <span>天鹅湖中的白天鹅在水中嬉戏！</span>
            </a>
          </li>
          <li>
            <a href="javascript:;">
              <img src="static/uploads/11.jpg" alt="">
              <span>停车坐爱枫林晚，霜叶红于二月花。！</span>
            </a>
          </li>
        </ul>
      </div>
      <div class="panel top">
        <h3>一周热门排行</h3>
        <ol>
          <li>
            <i>1</i>
            <a href="javascript:;">你想去吗？临海民宿美如画</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
          <li>
            <i>2</i>
            <a href="javascript:;">开封古城夜景惹人醉</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span class="">阅读 (18206)</span>
          </li>
          <li>
            <i>3</i>
            <a href="javascript:;">西藏拉萨_十大景点介绍</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
          <li>
            <i>4</i>
            <a href="javascript:;">云南大理-云南各大景点必读攻略</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
          <li>
            <i>5</i>
            <a href="javascript:;">废灯泡的14种玩法 妹子见了都会心动</a>
            <a href="javascript:;" class="like">赞(964)</a>
            <span>阅读 (18206)</span>
          </li>
        </ol>
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
      <div class="panel new">
        <h3>最新发布</h3>
    
        <?php  foreach($indexArr as $value){ ?>
          <div class="entry">
          <div class="head">
            <span class="sort"><?php  echo $value["name"] ?></span>
            <a href="javascript:;"><?php  echo $value["title"] ?></a>
          </div>
          <div class="main">
            <p class="info"><?php  echo $value["nickname"] ?> 发表于 <?php  echo $value["created"] ?></p>
            <p class="brief"><?php  echo $value["content"] ?></p>
            <p class="extra">
              <span class="reading">阅读(<?php  echo $value["views"] ?>)</span>
              <span class="comment">评论(<?php  echo $value["commentsCount"] ?>)</span>
              <a href="javascript:;" class="like">
                <i class="fa fa-thumbs-up"></i>
                <span>赞(<?php  echo $value["likes"] ?>)</span>
              </a>
              <a href="javascript:;" class="tags">
                分类：<span><?php echo $value['name'] ?></span>
              </a>
            </p>
            <a href="javascript:;" class="thumb">
              <img src="<?php echo $value['feature'] ?>" alt="">
            </a>
          </div>
        </div>
       <?php  } ?>
       
      </div>
    </div>
    <div class="footer">
      
    </div>
  </div>
  <script src="static/assets/vendors/jquery/jquery.js"></script>
  <script src="static/assets/vendors/swipe/swipe.js"></script>
  <script>
    //
    var swiper = Swipe(document.querySelector('.swipe'), {
      auto: 2000,
      transitionEnd: function (index) {
        // index++;

        $('.cursor span').eq(index).addClass('active').siblings('.active').removeClass('active');
      }
    });

    // 上/下一张
    $('.swipe .arrow').on('click', function () {
      var _this = $(this);

      if(_this.is('.prev')) {
        swiper.prev();
      } else if(_this.is('.next')) {
        swiper.next();
      }
    })
  </script>
</body>
</html>
