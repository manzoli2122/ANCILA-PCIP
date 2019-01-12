<template> 
	<div class="row">
		<div class="col-12">
			<h6 class="titulo text-center" style="margin-bottom:0px">
				<b>DISCIPLINA:</b> {{ disciplina_atual  }} 
			</h6>
			<p class=" text-center"   style="margin-bottom:0px">
				<b>Questão Nº:<span class=" text-primary"> {{pergunta.id }}</span></b>	| <b>Dificulidade:<span class=" text-success"> {{ dificuldade  }}</span></b>	  
			</p>
			<p class=" text-center" v-if="pergunta" style="margin-bottom:0px">
				<b><span class=" text-success">{{ positivas  }}</span></b>	  pessoas ACERTARAM | <b><span class=" text-danger">{{ negativas  }}</span></b> pessoas ERRARAM    
			</p>

			<p class=" text-center" v-if="rank.rank" style="margin-bottom:0px">Classificação: 
				<b><span class=" text-success">{{ rank.rank  }}º</span></b>	 lugar geral com <b><span class=" text-info">{{ parseFloat(rank.porcentagem).toFixed(2)  }}%</span></b> de acerto    
			</p>
		</div>
	</div>  
</template>




<script>

	export default {
		props:[
		'pergunta', 'rank' , 'disciplina_atual'
		],

		computed: {
			
			positivas: function () {
				let valor = 0 ; 
				for (var i = 0 ; i <= this.pergunta.resposta.length - 1; i++) {
					if(this.pergunta.resposta[i].id === this.pergunta.resposta_certa_id)
						valor +=  parseInt(this.pergunta.resposta[i].count);
				}
				return valor;
			},
 

			negativas: function () {
				let valor = 0 ; 
				for (var i = 0 ; i <= this.pergunta.resposta.length - 1; i++) {
					if(this.pergunta.resposta[i].id !== this.pergunta.resposta_certa_id)
						valor +=  parseInt(this.pergunta.resposta[i].count);
				}
				return valor;
			},

			// disciplina_pergunta(){ 
			// 	for (var i = this.disciplinas.length - 1; i >= 0; i--) {
			// 		if(this.disciplinas[i].id == this.pergunta.assunto.disciplina_id ){
			// 			return this.disciplinas[i].nome;
			// 		}					
			// 	} 
			// 	return ''; 
			// },
			
			
			dificuldade(){ 
				let total = this.positivas + this.negativas;
				if(this.positivas / total > 0.9  ){
					return 'Muito Facil';
				}
				if(this.positivas / total > 0.8){
					return 'Facil';
				}
				if(this.positivas / total > 0.7 || ( total <= 3 )  ) {
					return 'Médio';
				}
				if(this.positivas / total > 0.6 || ( total <= 6 ) ){
					return 'Difícil';
				} 
				if(this.positivas / total > 0.5 || ( total <= 9 ) ){
					return 'Muito Difícil';
				} 
				if(this.positivas / total > 0.3){
					return 'Sobrenatural';
				} 
				if(this.positivas / total > 0.2){
					return 'Colossal';
				} 
				if(this.positivas / total > 0.1){
					return 'Utópica';
				} 
				if(this.positivas / total > 0.0){
					return 'Lendária';
				}  
				return ''; 
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
