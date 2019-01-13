<template>  
	<div>  
		<crudHeader texto="Alterar Senha">
			<li class="breadcrumb-item">Alterar Senha</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<Formulario :url="url_envio" :form="form" metodo="post" retorno="/profile"> 
					<crudFormElemento :errors="form.errors.has('password')" :errors_texto="form.errors.get('password')">
						<label for="password">Senha:</label>
						<input type="password" id="password" name="password" class="form-control" v-model="form.password" v-bind:class="{ 'is-invalid': form.errors.has('password') }">  
					</crudFormElemento>   
					<crudFormElemento :errors="form.errors.has('passwordConfirm')" :errors_texto="form.errors.get('passwordConfirm')">
						<label for="passwordConfirm">Confirmar Senha:</label>
						<input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" v-model="form.passwordConfirm" v-bind:class="{ 'is-invalid': form.errors.has('passwordConfirm') }">  
					</crudFormElemento> 

				</Formulario>
			</div> 
		</div>  
	</div>
</template>

<script>
	
	import Form from '../../../_core/formulario/Form'; 

	export default {

		props:[
		'url' 
		],  

		computed: { 
			url_envio: function () {  
				return '/api/auth/update/senha'; 
			}
		},


		data() {
			return {  
				form: new Form({
					password: '',    
					passwordConfirm: '',    
				})
			}
		}, 
 
	}

</script>

<style > 
 
</style>