@extends('layouts.admin')
@section('title','类型展示页面')
@section('content')
    <h3>分类展示页面</h3>
    <table class='table table-striped table-bordered'>
        <tr>
            <td>id</td>
            <td>商品名称</td>
            <td>商品分类</td>
            <td>商品价格</td>
            <td>商品图片</td>
        </tr>
        @foreach($res as $v)
            <tr>
                <td>{{$v->goods_id}}</td>
                <td>{{$v->goods_name}}</td>
                <td>{{$v->id}}</td>
                <td>{{$v->goods_price}}</td>
                <td>
                	<img src="{{$v->goods_img}}" width="200" height="200">
                </td>
            </tr>
        @endforeach
    </table>
<!-- <nav aria-label="Page navigation">
        <ul class="pagination">
            <li>
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
            </li>
        </ul>
    </nav> -->

<!-- <script>
        $.ajax({
            url:"http://www.wechat.com/api/goods_list",
            dataType:"json",
            type:"GET",
            success:function(res){
                $('.btn-danger').click(function() {
                    var id = $(this).attr('id');
                    // alert(id);
                
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
                tr.append("<td>"+v.goods_id+"</td>");
                tr.append("<td>"+v.goods_name+"</td>");
                tr.append("<td>"+v.id+"</td>");
                tr.append("<td>"+v.goods_price+"</td>");
                tr.append("<td>"+v.goods_price+"</td>");

                $(".add").append(tr);
            })
            var max_page =res.data.last_page;
            $(".pagination").empty();
            for(var i=1;i<=max_page;i++){
                var li ="<li><a href='javascript:;'>"+i+"</a></li>";
                $(".pagination").append(li);
            }
        }

    </script> -->
    {{ $res->links() }}
@endsection
