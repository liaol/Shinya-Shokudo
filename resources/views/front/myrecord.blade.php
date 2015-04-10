@extends('layout')

@section('content')
<div class="container">
    <h2>
        我的账户流水
        <a class="btn btn-info" href="/order/my">我的订单</a>
    </h2>
    
    <table class="table table-striped table-bordered">
        <thead>
            <tr>
                <th>类型</th>
                <th>金额</th>
                <th>余额</th>
                <th>时间</th>
                <th>备注</th>
            </tr>
        </thead>
        <tbody>
            @foreach($data as $v)
                <tr>
                    <td>@if($v['type'] == 1) 充值 @else 消费 @endif</td>
                    <td>{{$v['money']}}</td> 
                    <td>{{$v['balance']}}</td> 
                    <td>{{$v['time']}}</td>
                    <td>{{$v['remark']}}</td> 
                </tr>
            @endforeach
        </tbody>
    </table>
    <?php echo $data->render(); ?>
</div>
@endsection







