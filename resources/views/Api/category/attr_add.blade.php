@extends('layouts.admin')
@section('content')
    <h3 align="center">属性添加</h3>
    <form action="{{url('api/attr_do_add')}}" method="post">
        <div class="form-group">
            <label for="inputEmail3" class="col-sm-2 control-label">属性名称</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="attr_name">
            </div>
        </div>


        <div class='form-group'>
            <label for="exampleInputEmail1">所属商品类型：</label>
            <!-- <input type="text" class='form-control' name='tnum'> -->

            <select name="type_id" id="" class='form-control'>
                <option value="0">请选择...</option>
                @foreach ($res as $v)
                    <option value="{{$v['id']}}">{{$v['cate_name']}}</option>
                @endforeach
            </select>
        </div>

        <div class='form-group'>
            <label for="exampleInputEmail1">属性是否可选：</label>
            <input type="radio" name='attr_status' value='1'>可选
            <input type="radio" name='is_show' value='2'>不可选
        </div>

        <input type="submit" value="确定">
        <input type="reset" value="重置">
    </form>
@endsection






