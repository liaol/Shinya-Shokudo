<!DOCTYPE html>
<html lang="zh-cn">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta http-equiv="X-UA-Compatible" content="IE=8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>点餐系统</title>
	<link href='/static/css/bootstrap.min.css' rel='stylesheet' type='text/css'>
</head>
<body>
    <div class="container">
	<nav class="navbar navbar-default">
		<div class="container-fluid">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="/">点餐系统</a>
			</div>

			<div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
                @if (Auth::user())
                    @if (Auth::user()->level == 1)
                        <ul class="nav navbar-nav">
                            <li><a href="/menu">菜单</a></li>
                            <li><a href="/order/my">我的订单</a></li>
                            <li><a href="/record/my">我的流水</a></li>
                            <li><a> 余额：{{Auth::user()->money}}</a></li>
                        </ul>
                    @elseif (Auth::user()->level ==2)
                        <ul class="nav navbar-nav">
                            <li><a href="/">今日订单</a></li>
                            <li><a href="/menu">菜单</a></li>
                            <li><a href="/admin/user/list">用户管理</a></li>
                            <li><a href="/admin/department/list">部门管理</a></li>
                            <li><a href="/admin/seller/list">商家管理</a></li>
                        </ul>
            
                    @endif 
                @endif

				<ul class="nav navbar-nav navbar-right">
					@if (auth::guest())
						<li><a href="/auth/login">登录</a></li>
					@else
						<li class="dropdown">
							<a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false">{{ Auth::user()->real_name }} <span class="caret"></span></a>
							<ul class="dropdown-menu" role="menu">
								<li><a href="/auth/logout">登出</a></li>
								<li><a href="/auth/password/update">修改密码</a></li>
							</ul>
						</li>
					@endif
				</ul>
			</div>
		</div>
	</nav>
    </div>
	<!-- Scripts -->
	<script src="/static/js/jquery.min.js"></script>
	<script src="/static/js/bootstrap.min.js"></script>

	@yield('content')
</body>
</html>
