<template>             
	<div v-if="usuario">  
		<crudHeader :texto="'Usuário - ' + usuario.nome ">
			<li class="breadcrumb-item"><router-link :to="url_retorno" exact><a>Usuários</a></router-link></li> 
			<li class="breadcrumb-item">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">   
				<crudCard>
					<div class="card-header text-center">
						<h2 class="card-title">Perfis</h2>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableUsuariosPerfis" :reload="reloadDatatable" v-on:perfilRemovido="perfilRemovido($event)"> 
							<th style="max-width:30px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>
							<th pesquisavel>Responsável</th>  
							<th class="text-center">Ações</th>
						</datatable> 
					</div>    
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="url_retorno" />   
						<router-link :to="url_retorno +'/' + this.$route.params.id + '/perfil/historico'" exact  class="btn btn-warning">
							<i class="fa fa-database"></i> Historico
						</router-link>
					</div>
				</crudCard>  

				<formAdicionarPerfil v-if="perfis.length > 0" v-on:perfilAdicionado="perfilAdicionado($event)" :perfis="perfis" :url="api_url"> </formAdicionarPerfil>    

			</div> 
		</div>  
	</div>
</template>


<script>

	Vue.component('formAdicionarPerfil', require('./_PerfilFormAdicionar.vue'));

	import { userService  }  from '../../../_services';

	export default {

		props:[ 
		'url' 
		],  

		data() {
			return {    
				usuario:'',
				perfis:'', 
				reloadDatatable: false , 
				config: {
					exclusao:{
						url: userService.getUrl() + '/' + this.$route.params.id + '/delete/perfil',
						evento:'perfilRemovido',
						item:'Perfil',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: userService.getUrl() + '/' + this.$route.params.id + '/perfil/datatable'
					},
					columns: [
					{ data: 'perfil_id', name: 'perfils_users.perfil_id'  },
					{ data: 'nome', name: 'perfils.nome' },
					{ data: 'descricao', name: 'perfils.descricao' }, 
					{ data: 'responsavel_id', name: 'perfils.pivot.responsavel_id' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} ,
				url_retorno:'/usuario',  
				api_url: userService.getUrl(),
			}
		},

		watch: { 
			usuario: function (newQuestion, oldQuestion) {
				this.buscarPerfis();
			}
		},


		created() { 
			alertProcessando();
			userService.getUsuario( this.$route.params.id )  
			.then(response => {
				alertProcessandoHide();
				this.usuario = response;
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Usuário', error.data);
				alertProcessandoHide();
				this.$router.push(this.url_retorno);
			});  

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-usuario').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = ''; 
		}, 

		methods: {

			perfilRemovido(event) {
				this.perfis = event;  
			},

			perfilAdicionado(event) {
				this.perfis = event;
				this.reloadDatatable = !this.reloadDatatable; 
			},

			buscarPerfis() {
				alertProcessando();
				userService.buscarPerfis( this.$route.params.id )   
				.then(response => {
					this.perfis = response;
					alertProcessandoHide();
				})
				.catch(error => {
					toastErro("Não foi possivel achar os Perfis para adiocionar", error.data);
					alertProcessandoHide();
				});   
			},
		},

	}

</script>

<style scoped>  
</style>