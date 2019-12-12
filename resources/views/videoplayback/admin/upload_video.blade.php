<!DOCTYPE html>
<html>
<head>
    <title>微信上传素材</title>
</head>
<body>
    <form action="{{url('do_upload')}}" class="all" method="post" enctype="multipart/form-data">
        @csrf
        素材类型: <select name="up_type">
            <option value="1">临时素材</option>
            <option value="2">永久素材</option>
        </select><br />
        <span>上传临时/永久视频</span>
        文件：<input type="file" name="video" value=""><br/><br/>
        <input type="submit" name="" value="提交">
    </form>
</body>
</html>