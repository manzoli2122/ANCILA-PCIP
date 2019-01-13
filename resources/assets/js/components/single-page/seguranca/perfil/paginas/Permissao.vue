<template>             
	<div v-if="perfil"> 
		<crudHeader :texto="'Perfil - ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Perfis </a></router-link> 
			</li> 
			<li class="breadcrumb-item active">Permissões</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				<crudCard>
					<div class="card-header text-center">
						<h2 class="card-title">Permissões</h2>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatablePerfisPermissao" :reload="reloadDatatable" v-on:permissaoRemovida="permissaoRemovida($event)"> 
							<th style="max-width:30px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
							<th class="text-center">Ações</th>
						</datatable> 
					</div>    
					<div class="card-footer text-right">  
						<crudBotaoVoltar :url="url_retorno" />   
						<router-link :to="url_retorno +'/' + this.$route.params.id + '/permissao/historico'" exact  class="btn btn-warning">
							<i class="fa fa-database"></i> Historico
						</router-link>
					</div>  
				</crudCard> 
				<formAdicionarPermissao v-if="permissoes.length > 0" v-on:permissaoAdicionada="permissaoAdicionada($event)" :permissoes="permissoes" :url="api_url"> </formAdicionarPermissao>  
			</div> 
		</div>   
	</div>
</template>


<script>

	Vue.component('formAdicionarPermissao', require('./_PermissaoFormAdicionar.vue'));
	import { perfilService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {        
				perfil:'', 
				permissoes:'',
				reloadDatatable: false ,
				reloadDatatableLog: false ,
				config: {
					exclusao:{
						url: perfilService.getUrl() + '/' + this.$route.params.id + '/delete/permissao'  ,
						evento:'permissaoRemovida',
						item:'Permissão',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: perfilService.getUrl() + '/' + this.$route.params.id + '/permissao/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },
					{ data: 'descricao', name: 'descricao' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} ,
				url_retorno:'/perfil',
				api_url: perfilService.getUrl() ,
			}
		},

		watch: { 
			perfil: function (newQuestion, oldQuestion) {
				this.buscarPermissoes();
			}
		},



		created() {
			alertProcessando();
			perfilService.getPerfil(this.$route.params.id ) 
			.then(response => {
				alertProcessandoHide();
				this.perfil = response ;  
			})
			.catch(error => { 
				alertProcessandoHide();
				toastErro('Não foi possivel achar a Perfil' , error.data);
				this.$router.push(this.url_retorno);
			});  

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-perfil').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/perfil/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Perfil</a>';  

		}, 




		methods: {

			permissaoRemovida(event) {
				this.permissoes = event;  
			},

			permissaoAdicionada(event) {
				this.permissoes = event;
				this.reloadDatatable = !this.reloadDatatable; 
			},

			buscarPermissoes() {
				alertProcessando();
				perfilService.buscarPermissoes(this.$route.params.id )
				.then(response => {
					this.permissoes = response ;
					alertProcessandoHide();
				})
				.catch(error => {
					toastErro('Não foi possivel achar a Permissoes' , error.data);
					alertProcessandoHide();
				});
 
			},



		},

	}

</script>

<style scoped> 
</style>