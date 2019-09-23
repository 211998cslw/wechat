<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
    <table border="1">
        <tr>
            <td>用户uid</td>
            <td>用户昵称</td>
            <td>操作</td>
        </tr>
        @foreach($res as $v)
            <tr>
                <td>{{$v->uid}}</td>
                <td>{{$v->name}}</td>
                <td><a href="#"></a></td>

            </tr>
        @endforeach    
    </table>
</body>
</html>