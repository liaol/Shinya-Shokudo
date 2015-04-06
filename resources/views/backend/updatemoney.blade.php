@extends('layout')
@section('content')
<div class="container ">
    <h2>给{{$userInfo['real_name']}}充值 <a style="margin-left: 50px;" class="btn btn-info" href="/admin/user/list">用户列表</a></h2>
    <div class="well">
        <form method="POST" id="update-form">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="row">
                <label for="type" class="col-md-1 control-label">操作</label>
                <div class="col-md-2">
                    <input name="type" type="radio" value="1" checked />充值
                    <input name="type" type="radio" value="2" />扣除
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="phone" class="col-md-1 control-label">金额</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="money" id="money" required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">提交</button>
            </div>
        </div>
        </form>
    </div>
</div>
<script>
    $('#update-form').on('submit',function(){
        var user_name = "{{$userInfo['real_name']}}";
        var money = $('#money').val();
        var type  = $('input[name="type"]:checked').val();
        if(type == "1")
            type = "充值";
        else 
            type = "扣除";
        var msg = "确认给"+user_name + type + money + "元";
        return confirm(msg);
        
    });
</script>
@endsection
