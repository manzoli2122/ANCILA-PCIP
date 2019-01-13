<template>             
	<div>
		<crudHeader texto="Alterar Permissão">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Permissões </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="api_url" :form="form" metodo="patch" :retorno="url_retorno">
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

	import { permissaoService  }  from '../../../_services';

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
				}),
				api_url: permissaoService.getUrl() + '/' + this.$route.params.id,
				url_retorno:'/permissao',
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
			permissaoService.getPermissao(this.$route.params.id) 
			.then(response => {
				this.model = response ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar a Permissão', error.data);
				alertProcessandoHide();
			});

			
			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-permissao').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/permissao/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Permissão</a>';
		},

	}



</script>
