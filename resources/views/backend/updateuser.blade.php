@extends('layout')
@section('content')
<div class="container ">
    <h2>更新用户 <a style="margin-left: 50px;" class="btn btn-info" href="/admin/user/list">用户列表</a></h2>
    @if (isset($msg))
        <div class="alert alert-dismissible @if ($status == "error") alert-danger @else alert-success @endif">
            <strong>{{$msg}}</strong>
        </div>
    @endif
    <div class="well">
        <form method="POST" class="form-horizontal" action="/admin/user/update" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="hidden" id="user_id" name="user_id" value="{{$user->id}}"/>
            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-md-1 control-label">姓名</label>
                    <div class="col-md-2">
                        <input  class="form-control" type="text" name="real_name" id="real_name" value="{{$user->real_name}}" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-md-1 control-label">登录名</label>
                    <div class="col-md-2">
                        <input  class="form-control" type="text" name="name" id="name" value="{{$user->name}}" required/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="qq" class="col-md-1 control-label">QQ</label>
                    <div class="col-md-2">
                        <input  class="form-control" type="text" name="qq" id="qq" value="{{$user->qq}}">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="department" class="col-md-1 control-label">部门</label>
                    <div class="col-md-2">
                        <select  class="form-control" type="text" name="department" id="department">
                            @foreach($department as $k=>$v)
                                <option value="{{$v['id']}}" id="option-{{$k}}" @if($v['id'] == $user->department_id) selected=selected @endif>{{$v['name']}} </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">确认修改</button>
                </div>
            </div>
        </form>
    </div>
</div>

@endsection
