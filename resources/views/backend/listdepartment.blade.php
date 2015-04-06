@extends('layout')

@section('content')
<div class="container">
    <h2>
        部门列表
        <button class="btn btn-success" onclick="$('#add').toggle()">添加部门</button>
    </h2>
    <div class="well" style="display:none" id="add">
        <form method="POST" class="form-horizontal" action="/admin/department/add" >
        <input type="hidden" name="_token" value="{{ csrf_token() }}">
        <div class="form-group" id="input-group">
            <div class="row">
                <label for="name" class="col-md-1 control-label">名称</label>
                <div class="col-md-1">
                    <input  class="form-control input-group" type="text" name="name"required>
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
                <th>人数</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['name']}}</td>
                    <td>
                        <button class="btn btn-danger btn-sm del-btn" data={{$v['id']}}>删除</button>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(function(){

    $(".del-btn").on('click',function(){
        var con = confirm('确定删除吗？');
        if(con){
            var that = $(this);
            $.ajax({
                type:"POST",
                url:"/admin/department/update",
                data:{_token:"{{csrf_token()}}",department_id:that.attr('data'),status:2}
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







