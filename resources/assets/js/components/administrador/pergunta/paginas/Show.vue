<template> 
	<div v-if="model">
		<crudHeader :texto="'Pergunta - ' + model.id ">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perguntas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Exibição</li>
		</crudHeader>  

		<div class="content">
			<div class="container-fluid"> 
				<crudCard> 
					<div class="card-header">
						<h4>  
							<span class="right badge badge-danger">{{ model.assunto.disciplina.nome }}</span>  
							<span data-toggle="tooltip" :title="model.assunto.nome " class="badge bg-success">{{ model.assunto.nome  }} </span>
							<span data-toggle="tooltip" :title="model.dificuldade" class="badge bg-primary">{{ model.dificuldade }} </span>
						</h4>  
					</div> 
					<div class="card-body"> 
						<h3> Pergunta: <span v-html="model.texto"></span></h3> 
						<hr>
						<section class="row"> 		                         
							<div class="col-12 col-sm-12" v-for="item in model.resposta" v-bind:class="[ item.id === model.resposta_certa_id ? 'text-red' : ''  ]"  >
								<h4>{{ item.id }} :  <span v-html="item.texto"></span>  {{ item.count }}  </h4>
							</div>
						</section>
					</div>    
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/" />  
						<!-- <button v-if="model.ativo" class="btn btn-danger" v-on:click="ativar_desativar()">Desativar</button>
						<button v-if="!model.ativo" class="btn btn-success" v-on:click="ativar_desativar()">Ativar</button> -->
						<button  class="btn btn-info" v-on:click="proxima()">Próxima</button>  
					</div> 
				</crudCard>


				<crudCard>
					<div class="card-body "> 
						<section class="row">  
							<div class="col-12 col-sm-12  "  >
								<h4> <span v-html="model.resumo"></span>  </h4>
							</div>
						</section>
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
			}
		},

		watch: {

			$route: function(){

				axios.get(this.url + '/' + this.$route.params.id )
				.then(response => {
					this.model = response.data ;
				})
				.catch(error => {
					toastErro('Não foi possivel achar a Pergunta');
				});
			}


		},   

		created() {
			alertProcessando();
			axios.get(this.url + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a Pergunta');
				alertProcessandoHide();
			});
		},





		methods: {   
			// ativar_desativar(){
			// 	alertProcessando();
			// 	axios.post(this.url + '/' + this.$route.params.id + '/ativar' )
			// 	.then(response => {
			// 		this.model = response.data ;
			// 		alertProcessandoHide();
			// 	})
			// 	.catch(error => {
			// 		if(error.response.status == '403'){
			// 			//console.log(error.response);
			// 			toastErro('Usuario sem Permissão!');
			// 		}else{
			// 			toastErro('Não foi possivel realizar a Operação!');
			// 		}
					
			// 		alertProcessandoHide();
			// 	});
			// },

			proxima(){
				let indice = 1 ;
				indice = indice + parseInt( this.$route.params.id ); 
				this.$router.push('/show/' + indice);
			},

		},


	}



</script>


<style scoped>
button{
	margin-left: 5px;
}
</style>
