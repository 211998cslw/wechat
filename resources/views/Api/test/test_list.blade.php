@extends('layouts.admin')
@section('title')列表展示@endsection
@section('content')
    <center>
        用户名:<input type="text" name="name"><input type="button" value="搜索" id="search">
        <table class="table table-striped table-bordered" border="1">
            <tr>
                <td>Id</td>
                <td>姓名</td>
                <td>年龄</td>
                <td>操作</td>
            </tr>
            <tbody class="add">
            </tbody>
        </table>
    </center>
    <nav aria-label="Page navigation">
        <ul class="pagination">
            <!-- <li>
              <a href="#" aria-label="Previous">
                <span aria-hidden="true">&laquo;</span>
              </a>
            </li>
            <li><a href="#">1</a></li>
            <li><a href="#">2</a></li>
            <li><a href="#">3</a></li>
            <li><a href="#">4</a></li>
            <li><a href="#">5</a></li>
            <li>
              <a href="#" aria-label="Next">
                <span aria-hidden="true">&raquo;</span>
              </a>
            </li> -->
        </ul>
    </nav>
    <script>
        $.ajax({
            url:url,
            dataType:"json",
            type:"GET",
            success:function(res){
                $('.btn-danger').click(function() {
                    var id = $(this).attr('id');
                    // alert(id);
                    $.ajax({
                        url: 'http://www.wechat.com/test_delete',
                        dataType: 'json',
                        data: {id:id},
                        success: function (res) {
                            if (res.res == 1) {
                                alert(res.msg);
                                location.href = "http://www.wechat.com/Api/test/test_list"
                            }
                        }
                    })
                })
                showData(res);
            }
        })
        //根据后台数据 渲染表格数据
        function showData(res)
        {
            $(".add").empty();
            $.each(res.data.data,function(k,v){
                var tr = $('<tr></tr>');
                tr.append("<td>"+v.id+"</td>");
                tr.append("<td>"+v.test_name+"</td>");
                tr.append("<td>"+v.test_age+"</td>");
                $(".add").append(tr);
            })
            var max_page =res.data.last_page;
            $(".pagination").empty();
            for(var i=1;i<=max_page;i++){
                var li ="<li><a href='javascript:;'>"+i+"</a></li>";
                $(".pagination").append(li);
            }
        }

    </script>
@endsection