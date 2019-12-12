<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
<link rel="stylesheet" href="/css/page.css">
</head>
<body>

</body>
</html>
<table border="1">
    <tr>
        <td>new_id</td>
        <td>title</td>
        <td>content</td>
        <td>img_width</td>
        <td>full_title</td>
        <td>img</td>
        <td>pdate</td>
    </tr>
    @foreach($res as $v)
        <tr>
            <td>{{$v['new_id']}}</td>
            <td>{{$v['title']}}</td>
            <td>{{$v['content']}}</td>
            <td>{{$v['img_width']}}</td>
            <td>{{$v['full_title']}}</td>
            <td><img src="{{$v['img']}}" alt="" width="100" height="100"></td>
            <td>{{$v['pdate']}}</td>
        </tr>
    @endforeach

</table>
{{ $res->links() }}