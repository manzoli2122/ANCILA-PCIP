<!DOCTYPE html> 
<html lang="{{ app()->getLocale() }}">
<head>
	<meta charset="UTF-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta content='width=device-width, initial-scale=1, maximum-scale=1' name='viewport'>

	<meta name="theme-color" content="#00a65a">
	<title> {{env('APP_NAME')}} </title>
	<link href="{{ mix('css/select2.css') }}" rel="stylesheet" type="text/css"/>
	<!--  Bootstrap -->
	<link href="{{ mix('css/bootstrap.css') }}" rel="stylesheet" type="text/css"/> 
	<!-- font-awesome  ionicons --> 
	<link href="{{ mix('css/fonts.css') }}" rel="stylesheet" type="text/css"/>
	<!-- template --> 
	<link href="/css/adminlte.css" rel="stylesheet" type="text/css"/> 
	
	<!-- Google Font: Source Sans Pro -->
	<link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet"> 
</head>
<body class="hold-transition sidebar-mini sidebar-collapse1">
	
	<div class="wrapper" > 

		<div id="header"></div>
		
		<div id="sidebar"></div> 

		<!-- Content Wrapper. Contains page content -->
		<div class="content-wrapper" id="contentwrapper"> 
			@yield('content') 
		</div> 

		<!-- Main Footer -->
		<footer class="main-footer"> 
			<div class="float-right d-none d-sm-inline"> Versão 0.0.3 </div> 
			<strong>Copyright &copy; 2019 <a href="#">{{env('APP_NAME')}}</a>.</strong> Todos Direitos Reservados.
		</footer>
	</div>


	<!-- REQUIRED SCRIPTS --> 
	<script src="{{ mix('js/vendor.js') }}" type="text/javascript"></script> 
	<script src="/js/adminlte.js" type="text/javascript"></script> 
	<script src="{{ mix('js/app.js') }}" type="text/javascript"></script> 
	<script src="{{ mix('js/single.js') }}" type="text/javascript"></script>

</body>
</html>
