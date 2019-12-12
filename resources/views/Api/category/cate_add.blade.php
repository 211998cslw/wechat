@extends('layouts.admin')
@section('title')分类添加@endsection
@section('content')
    <h3 align="center">分类添加</h3>
    <form action="{{url('api/cate_do_add')}}" method="post">
    <div class="form-group">
        <label for="inputEmail3" class="col-sm-2 control-label">分类名称</label>
        <div class="col-sm-10">
            <input type="text" class="form-control" name="cate_name">
        </div>
    </div>
    <input type="submit" value="确定">
    <input type="reset" value="重置">
    </form>
@endsection
