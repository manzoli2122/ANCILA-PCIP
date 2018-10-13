<template>             
	<div v-if="model && assunto">
		<crudHeader texto="Alterar Pergunta">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Perguntas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="url +'/' + $route.params.id" :form="form" metodo="patch"> 
					<crudFormElemento :errors="form.errors.has('texto')" :errors_texto="form.errors.get('texto')">
						<label for="texto">Pergunta:</label>
						<textarea id="texto" name="texto" class="form-control" v-model="form.texto" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('texto') }"> </textarea>   
					</crudFormElemento> 
					<div class="row">
						<div class="col-md-3"> 
							<crudFormElemento :errors="form.errors.has('dificuldade')" :errors_texto="form.errors.get('dificuldade')">
								<label for="dificuldade">Dificuldade:</label>
								<select2  v-model="form.dificuldade" class="form-control" v-bind:class="{'is-invalid': form.errors.has('dificuldade')}">
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
								</select2>  
							</crudFormElemento>   
						</div>
						<div class="col-md-6"> 
							<crudFormElemento :errors="form.errors.has('assunto_id')" :errors_texto="form.errors.get('assunto_id')">
								<label for="assunto_id">Assunto:</label> 
								<select2   v-model="form.assunto_id" class="form-control" v-bind:class="{ 'is-invalid': form.errors.has('assunto_id') }">
									<option    value="">Selecione a Assunto </option> 
									<option v-for="item in assunto" :key="item.id" :value="item.id"> {{ item.nome }} - {{item.disciplina.nome}}</option>
								</select2>     
							</crudFormElemento>  
						</div>
					</div> 
					<crudFormElemento :errors="form.errors.has('resumo')" :errors_texto="form.errors.get('resumo')">
						<label for="resumo">Resumo da Pergunta:</label>
						<textarea id="resumo" name="resumo" class="form-control" v-model="form.resumo" style="height:300px" v-bind:class="{ 'is-invalid': form.errors.has('resumo') }"> </textarea>   
					</crudFormElemento> 
				</Formulario>  
			</div> 
		</div>    
	</div> 
</template>


<script>

	import Form from '../../../core/Form';

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

				})
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

		created() {


			alertProcessando();
			axios.get(this.url + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a pergunta', error.response.data);
				alertProcessandoHide();
			});


			axios.get(this.url_assunto + '/all'  )
			.then(response => {
				this.assunto = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar os assunto');

			});


		},

	}



</script>
