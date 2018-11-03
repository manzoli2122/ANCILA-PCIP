 @extends('layout.master')
  

@section('content') 
	<div id="tentativa">				
        <router-view :url="{{ json_encode( route('tentativa.index')  ) }}"></router-view>    
	</div>	
@endsection

@push(Config::get('app.templateMasterScript' , 'script') )	
	<script src="{{ mix('js/tentativa.js') }}" type="text/javascript"></script>
	<script>
		$(document).ready(function() { 
			var el = document.getElementById('menu-administrador');
		 	el.classList.add("menu-open"); 

		 	var el2 = document.getElementById('menu-administrador-tentativa');
		 	el2.classList.add("active"); 
    	}); 
	</script>
@endpush