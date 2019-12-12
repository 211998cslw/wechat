<!doctype html>
<html  class="x-admin-sm">
<head>
	<meta charset="UTF-8">
	<title>后台登录-X-admin2.2</title>
	<meta name="renderer" content="webkit|ie-comp|ie-stand">
    <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
    <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
    <meta http-equiv="Cache-Control" content="no-siteapp" />
    <link rel="stylesheet" href="{{asset('admin/css/font.css')}}">
    <link rel="stylesheet" href="{{asset('admin/css/login.css')}}">
	  <link rel="stylesheet" href="{{asset('admin/css/xadmin.css')}}">
    <script type="text/javascript" src="https://cdn.bootcss.com/jquery/3.2.1/jquery.min.js"></script>
    <script src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
    <!--[if lt IE 9]>
      <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
      <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>
<body class="login-bg">
    
    <div class="login layui-anim layui-anim-up">
        <div class="message">x-admin2.0-管理登录</div>
        <div id="darkbannerwrap"></div>
        
        <form method="post" class="layui-form" action="{{url('do_login')}}">
            <input name="username" placeholder="用户名"  type="text" lay-verify="required" class="layui-input" >
            <hr class="hr15">
            <input name="password" lay-verify="required" placeholder="密码"  type="password" class="layui-input">
            <hr class="hr15">
            <input name="code" lay-verify="required" placeholder="验证码"  type="input" class="layui-input">
            <input type="hidden" value="" id="codename" name="codename">
            <input type="button" id="code" class="form-control" onclick="createCode()" style="width:60%" title='点击更换验证码'>
            <hr class="hr15">
            <input value="登录" lay-submit lay-filter="login" style="width:100%;" type="submit">
            <hr class="hr20" >
        </form>
    </div>


    
    <title>纯字验证码</title>
<meta http-equiv='content-type' content='text/html;charset=utf-8'/>
<script type='text/javascript'>
    var code ; //在全局定义验证码
    function createCode(){
        code = "";
        var codeLength = 4;//验证码的长度
        var checkCode = document.getElementById("code");
        var codename = document.getElementById("codename");
        var random = new Array(0,1,2,3,4,5,6,7,8,9,);//随机数
        for(var i = 0; i < codeLength; i++) {//循环操作
            var index = Math.floor(Math.random()*10);//取得随机数的索引（0~35）
            code += random[index];//根据索引取得随机数加到code上
        }
        checkCode.value = code;//把code值赋给验证码
        codename.value = code;//把code值赋给验证码
    }
   
</script>
<style type='text/css'>
    #code{
        font-family:Arial,宋体;
        font-style:italic;
        color:#F5FFFA;
        border:0;
        padding:2px 3px;
        letter-spacing:3px;
        font-weight:bolder;
    }
</style>

  
</body>
</html>


