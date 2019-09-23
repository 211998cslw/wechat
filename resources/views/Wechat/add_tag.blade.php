<!DOCTYPE html>
<html>
<head>
	<title>微信添加标签</title>
</head>
<body>
<form action="{{url('/wechat/do_add_tag')}}" method="post">
@csrf
	标签名:<input type="text" name="name"></br>
	<input type="submit" value="提交">
</form>
</body>
</html>