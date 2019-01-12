<template> 
	<crudCard>
		<div class="card-header with-border text-center">
			<h1 class="box-title"><b>Informações Parciais</b></h1>
		</div>            
		<div class="card-body"> 
			<div class="row">
				<div class="col-5"><h6><b> Acertos:</b> <span class="right badge badge-success">{{ certas  }}</span> </h6></div>
				<div class="col-7"><h6><b>Rendimento:</b> {{ rendimento }}%</h6></div>  
			</div>
			<div class="row"> 
				<div class="col-5"><h6><b>Erradas:</b> <span class="right badge badge-danger">{{  erradas  }}</span> </h6></div>   
			</div>
		</div> 
	</crudCard> 
</template>




<script>

	export default {
		props:[
		'respondidas',   
		],

		computed: {
			


			certas: function () {
				let total = this.respondidas.filter(function (number) {
					return number.resposta
				});				 	 
				return total.length;
			},



			erradas: function () {
				let total = this.respondidas.filter(function (number) {
					return ! number.resposta
				});				 	 
				return total.length;
			},

			rendimento: function () {
				let total = this.certas + this.erradas;
				let valor = 0 ; 
				if(total>0){
					valor = parseInt( this.certas/total*100) ; 
				}			 
				return valor;
			},
 

		},



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
