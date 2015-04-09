@extends('layout')

@section('content')
<div class="container">
    <h2>
       {{$userName}}的订单
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
                </tr>
            @endforeach
        </tbody>
    </table>
    <?php echo $data->render(); ?>
</div>
@endsection







