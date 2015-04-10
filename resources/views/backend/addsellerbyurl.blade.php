@extends('layout')
@section('content')
<div class="container ">
    <h2>通过链接添加商家 <a style="margin-left: 50px;" class="btn btn-info" href="/admin/seller/list">商家列表</a></h2>
    @if (isset($msg))
        <div class="alert alert-dismissible @if ($status == "error") alert-danger @else alert-success @endif">
            <strong>{{$msg}}</strong>
        </div>
    @endif
    <div class="well">
        <form method="POST" class="form-horizontal" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">链接</label>
                <div class="col-md-6">
                    <input  class="form-control" type="text" name="url" id="name" required>
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
