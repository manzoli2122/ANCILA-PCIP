<template>             
	<div> 
		<crudHeader texto="Editar Usuário">
			<li class="breadcrumb-item">
				<router-link :to="url_retorno" exact><a>Usuário </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<Formulario :url="api_url" :form="form" metodo="patch" :retorno="url_retorno">
					
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

					<crudFormElemento :errors="form.errors.has('data_fim_pro')" :errors_texto="form.errors.get('data_fim_pro')">
						<label for="data_fim_pro">Pro até:</label>
						<input id="data_fim_pro" name="data_fim_pro" v-model="form.data_fim_pro" type="date" class="form-control input-lg" v-bind:class="{ 'is-invalid': form.errors.has('data_fim_pro') }">  
					</crudFormElemento> 

					<crudFormElemento :errors="form.errors.has('situacao_aprovacao')" :errors_texto="form.errors.get('situacao_aprovacao')">
						<label for="situacao_aprovacao">situação aprovação:</label>
						<select2  v-model="form.situacao_aprovacao" class="form-control" v-bind:class="{'is-invalid': form.errors.has('situacao_aprovacao')}"  >
							<option   value="Aprovado"> Aprovado </option>
							<option   value="Cursando"> Cursando </option> 
						</select2> 
					</crudFormElemento>  

				</Formulario> 
			</div> 
		</div>   
	</div>
</template>


<script> 
	
	import Form from '../../../_core/formulario/Form';

	import { userService  }  from '../../../_services';

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
					data_fim_pro: '',       
					situacao_aprovacao: '',       
					email: ''               
				}),
				api_url: userService.getUrl() + '/' + this.$route.params.id,
				url_retorno:'/usuario',
			}
		}, 

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.nome = this.model.nome;
				this.form.apelido = this.model.apelido;  
				this.form.email = this.model.email;  
				this.form.data_fim_pro = this.model.data_fim_pro;  
				this.form.situacao_aprovacao = this.model.situacao_aprovacao;  
				this.form.id = this.model.id;  
			}

		},    

		created() {
			alertProcessando();
			userService.getUsuario( this.$route.params.id ) 
			.then(response => {
				this.model = response ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o usuario', error.data);
				alertProcessandoHide();
			});

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-usuario').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = ''; 
		},

	} 

</script>
