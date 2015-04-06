@extends('layout')
@section('content')
<div class="container ">
    <h2>添加用户 <a style="margin-left: 50px;" class="btn btn-info" href="/admin/user/list">用户列表</a></h2>
    @if (isset($msg))
        <div class="alert alert-dismissible @if ($status == "error") alert-danger @else alert-success @endif">
            <strong>{{$msg}}</strong>
        </div>
    @endif
    <div class="well">
        <form method="POST" class="">
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group" id="input-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">姓名</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="real_name[]" />
                </div>
                <label for="name" class="col-md-1 control-label">登录名</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="name[]" required/>
                </div>
                <label for="name" class="col-md-1 control-label">QQ</label>
                <div class="col-md-2">
                    <input  class="form-control" type="text" name="qq[]" />
                </div>
                <label for="department" class="col-md-1 control-label">部门</label>
                <div class="col-md-2">
                    <select  class="form-control" name="department[]" >
                    @foreach($data as $v)
                        <option value="{{$v['id']}}">{{$v['name']}}</option>
                    @endforeach
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">添加用户</button>
            </div>
        </div>
        </form>
    </div>
</div>

<script>
    $("#input-group").on("focus","input:last",function(){
        $("#input-group").append(
            '<div class="row">'+
                '<label for="name" class="col-md-1 control-label">姓名</label>'+
                '<div class="col-md-2">'+
                    '<input  class="form-control" type="text" name="real_name[]" />'+
                '</div>'+
                '<label for="name" class="col-md-1 control-label">登录名</label>'+
                '<div class="col-md-2">'+
                    '<input  class="form-control" type="text" name="name[]" />'+
                '</div>'+
                '<label for="name" class="col-md-1 control-label">QQ</label>'+
                '<div class="col-md-2">'+
                    '<input  class="form-control" type="text" name="qq[]" />'+
                '</div>'+
                '<label for="department" class="col-md-1 control-label">部门</label>'+
                '<div class="col-md-2">'+
                    '<select  class="form-control" name="department[]" >'+
                    @foreach($data as $v)
                        '<option value="{{$v['id']}}">{{$v['name']}}</option>'+
                    @endforeach
                    '</select>'+
                '</div>'+
            '</div>'
        );
    });
</script>

@endsection
