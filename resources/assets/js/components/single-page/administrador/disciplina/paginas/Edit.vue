<template>             
	<div>
		<crudHeader texto="Alterar Disciplina">
			<li class="breadcrumb-item">
				<router-link   to="/disciplina" exact><a>Disciplinas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="url + this.$apiDisciplina +'/' + $route.params.id" :form="form" metodo="patch" retorno="disciplina">
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Descrição:</label>
						<input type="text" id="descricao" name="descricao" class="form-control" v-model="form.descricao" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }">
					</crudFormElemento>
					<crudFormElemento :errors="form.errors.has('nivel')" :errors_texto="form.errors.get('nivel')">
								<label for="nivel">Nível:</label> 
								<select2   v-model="form.nivel" class="form-control  " v-bind:class="{ 'is-invalid': form.errors.has('nivel') }">   
									<option   value="Validada"> Validada </option>
									<!-- <option   value="Suspensa"> Suspensa </option>  -->
									<option   value="Restrita">   Restrita </option>
								</select2>  
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
				model:'',
				form: new Form({
					nome: '',    
					descricao: '',            
					nivel: ''               
				})
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.nome = this.model.nome;
				this.form.descricao = this.model.descricao;  
				this.form.nivel = this.model.nivel ; 
			}

		},    

		created() {
			alertProcessando();
			axios.get(this.url + this.$apiDisciplina + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a Disciplina', error.response.data);
				alertProcessandoHide();
			});


			acertaMenu('menu-administrador');

			document.getElementById('menu-administrador-disciplina').classList.add("active");

			document.getElementById('li-nav-create').innerHTML = '<a href="admin#/disciplina/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Disciplina</a>'; 
		},

	}



</script>
