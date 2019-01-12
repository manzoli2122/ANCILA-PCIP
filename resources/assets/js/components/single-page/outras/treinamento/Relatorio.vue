<template> 
	<div>
		<h2 class="text-center"> Resultado do Teste </h2>
		<crudCard v-bind:color="[ !item.resposta ? 'card-danger' : 'card-success']"   v-for="item in respondidas" :key="item.id">
			<div class="card-header  "> 
				<h1 class="box-title"><span v-html="item.pergunta.texto"></span></h1>
			</div>   
			<div class="card-body ">  
				<div class="row">
					<div v-for="resposta in item.pergunta.resposta" :key="resposta.id" class="col-md-12"> 
						<p  v-bind:class="[ resposta.id === item.pergunta.resposta_certa_id ? 'text-success' :  resposta.id === item.resposta_id ? 'text-danger' : '']"><span v-html="resposta.texto"></span></p> 
					</div>
				</div> 
			</div> 
			<div class="card-footer text-right"> </div> 
		</crudCard> 
	</div>  
</template>




<script>

	export default {
		props:[
		'respondidas',  
		],

		  
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
