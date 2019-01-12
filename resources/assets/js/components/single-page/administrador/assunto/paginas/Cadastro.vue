<template>             
	<div> 
		<crudHeader texto="Adicionar Assunto">
			<li class="breadcrumb-item">
				<router-link :to="url_retorno" exact><a>Assuntos </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="api_assunto" :form="form" metodo="post" :retorno="url_retorno">
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Descrição:</label>
						<textarea id="descricao" name="descricao" class="form-control" v-model="form.descricao" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }"> </textarea>
						 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('produto_id')" :errors_texto="form.errors.get('produto_id')">
						<label for="produto_id">Disciplina:</label> 
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
				form: new Form({
					nome: '',    
					disciplina_id: '',    
					descricao: ''               
				}),
				api_assunto: assuntoService.getUrl(),
				url_retorno:'/assunto',
			}
		}, 

		created() {
			

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
