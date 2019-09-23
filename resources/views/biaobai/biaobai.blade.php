<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>表白添加</title>
</head>
<body>
<form action="{{url('do_biaobai')}}" method="post">
    <table border="1">
        <tr>
            <td>
                表白内容：<input type="text" name="name">
            </td>
        </tr>
        
        <tr>
            <td>
                是否:<input type="radio" name="status" value="2">匿名
                <input type="radio" name="status" value="1">显示
            </td>
        </tr>

        <tr>
            <select name="id" >
                @foreach($data as $v)
                    <option value="{{$v->id}}">{{$v->nickname}}</option>
                @endforeach    
            </select>
        </tr>


        <tr>
            <td><input type="submit" value="提交"> </td>
        </tr>
    </table>
</form>
</body>
</html>
