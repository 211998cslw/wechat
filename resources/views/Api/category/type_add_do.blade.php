@extends('layouts.admin')
@section('title')类型添加@endsection
@section('content')
    <h3 align="center">类型添加</h3>
    <form action="{{url('api/type_add_d')}}" method="post">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">类型名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="type_name">
        </div>
    </div>
    <input type="submit" value="确定">
    <input type="reset" value="重置">
    </form>
@endsection
