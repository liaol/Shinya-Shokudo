@extends('layout')

@section('content')
<div class="container">
    <h2>
        {{$sellerName}}-菜单<a style="margin-left: 50px;" class="btn btn-info" href="/admin/seller/list">返回商家列表</a>
        <button class="btn btn-success" onclick="$('#add').toggle()">添加菜单</button>
    </h2>
    <div class="well" style="display:none" id="add">
        <form method="POST" class="form-horizontal" action="/admin/goods/add" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" name="seller_id" value="{{$sellerId}}">
        <div class="form-group" id="input-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">名称</label>
                <div class="col-md-1">
                    <input  class="form-control input-group" type="text" name="name[]"required>
                </div>
                <label for="price" class="col-md-1 control-label">价格</label>
                <div class="col-md-1">
                    <input  class="form-control input-group" type="text" name="price[]" required>
                </div>
            </div>
        </div>
        </br>
        <div class="form-group">
            <div class="row">
                <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">确认添加</button>
            </div>
        </div>
    </div>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>名称</th>
                <th>价格</th>
                <th>销量</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['price']}}</td>
                    <td>{{$v['count']}}</td>
                    <td>
                        <button class="btn btn-warning btn-sm" id="stop" data={{$v['id']}}>暂停</button>
                        <button class="btn btn-danger btn-sm" id="delete" data={{$v['id']}}>删除</button>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(function(){
    $("#input-group").on("focus","input:last",function(){
        $("#input-group").append(
            '<div class="row">'+
                '<label for="name" class="col-md-1 control-label">名称</label>'+
                '<div class="col-md-1">'+
                    '<input  class="form-control input-group" type="text" name="name[]">'+
                '</div>'+
                '<label for="price" class="col-md-1 control-label">价格</label>'+
                '<div class="col-md-1">'+
                    '<input  class="form-control input-group" type="text" name="price[]">'+
                '</div>'+
            '</div>'
        );
    });
});



    
</script>

@endsection







