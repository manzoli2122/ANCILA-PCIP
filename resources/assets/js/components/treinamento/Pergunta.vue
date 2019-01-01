<template>
	<div>   
		<div class="content">
			<div class="container-fluid"  v-if="placar"> 

				<div class="row" v-if="disciplina_id_atual.length > 0 ">
					<div class="col-12">
						<h6 class="titulo text-center" v-if="pergunta" style="margin-bottom:0px">
							<b>DISCIPLINA:</b> {{ disciplina_pergunta  }} 
						</h6>
						<p class=" text-center" v-if="pergunta" style="margin-bottom:0px">
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


				<form method="post" action="#"  @submit.prevent="onSubmit" v-if="disciplina_id_atual.length > 0 "> 
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
											<span v-show="respondido">  ( {{resposta.count}} ) </span>  
										</label>
									</div>
								</div>
							</div> 
						</div> 
						<div id="botao_proxima" class="card-footer text-right"> 
							<a  class="btn btn-default btn-block btn-proximo text-white" v-if="respondido" v-bind:class="respondido ? '' : 'disabled'" v-on:click="proximaPergunta()">
								Proxima Pergunta  <i class="fa fa-forward"></i>
							</a> 
							<button class="btn btn-success btn-block btn-responder" v-if="!respondido" v-bind:class="respondido ? 'disabled' : '' "  type="submit">
								<i class="fa fa-check"></i> Responder  
							</button>
						</div> 
					</crudCard>  
				</form>  

				<hr>
				<crudCard  v-show="respondido" color="card-danger" v-if="(disciplina_id_atual.length > 0) && pergunta.resumo ">
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



				<crudCard  v-show="respondido" color="card-danger" v-if="pergunta">
					<div class="card-header with-border text-center">
						<h1 class="box-title"><b>Comentário</b></h1>
					</div>            
					<div class="card-body">
						<h5>Deixe seu comentário, crítica ou sugestão aqui:</h5>
						<crudFormElemento > 
							<textarea maxlength="1500" id="texto" name="texto" class="form-control" v-model="comentario"  style="height:150px"  ></textarea> 
						</crudFormElemento> 
					</div> 
					<div class="card-footer text-center"> 
						<button style="width: 90%" class="btn btn-success  " v-on:click="criarComentario()"><i class="fa fa-check"></i> Enviar</button>
					</div> 
				</crudCard> 




				

				<div class="row" > 
					<div class="col-12 col-md-6 col-lg-6" v-if="disciplina_id_atual.length > 0 ">
						<crudCard>
							<div class="card-header with-border text-center">
								<h1 class="box-title"><b>Informações Parciais</b></h1>
							</div>            
							<div class="card-body"> 
								<div class="row">
									<div class="col-5"><h6><b> Acertos:</b> <span class="right badge badge-success">{{ placar.certas  }}</span> </h6></div>
									<div class="col-7"><h6><b>Rendimento:</b> {{ rendimento }}%</h6></div>  
								</div>
								<div class="row"> 
									<div class="col-5"><h6><b>Erradas:</b> <span class="right badge badge-danger">{{  placar.erradas  }}</span> </h6></div>  
									
								</div>
							</div> 
						</crudCard> 
					</div>




					<div class="col-12 col-md-6 col-lg-6" v-if="historico && pergunta && (disciplina_id_atual.length > 0 )">
						<crudCard>
							<div class="card-header with-border text-center">
								<h1 class="box-title"><b>Histórico geral em {{ disciplina_pergunta  }}</b></h1>
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
					</div>
					




					<!-- <div class="col-12 col-md-6 col-lg-4">
						<formDificuldade :url="url"  ></formDificuldade>
					</div> -->

					<div class="col-12 col-md-6 col-lg-6" >
						<formDisciplina :disciplina_atual="disciplina_atual" :disciplinas="disciplinas" :url="url" v-on:mudouDisciplina="mudouDisciplina($event)"></formDisciplina> 
					</div>




					<div class="col-12 col-md-6 col-lg-6" v-if="pergunta && (disciplina_id_atual.length > 0 )">
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
					</div>


				</div>
 <br><br><br>
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




			rendimento: function () {
				let total = this.placar.certas + this.placar.erradas;
				let valor = 0 ; 
				if(total>0){
					valor = parseInt( this.placar.certas/total*100) ; 
				}			 
				return valor;
			},




			rendimento_historico: function () {
				let total = this.historico_certas + this.historico_erradas;
				let valor = 0 ; 
				if(total>0){
					valor = parseInt( this.historico_certas/total*100) ; 
				}			 
				return valor;
			},



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




			mensagem: function () {
				let valor = (this.placar.certas + this.placar.erradas) % 2 ; 				 
				return valor;
			}, 



			disciplina_atual(){ 
				for (var i = this.disciplinas.length - 1; i >= 0; i--) {
					if(this.disciplinas[i].id == this.disciplina_id_atual[0] ){
						return this.disciplinas[i].nome;
					}					
				} 
				return ''; 
			},



			disciplina_pergunta(){ 
				for (var i = this.disciplinas.length - 1; i >= 0; i--) {
					if(this.disciplinas[i].id == this.pergunta.assunto.disciplina_id ){
						return this.disciplinas[i].nome;
					}					
				} 
				return ''; 
			},



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
				form: new Form({
					selected:'',
					pergunta_id:'', 
					latitude:'',
					longitude:'',
				}), 

				temp_errada:'',
				respondido:'',
				pergunta:'',          
				placar:'',

				historico:'',
				comentario:'',

				rank:'',
				geolocation:'',
				latitude:'',
				longitude:'',
				disciplinas:'',
				disciplina_id_atual:'',
			}
		},



		watch: {

			pergunta: function (newpergunta_id, oldpergunta_id) {
				this.form.pergunta_id = this.pergunta.id ; 
				alertProcessandoHide();
			},

		},    



		methods: {


			

			criarComentario(){
				
				let data = {}; 
		         
		        data['texto'] = this.comentario ;
		        data['pergunta_id'] = this.pergunta.id ; 
		        data['status'] = 'Criada' ; 

		        alertProcessando();
		        axios.post(this.url + '/criar/comentario'  , data  )
				.then(response => {  
					alertProcessandoHide();
					toastSucesso(response.data); 
					this.comentario = ''; 

				})
				.catch(error => { 
					alertProcessandoHide();
					// console.log(error.response.data.message);
					toastErro('Não foi Possivel Cadastrar o comentário.');
					toastErro(error.response.data.message);
				}); 
 				 
			},



			onSubmit() {

				this.form.latitude = this.latitude ;
				this.form.longitude = this.longitude; 

				if( this.form.selected === this.pergunta.resposta_certa_id ){				 
					swal("Você Acertou!!", "", "success"); 
					
				}  
				else{
					swal("Você Errou!!", "", "error");					 
					this.temp_errada =  this.form.selected; 
				}
				
				this.respondido = true ;
				this.comentario = '';

				$('html, body').animate({
				    scrollTop: $("#botao_proxima").offset().top
				}, 0);
				// var posicaoInicial = $('#botao_proxima').scrollTop();
				// var posicaoInicial = document.getElementById('botao_proxima').position().top;
				// console.log(posicaoInicial);
				// window.scrollTo(posicaoInicial, 0);

				this.form.post( this.url )
				.then(response => {
					// console.log(response.realizadas);
					this.placar = response ;
					let total = this.placar.certas + this.placar.erradas
					if( total % 5 === 0 ){
						if(this.placar.certas / total >= 0.9 ){
							toastSucesso('Parabens!! você esta indo muito bem!!');
						}
						else if(this.placar.certas / total >= 0.7 ){
							toastSucesso('Parabens!! você esta indo bem!!');
						}
						else if(this.placar.certas / total >= 0.5 ){
							toastSucesso('Vamos lá!! você esta indo bem, mas precisa melhorar um pouco!!');
						}
						else{
							toastSucesso('Não desista!! vamos tentar melhorar o resultado!!');
						}
						
					}
				})            
				.catch(errors => console.log(errors));
			},

			getHistorico(){
				axios.get(  this.url  + '/historico' )
				.then(response => {
					this.historico = response.data  ;
				})
				.catch(error => {
					console.log('erro ao atualiza placar');
				});
			},



			getRank(){
				axios.get(  this.url  + '/meu/rank' )
				.then(response => {
					this.rank = response.data  ;
				})
				.catch(error => {
					console.log('erro ao atualiza rank');
				});
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


			mudouDisciplina(evento) {				 				 
				this.proximaPergunta();
				this.atualizarPlacar(); 
				this.getHistorico();
				this.disciplina_id_atual = evento ;
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
					toastErro('Não foi possivel achar a proxima pergunta, provavelmente ja tenha feito todas!!!. Mude o filtro de disciplina para fazer novas, ou clique em proxima para repetir as questões.');
					console.log('erro na proxima pergunta');
					alertProcessandoHide();
					this.respondido = true ;
				});
			},






			//BUSCA TODAS AS DISCIPLINAS
			getDisciplinasAtivas() {				 				 
				axios.get(this.url_disciplina + '/all'  )
				.then(response => {
					this.disciplinas = response.data ;
				})
				.catch(error => {
					toastErro('Não foi possivel achar as disciplinas'); 
				});
			},






			//BUSCA A DISCIPLINA ATUAL
			getDisciplinaAtual() {				 				 
				axios.get(this.url + '/disciplina'  )
				.then(response => {
					this.disciplina_id_atual = response.data.disciplina ;
				})
				.catch(error => {
					toastErro('Não foi possivel achar as disciplinas'); 
				});
			},


			showPosition(position) {
				// this.geolocation = position.coords;
				this.latitude = position.coords.latitude ;
				this.longitude = position.coords.longitude; 

				this.form.latitude = position.coords.latitude ;
				this.form.longitude = position.coords.longitude; 

				// x.innerHTML = "Latitude: " + position.coords.latitude + 
				// "<br>Longitude: " + position.coords.longitude; 
			},


		},

		  


		created() {
			 
			this.proximaPergunta(); 

			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(this.showPosition);
			} else {
				console.log("Geolocation is not supported by this browser.");
			}
			 
			
			this.atualizarPlacar(); 
			this.getDisciplinasAtivas();
			this.getDisciplinaAtual();
			this.getHistorico();
			this.getRank();
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
