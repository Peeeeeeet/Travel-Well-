 
 
 <div class="aside">
    <div class="profile">
      <img class="avatar" src="../static/uploads/default.png">
      <h3 class="name">管理员</h3>
    </div>
    <ul class="nav">
      <li class="<?php echo $currentPage == "index"? "active":"" ?>">
        <a href="index.php"><i class="fa fa-dashboard"></i>主页</a>
      </li>
      <li>
      <?php                
      //echo $currentPage;
      $pageArr=["posts","categories","post-add"];
      $bool = in_array($currentPage,$pageArr);
      ?>
    <!-- <a href="#menu-posts" class="" data-toggle="collapse" aria-expanded="true">
        <ul id="menu-posts" class="collapse in" aria-expanded="true" style="">
        这是展开样式
    </a> -->
        <a href="#menu-posts" class="<?php echo $bool?"":"collapsed" ?>" data-toggle="collapse"  <?php echo $bool ? 'aria-expanded="true"':"" ?>>
          <i class="fa fa-thumb-tack"></i>文章<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-posts" class="collapse <?php echo $bool?"in":"" ?>"  <?php echo $bool ? 'aria-expanded="true"':"" ?>>
          <li class="<?php echo $currentPage == "posts"? "active":"" ?>"><a href="posts.php">所有文章</a></li>
          <li class="<?php echo $currentPage == "post-add"? "active":"" ?>"><a href="post-add.php">写文章</a></li>
          <li class="<?php echo $currentPage == "categories"? "active":"" ?>"><a href="categories.php">分类目录</a></li>
        </ul>
      </li>
      <li class="<?php echo $currentPage == "comments"? "active":"" ?>">
        <a href="comments.php"><i class="fa fa-comments"></i>评论</a>
      </li>
      <li  class="<?php echo $currentPage == "users"? "active":"" ?>">
        <a href="users.php"><i class="fa fa-users"></i>用户</a>
      </li>
      <li>
      <?php                
      //echo $currentPage;
      $setArr=["nav-menus","slides","settings"];
      $bool = in_array($currentPage,$setArr);
      ?>
        <a href="#menu-settings" class="<?php echo $bool?"":"collapsed" ?>" data-toggle="collapse" <?php echo $bool ? 'aria-expanded="true"':"" ?>>
          <i class="fa fa-cogs"></i>设置<i class="fa fa-angle-right"></i>
        </a>
        <ul id="menu-settings" class="collapse <?php echo $bool?"in":"" ?>" <?php echo $bool ? 'aria-expanded="true"':"" ?>>
          <li  class="<?php echo $currentPage == "nav-menus"? "active":"" ?>"><a href="nav-menus.php">导航菜单</a></li>
          <li  class="<?php echo $currentPage == "slides"? "active":"" ?>"><a href="slides.php">图片轮播</a></li>
          <li  class="<?php echo $currentPage == "settings"? "active":"" ?>"><a href="settings.php">网站设置</a></li>
        </ul>
      </li>
    </ul>
  </div>
  <!-- 因为是是外边的页面调用 所以../就行 -->
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
   $(function(){
    $.ajax({
        type: "post",
        url: "api/_getUserAvatar.php",
        dataType: "json",
        success: function (response) {
            if(response.code == 1){
          //1.动态设置头像 昵称
          var profile = $(".profile");
          profile.children("img").attr("src",response.avatar);
          profile.children("h3").text(response.nickname);
        }        
        }
    });
   });
  </script>