 @extends('single.layout.master') 

 @section('content') 
 <div id="single">				
 	<router-view :url="{{json_encode( route('inicio'))}}"></router-view>    
 </div>	
 @endsection
 
 