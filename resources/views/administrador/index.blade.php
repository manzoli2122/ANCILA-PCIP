 @extends('layout.master')
 
 @section('header')  
 <li class="nav-item d-none d-sm-inline-block" id="li-nav-create"></li>
 @endsection


 @section('content') 
 <div id="administrador">				
 	<router-view :url="{{json_encode( route('inicio'))}}" ></router-view>    
 </div>	
 @endsection
 

 @push(Config::get('app.templateMasterScript' , 'script') )	
 <script src="{{ mix('js/administrador.js') }}" type="text/javascript"></script>

 <script type="text/javascript">


 	$(document).ready(function() { 
 		   
 		var el3 = document.getElementById('menu-administrador'); 
 		el3.hidden = false ;
 

 		var el4 = document.getElementById('menu-administrador-temp');
 		el4.hidden = true; 

 		var el = document.getElementById('menu-administrador');
 		el.classList.add("menu-open"); 

 	}); 

 </script>

 @endpush