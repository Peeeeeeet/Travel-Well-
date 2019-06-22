<!DOCTYPE html>
<html lang="zh-CN">
<head>
  <meta charset="utf-8">
  <title>Posts &laquo; Admin</title>
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
        <h1>所有文章</h1>
        <a href="post-add.php" class="btn btn-primary btn-xs">写文章</a>
      </div>
      <!-- 有错误信息时展示 -->
      <!-- <div class="alert alert-danger">
        <strong>错误！</strong>发生XXX错误
      </div> -->
      <div class="page-action">
        <!-- show when multiple checked -->
        <a class="btn btn-danger btn-sm" href="javascript:;" style="display: none">批量删除</a>
        <form class="form-inline">
          <select name=""id="select" class="form-control input-sm">
            <option value="all">所有分类</option>
            <!-- <option value="">未分类</option> -->
          </select>
          <select id="status" name="" class="form-control input-sm">
          <option value="all">所有状态</option>
            <option value="drafted">草稿</option>
            <option value="published">已发布</option>
            <option value="trashed">已作废</option>
          </select>
          <!-- <button class="btn btn-default btn-sm">筛选</button> -->
          <input  id="filt" class="btn btn-default btn-sm" type="button" value="筛选">
        </form>
        <ul class="pagination pagination-sm pull-right">
          <!-- <li><a href="#">上一页</a></li>
          <li><a href="#">1</a></li>
          <li><a href="#">2</a></li>
          <li><a href="#">3</a></li>
          <li><a href="#">下一页</a></li> -->
        </ul>
      </div>
      <table class="table table-striped table-bordered table-hover">
        <thead>
          <tr>
            <th class="text-center" width="40"><input type="checkbox"></th>
            <th>标题</th>
            <th>作者</th>
            <th>分类</th>
            <th class="text-center">发表时间</th>
            <th class="text-center">状态</th>
            <th class="text-center" width="100">操作</th>
          </tr>
        </thead>
        <tbody>
          <!-- <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr>
          <tr>
            <td class="text-center"><input type="checkbox"></td>
            <td>随便一个名称</td>
            <td>小小</td>
            <td>潮科技</td>
            <td class="text-center">2016/10/07</td>
            <td class="text-center">已发布</td>
            <td class="text-center">
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>
            </td>
          </tr> -->
        </tbody>
      </table>
    </div>
  </div>
  <?php $currentPage="posts" ?>
  <!-- 抽取公共部分 -->
  <?php include_once 'public/_aside.php' ?>

  <script src="../static/assets/vendors/jquery/jquery.js"></script>
  <script src="../static/assets/vendors/bootstrap/js/bootstrap.js"></script>
  <script>NProgress.done()</script>
  <script>

  //动态生成分页结构、
  //声明一个变量  总共有多少页
  var pageCount = 5;
  //声明一个变量记录当前页码
  var currentPage=1;//当前页码
  var  pageSize =10;//每页的数量
  //最大页码数=Math.ceil（文章的数据的总量/每一页获取的数据的条数）;

  // var start = currentPage-2;
  // if(start<1){
  //   start=1;
  // }
  // var end = start+4;//结束页码
  // if(end>pageCount){
  //   end=pageCount;
  // }

  //封装makePageButton
function makePageButton() {
  var start = currentPage-2; //开始页码
  if(start<1){
    start=1;
  }
   var end = start+4; //结束页码
  if(end>pageCount){
    end=pageCount;
  }
  if(currentPage==end){
    start=end-4;
  }

  var html = '';
  if(currentPage!=1){
  html+='<li class="item" data-page='+(currentPage-1)+'><a href="javascript:;">上一页</a></li>';
  }
  for (var index = start; index <=end; index++) {
    if(index==currentPage){
     html+='<li class="item active" data-page='+index+'><a href="javascript:;">'+index+'</a></li>';
    }else{
      html+='<li class="item" data-page='+index+'><a href="javascript:;">'+index+'</a></li>';
    }
  }        
   if(currentPage != pageCount){
    html+='<li class="item" data-page='+(currentPage+1)+'><a href="javascript:;">下一页</a></li>';
   }
  $('.pagination').html(html);

  }

     var statusData={
        drafted:"草稿",
        published:"已发布",
        trashed:"已作废"
    };
    //封装makeData
function makeData(data) {
      $('tbody').empty();
      $.each(data, function (index, val) { 
        var str = '<tr>\
            <td class="text-center"><input type="checkbox"></td>\
            <td>'+val.title+'</td>\
            <td>'+val.nickname+'</td>\
            <td>'+val.name+'</td>\
            <td class="text-center">'+val.created+'</td>\
            <td class="text-center">'+statusData[val.status]+'</td>\
            <td class="text-center">\
              <a href="javascript:;" class="btn btn-default btn-xs">编辑</a>\
              <a href="javascript:;" class="btn btn-danger btn-xs">删除</a>\
            </td>\
          </tr>';
        $(str).appendTo("tbody");    
      });
    }


  $(function(){
  //获取所有文章列表
  $.ajax({
    type: "post",
    url: "api/_getPostsData.php",
    data:{currentPage:currentPage,pageSize:pageSize,status:$('#status').val(),categoryId:$('#select').val()},
    dataType: "json",
    success: function (res) {
      if(res.code==1){
        pageCount=res.pageCount;
        makePageButton();
        makeData(res.data);
      }
    }
  });

  //给分页按钮设置点击事件
  $('.pagination').on('click','.item',function () {
       //获取页码数
      currentPage= parseInt($(this).attr('data-page'));
      //发送请求
      $.ajax({
        type: "post",
        url: "api/_getPostsData.php",
        data:{currentPage:currentPage,pageSize:pageSize,status:$('#status').val(),categoryId:$('#select').val()},
        dataType: "json",
        success: function (res) {
        //  console.log(res);
          if(res.code==1){
          pageCount=res.pageCount;
          makePageButton();
          makeData(res.data);
          }
        }
      });
  });



  //获取所有分类数据
  $.ajax({
    type: "post",
    url: "api/_getCategoryData.php",
    dataType: "json",
    success: function (response) {
      if(response.code==1){
        //生成分类结构
         $.each(response.data, function (index, val) { 
            var  html ='<option value="'+val.id+'">'+val.name+'</option>';
           $(html).appendTo("#select");
         });
      }
    }
  });

//筛选点击事件
    
    $("#filt").on("click", function () {
    
    var categoryid=$("#select").val();
    var status=$("#status").val();

    $.ajax({
      type: "post",
      url: "api/_getPostsData.php",
      data: {currentPage:currentPage,pageSize:pageSize,status:status,categoryId:categoryid},
      dataType: "json",
      success: function (response) {
        if(response.code==1){
         var data= response.data;
         pageCount=response.pagecount
         makePageButton();
         makeData(data);
        }
      }
    });
     
   });






  })//入口函数
  </script>
</body>
</html>
