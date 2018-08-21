 @extends('layout.master')
 
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="assunto#/create" class="nav-link">
			<i class="fa fa-plus"></i> Cadastrar Assunto
		</a>
	</li>
@endsection


@section('content') 
	<div id="assunto">				
        <router-view :url="{{ json_encode( route('assunto.index')  ) }}" :url_disciplina="{{ json_encode( route('disciplina.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/assunto.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-administrador');
		 	el.classList.add("menu-open"); 

		 	var el2 = document.getElementById('menu-administrador-assunto');
		 	el2.classList.add("active"); 
		 	
    	}); 
	</script>
@endpush