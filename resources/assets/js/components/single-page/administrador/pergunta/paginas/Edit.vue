<template>             
	<div v-if="model && assunto">
		<crudHeader texto="Alterar Pergunta">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Perguntas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="api_url" :form="form" metodo="patch" :retorno="url_retorno + '/show/' + model.id "> 
					<div class="row">
						<div class="col-md-8"> 
							<crudFormElemento :errors="form.errors.has('texto')" :errors_texto="form.errors.get('texto')">
								<label for="texto">Pergunta:</label>
								<textarea id="texto" name="texto" class="form-control" v-model="form.texto" style="height:270px" v-bind:class="{ 'is-invalid': form.errors.has('texto') }" v-bind:disabled="model.status == 'Finalizada' && !admin"> </textarea>   
							</crudFormElemento> 
							</div>
						<div class="col-md-4"> 
							<crudCard> 
								<div class="card-header">
									<h4> Informações:</h4>  
								</div> 
								<div class="card-body"> 
									  <p> {{novaLinha}} </p>
									  <p> <b> negrito </b> {{negrito}} </p>
									  <p style="font-size: 10pt;"> <b class="text-danger">vermelho</b>{{vermelho}}</p>
									  <p> <u> sublinhado </u> {{sublinhado}} </p>
									  <p> <i> italico </i> {{italico}} </p> 
								</div>    
							</crudCard>
						</div>
					</div>
					<div class="row">
						<div class="col-md-3"> 
							<crudFormElemento :errors="form.errors.has('dificuldade')" :errors_texto="form.errors.get('dificuldade')">
								<label for="dificuldade">Dificuldade:</label>
								<select2  v-model="form.dificuldade" class="form-control" v-bind:class="{'is-invalid': form.errors.has('dificuldade')}" v-bind:disabled="model.status == 'Finalizada' && !admin ">
									<option   value="Muito Facil"> Muito Fácil </option>
									<option   value="Facil"> Fácil </option>
									<option   value="Medio"> Medio </option>
									<option   value="Dificil">   Difícil </option>
									<option   value="Muito Dificil"> Muito Difícil </option>
								</select2> 
							</crudFormElemento>   
						</div>
						<div class="col-md-3">
							<crudFormElemento :errors="form.errors.has('status')" :errors_texto="form.errors.get('status')">
								<label for="status">Status:</label> 
								<select2   v-model="form.status" class="form-control  " v-bind:class="{ 'is-invalid': form.errors.has('status') }"> 
									<option   value="Criada"> Criada </option>
									<option   value="Validada"> Validada </option>
									<option   value="Suspensa"> Suspensa </option>
									<option   value="Finalizada">   Finalizada </option>
									<option   value="Restrita">   Restrita </option>
								</select2>  
							</crudFormElemento>   
						</div>
						<div class="col-md-6"> 
							<crudFormElemento :errors="form.errors.has('assunto_id')" :errors_texto="form.errors.get('assunto_id')">
								<label for="assunto_id">Assunto:</label> 
								<select2   v-model="form.assunto_id" class="form-control" v-bind:class="{ 'is-invalid': form.errors.has('assunto_id') }" v-bind:disabled="model.status == 'Finalizada' && !admin">
									<option    value="">Selecione a Assunto </option> 
									<option v-for="item in assunto" :key="item.id" :value="item.id"> {{ item.nome }} - {{item.disciplina.nome}}</option>
								</select2>     
							</crudFormElemento>  
						</div>
					</div> 
					<crudFormElemento :errors="form.errors.has('resumo')" :errors_texto="form.errors.get('resumo')">
						<label for="resumo">Resumo da Pergunta:</label>
						<textarea id="resumo" name="resumo" class="form-control" v-model="form.resumo" style="height:300px" v-bind:class="{ 'is-invalid': form.errors.has('resumo') }" v-bind:disabled="model.status == 'Finalizada' && !admin"> </textarea>   
					</crudFormElemento> 
				</Formulario>  
			</div> 
		</div>    
	</div> 
</template>


<script>

	import Form from '../../../_core/formulario/Form';

	import { perguntaService , assuntoService }  from '../../../_services';

	export default {

		props:[
		'url' , 'url_assunto'
		], 

		data() {
			return {                
				assunto: '',             
				model:'',
				form: new Form({
					texto: '',    
					resumo: '',
					assunto_id:'' ,
					dificuldade:'',    
					status:'',    

				}),
				api_url: perguntaService.getUrl() + '/' + this.$route.params.id,
				url_retorno:'/pergunta',
				novaLinha:'nova linha = <br>', 
				negrito:' =  <b>  texto </b>', 
				vermelho:' =  <b class="text-danger"> texto </b>', 
				sublinhado:' =  <u>  texto </u>', 
				italico:' =  <i>  texto </i>', 
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.texto = this.model.texto;
				this.form.resumo = this.model.resumo;
				this.form.assunto_id = this.model.assunto_id ;
				this.form.dificuldade = this.model.dificuldade ;
				this.form.status = this.model.status ;  
			}

		},    

		computed: {
			admin () {
 				if(this.$store.state.authentication.perfis){
 					return this.$store.state.authentication.perfis.filter(
 						perfil => { if(perfil == 'Admin'){
 							return true;
 						}} ).length > 0 ;
 				}
 				return false;
 			},
		},



		created() {


			alertProcessando();
			perguntaService.getPergunta(this.$route.params.id) 
			.then(response => {
				this.model = response ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a pergunta', error.data);
				alertProcessandoHide();
				if ( error.status === 401) {
					this.$store.dispatch('authentication/logout');			
				}
			});

			assuntoService.getAll() 
			.then(response => {
				this.assunto = response ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar os assunto');
			});

			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-pergunta').classList.add("active"); 
			document.getElementById('li-nav-create').innerHTML = '<a href="#/pergunta/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Pergunta</a>';  
			
		},

	}



</script>
