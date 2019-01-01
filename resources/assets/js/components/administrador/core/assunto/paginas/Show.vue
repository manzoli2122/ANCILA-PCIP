<template>  
	
	<div v-if="model">  
		<crudHeader :texto="'Assunto - ' + model.nome ">
			<li class="breadcrumb-item">Assunto</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<section  class="row text-center dados">    
							<div class="col-12 col-sm-12 dado">
								<h1 style="text-align:center;"> Descrição: </h1>
							</div>  
						</section>
						<section class="row text-center dados">    
							<div class="col-12 col-sm-12 dado">
								<h4 style="text-align:left;">
									<span v-html="model.descricao"></span><br> 
								</h4>
							</div>     
							<div class="col-12 col-sm-12 dado">
								<h4 style="text-align:left;"> Data de Criação: {{model.created_at}} </h4>
							</div>
							<div class="col-12 col-sm-12 dado">
								<h4 style="text-align:left;"> Disciplina: {{model.disciplina.nome}} </h4>
							</div>
						</section>

						<section  class="row text-center dados">    
							<div class="col-12 col-sm-12 dado">
								<h1 style="text-align:center;"> Perguntas </h1>
							</div>  
						</section>

						<section  v-for="pergunta in perguntas" class="row text-center dados">    
							<div class="col-12 col-sm-12 dado">
								<h1 style="text-align:center;"> Pergunta {{pergunta.id}}: </h1>
								<p style="text-align:left;">  
									<span v-html="pergunta.texto"></span><br> 
									<span v-for="resposta in pergunta.resposta">
										( )<span v-html="resposta.texto"></span><br>
									</span> 
									<br> 
									<span v-html="pergunta.resumo"></span>
								</p>
							</div>  
						</section>
					</div>   
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/assunto" />   
					</div> 
				</crudCard> 
			</div> 
		</div>  
	</div>


</template>


<script>

	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				model:'',
				perguntas:'',

			}
		},

		watch: {

			model: function (newmodel, oldmodel) {
				alertProcessandoHide();
			}

		},   

		created() {


			alertProcessando();
			axios.get(this.url + this.$apiAssunto + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar Assunto');
			});



			axios.get(this.url + this.$apiAssunto + '/' + this.$route.params.id + '/perguntas' )
			.then(response => {
				this.perguntas = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar as perguntas');
			});



		},



	}



</script>
