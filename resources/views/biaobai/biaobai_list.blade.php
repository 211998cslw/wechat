
<table border="1">
    <tr>
        <td>菜单结构</td>
        <td>菜单编号</td>
        <td>表白名称</td>
        <td>二级表白名称</td>
        <td>标识</td>
        <td>事件类型</td>
        <td>菜单等级</td>
    </tr>
@foreach($info as $v)
    <tr>
        <td>{{$v->bb88_str}}</td>
        <td>{{$v->id}}</td>
        <td>{{$v->bb_name}}</td>
        <td>{{$v->second_biaobai_name}}</td>
        <td>{{$v->bb_tag}}</td>
        <td>{{$v->event_type}}</td>
        <td>{{$v->bb_type}}</td>

    </tr>
@endforeach
</table>




