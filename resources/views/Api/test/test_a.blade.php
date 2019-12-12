@extends('layouts.admin')
@section('title')测试添加@endsection
@section('content')
    <h3>添加页面</h3>
            <div class="form-group">
                <label for="inputEmail3" class="col-sm-2 control-label">姓名</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="test_name">
                </div>
            </div>
            <div class="form-group">
                <label for="inputPassword3" class="col-sm-2 control-label">年龄</label>
                <div class="col-sm-10">
                    <input type="test" class="form-control" name="test_age">
                </div>
            </div>

    <div class="form-group">
        <label for="inputPassword3" class="col-sm-2 control-label">图片</label>
        <div class="col-sm-10">
            <input type="file" name="file">
        </div>
    </div>
    <input type="button" id="add" value="提交">

    <script>
//        alert(111);
    var url="http://www.wechat.com/api/user";
        $('#add').on('click',function(){
//            alert(111);
            //获取用户名 年龄
            var test_name=$("[name='test_name']").val();
            var test_age=$("[name='test_age']").val();
//            alert(test_name);
//            alert(test_age);
            //return;//不执行下面代码
            var fd =new FormData();//空表单
            fd.append('file',$("[name='file']")[0].files[0]);
            fd.append('test_name',test_name);
            fd.append('test_age',test_age);
            //ajax请求
            $.ajax({
                url:url,
                type:'POST',
                data:fd,
                dataType:"json",
                contentType:false,   //post数据类型  unlencode
                processData:false,   //处理数据
                success:function(res){
                    if(res.ret==1){
                        alert(res.msg);
                        location.href="http://www.wechat.com/Api/test/test_list";
                    }else{
                        alert(res.msg);
                    }
            }
            })
        })

    </script>
@endsection