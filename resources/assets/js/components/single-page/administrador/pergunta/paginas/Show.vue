<template> 
	<div v-if="model" id="inicio">
		<crudHeader :texto="'Pergunta - ' + model.id ">
			<li class="breadcrumb-item">
				<router-link   to="/pergunta" exact><a>Perguntas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Exibição</li>
		</crudHeader>    
		<div class="content">
			<div class="container-fluid">  
				<crudCard v-if="visualizarResposta"> 
					<div class="card-header">
						<h4> Texto da Resposta:</h4>  
					</div> 
					<div class="card-body"> 
						<crudFormElemento > 
							<textarea id="texto" name="texto" class="form-control" v-model="resposta"  style="height:150px"  ></textarea> 
						</crudFormElemento> 
					</div>    
					<div class="card-footer text-center">
						<button  class="btn btn-secondary btn-sm" v-on:click="cancelar()">Cancelar</button>
						<button  class="btn btn-success btn-sm" v-on:click="criarResposta()"><i class="fa fa-check"></i> Enviar</button>
					</div> 
				</crudCard>
 
				<crudCard v-if="visualizarEditarResposta"> 
					<div class="card-header">
						<h4> Editar Resposta:</h4>  
					</div> 
					<div class="card-body"> 
						<crudFormElemento > 
							<textarea id="texto" name="texto" class="form-control" v-model="resposta"  style="height:150px"  ></textarea> 
						</crudFormElemento> 
					</div>    
					<div class="card-footer text-center">
						<button  class="btn btn-secondary btn-sm" v-on:click="cancelar()">Cancelar</button>
						<button  class="btn btn-success btn-sm" v-on:click="editarResposta()"><i class="fa fa-check"></i> Enviar</button>
					</div> 
				</crudCard>
 
				<crudCard> 
					<div class="card-header">
						<h4>   
							<h3> Pergunta: <span v-html="model.texto"></span></h3> 
						</h4>  
					</div> 
					<div class="card-body">  
						<section class="row"> 		                         
							<div class="col-12 col-sm-12" v-for="item in model.resposta" v-bind:class="[ item.id === model.resposta_certa_id ? 'text-danger' : ''  ]"  >
								<h4>
									{{ item.id }} :  <span v-html="item.texto"></span>  
									
									<button v-if="item.id !== model.resposta_certa_id" class="btn btn-success btn-sm" v-on:click="alterarResposta(item.id)"><i class="fa fa-check"></i></button> 

									<button class="btn btn-danger btn-sm" v-on:click="verEditarResposta(item.texto, item.id )"><i class="fa fa-pencil"></i></button> 

									{{ item.count }}
								</h4>
							</div>
							<button  class="btn btn-info" v-on:click="verResposta()"><i class="fa fa-plus"></i> Criar Resposta</button>  
						</section>
					</div>    
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/pergunta" />  
						
						<router-link :to="'/pergunta/edit/' +  $route.params.id" exact class="btn btn-success"><a><i class="fa fa-pencil"></i> Editar</a></router-link>

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
	
	import { perguntaService , respostaService }  from '../../../_services';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				model:'',
				resposta:'',
				resposta_id:'',
				visualizarResposta:false,
				visualizarEditarResposta:false,

			}
		},

		watch: { 
			$route: function(){ 
				this.buscarModel(); 
			},
		},   

		created() { 
			this.buscarModel(); 
			acertaMenu('menu-administrador'); 
			document.getElementById('menu-administrador-pergunta').classList.add("active"); 
			document.getElementById('li-nav-create').innerHTML = '<a href="admin#/pergunta/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Pergunta</a>';  
		},





		methods: {   


			buscarModel(){
				alertProcessando();
				perguntaService.getPergunta( this.$route.params.id)
				// axios.get(this.url + this.$apiPergunta + '/' + this.$route.params.id )
				.then(response => {
					this.model = response ;
					alertProcessandoHide();
				})
				.catch(error => {
					alertProcessandoHide();
					if ( error.status === 401) {
						this.$store.dispatch('authentication/logout');			
					}
					toastErro('Não foi possivel achar a Pergunta');
				});
			},



			

			verResposta(){
				this.visualizarResposta = true ; 
				$('html, body').animate({
					scrollTop: $("#inicio").offset().top
				}, 0);
			},



			verEditarResposta(valor , resposta_id){
				this.visualizarEditarResposta = true ; 
				this.resposta = valor ; 
				this.resposta_id = resposta_id ; 
				$('html, body').animate({
					scrollTop: $("#inicio").offset().top
				}, 0);
			},

			cancelar(){
				this.resposta = '';
				this.resposta_id = '';
				this.visualizarEditarResposta = false ; 
				this.visualizarResposta = false ; 
			},


			proxima(){
				let indice = 1 ;
				indice = indice + parseInt( this.$route.params.id ); 
				this.$router.push('/pergunta/show/' + indice);
			},




			editarResposta(){
				
				let data = {}; 
				data['texto'] = this.resposta ;  

				alertProcessando();
				respostaService.editarResposta(this.resposta_id , data )
				// axios.patch(this.url+this.$apiPergunta+'/editar/resposta/'+this.resposta_id,data)
				.then(response => {  
					toastSucesso(response); 
					this.resposta = '';
					this.resposta_id = '';
					this.visualizarEditarResposta = false ; 
				})
				.catch(error => { 
					console.log(error);
				});  

				setTimeout( this.buscarModel , 1020);
				setTimeout(alertProcessandoHide , 1220);

			},






			criarResposta(){
				
				let data = {}; 

				data['texto'] = this.resposta ;
				data['pergunta_id'] = this.$route.params.id ;
				data['correta'] = false ;

				alertProcessando();
				respostaService.criarResposta(  data )
				// axios.post(this.url + this.$apiPergunta + '/criar/resposta'  , data  )
				.then(response => {  
					toastSucesso(response); 
					this.resposta = '';
					this.visualizarResposta = false ; 
				})
				.catch(error => { 
					console.log(errors);
				}); 
				setTimeout( this.buscarModel , 1020);
				setTimeout(alertProcessandoHide , 1220);
			},





			alterarResposta(resposta){
				
				let data = {}; 

				data['resposta_id'] = resposta ;
				alertProcessando();
				axios.post(this.url + this.$apiPergunta + '/alterar/resposta/' + this.$route.params.id , data  )
				.then(response => {
					this.model = response.data ;					 
				})
				.catch(error => {
					console.log(errors);
				});
				alertProcessandoHide();

			},




		},


	}



</script>


<style scoped>
button{
	margin-left: 5px;
}
</style>
