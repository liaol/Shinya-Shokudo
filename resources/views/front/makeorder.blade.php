@extends('layout')
@section('content')
<div class="container ">
    <h2>下订单 <a style="margin-left: 50px;" class="btn btn-info" href="/menu">菜单</a></h2>
    <div class="well">
        <h3>{{$seller->name}} -- {{$goods->name}}</h3>
        <form method="POST" action="/order/make">
            <input type="hidden" name="_token" value="{{ csrf_token() }}">
            <input type="hidden" name="seller_id" value="{{$seller->id}}">
            <input type="hidden" name="goods_id" value="{{$goods->id}}">
            <div class="form-group">
                <div class="row">
                    <label for="name" class="col-md-1 control-label" class="col-md-1">数量</label>
                    <input value="-"  type="button" onclick="Sub(this)" width="10"/>
                    <input type="text" value="1" name="quantity"/>
                    <input value="+"  type="button"  onclick="Add(this)" width="10"/>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="time_type" class="col-md-1 control-label">时间</label>
                    <div class="col-md-2">
                        <input name="time_type" type="radio" value="2" checked />午餐
                        <input name="time_type" type="radio" value="3" />晚餐
                    </div>
                </div>
            </div>
            <div class="form-group">
                <div class="row">
                    <label for="pay_type" class="col-md-1 control-label">支付方式</label>
                    <div class="col-md-4">
                        <input name="pay_type" type="radio" value="1" checked />自付
                        <input name="pay_type" type="radio" value="2" />公司付(只有晚上加班才能选公司付哦)
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
                    <button class="btn btn-primary col-md-1 col-md-offset-1" type="submit">确认订单</button>
                </div>
            </div>
        </form>
    </div>
    @if (!empty($order))
        <h3>看看其他人都点了什么</h3>
        <table class="table table-striped table-bordered table-condensed">
            @if (!empty($money))
                <caption>
                    @foreach ($money as $k=>$v)
                        {{$k}} : {{$v}} 元&nbsp;
                    @endforeach
                </caption>
            @endif
            <thead>
                <tr>
                    <th>姓名</th>
                    <th>商家</th>
                    <th>菜名</th>
                    <th>数量</th>
                </tr>
            </thead>
            <tbody>
                @foreach($order as $k=>$v)
                    <tr>
                        <td>{{$v['user_name']}}</td>
                        <td>{{$v['seller_name']}}</td>
                        <td>{{$v['goods_name']}}</td>
                        <td>{{$v['quantity']}}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    @endif
</div>
<script type="text/javascript">
    function Add( node)
    {
        var inputs=node.parentNode.getElementsByTagName("input");
        var a= new Number(inputs[1].value);
        a=a+1;
        inputs[1].value=""+a;

    }
    function Sub( node)
    {
        //node.parentNode的类型为单元格
        var inputs=node.parentNode.getElementsByTagName("input");
        var a= new Number(inputs[1].value);
        if(a < 2){
            return false;
        }
        a=a-1;
        inputs[1].value=inputs[1].value-1;
    }
</script>
@endsection
