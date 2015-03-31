@extends('layout')

@section('content')
<div class="container">
    <h2>商家列表<a style="margin-left: 50px;" class="btn btn-info" href="/admin/seller/add">添加商家</a></h2>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>商家名</th>
                <th>电话</th>
                <th>备注</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['phone']}}</td>
                    <td>{{$v['remark']}}</td>
                    <td>
                        <a class="btn btn-primary btn-sm" href="/admin/goods/list/{{$v['id']}}">菜单</a>
                        <button class="btn btn-warning btn-sm btn-stop" data={{$v['id']}}>暂停</button>
                        <button class="btn btn-danger btn-sm btn-delete" data={{$v['id']}}>删除</button>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
</script>

@endsection
