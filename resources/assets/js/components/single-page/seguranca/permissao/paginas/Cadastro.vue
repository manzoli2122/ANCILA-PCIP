<template>             
	<div> 
		<crudHeader texto="Adicionar Permissão">
			<li class="breadcrumb-item">
				<router-link to="/permissao" exact><a>Permissões </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="url + this.$apiPermissao" :form="form" metodo="post" retorno="permissao">
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
	import Form from '../../../../core/Form'; 
	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				form: new Form({
					nome: '',    
					descricao: ''               
				})
			}
		}, 

		created() {
			
			acertaMenu('menu-seguranca');

			document.getElementById('menu-seguranca-permissao').classList.add("active");

			document.getElementById('li-nav-create').innerHTML = '<a href="seguranca#/permissao/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Permissão</a>'; 
		},

	} 

</script>
