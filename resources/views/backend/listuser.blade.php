@extends('layout')

@section('content')
<div class="container">
    <h2>用户列表<a style="margin-left: 50px;" class="btn btn-info" href="/admin/user/add">添加用户</a></h2>
    <div class="well" style="display:none" id="update-form">
        <form method="POST" class="form-horizontal" action="/admin/user/update" >
            <input type="hidden" name="_token" value="{{ csrf_token() }}"/>
            <input type="hidden" id="user_id" name="user_id" value=""/>
            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-md-1 control-label">姓名</label>
                    <div class="col-md-2">
                        <input  class="form-control" type="text" name="real_name" id="real_name" />
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-md-1 control-label">登录名</label>
                    <div class="col-md-2">
                        <input  class="form-control" type="text" name="name" id="name" required/>
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="qq" class="col-md-1 control-label">QQ</label>
                    <div class="col-md-2">
                        <input  class="form-control" type="text" name="qq" id="qq">
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="department" class="col-md-1 control-label">部门</label>
                    <div class="col-md-2">
                        <select  class="form-control" type="text" name="department" id="department">
                            @foreach($department as $k=>$v)
                                <option value="{{$v['id']}}" id="option-{{$k}}">{{$v['name']}}</option>
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
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>登录名</th>
                <th>姓名</th>
                <th>部门</th>
                <th>余额</th>
                <th>类型</th>
                <th>QQ</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['name']}}</td>
                    <td>{{$v['real_name']}}</td>
                    <td>{{$v['department_name']}}</td>
                    <td>{{$v['money']}}</td>
                    <td>@if ($v['level'] == 1) 普通用户  @else 管理员 @endif</td>
                    <td>{{$v['qq']}}</td>
                    <td>
                        <a class="btn btn-link btn-sm" href="/admin/goods/list/{{$v['id']}}">历史记录</a>
                        <a class="btn btn-link btn-sm" href="/admin/money/update?userId={{$v['id']}}">充值</a>
                        <button class="btn btn-primary btn-sm update-btn" data={{$v['id']}}>修改</button>
                        <button class="btn btn-warning btn-sm reset-btn" data={{$v['id']}}>重置密码</button>
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
                    url:"/admin/user/update",
                    data:{_token:"{{csrf_token()}}",user_id:that.attr('data'),status:2}
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
            var real_name = $(this).parent().parent().find('td').eq(1).html();
            var department = $(this).parent().parent().find('td').eq(2).html();
            var qq = $(this).parent().parent().find('td').eq(5).html();
            var user_id = $(this).attr('data');
            $("#name").val(name);
            $("#real_name").val(real_name);
            $("#qq").val(qq);
            $('#user_id').val(user_id);
            var option = $("#department option");
            for(var i=0;i<option.length;i++){
                if($("#option-"+i).html().trim() == department.trim()){
                    $("#option-"+i).attr("selected","selected");
                }
            }
            $("#update-form").show();
        });
    });
</script>

@endsection
