<!DOCTYPE html>
<html>
<head>
	<title>微信用户标签推送消息</title>
</head>
<body>
	<form action="{{url('wechat/do_push_tag_message')}}" method="post">
		@csrf
		消息类型：
		<select name="push_type">
			<option value="1">文本消息</option>
			<option value="2">图片消息</option>
		</select>
		<br/><br/><br/>
		<input type="hidden" name="openid" value="{{$openid}}">
		<input type="hidden" name="tag_id" value="{{$tag_id}}">
		消息内容：<textarea name="message" cols="30" rows="10"></textarea>
		 <br/><br/><br/><br/>
		 素材id:<input type="text" name="media_id">
		 <br/><br/><br/>
		 <input type="submit" value="提交">
	</form>
</body>
</html>