<?php                
  // 创建连接
  $conn = connect();
  //准备sql语句
  $sql = "select * from categories where id !=1";
  //3.执行查询
  $headerArr = query($conn,$sql);
  //print_r($headerArr);
?>

<div class="header">
      <h1 class="logo"><a href="index.php"><img src="static/assets/img/logo.png" alt=""></a></h1>
      <ul class="nav">
        <!-- <li><a href="javascript:;"><i class="fa fa-glass"></i>奇趣事</a></li>
        <li><a href="javascript:;"><i class="fa fa-phone"></i>潮科技</a></li>
        <li><a href="javascript:;"><i class="fa fa-fire"></i>会生活</a></li>
        <li><a href="javascript:;"><i class="fa fa-gift"></i>美奇迹</a></li> -->
        <?php foreach( $headerArr as $key => $value){?>
            <li><a href="list.php?categoryId=<?php echo $value['id'] ?>"><i class="fa <?php echo $value["classname"]?>"></i><?php echo $value["name"]?></a></li>
        <?php  } ?>
      </ul>
      <div class="search">
        <form>
          <input type="text" class="keys" placeholder="输入关键字">
          <input type="button" class="btn" value="搜索" id="btn-wether">
        </form>
      </div>
      <div class="slink">
          
      </div>
    </div>
    <script src="static/assets/vendors/art-template/template-web.js"></script>
    <script type="text/template" id="weatherTemp">
    <% for(var i=0;i<items.length;i++){ %>
         <p><%=items[i].date%></p>
         <p><%=items[i].temperature%> <%=items[i].weather%></p> 
         <p><%=items[i].wind%> </p>
            <% }%>
    </script>
<script src="static/assets/vendors/jquery/jquery.min.js"></script>
<script>

    $.ajax({
            type: 'post',
            url: "http://api.map.baidu.com/telematics/v3/weather",
            data: {
                "ak": "zVo5SStav7IUiVON0kuCogecm87lonOj",
                "location": "开封",
                "output": 'json'
            },
            dataType: 'jsonp',
            // jsonpCallback:function(){}
            success: function(result) {
                //console.log(result);
                var html = template("weatherTemp", {
                    "items": result.results[0].weather_data
                });
                document.querySelector(".slink").innerHTML = html;
            }
        });

</script>