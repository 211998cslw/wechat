<center>
    <h1>公众号标签管理</h1>
<table border="1">
    <a href="{{url('add_tag')}}">添加标签</a>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
    <a href="{{url('user_list')}}">粉丝列表</a>
    <tr>
        <td>tag_id</td>
        <td>tag_name</td>
        <td>标签下的粉丝数</td>
        <td>操作</td>
    </tr>
    @foreach($info as $v)
        <tr>
            <td>{{$v['id']}}</td>
            <td>{{$v['name']}}</td>
            <td>{{$v['count']}}</td>
            <td>
                <a href="{{url('tag_del')}}?id={{$v['id']}}">删除标签</a> |
                <a href="{{url('tag_update')}}?tag_id={{$v['id']}}&tag_name={{$v['name']}}">修改标签</a> |
                <a href="{{url('tag_openid_list')}}?tagid={{$v['id']}}">标签下的粉丝列表</a> |
                <a href="{{url('push_tag_message')}}?tagid={{$v['id']}}">推送标签群发消息</a> |
                <a href="{{url('user_list')}}?tag_id={{$v['id']}}">批量为用户打标签</a>
            </td>
        </tr>
    @endforeach
</table>
</center>