@extends('layout')
@section('content')
<div class="container ">
    <h2>修改密码</a></h2>
    @if (Session::has('error'))
        <div class="alert alert-danger">
            <ul>
                    <li>{{ Session::get('error') }}</li>
            </ul>
        </div>
    @endif
    <div class="well">
        <form method="POST" class="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
                <label for="name" class="col-md-1 control-label">旧密码</label>
                <div class="col-md-2">
                    <input  class="form-control" type="password" name="old_password" required/>
                </div>
        </div>
        <div class="form-group">
                <label for="name" class="col-md-1 control-label">新密码</label>
                <div class="col-md-2">
                    <input  class="form-control" type="password" name="new_password" id="password_1" required/>
                </div>
        </div>
        <div class="form-group">
                <label for="name" class="col-md-1 control-label">确认密码</label>
                <div class="col-md-2">
                    <input  class="form-control" type="password" name="name" id="password_2" required/>
                </div>
        </div>
        <div class="form-group">
            <div class="row">
                <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit" id="submit-btn">确认修改</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
$(function(){
    $("#submit-btn").on('click',function(){
        if($('#password_1').val() != $('#password_2').val()){
            alert('两次输入不一致');
            return false;
        }
    });
});
    
</script>
@endsection
