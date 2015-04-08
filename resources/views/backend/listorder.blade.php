@extends('layout')

@section('content')
<div class="container">
    <h2>
        {{Request::input('date') }} @if(Request::input('time')==2) 午餐 @elseif(Request::input('time')==3) 晚餐 @endif 订单列表<a style="margin-left: 50px;" class="btn btn-info" href="/admin/seller/list">返回商家列表</a>
    </h2>
    <h3>{{$count['all']}}人点餐，其中{{$count['uncheck']}}人未审核</h3>
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>用户名</th>
                <th>商家</th>
                <th>菜名</th>
                <th>数量</th>
                <th>金额</th>
                <th>时间类型</th>
                <th>支付类型</th>
                <th>状态</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['user_name']}}</td>
                    <td>{{$v['seller_name']}}</td>
                    <td>{{$v['goods_name']}}</td>
                    <td>{{$v['quantity']}}</td>
                    <td>{{$v['money']}}</td>
                    <td>@if($v['time_type'] == 2) 午餐 @else 晚餐 @endif</td> 
                    <td>@if($v['pay_type'] == 1) 自付 @else 公司付 @endif</td> 
                    <td>@if($v['status'] == 1)未审核@elseif($v['status']==2)审核通过 @elseif($v['status']==3)审核未通过@else 已取消 @endif </td>
                    <td>{{$v['time']}}</td>
                    <td>
                        <button class="btn btn-success btn-sm pass-btn" data={{$v['id']}} @if($v['status'] != 1) disabled="disabled" @endif>通过</button>
                        <button class="btn btn-warning btn-sm cancle-btn" data={{$v['id']}} @if($v['status'] != 1) disabled="disabled" @endif>取消</button>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
</div>

<script>
$(function(){
    $(".pass-btn").on('click',function(){
        var that = $(this);
        var msg = getMsg(that,'通过');
        var con = confirm(msg);
        if(con){
            $.ajax({
                type:"POST",
                url:"/admin/order/pass",
                data:{_token:"{{csrf_token()}}",order_id:that.attr('data')}
            }).done(function(data){
                if(data.status == 'success'){
                    location.reload();
                }else{
                    alert('操作失败！');
                }
            });
        }else{
            return false;
        }
    });

    $(".cancle-btn").on('click',function(){
        var that = $(this);
        var msg = getMsg(that,'取消');
        var con = confirm(msg);
        if(con){
            $.ajax({
                type:"POST",
                url:"/admin/order/cancle",
                data:{_token:"{{csrf_token()}}",order_id:that.attr('data')}
            }).done(function(data){
                if(data.status == 'success'){
                    location.reload();
                }else{
                    alert('操作失败！');
                }
            });
        }else{
            return false;
        }
    });

    function getMsg(that,type){
        var user_name =  that.parent().parent().find('td').eq(0).html();
        var seller_name =  that.parent().parent().find('td').eq(1).html();
        var goods_name =  that.parent().parent().find('td').eq(2).html();
        var quantity =  that.parent().parent().find('td').eq(3).html();
        var money =  that.parent().parent().find('td').eq(4).html();
        var pay_type =  that.parent().parent().find('td').eq(6).html();
        var msg = '确定'+type+user_name+"的"+quantity+"份"+seller_name+"-"+goods_name+'共'+money+"元"+pay_type+"？";
        return msg;
    }
});
</script>

@endsection







