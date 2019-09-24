<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>推送模板消息</title>
</head>
<body>
<center>
    <form action="{{url('zk_do_push_tag_message')}}" method="post">
        @csrf
        <input type="hidden" name="tagid" value="{{$tagid}}">
        消息：
        <textarea name="message" id="" cols="30" rows="10"></textarea>
        <br>
        <br>
        <input type="submit" value="提交">
    </form>
</center>
</body>
</html>