<template>
	<div>   
		<div class="content">
			<div class="container-fluid">
				<div class="row">
					<div class="col-12">
						<h4 class="titulo text-center" v-if="pergunta">
							<b>DISCIPLINA:</b> {{ pergunta.assunto.disciplina.nome  }} 
						</h4>
					</div>
				</div> 
				<form method="post" action="#"  @submit.prevent="onSubmit"> 
					<crudCard>
						<div class="card-header  "> 
							<h1 class="box-title"><span v-html="pergunta.texto"></span></h1>
						</div>   
						<div class="card-body ">  
							<div class="row">
								<div v-for="resposta in pergunta.resposta" :key="resposta.id" class="col-md-12">
									<div class="radio"  v-bind:class="[respondido & (resposta.id === pergunta.resposta_certa_id) ? 'text-success' : '']">
										<label v-bind:class="[temp_errada === resposta.id ? 'text-danger' : '' ]"  >
											<input  style="margin-top: 8px;" type="radio" required name="resposta" :value="resposta.id" v-model="form.selected">
											<span v-html="resposta.texto"></span>  
										</label>
									</div>
								</div>
							</div> 
						</div> 
						<div class="card-footer text-right"> 
							<a class="btn btn-default btn-block btn-proximo text-white" v-if="respondido" v-bind:class="respondido ? '' : 'disabled'" v-on:click="proximaPergunta()">
								Proxima Pergunta  <i class="fa fa-forward"></i>
							</a> 
							<button class="btn btn-success btn-block btn-responder" v-if="!respondido" v-bind:class="respondido ? 'disabled' : '' "  type="submit">
								<i class="fa fa-check"></i> Responder  
							</button>
						</div> 
					</crudCard>  
				</form>  

				<hr>
				<crudCard  v-show="respondido">
					<div class="card-header with-border text-center">
						<h1 class="box-title"><b>Definições Abordadas</b></h1>
					</div>            
					<div class="card-body">
						<div class="row">
							<div class="col-md-12">
								<span v-html="pergunta.resumo"></span>
							</div>
						</div>
					</div> 
				</crudCard> 
				

				<div class="row"> 
					<div class="col-12 col-md-6 col-lg-4">
						<crudCard>
							<div class="card-header with-border text-center">
								<h1 class="box-title"><b>Informações</b></h1>
							</div>            
							<div class="card-body">
								<h4 class="text-center" v-if="pergunta"> {{ pergunta.assunto.nome  }} </h4>
								<h4 class="text-center" v-if="pergunta">  <span class="right badge badge-info">{{ pergunta.dificuldade  }}</span></h4>

								<div class="row">
									<div class="col-6"><h4><b> Acertos:</b> <span class="right badge badge-success">{{ placar.certas  }}</span> </h4></div>
									<div class="col-6"><h4><b>Erradas:</b> <span class="right badge badge-danger">{{  placar.erradas  }}</span> </h4></div>  
									<!-- <div class="col-12"><h4><b>Questões respondidas: </b><span v-for="item in placar.realizadas" :key="item.id">{{  item }} , </span></h4></div> -->
								</div>
								<div class="row"> 
									<div class="col-12"><h3><b>Aproveitamento:</b> {{ parseInt( placar.certas/(placar.certas + placar.erradas)*100)}}%</h3></div> 
								</div>
							</div> 
						</crudCard> 
					</div>
					
					<div class="col-12 col-md-6 col-lg-4">
						<formDificuldade :url="url"  ></formDificuldade>
					</div>

					<div class="col-12 col-md-6 col-lg-4">
						<formDisciplina :url="url"  :url_disciplina="url_disciplina"></formDisciplina> 
					</div>

				</div>
 
				<a class="btn btn-info btn-block "  href="/">
					<i class="fa fa-reply"></i> Voltar  
				</a>
			</div> 

		</div>  
	</div>

</template>




<script>

	Vue.component('formDificuldade', require('./dificuldade.vue'));
	Vue.component('formDisciplina', require('./disciplina.vue'));

	import Form from '../core/Form';


	export default {
		props:[
		'url',   'url_disciplina'     
		],

		data() {
			return {                
				form: new Form({
					selected:'',
					pergunta_id:'',
				}), 

				temp_errada:'',
				respondido:'',
				pergunta:'',          
				placar:'',
			}
		},



		watch: {

			pergunta: function (newpergunta_id, oldpergunta_id) {
				this.form.pergunta_id = this.pergunta.id ;
				alertProcessandoHide();
			},

		},    



		methods: {

			onSubmit() {

				if( this.form.selected === this.pergunta.resposta_certa_id ){
				 
					swal("Você Acertou!!", "", "success");
 
				}  
				else{
					swal("Você Errou!!", "", "error");
					 
					this.temp_errada =  this.form.selected;
 
				}

				this.respondido = true ;

				this.form.post( this.url )
				.then(response => {
					console.log(response);
					this.placar = response ;
				})            
				.catch(errors => console.log(errors));
			},




			atualizarPlacar(){
				axios.get(  this.url  + '/placar' )
				.then(response => {
					this.placar = response.data  ;
				})
				.catch(error => {
					console.log('erro ao atualiza placar');
				});
			},


			atualizarPergunta(){
				axios.post(  this.url + '/' + this.pergunta_id   )
				.then(response => {
					this.pergunta = response.data ;
				})
				.catch(error => {
					console.log('erro ao atualiza Pergunta');
				});
			},







			proximaPergunta(){
				this.temp_errada = ''; 
				this.respostas = '';
				this.respondido = false ;
				alertProcessando();
				window.scrollTo(0, 0);
				axios.get(this.url + '/proximo'  )
				.then(response => {
					this.pergunta = response.data ;
				})
				.catch(error => {
					toastErro('Não foi possivel achar a proxima pergunta, talvez vc ja tenha feito todas!!!!!!!!!!!!');
					console.log('erro na proxima pergunta');
					alertProcessandoHide();
					this.respondido = true ;
				});
			},


		},


		created() {
			this.proximaPergunta(); 
			this.atualizarPlacar(); 
		},


	}



</script>

<style scoped>

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