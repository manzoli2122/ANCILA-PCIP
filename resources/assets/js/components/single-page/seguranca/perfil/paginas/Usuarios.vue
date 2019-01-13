<template>             
	<div v-if="perfil"> 
		<crudHeader :texto="'Perfil - ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Perfis </a></router-link> 
			</li> 
			<li class="breadcrumb-item active">Usuários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Usuários</h3>  
					</div>
					<div class="card-body  table-responsive">  
						<datatable :config="config" id="datatableUsuarios">  
							<th pesquisavel style="max-width:90px">CPF</th> 
							<th pesquisavel>Nome</th> 
						</datatable>  
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="url_retorno" />   
					</div>        
				</crudCard>  
			</div> 
		</div>   
	</div>
</template>


<script>
	
	import { perfilService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {        
				perfil:'', 
				config: {
					order: [[ 1, "asc" ]],
					ajax: { 
						url: perfilService.getUrl() + '/' + this.$route.params.id + '/usuarios/datatable'
					},
					columns: [
					{ data: 'user_id', name: 'id'  }, 
					{ data: 'nome', name: 'nome' }, 
					],
				} , 
				url_retorno:'/perfil',
			}
		},

		



		created() {
			alertProcessando();
			perfilService.getPerfil( this.$route.params.id) 
			.then(response => {
				this.perfil = response ;
				alertProcessandoHide();
			})
			.catch(error => { 
				alertProcessandoHide();
				toastErro('Não foi possivel achar a Perfil' , error.data);
				this.$router.push('/perfil'); 
			});   

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-perfil').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/perfil/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Perfil</a>'; 
		}, 
		
		

	}
	
</script>

<style scoped> 
</style>