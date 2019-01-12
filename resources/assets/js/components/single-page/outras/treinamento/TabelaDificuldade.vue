<template>

	<crudCard>
		<div class="card-header with-border text-center">
			<h1 class="box-title"><b>Tabela de Dificudade</b></h1>
		</div>            
		<div class="card-body"> 
			<div class="row">
				<div class="col-5 text-right"><h6><b> Muito Facil:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
				</h6></div> 

				<div class="col-5 text-right"><h6><b>Facil:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
				</h6></div> 

				<div class="col-5 text-right"><h6><b>Médio:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
				</h6></div> 

				<div class="col-5 text-right"><h6><b>Difícil:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
					<span class="right badge badge-warning">I</span>
				</h6></div> 

				<div class="col-5 text-right"><h6><b>Muito Difícil:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
				</h6></div> 

				<div class="col-5 text-right"><h6><b>Sobrenatural:</b></h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-danger">I</span>
				</h6></div>

				<div class="col-5 text-right"><h6><b>Colossal:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-danger">I</span>
					<span class="right badge badge-danger">I</span>
				</h6></div>

				<div class="col-5 text-right"><h6><b>Utópica:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-danger">I</span>
					<span class="right badge badge-danger">I</span>
					<span class="right badge badge-danger">I</span>
				</h6></div>

				<div class="col-5 text-right"><h6><b>Lendária:</b>	</h6></div> 
				<div class="col-7"><h6>
					<span class="right badge badge-info">I</span> 
					<span class="right badge badge-success">I</span> 
					<span class="right badge badge-success">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-warning">I</span>
					<span class="right badge badge-danger">I</span>
					<span class="right badge badge-danger">I</span>
					<span class="right badge badge-danger">I</span>
					<span class="right badge badge-dark">I</span>
				</h6></div> 

			</div> 
		</div> 
	</crudCard>  
</template>




<script>


	export default {

		data() {
			return {      
			}
		},


	}



</script>

<style scoped>

.badge{
	padding-left: 4px;
	padding-right: 4px;
}

.content {
	padding: 10px;
}

.titulo{
	margin:0px; 
	margin-bottom:10px;
	text-align: center;
}

.box-title{
	font-size: 20px;       
}

.btn-proximo{
	padding:10px; 
	font-size:20px; 
	background-color: #646464; 
	color:white;
}

.btn-responder{
	padding:10px; 
	font-size:20px
}

.box-body{
	font-size: 18px;
}

</style>
