<table border="1">
    <tr>
        <td>uid</td>
        <td>用户名</td>
        <td>分享二维码</td>
        <td>二维码</td>
        <td>操作</td>
    </tr>
    @foreach($info as $v)
        <tr>
            <td>{{$v->id}}</td>
            <td>{{$v->name}}</td>
            <td>{{$v->id}}</td>
            <td><img src='{{$v->qrcode_url}}' alt="" height="150"></td>
            <td><a href="{{url('create_qrcode')}}?id={{$v->id}}">生成专属二维码</a></td>
        </tr>
    @endforeach
</table>
</html>