<?php                
include_once '../functions.php';
//调用已经封装好的checkLogin验证是否已经登录
checkLogin();

?>

<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Categories &laquo; Admin</title>
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
      <div class="page-title">
        <h1>分类目录</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <div class="alert alert-danger" style = "display:none">
        <strong>错误！</strong><span id='msg'>发生XXX错误</span>
      </div>
      <div class="row">
        <div class="col-md-4">
          <form id = "data">
            <h2>添加新分类目录</h2>
            <div class="form-group">
              <label for="name">名称</label>
              <input id="name" class="form-control" name="name" type="text" placeholder="分类名称">
            </div>
            <div class="form-group">
              <label for="slug">别名</label>
              <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">

            </div>
            <div class="form-group">
              <label for="slug">类名</label>
              <input id="classname" class="form-control" name="classname" type="text" placeholder="classname">

            </div>
            <div class="form-group">
             <!-- <button class="btn btn-primary" type="submit">添加</button> -->
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
                <th>名称</th>
                <th>Slug</th>
                <th>类名</th>
                <th class="text-center" width="100">操作</th>
              </tr>
            </thead>
            <tbody>


            </tbody>
          </table>
        </div>
      </div>
    </div>
  </div>
  <?php $currentPage="categories" ?>
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
    <td>{{value.name}}</td>
    <td>{{value.slug}}</td>
    <td>{{value.classname}}</td>
    <td class="text-center">
      <a href="javascript:;" data-cid={{value.id}}  class="btn btn-info btn-xs edit">编辑</a>
      <a href="javascript:;" class="btn btn-danger btn-xs del">删除</a>
    </td>
  </tr>
  {{/each}}
  </script>
  <script>
    //使用ajax请求 获取数据 在动态生成结构即可
    $(function(){
      function getCategoryData() {
        $.ajax({
      type: "POST",
      url: "api/_getCategoryData.php",
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

      //点击按钮添加分类数据
      $("#btn-add").on("click", function () {
        
         //1.收集数据
    var  name = $("#name").val();
    var  slug = $("#slug").val();
    var  classname = $("#classname").val();
    //2.校验数据
    if(name == "") {
      $("#msg").text("分类名称不能为空");
      $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
      return;
    }
    if(slug == "") {
      $("#msg").text("分类别名不能为空");
      $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
      return;
    }
    if(classname == "") {
      $("#msg").text("分类类名不能为空");
      $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
      return;
    }
    $.ajax({
      type: "post",
      url: "api/_addCategory.php",
      data: $("#data").serialize(),
      dataType: "json",
      success: function (response) {
        if(response.code ==1){
          getCategoryData()
        }else{
          $("#msg").text(response.msg);
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
        }
      }
    });
      });

      var currentRow = '';
      //编辑按钮的点击事件
      $("tbody").on("click" ,".edit", function () {

        var cid = $(this).attr("data-cid");
        $("#btn-edit").attr("data-cid",cid )


        $("#btn-add").hide();
        $("#btn-edit").show();
        $("#btn-cancel").show();
        currentRow = $(this).parents('tr');
        var name = $(this).parents('tr').children().eq(1).text();
        var slug = $(this).parents('tr').children().eq(2).text();
        var classname = $(this).parents('tr').children().eq(3).text();
        //3.展示数据
        $("#name").val(name);
        $("#slug").val(slug);
        $("#classname").val(classname);


      });

      //编辑完成
      $("#btn-edit").on("click", function () {
        //1.获取id
        var cid = $(this).attr("data-cid");
       //2.校验数据
       var  name = $("#name").val();
        var  slug = $("#slug").val();
        var  classname = $("#classname").val();
        
        //2.校验数据
        if(name == "") {
          $("#msg").text("分类名称不能为空");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }
        if(slug == "") {
          $("#msg").text("分类别名不能为空");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }
        if(classname == "") {
          $("#msg").text("分类类名不能为空");
          $(".alert").fadeIn(1000).delay(3000).fadeOut(1000);
          return;
        }
        //发送请求
        $.ajax({
         type: "post",
         url: "api/_updateCategory.php",
         data:{cid:cid,name:name,slug:slug,classname:classname},
         dataType: "json",
         success: function (response) {
           if(response.code==1){
             //1.隐藏按钮
             $("#btn-add").show();
             $("#btn-edit").hide();
             $("#btn-cancel").hide();
             //2.保存原来的数据
             var  name = $("#name").val();
             var  slug = $("#slug").val();
             var  classname = $("#classname").val();

             //3,清空数据
             $("#name").val("");
             $("#slug").val("");
             $("#classname").val("");
             //4.更新数据
           //  getCategoryData();
              currentRow.children().eq(1).text(name);
              currentRow.children().eq(2).text(slug);
              currentRow.children().eq(3).text(classname);
           }
         }
       }); 

      });

      //  取消编辑注册点击事件
      $("#btn-cancel").on("click", function () {
      //1.数据清空
      $("#name").val("");
      $("#slug").val("");
      $("#classname").val("");
      //2.按钮消失
      $("#btn-add").show();
      $("#btn-edit").hide();
      $("#btn-cancel").hide();
    });

//删除按钮点击事件   
    $("tbody").on("click",".del",function(){
      //获取id
      var row =$(this).parents('tr');
      var categoryId = row.attr("data-categoryId");
      

      
      //发送清请求
      $.ajax({
        type: "POST",
        url: "api/_delCategory.php",
        data: {id:categoryId},
        dataType: "json",
        success: function (response) {
          if(response.code == 1){
          row.remove();
         }
        }
      });

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
         url: "api/_delCategories.php",
         data: {ids:ids},
         dataType: "json",
         success: function (response) {
           if(response.code == 1){
            body.parents("tr").remove();
           }
         }
       });
       
     });

    
    

    });

  </script>
</body>
</html>
