<template> 
	<crudCard>
		<div class="card-header with-border text-center">
			<h1 class="box-title"><b>Histórico geral em {{ disciplina_atual  }}</b></h1>
		</div>            
		<div class="card-body"> 
			<div class="row">
				<div class="col-5"><h6><b> Acertos:</b> <span class="right badge badge-success">{{ historico_certas  }}</span> </h6></div> 
				<div class="col-7"><h6><b>Rendimento geral:</b> {{ rendimento_historico }}%</h6></div> 
			</div>
			<div class="row"> 
				<div class="col-5"><h6><b>Erradas:</b> <span class="right badge badge-danger">{{  historico_erradas  }}</span> </h6></div>  

			</div>

		</div> 
	</crudCard>  
</template>




<script>
  
	export default {
		props:[
		'historico',    'disciplina_atual'
		],

		computed: {
			


			historico_certas: function () {
				let total = this.historico.filter(function (number) {
					return number.acerto
				});				 	 
				return total.length;
			},



			historico_erradas: function () {
				let total = this.historico.filter(function (number) {
					return ! number.acerto
				});				 	 
				return total.length;
			},


 
			rendimento_historico: function () {
				let total = this.historico_certas + this.historico_erradas;
				let valor = 0 ; 
				if(total>0){
					valor = parseInt( this.historico_certas/total*100) ; 
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
