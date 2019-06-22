<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Sign in &laquo; Admin</title> 
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <link rel="shortcut icon" href="/bitbug_favicon.ico" />

</head>
<body>
  <div class="login">
    <form class="login-wrap">
      <img class="avatar" src="../static/assets/img/default.png">
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style="display:none">
        <strong>错误！</strong> <span id="msg">用户名或密码错误！</span>
      </div>
      <div class="form-group">
        <label for="email" class="sr-only">邮箱</label>
        <input id="email" type="email" class="form-control" placeholder="邮箱" autofocus>
      </div>
      <div class="form-group">
        <label for="password" class="sr-only">密码</label>
        <input id="password" type="password" class="form-control" placeholder="密码">
      </div>
      <span id="btn-login" class="btn btn-primary btn-block" href="index.php">登 录</span>
    </form>
  </div>
  <script src="../static/assets/vendors/jquery/jquery.min.js"></script>
  <script>
    $(function(){
      //失去焦点自动获取用户头像
      $("#email").on("blur",function () {
        var email = $("#email").val();
        if(email ==""){
          //如果为空显示原图片
          $(".avatar").attr("src","../static/assets/img/default.png")
        }else{
          $.ajax({
        type: "post",
        url: "api/_getLoginAvatar.php",
        data:{email:email},
        dataType: "json",
        success: function (response) {
            if(response.code == 1){
          //1.显示头像
          $(".avatar").attr("src",response.avatar)
        }        
        }
    })
        }
        });
      //给登录按钮注册点击事件
      $("#btn-login").on("click",function(){
        //1 收集用户的邮箱密码
        var email = $("#email").val();
        var password = $("#password").val();
        //2 先在前端把数据做一下简单地数据验证
        //利用正则表达式判断邮箱格式
        var reg = /\w+[@]\w+[.]\w+/;
        if(!reg.test(email)){
          //验证失败 友好提示
          $("#msg").text("邮箱格式错误");
          $(".alert").show();
          return;
        }else{
          $(".alert").hide();
        }
        //3 如果邮箱格式正确，就把数据发送回服务器
        //发送ajax
        $.ajax({
          type: "POST",
          url: "api/_userLogin.php",
          data: {email:email,password:password},
          dataType:'json',
          success: function (response) {
            if(response.code==1){
              location.href = 'index.php';
            }else{
              $("#msg").text("用户名或密码错误");
              $(".alert").show();
            }
          }
        });

      });
    });
  </script>
</body>
</html>
