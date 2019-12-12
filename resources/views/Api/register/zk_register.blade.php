@extends('layouts.admin')
@section('title')注冊@endsection
@section('content')
    <h3 align="center">注册</h3>
    <form action="{{url('zk_register_do')}}" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">账号</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name">
            </div>
        </div>

        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">密码</label>
            <div class="col-sm-10">
                <input type="password" class="form-control" name="password">
            </div>
        </div>
        <input type="submit" value="注册">
        <input type="reset" value="重置">
    </form>
@endsection
