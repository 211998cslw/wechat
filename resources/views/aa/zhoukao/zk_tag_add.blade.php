<!DOCTYPE html>
<html>
<head>
    <title>微信添加标签</title>
</head>
<body>
<form action="{{url('zk_do_tag_add')}}" method="post">
    @csrf
    标签名:<input type="text" name="name"></br>
    <input type="submit" value="提交">
</form>
</body>
</html>