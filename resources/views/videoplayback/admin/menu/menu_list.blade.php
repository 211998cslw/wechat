<center>
    <h1>创建菜单</h1>
    <form action="{{url('create_menu')}}" method="post">
        一级菜单:<input type="text" name="name1"></br>
        二级菜单:<input type="text" name="name2"></br>
        菜单类型[click/view]
        <select name="type" id="">
            <option value="1">click</option>
            <option value="2">view</option>
            <option value="3">pic_weixin</option>

        </select></br>
        事件值
        <input type="text" name="event_value"></br>
        <input type="submit" value="提交">
    </form>
    <h1>自定义菜单列表</h1>
    <table border="1">
        <tr>
            <td>name1</td>
            <td>name2</td>
            <td>操作</td>
        </tr>
        @foreach($info as $v)
            <tr>
                <td>{{$v->name1}}</td>
                <td>{{$v->name2}}</td>
                <td><a href="{{url('menu_del')}}?id={{$v->id}}">删除</a></td>
            </tr>
        @endforeach
    </table>
</center>
