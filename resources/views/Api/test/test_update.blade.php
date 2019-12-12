@extends('layouts.admin')
@section('title','修改页面')
@section('content')
    <h3>修改页面</h3>
    <div class='form-group'>
        <label for="exampleInputEmail1">用户名：</label>
        <input type="text" class='form-control' name='test_name' >
    </div>

    <div class='form-group'>
        <label for="exampleInputEmail1">年龄：</label>
        <input type="text" class='form-control' name='test_age' >
    </div>
    <button type='submit' class='btn btn-default' id='but'>修改</button>

    <script>
        function getUrlParms(name){
            var reg = new RegExp("(^|&)"+ name +"=([^&]*)(&|$)");
            var r = window.location.search.substr(1).match(reg);
            if(r!=null)
                return unescape(r[2]);
            return null;
        }
        var url="http://www.wechat.com/api/user";
        var id = getUrlParms("id");
//        alert(id);
        $.ajax({
            url:url+"/"+id,
            type:'GET',
            dataType:'json',
            success:function (res) {
                var name=$('[name="test_name"]').val(res.data.test_name);
                var age=$('[name="test_age"]').val(res.data.test_age);
            }
//            alert(11);
        })
        $('#but').on('click',function(){
            // alert('123');
            //获取姓名 年龄
            var name=$('[name="test_name"]').val();
            var tag_age=$('[name="test_age"]').val();
            $.ajax({
                url:url+"/"+id,
                type:'POST',
                data:{test_name:name,test_age:tag_age,id:id,"_method":"PUT"},
                dataType:"json",
                success:function(res){
                    if(res.ret==1){
                        alert(res.msg);
                        location.href="http://www.wechat.com/Api/test/test_list";
                    }
                }

            })
        })
    </script>
@endsection