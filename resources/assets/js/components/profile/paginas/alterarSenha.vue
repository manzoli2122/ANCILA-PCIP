<template>  
	<div>  
		<crudHeader texto="Alterar Senha">
			<li class="breadcrumb-item">Alterar Senha</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<Formulario :url="url_envio" :form="form" metodo="post">	
					
					<crudFormElemento :errors="form.errors.has('password')" :errors_texto="form.errors.get('password')">
						<label for="password">Senha:</label>
						<input type="password" id="password" name="password" class="form-control" v-model="form.password" v-bind:class="{ 'is-invalid': form.errors.has('password') }"> 

						<!-- <textarea id="password" name="password" class="form-control" v-model="form.password" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('password') }"> </textarea> -->
					</crudFormElemento>  


					<crudFormElemento :errors="form.errors.has('passwordConfirm')" :errors_texto="form.errors.get('passwordConfirm')">
						<label for="passwordConfirm">Confirmar Senha:</label>
						<input type="password" id="passwordConfirm" name="passwordConfirm" class="form-control" v-model="form.passwordConfirm" v-bind:class="{ 'is-invalid': form.errors.has('passwordConfirm') }"> 

						<!-- <textarea id="passwordConfirm" name="passwordConfirm" class="form-control" v-model="form.passwordConfirm" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('passwordConfirm') }"> </textarea> -->
					</crudFormElemento> 

				</Formulario>
			</div> 
		</div>  
	</div>
</template>

<script>
	
	import Form from '../../core/Form'; 

	export default {

		props:[
		'url' , 'user'
		],  

		computed: { 
			url_envio: function () {  
				return this.url + '/alterar/senha'; 
			}
		},


		data() {
			return {  
				assunto: '',  
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