<!doctype html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
</head>
<body>
<form action="{{url('k_add')}}" method="post">
    <table border="1">
        <tr>
            <td colspan="2">
                第一节课:<select name="kecheng1" id="">
                    <option value="php">php</option>
                    <option value="css">css</option>
                    <option value="html">html</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                第二节课:<select name="kecheng2" id="">
                    <option value="语文">语文</option>
                    <option value="数学">数学</option>
                    <option value="英语">英语</option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                第三节课:<select name="kecheng3" id="">
                    <option value="数学">数学</option>
                    <option value="体育">体育</option>
                    <option value="音乐">音乐</option>
                </select>
            </td>
        </tr>

        <tr>
            <td colspan="2">
                第四节课:<select name="kecheng4" id="">
                    <option value="语文">语文</option>
                    <option value="数学">数学</option>
                    <option value="体育">体育</option>
                </select>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <input type="submit" value="提交">
            </td>
        </tr>
    </table>
</form>

</body>
</html>