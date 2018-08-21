 @extends('layout.master')
 
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="pergunta#/create" class="nav-link">
			<i class="fa fa-plus"></i> Cadastrar Pergunta
		</a>
	</li>
@endsection


@section('content') 
	<div id="pergunta">				
        <router-view :url="{{ json_encode( route('pergunta.index')  ) }}" :url_assunto="{{ json_encode( route('assunto.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/pergunta.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-administrador');
		 	el.classList.add("menu-open"); 

		 	var el2 = document.getElementById('menu-administrador-pergunta');
		 	el2.classList.add("active"); 
    	}); 
	</script>
@endpush