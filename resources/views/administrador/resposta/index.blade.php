 @extends('layout.master')
 
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="resposta#/create" class="nav-link">
			<i class="fa fa-plus"></i> Cadastrar Resposta
		</a>
	</li>
@endsection


@section('content') 
	<div id="resposta">				
        <router-view :url="{{ json_encode( route('resposta.index')  ) }}" :url_pergunta="{{ json_encode( route('pergunta.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/resposta.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-administrador');
		 	el.classList.add("menu-open"); 
		 	
		 	var el2 = document.getElementById('menu-administrador-resposta');
		 	el2.classList.add("active"); 
    	}); 
	</script>
@endpush