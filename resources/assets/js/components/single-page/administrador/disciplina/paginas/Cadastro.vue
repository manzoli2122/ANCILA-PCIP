<template>             
	<div> 
		<crudHeader texto="Adicionar Disciplina">
			<li class="breadcrumb-item">
				<router-link :to="url_retorno" exact><a>Disciplinas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="api_url" :form="form" metodo="post" :retorno="url_retorno">
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Descrição:</label>
						<input type="text" id="descricao" name="descricao" class="form-control" v-model="form.descricao" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }">
					</crudFormElemento> 
				</Formulario> 
			</div> 
		</div>   
	</div>
</template>


<script> 

	import Form from '../../../_core/formulario/Form';

	import { disciplinaService }  from '../../../_services';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				form: new Form({
					nome: '',    
					descricao: ''               
				}),
				api_url: disciplinaService.getUrl() ,
				url_retorno:'/disciplina',
			}
		}, 


		created() {
			
			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-disciplina').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/disciplina/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Disciplina</a>';  

		},
		
	} 

</script>
