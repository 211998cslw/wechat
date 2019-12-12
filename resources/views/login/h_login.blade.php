<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> - 登录</title>
    <meta name="keywords" content="">
    <meta name="description" content="">
    <link rel="shortcut icon" href="favicon.ico"> <link href="{{asset('css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('css/font-awesome.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('css/style.css?v=4.1.0')}}" rel="stylesheet">
    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->
    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>
<body class="gray-bg">
<div class="middle-box text-center loginscreen  animated fadeInDown">
    <div>
        <div>
            <h1 class="logo-name">h</h1>
        </div>
        <h3>欢迎使用 hAdmin</h3>
        <form class="m-t" role="form" action="{{url('h_do_login')}}" method="post">
            <div class="form-group">
                <input type="text" class="form-control" placeholder="用户名" name="name">
            </div>
            <div class="form-group">
                <input type="password" class="form-control" placeholder="密码"   name="password">
            </div>
            <div class="form-group">
                <input type="text" class="form-control" placeholder="微信验证码" name="code">
                <input type="button" value="发送验证码" id="send">
            </div>
            <button type="submit" class="btn btn-primary block full-width m-b">登录</button>
            <h3><a href="#">点击前往微信扫码登录</a></h3>
            <img src="{{asset('Screenshot_3.png')}}" alt="" height="100" width="100">
        </form>
    </div>
</div>
<!-- 全局js -->
<script src="{{asset('js/jquery.min.js?v=2.1.4')}}"></script>
<script src="{{asset('js/bootstrap.min.js?v=3.3.6')}}"></script>
<script>
    $('#send').on('click',function(){
        //获取用户名 密码
        var name=$("[name=name]").val();
        var password=$("[name=password]").val();
        //向后台发送ajax请求
        $.ajax({
            url:"{{url('/send')}}",//跳转地址
            data:{name:name,password:password},//传值
            dataType:'json',//数据类型
            success:function(res){
            }
        });
    })
</script>
</body>

</html>
