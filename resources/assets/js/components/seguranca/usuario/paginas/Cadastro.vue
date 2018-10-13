<template>             
	<div> 
		<crudHeader texto="Adicionar Usuário">
			<li class="breadcrumb-item">
				<router-link to="/" exact><a>Usuário </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="url" :form="form" metodo="post">
					
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento>

					<crudFormElemento :errors="form.errors.has('id')" :errors_texto="form.errors.get('id')">
						<label for="id">CPF:</label>
						<input type="number" id="id" name="id" class="form-control" v-model="form.id" v-bind:class="{ 'is-invalid': form.errors.has('id') }"> 
					</crudFormElemento> 

					<crudFormElemento :errors="form.errors.has('apelido')" :errors_texto="form.errors.get('apelido')">
						<label for="apelido">Apelido:</label>
						<input type="text" id="apelido" name="apelido" class="form-control" v-model="form.apelido" v-bind:class="{ 'is-invalid': form.errors.has('apelido') }"> 
					</crudFormElemento>
 

					<crudFormElemento :errors="form.errors.has('email')" :errors_texto="form.errors.get('email')">
						<label for="email">Email:</label>
						<input type="text" id="email" name="email" class="form-control" v-model="form.email" v-bind:class="{ 'is-invalid': form.errors.has('email') }">
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
		'url' 
		], 

		data() {
			return {                
				form: new Form({
					nome: '',    
					id: '',    
					apelido: '',    
					status: 'A',    
					password: 'pmes@123',    
					email: ''               
				})
			}
		}, 

	} 

</script>
