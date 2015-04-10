@extends('layout')

@section('content')
<div class="container">
    <h2>商家列表
        <a style="margin-left: 50px;" class="btn btn-info" href="/admin/seller/add">添加商家</a>
        <a style="margin-left: 20px;" class="btn btn-info" href="/admin/seller/addbyurl">通过链接添加商家</a>
    </h2>
    <div class="well" style="display:none" id="update-form">
        <form method="POST" class="form-horizontal" action="/admin/seller/update" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <input type="hidden" id="seller_id" name="seller_id" value="">
        <div class="form-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">名称</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="name" id="name" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="phone" class="col-md-1 control-label">电话</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="phone" id="phone">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="delivery_time" class="col-md-1 control-label">配送时间</label>
                <div class="col-md-2">
                    <input name="delivery_time" type="radio" id="radio-1" value="1"/>全天
                    <input name="delivery_time" type="radio" id="radio-2" value="2" />午餐
                    <input name="delivery_time" type="radio" id="radio-3" value="3" />晚餐
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="remark" class="col-md-1 control-label">备注</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="remark" id="remark">
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">添加店铺</button>
            </div>
        </div>
        </form>
    </div>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>商家名</th>
                <th>电话</th>
                <th>配送时间</th>
                <th>备注</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['phone']}}</td>
                    <td>@if ($v['delivery_time'] == 1) 全天 @elseif ($v['delivery_time'] == 2) 午餐 @else 晚餐 @endif</td>
                    <td>{{$v['remark']}}</td>
                    <td>
                        <a class="btn btn-link btn-sm" href="/admin/goods/list/{{$v['id']}}">菜单</a>
                        @if ($v['status'] == 1)
                            <button class="btn btn-warning btn-sm close-btn" data={{$v['id']}}>关闭</button>
                        @else 
                            <button class="btn btn-success btn-sm open-btn" data={{$v['id']}}>开放</button>
                        @endif
                        <button class="btn btn-primary btn-sm update-btn" data={{$v['id']}}>修改</button>
                        <button class="btn btn-danger btn-sm del-btn" data={{$v['id']}}>删除</button>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
    $(function(){
        $(".close-btn").on('click',close);

        $(".open-btn").on('click',open);

        function open(that){
            var that = $(this);
            var con = confirm('确定开放吗？');
            if(con){
                $.ajax({
                    type:"POST",
                    url:"/admin/seller/update",
                    data:{_token:"{{csrf_token()}}",seller_id:that.attr('data'),status:1}
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
                    url:"/admin/seller/update",
                    data:{_token:"{{csrf_token()}}",seller_id:that.attr('data'),status:2}
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
                    url:"/admin/seller/update",
                    data:{_token:"{{csrf_token()}}",seller_id:that.attr('data'),status:3}
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

        $(".update-btn").on("click",function(){
            var name = $(this).parent().parent().find('td').eq(0).html();
            var phone = $(this).parent().parent().find('td').eq(1).html();
            var delivery_time = $(this).parent().parent().find('td').eq(2).html();
            var remark = $(this).parent().parent().find('td').eq(3).html();
            var seller_id = $(this).attr('data');
            $("#name").val(name);
            $("#phone").val(phone);
            $("#remark").val(remark);
            $('#seller_id').val(seller_id);
            var type;
            switch (delivery_time.trim()){//要去除空格先
                case "午餐":
                    type = '2';
                    break;
                case "晚餐":
                    type = '3';
                    break;
                default:
                    type = '1';
                    break;
            }
            $("#radio-"+type).click();
            $("#update-form").show();
        });
    });
</script>

@endsection
