@extends('layout.master')

@push(  'styles')  
 <meta http-equiv="refresh"   content="0; single#/" >
@endpush


@section('content') 

<div class="content"> 
	<div class="container-fluid">
		<br>
		<div class="row">
			<a href="{{ route('treinamento.index')}}" class="btn btn-success btn-block">
				<i class="fa fa-gamepad text-danger"></i> Treinar 
			</a>
		</div> 
	</div> 
</div>  

@endsection
