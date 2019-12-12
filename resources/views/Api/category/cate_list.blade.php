@extends('layouts.admin')
@section('title','类型展示页面')
@section('content')
    <h3>分类展示页面</h3>
    <table class='table table-striped table-bordered'>
        <tr>
            <td>id</td>
            <td>分类名</td>

        </tr>
        @foreach($res as $v)
            <tr>
                <td>{{$v['id']}}</td>
                <td>{{$v['cate_name']}}</td>
            </tr>
        @endforeach
    </table>
@endsection