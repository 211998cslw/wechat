<!DOCTYPE html>
<html class="x-admin-sm">
    <head>
        <meta charset="UTF-8">
        <title>欢迎页面-X-admin2.2</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width,user-scalable=yes, minimum-scale=0.4, initial-scale=0.8,target-densitydpi=low-dpi" />
        <link rel="stylesheet" href="{{asset('admin/css/font.css')}}">
        <link rel="stylesheet" href="{{asset('admin/css/xadmin.css')}}">
        <script type="text/javascript" src="{{asset('admin/lib/layui/layui.js')}}" charset="utf-8"></script>
        <script type="text/javascript" src="{{asset('admin/js/xadmin.js')}}"></script>
        <!-- 让IE8/9支持媒体查询，从而兼容栅格 -->
        <!--[if lt IE 9]>
            <script src="https://cdn.staticfile.org/html5shiv/r29/html5.min.js"></script>
            <script src="https://cdn.staticfile.org/respond.js/1.4.2/respond.min.js"></script>
        <![endif]-->
    </head>
    <body>
        <div class="layui-fluid">
            <div class="layui-row">
                <form class="layui-form" action="{{url('cate_update_do/'.$res->cate_id)}}" method="post">
      
                  <div class="layui-form-item">
                      <label for="username" class="layui-form-label">
                          <span class="x-red">*</span>分类名称
                      </label>
                      <div class="layui-input-inline">
                          <input type="text"  name="cate_name" required="" lay-verify="required"
                          autocomplete="off" class="layui-input" value="{{$res->cate_name}}">
                      </div>
                    </div>

                    <div class="layui-form-item">
                      <div class="layui-input-inline">
                          <input type="submit"  value="修改" required="" lay-verify="required"
                          autocomplete="off" class="layui-input">
                      </div>
                    </div>
              </form>
            </div>
        </div>
    </body>
</html>