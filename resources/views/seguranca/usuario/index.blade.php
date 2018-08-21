@extends('layout.master')
   
@section('content') 
	<div id="usuario">				
        <router-view :url="{{ json_encode( route('usuario.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/usuario.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-seguranca');
		 	el.classList.add("menu-open"); 

		 	var el2 = document.getElementById('menu-seguranca-usuario');
		 	el2.classList.add("active");
    	}); 
	</script>
@endpush