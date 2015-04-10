@extends('layout')
@section('content')
<div class="container ">
    <h2>设置点餐时间 </h2>
    <div class="well">
        @if (Session::has('msg'))
            <div class="alert alert-success alert-dismissible">
                <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <ul>
                        <li>{{ Session::get('msg') }}</li>
                </ul>
            </div>
        @endif
        <form method="POST" class="form-horizontal" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">链接</label>
                <div class="col-md-2">
                    <input  class="form-control" type="time" name="lunch" value=@if(isset($time->lunch_time)) {{$time->lunch_time}} @endif required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">链接</label>
                <div class="col-md-2">
                    <input  class="form-control" type="time" name="supper" value=@if(isset($time->supper_time)) {{$time->supper_time}} @endif required>
                </div>
            </div>
        </div>
        <div class="form-group">
            <div class="row">
                <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">添加商家</button>
            </div>
        </div>
        </form>
    </div>
</div>

@endsection
