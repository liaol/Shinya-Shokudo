@extends('layout')

@section('content')
<div class="container">
    <h2>
        我的订单
        <a class="btn btn-info" href="/menu">菜单</a>
    </h2>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>商家名</th>
                <th>菜名</th>
                <th>数量</th>
                <th>金额</th>
                <th>类型</th>
                <th>付款方式</th>
                <th>状态</th>
                <th>时间</th>
                <th>操作</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>{{$v['seller_name']}}</td>
                    <td>{{$v['goods_name']}}</td>
                    <td>{{$v['quantity']}}</td>
                    <td>{{$v['money']}}</td>
                    <td>@if($v['time_type'] == 2) 午餐 @else 晚餐 @endif</td> 
                    <td>@if($v['pay_type'] == 1) 自付 @else 公司付 @endif</td> 
                    <td>@if($v['status'] == 1)未审核@elseif($v['status']==2)审核通过 @elseif($v['status']==3)审核未通过@else 已取消 @endif </td>
                    <td>{{$v['time']}}</td>
                    <td>
                        <button class="btn btn-warning cancle-btn" data={{$v['id']}} @if($v['status'] != 1) disabled="disabled" @endif>取消</button>
                    </td>   
                </tr>
            @endforeach
        </tbody>
    </table>
    <?php echo $data->render(); ?>
</div>

<script>
    $(function(){
        $(".cancle-btn").on('click',function(){
            var con = confirm('确定取消吗？');
            if(con){
                var that = $(this);
                $.ajax({
                    type:"POST",
                    url:"/order/cancel",
                    data:{_token:"{{csrf_token()}}",order_id:that.attr('data')}
                }).done(function(data){
                    if(data.status == 'success'){
                        location.reload();
                    }else{
                        alert(data.msg);
                    }
                });
            }else{
                return false;
            }
        });
    });
</script>

@endsection







