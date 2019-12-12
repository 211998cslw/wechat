<table border="1">
	<tr>
		<td>班级id</td>
		<td>班级名称</td>
		<td>学生信息</td>
	</tr>
	@foreach($data as $v)
	<tr>
		<td>{{$v->class_id}}</td>
		<td>{{$v->class_name}}</td>
		<td></td>
	</tr>
	@endforeach
</table>