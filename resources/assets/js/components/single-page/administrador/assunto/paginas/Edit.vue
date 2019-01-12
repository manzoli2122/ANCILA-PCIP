<template>             
	<div v-if="model && disciplinas">
		<crudHeader texto="Alterar Assunto">
			<li class="breadcrumb-item">
				<router-link :to="url_retorno" exact><a>Assuntos </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="api_assunto" :form="form" metodo="patch" :retorno="url_retorno">
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Descrição:</label>
						
						<textarea id="descricao" name="descricao" class="form-control" v-model="form.descricao" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }"> </textarea>
 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('disciplina_id')" :errors_texto="form.errors.get('disciplina_id')">
						<label for="disciplina_id">Disciplina:</label> 
						<select2   v-model="form.disciplina_id" class="form-control" required> 
							<option    value="">Selecione a Disciplina </option>  
							<option v-for="item in disciplinas" :key="item.id" :value="item.id"> {{ item.nome }}</option>   
						</select2>  
					</crudFormElemento>
				</Formulario>  
			</div> 
		</div>    
	</div>
</template>


<script>

	import Form from '../../../_core/formulario/Form';

	import { assuntoService , disciplinaService }  from '../../../_services';


	export default {

		props:[
		'url'  
		], 

		data() {
			return { 
				disciplinas:'',               
				model:'',
				form: new Form({
					nome: '',    
					descricao: '' ,
					disciplina_id: ''             
				}),
				api_assunto: assuntoService.getUrl() + '/' + this.$route.params.id,
				url_retorno:'/assunto',
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.nome = this.model.nome;
				this.form.descricao = this.model.descricao;  
				this.form.disciplina_id = this.model.disciplina_id + '' ;
			}

		},    

		created() {


			alertProcessando();
			assuntoService.getAssunto( this.$route.params.id )  
			.then(response => {
				this.model = response ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Assunto', error.data);
				alertProcessandoHide();
				if ( error.status === 401) {
					this.$store.dispatch('authentication/logout');			
				}
			});

  
 
			disciplinaService.getAll() 
			.then(response => {
				this.disciplinas = response ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar as disciplinas');
			});
 	  

 			acertaMenu('menu-administrador'); 
			document.getElementById('menu-administrador-assunto').classList.add("active");  
			document.getElementById('li-nav-create').innerHTML = '<a href="#/assunto/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Assunto</a>'; 

		},
 

	}

 
</script>
