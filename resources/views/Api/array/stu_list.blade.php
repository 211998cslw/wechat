<table border="1">
	<tr>
		<td>班级id</td>
		<td>班级名称</td>
		<td>班级学生总人数</td>
	</tr>
	@foreach($res as $v)
	<tr>
		<td>{{$v->class_id}}</td>
		<td>{{$v->class_name}}</td>
		<td>{{$v->attr_count}}</td>
	</tr>
	@endforeach
</table>