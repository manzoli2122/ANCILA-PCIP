<template>             
	<div>
		<crudHeader texto="Alterar Permissão">
			<li class="breadcrumb-item">
				<router-link   to="/permissao" exact><a>Permissões </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="url + this.$apiPermissao +'/' + $route.params.id" :form="form" metodo="patch" retorno="permissao">
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
				model:'',
				form: new Form({
					nome: '',    
					descricao: ''               
				})
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.nome = this.model.nome;
				this.form.descricao = this.model.descricao;  
			}

		},    

		created() {
			alertProcessando();
			axios.get(this.url + this.$apiPermissao + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a Permissão', error.response.data);
				alertProcessandoHide();
			});

			
			acertaMenu('menu-seguranca');

			document.getElementById('menu-seguranca-permissao').classList.add("active");

			document.getElementById('li-nav-create').innerHTML = '<a href="seguranca#/permissao/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Permissão</a>';
		},

	}



</script>
