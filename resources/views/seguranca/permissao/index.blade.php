@extends('layout.master')
  
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="permissao#/create" class="nav-link"> 
			<i class="fa fa-plus"></i> Cadastrar Permissão
		</a>
	</li>
@endsection


@section('content') 
	<div id="permissao">				
        <router-view :url="{{ json_encode( route('permissao.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/permissao.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-seguranca');
		 	el.classList.add("menu-open"); 

		 	var el2 = document.getElementById('menu-seguranca-permissao');
		 	el2.classList.add("active");
    	}); 
	</script>
@endpush