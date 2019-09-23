<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>菜单列表</title>
</head>
<body>
<h3 align="center">菜单添加</h3>
<form action="{{url('do_qd')}}" method="post">
    <table border="1" align="center">
        <tr>
                <td>菜单类型: <select name="qd_type" id="">
                    <option value="1">一级菜单</option>
                    <option value="2">二级菜单</option>
                </select>
            </td>
        </tr>

        <tr>
            <td> 菜单名称:<input type="text" name="qd_name"></td>
        </tr>

        <tr>
            <td>二级菜单名称:<input type="text" name="second_qd_name"></td>
        </tr>

        <tr>
            <td>  菜单标识(标识或url)<input type="text" name="qd_tag"></td>
        </tr>

        <tr>
            <td>事件类型:<select name="event_type" id="">
                    <option value="click">click</option>
                    <option value="view">view</option>
                    <option value="scancode_push">scancode_push</option>
                    <option value="scancode_waitmsg">scancode_waitmsg</option>
                    <option value="pic_sysphoto">pic_sysphoto</option>
                    <option value="pic_photo_or_album">pic_photo_or_album</option>
                    <option value="pic_weixin">pic_weixin</option>
                    <option value="location_select">location_select</option>
                    <option value="media_id">media_id</option>
                </select>
            </td>
        </tr>

        <tr>
            <td><input type="submit" value="提交"></td>
        </tr>
    </table>
</form>
</body>
</html>

<h3 align="center">菜单展示</h3>
<table border ="1"  align="center">
    <tr>

        <td>菜单结构</td>
        <td>菜单编号</td>
        <td>菜单名称</td>
        <td>二级菜单名</td>
        <td>菜单等级</td>
        <td>事件类型</td>
        <td>菜单标识</td>

    </tr>
    @foreach($info as $v)
        <tr>
            <td>{{$v['qd_str']}}</td>
            <td>{{$v['qd_num']}}</td>
            <td>@if(empty($v['second_qd_name'])){{$v['qd_name']}}@endif</td>
            <td>{{$v['second_qd_name']}}</td>
            <td>{{$v['qd_type']}}</td>
            <td>{{$v['event_type']}}</td>
            <td>{{$v['qd_tag']}}</td>
        </tr>
    @endforeach
</table>