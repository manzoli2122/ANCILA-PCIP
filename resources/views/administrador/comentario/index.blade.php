 @extends('layout.master')
  
@section('content') 
	<div id="comentario">				
        <router-view :url="{{ json_encode( route('comentario.index')  ) }}" :url_pergunta="{{ json_encode( route('pergunta.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/comentario.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-administrador');
		 	el.classList.add("menu-open"); 
		 	
		 	var el2 = document.getElementById('menu-administrador-comentario');
		 	el2.classList.add("active"); 
    	}); 
	</script>
@endpush