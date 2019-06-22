<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Add new post &laquo; Admin</title>
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
        <h1>写文章</h1>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <form class="row">
        <div class="col-md-9">
          <div class="form-group">
            <label for="title">标题</label>
            <input id="title" class="form-control input-lg" name="title" type="text" placeholder="文章标题">
          </div>
          <div class="form-group">
            <label for="content">标题</label>
            <textarea id="content" class="form-control input-lg" name="content" cols="30" rows="10" placeholder="内容"></textarea>
          </div>
        </div>
        <div class="col-md-3">
          <div class="form-group">
            <label for="slug">别名</label>
            <input id="slug" class="form-control" name="slug" type="text" placeholder="slug">
            <p class="help-block">https://zce.me/post/<strong>slug</strong></p>
          </div>
          <div class="form-group">
            <label for="feature">特色图像</label>
            <!-- show when image chose -->
            <img id="img" class="help-block thumbnail" style="display: none">
            <input id="feature" class="form-control" name="feature" type="file">
          </div>
          <div class="form-group">
            <label for="category">所属分类</label>
            <select id="category" class="form-control" name="category">
              <option value="1">未分类</option>
              <option value="2">潮生活</option>
            </select>
          </div>
          <div class="form-group">
            <label for="created">发布时间</label>
            <input id="created" class="form-control" name="created" type="datetime-local">
          </div>
          <div class="form-group">
            <label for="status">状态</label>
            <select id="status" class="form-control" name="status">
              <option value="drafted">草稿</option>
              <option value="published">已发布</option>
            </select>
          </div>
          <div class="form-group">
            <input id="btn-save" class="btn btn-primary" type="button" value="添加"/>
            <!-- <button class="btn btn-primary" type="submit">保存</button> -->
          </div>
        </div>
      </form>
    </div>
  </div>
  <?php $currentPage="post-add" ?>
  <!-- 抽取公共部分 -->
  <?php include_once 'public/_aside.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script src="../static/assets/vendors/ckeditor/ckeditor.js"></script>
  <script>NProgress.done()</script>
  <script>
  $(function(){
    //实现文件上传功能
    /*
    文件上传一般是不用点击事件，因为点击事件完成的时候，得不到选中的文件
    一般使用change事件 change事件会在表单的值发上改变的时候触发
      
     */
    $("#feature").on("change",function(){
      //文件上传
      //获取想要上传的文件
      var file = this.files[0];
     // console.log(this.files);
      

      //jquery是无法直接把文件上传的 需要一个FromData对象来配合上传才可以
      var  data = new FormData();
      //data.append(键，值);
      data.append("file",file);

      $.ajax({
        type: "POST",
        url: "api/_uploadfile.php",
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


    //实现 富文本编辑器  文本域id
    CKEDITOR.replace('content');
  //添加功能
  $("#btn-save").on("click", function () {
      //更新CKEDITOR里面的数据到 文本域
      CKEDITOR.instances.content.updateElement();
      //  var content=   CKEDITOR.instances.content.getData();
      //  console.log(content);

      var  data=$("#data").serialize();
      // console.log(data);
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

  })
  </script>
</body>
</html>
