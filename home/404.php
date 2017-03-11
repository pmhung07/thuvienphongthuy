<?require_once('config.php')?>
<!DOCTYPE html>
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="refresh" content="10; URL=http://<?=$base_url?>" />
<title>Error 404</title>
<?=$var_common_css?>
<style type="text/css">
.error_land{
   width: 650px;
   padding: 30px;
   background: #fff;
   border-radius: 5px;
   margin: 100px auto;
   line-height: 24px;
}
.bold{
   font-weight: bold;
   text-align: center;
}
</style>
</head>

<body>
   <div class="error_land">
      <div class="bold">Địa chỉ bạn truy cập hiện không tồn tại !</div>
      <div>Bạn hãy <a href="http://<?=$base_url?>">bấm vào đây</a> để quay lại trang chủ, hoặc website sẽ tự động quay lại trang chủ sau 10s nữa. </div>
   </div>
</body>
</html>