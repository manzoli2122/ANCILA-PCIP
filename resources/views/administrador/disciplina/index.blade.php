 @extends('layout.master')
 
@section('header')  
	<li class="nav-item d-none d-sm-inline-block"> 
		<a href="disciplina#/create" class="nav-link">
			<i class="fa fa-plus"></i> Cadastrar Disciplina
		</a>
	</li>
@endsection


@section('content') 
	<div id="disciplina">				
        <router-view :url="{{ json_encode( route('disciplina.index')  ) }}" :url_assunto="{{ json_encode( route('assunto.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/disciplina.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-administrador');
		 	el.classList.add("menu-open"); 

		 	var el2 = document.getElementById('menu-administrador-disciplina');
		 	el2.classList.add("active"); 
    	}); 
	</script>
@endpush