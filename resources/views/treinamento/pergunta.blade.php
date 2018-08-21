@extends('templates.master_treinamento')

@section('content')
 	<div id="app">
		<formulario-treinamento  	 
			:url="{{ json_encode( route('treinamento.index') ) }}">
		</formulario-treinamento>
	</div>
        
 
@endsection
