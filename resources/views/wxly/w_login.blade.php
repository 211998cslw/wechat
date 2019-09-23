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
<form action="{{url('w_do_login')}}" method="post">
    @csrf
    <tr>
        <td>用户名:<input type="text" name="name"></td>
        <td>密码:<input type="password" name="password"></td>
        <td console="2"><input type="submit" value="提交">

        </td>
    </tr>
</form>
<script type="text/javascript">
    $(function(){
        $.ajaxSetup({
            headers:{
                'X-CSRF-TOKEN':$('meta['name="csrf-token"]').attr('content)
            }
        });
        $.ajax({});
    })
</script>
</body>
</html>