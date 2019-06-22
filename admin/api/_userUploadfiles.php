<?php                
//print_r($_FILES);

$file =$_FILES['file'];


$filename= $file['name'];

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