<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Users &laquo; Admin</title>
  <link rel="stylesheet" href="../static/assets/vendors/bootstrap/css/bootstrap.css">
  <link rel="stylesheet" href="../static/assets/vendors/font-awesome/css/font-awesome.css">
  <link rel="stylesheet" href="../static/assets/vendors/nprogress/nprogress.css">
  <link rel="stylesheet" href="../static/assets/css/admin.css">
  <script src="../static/assets/vendors/nprogress/nprogress.js"></script>
</head>
<body>
  <script>NProgress.start()</script>

  <div class="main">
  <!-- 抽取公共部分 -->
  <?php include_once 'public/_navbar.php' ?>
  
    <div class="container-fluid">
      <div class="page-title">
        <h1>用户</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style = "display:none">
        <strong>错误！</strong><span id='msg'>发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id = "data">
            <h2>添加新用户</h2>
            <div class="form-group">
              <label for="email">邮箱</label>
              <input id="email" class="form-control" name="email" type="email" placeholder="邮箱">
            </div>
            <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img id="img" class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            </div>
            <div class="form-group">
              <label for="nickname">昵称</label>
              <input id="nickname" class="form-control" name="nickname" type="text" placeholder="昵称">
            </div>
            <div class="form-group">
              <label for="password">密码</label>
              <input id="password" class="form-control" name="password" type="text" placeholder="密码">
            </div>
            <div class="form-group">
              <label for="status">状态</label>
              <input id="status" class="form-control" name="status" type="text" placeholder="状态:填下面英文">
              <p class="help-block"><strong>状态（未激活（unactivated）/ 激活（activated）/ 禁止（forbidden）/ 回收站（trashed））</strong></p>
            </div>
            <div class="form-group">
            <input id="btn-add" type ="button"  class="btn btn-primary" value="添加">
              <input id="btn-edit" type ="button"  class="btn btn-primary" value="编辑完成" style = "display:none">
              <input id="btn-cancel" type ="button"  class="btn btn-primary" value="取消编辑" style = "display:none">
            </div>
          </form>
        </div>
        <div class="col-md-8">
          <div class="page-action">
            <!-- show when multiple checked -->
            <a id ="delAll" class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
          </div>
          <table class="table table-striped table-bordered table-hover">
            <thead>
               <tr>
                <th class="text-center" width="40"><input type="checkbox"></th>
                <th class="text-center" width="80">头像</th>
                <th>邮箱</th>
                <th>别名</th>
                <th>昵称</th>
                <th>状态</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>
              <!-- <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="../static/assets/img/default.png"></td>
                <td>i@zce.me</td>
                <td>zce</td>
                <td>汪磊</td>
                <td>激活</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="../static/assets/img/default.png"></td>
                <td>i@zce.me</td>
                <td>zce</td>
                <td>汪磊</td>
                <td>激活</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr>
              <tr>
                <td class="text-center"><input type="checkbox"></td>
                <td class="text-center"><img class="avatar" src="../static/assets/img/default.png"></td>
                <td>i@zce.me</td>
                <td>zce</td>
                <td>汪磊</td>
                <td>激活</td>
                <td class="text-center">
                  <a href="post-add.php" class="btn btn-default btn-xs">编辑</a>
                  <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
                </td>
              </tr> -->
            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>

  <?php $currentPage="users" ?>
  <!-- 抽取公共部分 -->
<?php include_once 'public/_aside.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/art-template/template-web.js"></script>
  <script>NProgress.done()</script>
  <script type = 'text/template' id="list">
  
  {{each data as value  index}}
  <tr data-categoryId = {{value.id}} >
      <td class="text-center"><input type="checkbox"></td>
      <td class="text-center"><img class="avatar" src="{{value.avatar}}"></td>
      <td>{{value.email}}</td>
      <td>{{value.slug}}</td>
      <td>{{value.nickname}}</td>
      <!-- <td>{{value.status}}</td> -->
      <td> {{if value.status == "activated"}}
              激活
            {{else if value.status == "unactivated"}}
             未激活
            {{else if value.status == "forbidden"}}
              禁止
            {{else if value.status == "trashed"}}
              回收站
      {{/if}}</td>
      <td class="text-center">
      <a href="javascript:;" data-cid={{value.id}}  class="btn btn-info btn-xs edit">编辑</a>
      <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
      </td>
 </tr>
  {{/each}}
  </script>

  <script>
    
  $(function(){

    $("#email").on("blur", function () {

      var email = $("#email").val();
        //var password = $("#password").val();
        //2 先在前端把数据做一下简单地数据验证
        //利用正则表达式判断邮箱格式
        var reg = /\w+[@]\w+[.]\w+/;
        if(!reg.test(email)){
          //验证失败 友好提示
          $("#msg").text("邮箱格式错误");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }

    });

    function getCategoryData() {
        $.ajax({
      type: "POST",
      url: "api/_getUsersData.php",
      dataType: "json",
      success: function (response) {
        //请求成功把数据动态渲染到页面
        if(response.code == 1){
          //请求成功的条件下，动态的渲染表格
          //遍历数组，生成每一行，添加到表格中即可
          var html = template("list",response);
          $("tbody").html(html);
        }
      }
    })
      }

      getCategoryData();

     //点击按钮添加用户数据
    $("#btn-add").on("click", function () {  
 
    //console.log($("#feature").val());
    var img = $("#feature").val();
    var str = img.substr(12);
    //console.log(str);
    var imgPath='/static/uploads/'+ str+'';
    //console.log(imgPath);
    //1.收集数据
   var  slug = $("#slug").val();
   var  email = $("#email").val();
   var  nickname = $("#nickname").val();
   var  password = $("#password").val();
   var  status = $("#status").val();
   //2.校验数据
   if(email == "") {
     $("#msg").text("邮箱不能为空");
     $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
     return;
   }
   if(slug == "") {
     $("#msg").text("分类别名不能为空");
     $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
     return;
   }
   if(nickname == "") {
     $("#msg").text("昵称不能为空");
     $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
     return;
   }
   if(status == "") {
     $("#msg").text("状态不能为空");
     $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
     return;
   }
   $.ajax({
     type: "post",
     url: "api/_addUsers.php",
     data: {slug:slug,email:email,nickname:nickname,password:password,imgPath:imgPath,status:status},
     dataType: "json",
     success: function (response) {
       if(response.code ==1){
         getCategoryData();
         $("#email").val("");
         $("#slug").val("");
         $("#nickname").val("");
         $("#password").val("");
         $("#feature").val("");
         $("#img").attr("style","display: none");
       }else{
         $("#msg").text(response.msg);
         $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
       }
     }
   });
     });


     $("#feature").on("change",function(){
      //文件上传
      var file = this.files[0];

      //jquery是无法直接把文件上传的 需要一个FromData对象来配合上传才可以
      var  data = new FormData();
      //data.append(键，值);
      data.append("file",file);

      $.ajax({
        type: "POST",
        url: "api/_userUploadfiles.php",
        data: data,
        dataType: "json",
        contentType:false,
        processData:false,
        success: function (response) {
          if(response.code==1){
            //图片回显
            $('#img').attr('src',response.path).show();
          }
        }
      });


    })
     //编辑按钮的点击事件
    $("tbody").on("click" ,".edit", function () {

    var cid = $(this).attr("data-cid");
    $("#btn-edit").attr("data-cid",cid )

    $("#btn-add").hide();
    $("#btn-edit").show();
    $("#btn-cancel").show();
    currentRow = $(this).parents('tr');
    var email = $(this).parents('tr').children().eq(2).text();
    var slug = $(this).parents('tr').children().eq(3).text();
    var nickname = $(this).parents('tr').children().eq(4).text();
    var status = $(this).parents('tr').children().eq(5).text();
    //3.展示数据
    $("#email").val(email);
    $("#slug").val(slug);
    $("#nickname").val(nickname);
    $("#status").val(status);


    });

    //编辑完成
    $("#btn-edit").on("click", function () {
        //1.获取id
        var cid = $(this).attr("data-cid");
       //2.校验数据
       var  email = $("#email").val();
        var  slug = $("#slug").val();
        var  nickname = $("#nickname").val();
        
        //2.校验数据
        if(email == "") {
          $("#msg").text("邮箱不能为空");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }
        if(slug == "") {
          $("#msg").text("别名不能为空");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }
        if(nickname == "") {
          $("#msg").text("昵称不能为空");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }
        //发送请求
        $.ajax({
         type: "post",
         url: "api/_updateUsers.php",
         data:{cid:cid,email:email,slug:slug,nickname:nickname},
         dataType: "json",
         success: function (response) {
           if(response.code==1){
             //1.隐藏按钮
             $("#btn-add").show();
             $("#btn-edit").hide();
             $("#btn-cancel").hide();
             //2.保存原来的数据
             var  email = $("#email").val();
             var  slug = $("#slug").val();
             var  nickname = $("#nickname").val();

             //3,清空数据
             $("#email").val("");
             $("#slug").val("");
             $("#nickname").val("");
             //4.更新数据
           //  getCategoryData();
              currentRow.children().eq(2).text(email);
              currentRow.children().eq(3).text(slug);
              currentRow.children().eq(4).text(nickname);
           }
         }
       }); 

      });
    

    
      //  取消编辑注册点击事件
      $("#btn-cancel").on("click", function () {
      //1.数据清空
      $("#email").val("");
      $("#slug").val("");
      $("#nickname").val("");
      //2.按钮消失
      $("#btn-add").show();
      $("#btn-edit").hide();
      $("#btn-cancel").hide();
    });

    //删除点击事件
    $("tbody").on("click",".del",function() {
      //找到tr
      var row =$(this).parents('tr');
      //获取分类id
      var cid =row.attr("data-categoryid");
      //发送请求
      $.ajax({
        type: "post",
        url: "api/_delUser.php",
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



//全选功能的实现
$("thead input").on('click',function(){
      //控制别的多选框跟我的选中转台一样
      //获取自己的选中状态
      var status = $(this).prop("checked");
      //控制别的多选框
      $("tbody input").prop("checked",status);
      if(status){
       $("#delAll").show();
     }else{
      $("#delAll").hide();
     }

    })
    

    //使用委托给别的多选框注册事件
    $("tbody").on('click',"input",function(){
      //控制全选的多选框是否选中，只有当所有的多选框都选中，全选按钮才选中
      //获取全部多选框
      var all = $("thead input");
      var cks = $("tbody input");
      //如果cks中的多选框都选中全选也选中
      if(cks.size() == $("tbody input:checked").size()){
        all.prop("checked",true);
      }else{
        all.prop("checked",false);   
      }
      if($("tbody input:checked").size() >=2 ){
       $("#delAll").show();
     }else{
      $("#delAll").hide();
     }

    });

   
    $("#delAll").on("click", function () {
       //1.获取所有选中
       var ids=[];
       var body=$("tbody input:checked");
       //2.获取所有选中id
       body.each(function (index, element) {
         // element == this
         var id =$(element).parents("tr").attr("data-categoryId");
         ids.push(id);
       });
       //3.发送请求 删除数据 更新界面
       $.ajax({
         type: "post",
         url: "api/_delAllUsers.php",
         data: {ids:ids},
         dataType: "json",
         success: function (response) {
           if(response.code == 1){
            body.parents("tr").remove();
           }
         }
       });
       
     });






  })
  
  </script>

</body>
</html>
