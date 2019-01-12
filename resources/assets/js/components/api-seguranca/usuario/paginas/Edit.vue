<template>             
	<div> 
		<crudHeader texto="Adicionar Usuário">
			<li class="breadcrumb-item">
				<router-link to="/usuario" exact><a>Usuário </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="url + this.$apiUsuario + '/' + $route.params.id" :form="form" metodo="patch" retorno="usuario">
					
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
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
				model:'',              
				form: new Form({
					nome: '',  
					apelido: '',       
					id: '',       
					email: ''               
				})
			}
		}, 

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.nome = this.model.nome;
				this.form.apelido = this.model.apelido;  
				this.form.email = this.model.email;  
				this.form.id = this.model.id;  
			}

		},    

		created() {
			alertProcessando();
			axios.get(this.url + this.$apiUsuario + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o usuario', error.response.data);
				alertProcessandoHide();
			});
		},

	} 

</script>
