<template>
	<div>   
		<div class="content">
			<div class="container-fluid"> 

				<info v-if="disciplina_id_atual && pergunta" :pergunta="pergunta" :rank="rank" :disciplina_atual="disciplina_atual"></info> 
				
				<relatorio v-if="concluido" :respondidas="respondidas"></relatorio>

				<form method="post" action="#"  @submit.prevent="responder" v-if="disciplina_id_atual && pergunta"  > 
					<crudCard>
						<div class="card-header  "> 
							<h1 class="box-title"><span v-html="pergunta.texto"></span></h1>
						</div>   
						<div class="card-body ">  
							<div class="row">
								<div v-for="resposta in pergunta.resposta" :key="resposta.id" class="col-md-12">
									<div class="radio"  v-bind:class="[respondido & (resposta.id === pergunta.resposta_certa_id) ? 'text-success' : '']">
										<label v-bind:class="[respondido & selected != pergunta.resposta_certa_id  & selected === resposta.id ? 'text-danger' : '' ]"  >
											<input  style="margin-top: 8px;" type="radio" required name="resposta" :value="resposta.id" v-model="selected">
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

				<a  class="btn btn-default btn-block btn-proximo text-white" v-if="concluido" v-on:click="proximaPergunta()">
					Reiniciar  <i class="fa fa-forward"></i>
				</a>
				<hr v-if="concluido">

				
				<crudCard  v-show="respondido" color="card-danger" v-if="(disciplina_id_atual) && pergunta.resumo ">
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
					<div class="col-12 col-md-6 col-lg-6" v-if="disciplina_id_atual"> 
						<parciais :respondidas="respondidas"></parciais> 
					</div> 

					<div class="col-12 col-md-6 col-lg-6" v-if="historico && disciplina_id_atual ">
						<historico :disciplina_atual="disciplina_atual" :historico="historico"></historico> 
					</div> 

					<div class="col-12 col-md-6 col-lg-6" >
						<formDisciplina :disciplina_atual="disciplina_atual" :disciplinas="disciplinas" :url="url" v-on:mudouDisciplina="mudouDisciplina($event)"></formDisciplina> 
					</div> 

					<div class="col-12 col-md-6 col-lg-6" v-if="pergunta && (disciplina_id_atual)">
						<tabelaDificuldade></tabelaDificuldade> 
					</div> 
				</div>

				<br><br><br>

				<crudBotaoVoltar class="btn btn-info btn-block " url="/" />  

			</div> 

		</div>  
	</div>

</template>




<script>
	
	import { disciplinaService , treinamentoService  }  from '../../_services';

	// Vue.component('formDificuldade', require('./dificuldade.vue'));
	Vue.component('formDisciplina', require('./disciplina.vue'));
	Vue.component('tabelaDificuldade', require('./TabelaDificuldade.vue'));
	Vue.component('historico', require('./Historico.vue'));
	Vue.component('parciais', require('./Parciais.vue'));
	Vue.component('info', require('./Info.vue'));
	Vue.component('relatorio', require('./Relatorio.vue'));


	export default {
		props:[
		'url',    
		],

		computed: {

			disciplina_atual(){ 
				for (var i = this.disciplinas.length - 1; i >= 0; i--) {
					if(this.disciplinas[i].id == this.disciplina_id_atual ){
						return this.disciplinas[i].nome;
					}					
				} 
				return ''; 
			},


		},



		data() {
			return {       
				disciplina_id_atual:'', 
				latitude:'',
				longitude:'',
				selected:'',
				pergunta:'',  
				todas:'',
				respondidas:'', 
				respondido:'', 
				concluido:false,  
				historico:'',
				comentario:'', 
				rank:'',
				geolocation:'', 
				disciplinas:'', 
			}
		},


		created() {

			this.getDisciplinasAtivas(); 
			this.getDisciplinaAtual();  
			this.getListaPerguntasRespondidas();  
			this.getTodasPerguntas();  
			if (navigator.geolocation) {
				navigator.geolocation.getCurrentPosition(this.showPosition);
			} else {
				console.log("Geolocation is not supported by this browser.");
			} 
			this.getHistorico();
			this.getRank(); 
			document.getElementById('header').hidden = true ;   
			document.getElementById('sidebar').hidden = true ;  
			document.getElementById('contentwrapper').style.marginLeft = "0px" ;   
		},

		



		methods: {

			mudouDisciplina(evento) {	 
				this.disciplina_id_atual = evento ;	
				this.respondidas =[];
				localStorage.removeItem('respondidas' );
				localStorage.removeItem('todas' ); 
				this.getTodasPerguntas();  
				this.getHistorico(); 
			},


			//BUSCA TODAS AS DISCIPLINAS
			getDisciplinasAtivas() {		 
				if (localStorage.getItem('disciplinas')) {
					this.disciplinas = JSON.parse( localStorage.getItem('disciplinas') ) ; 
				}
				else{
					alertProcessando(); 	
					disciplinaService.getAll()	 
					.then(response => {
						this.disciplinas = response ; 
						localStorage.setItem('disciplinas', JSON.stringify( response ) );
						alertProcessandoHide();
					})
					.catch(error => {
						toastErro('Não foi possivel achar as disciplinas todas'); 
						alertProcessandoHide();
						if( error.status == 401 ){ 
							this.$store.dispatch('authentication/logout');
						} 
					});
				} 
			},

			//BUSCA A DISCIPLINA ATUAL
			getDisciplinaAtual() { 
				if (localStorage.getItem('disciplina')) {
					this.disciplina_id_atual = JSON.parse( localStorage.getItem('disciplina') ) ; 
				}
				else{
					this.disciplina_id_atual ='';
				} 	 
			},

			//BUSCA OS ID DAS PERGUNTAS RESPONDIDAS
			getListaPerguntasRespondidas() { 
				if (localStorage.getItem('respondidas')) {
					this.respondidas = JSON.parse( localStorage.getItem('respondidas') ) ; 
				}
				else{
					this.respondidas =[];
				} 	 
			},


			//BUSCA TODAS AS PERGUNTA DA DISCIPLINA
			getTodasPerguntas() {		 
				if (localStorage.getItem('todas')) {
					this.todas = JSON.parse( localStorage.getItem('todas') ) ; 
					this.proximaPergunta(); 
				}
				else if(this.disciplina_id_atual){
					let data = {};  
					data['disciplina_id'] = [ this.disciplina_id_atual  ];  
					alertProcessando(); 

					treinamentoService.getTodasPerguntas(data) 
					.then(response => {
						this.todas = response ; 
						localStorage.setItem('todas', JSON.stringify( response ) );
						this.proximaPergunta(); 
						alertProcessandoHide();
					})
					.catch(error => {
						toastErro('Não foi possivel achar as   todas perguntas'); 
						alertProcessandoHide();
						if( error.status == 401 ){ 
							this.$store.dispatch('authentication/logout');
						} 
					});
				} 
				
			},



			// logout(){ 
			// 	localStorage.clear( ); 
			// 	window.location = window.location.protocol+ '//' + window.location.host + '/login';
			// },



			proximaPergunta(){ 
				this.selected = '' ; 
				this.respondido = false ; 
				window.scrollTo(0, 0); 
				
				if(this.todas.length > 0 ){
					this.pergunta = this.todas.pop() ;
				}
				else{
					if( this.concluido ){
						this.concluido = false ;
						this.mudouDisciplina(this.disciplina_id_atual);
					}
					else{
						this.pergunta = '' ;
						this.respondido = true ;
						this.concluido = true ;
					} 
				} 
			},


			responder() {  
				if( this.selected === this.pergunta.resposta_certa_id ){	
					this.respondidas.push({'pergunta':this.pergunta,'resposta':true,'resposta_id': this.selected}); 
					swal("Você Acertou!!", "", "success");  
				}  
				else{
					this.respondidas.push({'pergunta':this.pergunta,'resposta':false,'resposta_id': this.selected});
					swal("Você Errou!!", "", "error");	 
				}

				localStorage.setItem('todas',JSON.stringify(  this.todas ) );				 
				localStorage.setItem('respondidas', JSON.stringify( this.respondidas ) );

				this.respondido = true ;
				this.comentario = '';

				$('html, body').animate({
					scrollTop: $("#botao_proxima").offset().top
				}, 0);

				let data = {}; 
				data['pergunta_id'] = this.pergunta.id ; 
				data['selected'] = this.selected ;  
				data['latitude'] = this.latitude  ; 
				data['longitude'] = this.longitude  ;

				treinamentoService.responder(data)  
				.then(response => { })
				.catch(error => { 
					if( error.status == 401 ){ 
						this.$store.dispatch('authentication/logout');
					} 
				});

			},






			

			criarComentario(){ 
				let data = {};  
				data['texto'] = this.comentario ;
				data['pergunta_id'] = this.pergunta.id ; 
				data['status'] = 'Criada' ;  
				alertProcessando();
				treinamentoService.criarComentario(data)  
				.then(response => {  
					alertProcessandoHide();
					toastSucesso(response); 
					this.comentario = '';  
				})
				.catch(error => { 
					alertProcessandoHide(); 
					toastErro('Não foi Possivel Cadastrar o comentário.');
					toastErro(error.data.message);
				});  
			},



			getHistorico(){
				let data = {};  
				data['disciplina'] = [ this.disciplina_id_atual  ];  
				treinamentoService.getHistorico(data)   
				.then(response => {
					this.historico = response  ;
				})
				.catch(error => {
					console.log('erro ao atualiza HISTORICO');
					if( error.status == 401 ){ 
						this.$store.dispatch('authentication/logout');
					} 
				});
			},


			getRank(){
				treinamentoService.getRank() 
				.then(response => {
					this.rank = response  ;
				})
				.catch(error => {
					console.log('erro ao atualiza rank');
					if( error.status == 401 ){ 
						this.$store.dispatch('authentication/logout');
					} 
				});
			},


			showPosition(position) { 
				this.latitude = position.coords.latitude ;
				this.longitude = position.coords.longitude;  
			},



		},

		


		destroyed(){ 
			document.getElementById('header').hidden = false ;  
			document.getElementById('sidebar').hidden = false ;  
			document.getElementById('contentwrapper').style.marginLeft = null ;  
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
