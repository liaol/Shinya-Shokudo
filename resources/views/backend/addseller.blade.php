@extends('layout')
@section('content')
<div class="container ">
    <h2>添加商家 <a style="margin-left: 50px;" class="btn btn-info" href="/admin/seller/list">商家列表</a></h2>
    @if (isset($msg))
        <div class="alert @if ($status == "error") alert-danger @else alert-success @endif">
            <strong>{{$msg}}</strong>
        </div>
    @endif
    <div class="well">
        <form method="POST" class="form-horizontal" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
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
                    <input name="delivery_time" type="radio" value="1" checked />全天
                    <input name="delivery_time" type="radio" value="2" />午餐
                    <input name="delivery_time" type="radio" value="3" />晚餐
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
</div>

@endsection
