@extends('layout')
<style>
    table{width:100%;}
    td{height:40px;line-height:40px;}
</style>

@section('content')
<div class="container">
    <h2>菜单
        <a class="btn btn-info" href="/order/my">我的订单</a>
    </h2>
    @foreach($data as $k=>$v)
        <h3>{{$v['name']}}</h3> 
        <h4>电话：{{$v['phone']}}&nbsp;&nbsp;&nbsp;备注：{{$v['remark']}}</h4>
        <table>
        @for($i = 0;$i<(count($v['menu']));$i+=5)
        <tr>
            @for($k = $i;$k<$i+5;$k++)
                @if(isset($v['menu'][$k]['name']))
                    <td>
                    {{$v['menu'][$k]['name']}}&nbsp;&nbsp;{{$v['menu'][$k]['price']}}&nbsp;&nbsp;
                    <a href="/order/make?sellerId={{$v['id']}}&goodsId={{$v['menu'][$k]['id']}}">订购 </a>
                    </td>
                @endif
            @endfor
        </tr>
        @endfor
       </table> </br>
    @endforeach

@endsection
