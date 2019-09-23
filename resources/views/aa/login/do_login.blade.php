<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>登录</title>
</head>
<body>
<form action="{{url('login')}}" method="post">
    用户名:<input type="text"></br>
    密码:<input type="password"></br>
    <input type="submit" value="微信授权登录">
</form>
</body>
</html>
