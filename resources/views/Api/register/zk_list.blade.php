@extends('layouts.admin')
@section('title','类型展示页面')
@section('content')
    <h3>分类展示页面</h3>
    <table class='table table-striped table-bordered'>
        <tr>
            <td>new_id</td>
            <td>标题</td>
            <td>内容</td>
            <td>img_width</td>
            <td>full_title</td>
            <td>padate</td>
            <td>图片</td>
        </tr>
        <tbody class="add">
            
        </tbody>
    </table>
    <nav aria-label="Page navigation">
    <ul class="pagination">
        
    </ul>
    <!-- <a href="">上一页</a>
    <a href="">下一页</a> -->
</nav>
<script type="text/javascript">
    alert(1);
    // $.ajax({
    //         url:"http://www.wechat.com/zk_list",
    //         type:'GET',
    //         dataType:'json',
    //         success:function(res){
    //     // $(".add").empty();
    //         $.each(res.data,function(i,v){
    //             var arr='<tr><td>'+v.id+'</td>\
    //             <td>'+v.new_id+'</td>\
    //             <td>'+v.content+'</td>\
    //             <td>'+v.title+'</td>\
    //             <td>'+v.img_width+'</td>\
    //             <td>'+v.full_title+'</td>\
    //             <td>'+v.padate+'</td>\
    //             <td><img src="/'+v.img+'"></td>\
    //             </tr>';  
    //              $(".add").append(arr);
    //         })
            
    //     }
    // })
    $.ajax({
        url:"http://www.wechat.com/zk_list",
        type:'GET',
        dataType:'json',
        success:function(res){
            $.each(res,function(i,v){
                var arr='<tr><td>'+v.new_id+'</td>\
                <td>'+v.title+'</td>\
                <td>'+v.content+'</td>\
                </tr>';
                 $(".add").append(arr);
            })
        }
    })
   // //分页
   //        $(document).on('click',".pagination a",function(){
   //           //alert(111);
   //          var page = $(this).attr('page');
   //          // var val = $("#test").val();
   //          // alert(page);
   //          $.ajax({
   //              url:"http://www.wechat.com/zk_list",
   //              type:"GET",
   //              data:{page:page},
   //              dataType:"json",
   //              success:function(res){
   //                  msgion(res);
   //              },
   //          });
   //        })
   //      function msgion(res){
   //          $(".add").empty();
   //          $.each(res.data.data,function(i,v){
   //              var arr='<tr><td>'+v.id+'</td>\
   //              <td>'+v.new_id+'</td>\
   //              <td>'+v.content+'</td>\
   //              <td>'+v.title+'</td>\
   //              <td>'+v.img_width+'</td>\
   //              <td>'+v.full_title+'</td>\
   //              <td>'+v.padate+'</td>\
   //              <td><img src="/'+v.img+'"></td>\
   //              </tr>';
   //              $(".add").append(arr);
   //          });
   //          var page="";
   //          for(var i=1;i<=res.data.last_page;i++){
   //              page += "<li><a page='"+i+"'>第"+i+"页</a></li>";
   //          }
   //          $('.pagination').html(page);
   //    }
      </script>
@endsection