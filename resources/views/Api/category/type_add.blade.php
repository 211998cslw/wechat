@extends('layouts.admin')
@section('title','类型展示页面')
@section('content')
    <h3>类型展示页面</h3>
    <table class='table table-striped table-bordered'>
        <tr>
            <td>id</td>
            <td>商品类型名称</td>
            <td>属性数</td>
            <td>操作</td>
        </tr>
        @foreach($res as $v)
            <tr>
                <td>{{$v['type_id']}}</td>
                <td>{{$v['type_name']}}</td>
                <td>{{$v['attr_count']}}</td>
                <td>
                    <a href="{{url('api/attr_list')}}?type_id={{$v->type_id}}">属性列表</a>
                </td>
            </tr>
        @endforeach
    </table>
@endsection