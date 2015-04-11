@extends('layout')
@section('content')
<div align="center">
    <h3>{{$msg}} </h3>
    <p style="font-size:150%" id="redirect"></p>
</div>

<script type="text/javascript">
    var sec = 3;
    function redirect(){
        if (sec > 0){
            var str = sec + '秒后跳转到<a href="{{$uri}}">@if($uri=="/") 首页 @else {{$uri}} @endif</a>';
            $("#redirect").html(str);
            sec--;
            setTimeout(redirect,1000);
        }else {
            window.location.href  = "{{$uri}}";
        }
    }
    $(function(){
        redirect();
    });
</script>
@endsection
