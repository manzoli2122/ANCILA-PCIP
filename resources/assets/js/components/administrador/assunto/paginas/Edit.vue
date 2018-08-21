<template>             
	<div v-if="model && disciplinas">
		<crudHeader texto="Alterar Assunto">
			<li class="breadcrumb-item">
				<router-link   to="/" exact><a>Assuntos </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="url +'/' + $route.params.id" :form="form" metodo="patch">
					<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
						<label for="nome">Nome:</label>
						<input type="text" id="nome" name="nome" class="form-control" v-model="form.nome" v-bind:class="{ 'is-invalid': form.errors.has('nome') }"> 
					</crudFormElemento> 
					<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
						<label for="descricao">Descrição:</label>
						
						<textarea id="descricao" name="descricao" class="form-control" v-model="form.descricao" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }"> </textarea>

						<!-- <input type="text" id="descricao" name="descricao" class="form-control" v-model="form.descricao" v-bind:class="{ 'is-invalid': form.errors.has('descricao') }"> -->
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

	import Form from '../../../core/Form';

	export default {

		props:[
		'url' , 'url_disciplina'
		], 

		data() {
			return { 
				disciplinas:'',               
				model:'',
				form: new Form({
					nome: '',    
					descricao: '' ,
					disciplina_id: ''             
				})
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
			axios.get(this.url + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Assunto', error.response.data);
				alertProcessandoHide();
			});




			axios.get(this.url_disciplina + '/all'  )
			.then(response => {
				this.disciplinas = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar as disciplinas');
			});




		},




	}



</script>
