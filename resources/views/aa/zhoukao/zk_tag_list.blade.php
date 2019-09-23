<center>
    <a href="{{url('zk_tag_add')}}">添加标签</a> |
    <a href="{{url('zk_user_list')}}">粉丝列表</a>
    <table border="1">
        <tr>
            <td>id</td>
            <td>标签名</td>
            <td>标签下粉丝数</td>
            <td>操作</td>
        </tr>
        @foreach($res as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['name']}}</td>
                <td>{{$v['count']}}</td>
                <td>
                    <a href="{{url('zk_user_list')}}?tag_id={{$v['id']}}">为粉丝打标签</a> |
                    <a href="{{url('zk_push_tag_message')}}?tagid={{$v['id']}}">推送消息</a>|
                    <a href="{{url('zk_tag_user')}}?id={{$v['id']}}">标签下粉丝列表</a>
                </td>
            </tr>
        @endforeach
    </table>

</center>