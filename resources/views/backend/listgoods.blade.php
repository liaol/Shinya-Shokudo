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
                        @if ($v['status'] == 1)
                            <button class="btn btn-warning btn-sm close-btn" data={{$v['id']}}>关闭</button>
                        @else 
                            <button class="btn btn-success btn-sm open-btn" data={{$v['id']}}>开放</button>
                        @endif
                        <button class="btn btn-danger btn-sm del-btn" data={{$v['id']}}>删除</button>
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
    $(".close-btn").on('click',close);

    $(".open-btn").on('click',open);

    function open(that){
        var that = $(this);
        var con = confirm('确定开放吗？');
        if(con){
            $.ajax({
                type:"POST",
                url:"/admin/goods/update",
                data:{_token:"{{csrf_token()}}",goods_id:that.attr('data'),status:1}
            }).done(function(data){
                if(data.status == 'success'){
                    that.toggleClass('btn-warning close-btn btn-success open-btn').html("关闭");
                    that.unbind();//先解绑原来的事件 再绑定新事件
                    that.on('click',close);
                }else{
                    alert('操作失败！');
                }
            });
        }else{
            return false;
        }
    }

    function close(that){
        var that = $(this);
        var con = confirm('确定关闭吗？');
        if(con){
            $.ajax({
                type:"POST",
                url:"/admin/goods/update",
                data:{_token:"{{csrf_token()}}",goods_id:that.attr('data'),status:2}
            }).done(function(data){
                if(data.status == 'success'){
                    that.toggleClass('btn-warning close-btn btn-success open-btn').html("开放");
                    that.unbind();
                    that.on('click',open);
                }else{
                    alert('操作失败！');
                }
            });
        }else{
            return false;
        }
    }

    $(".del-btn").on('click',function(){
        var con = confirm('确定删除吗？');
        if(con){
            var that = $(this);
            $.ajax({
                type:"POST",
                url:"/admin/goods/update",
                data:{_token:"{{csrf_token()}}",goods_id:that.attr('data'),status:3}
            }).done(function(data){
                if(data.status == 'success'){
                    that.parent().parent().fadeOut();
                }else{
                    alert('操作失败！');
                }
            });
        }else{
            return false;
        }
    });
});
</script>

@endsection







