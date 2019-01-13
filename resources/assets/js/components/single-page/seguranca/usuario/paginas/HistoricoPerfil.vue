<template>             
	<div>  
		<crudHeader :texto="'Usuário - ' + usuario.nome ">
			<li class="breadcrumb-item"><router-link :to="url_retorno" exact><a>Usuários</a></router-link></li> 
			<li class="breadcrumb-item">
				<router-link :to="url_retorno + '/' + this.$route.params.id + '/perfil'" exact><a>Perfis</a></router-link>
			</li>
			<li class="breadcrumb-item">Histórico</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Histórico de Perfis</h3>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableUsuariosPerfisLog">  
							<th pesquisavel>Responsável</th>
							<th pesquisavel>Ação</th>
							<th pesquisavel>Perfil</th> 
							<th pesquisavel>Data</th>
							<th pesquisavel>IP</th>
							<th pesquisavel>Host</th>
						</datatable> 
					</div>  
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="url_retorno + '/' + this.$route.params.id + '/perfil'" />   
					</div>  
				</crudCard > 
				
			</div> 
		</div>  
	</div>
</template>


<script>
	
	import { userService  }  from '../../../_services';

	export default {
		
		props:[ 
		'url' 
		],  

		data() {
			return {   
				logs:'', 
				usuario:'', 

				config: { 
					order: [[ 4, "desc" ]],
					ajax: { 
						url: userService.getUrl() + '/' + this.$route.params.id + '/perfil/log/datatable'
					},
					columns: [ 
					{ data: 'autor.nome', name: 'autor.nome'  },
					{ data: 'acao', name: 'usuario_perfil_log.acao'  },
					{ data: 'perfil.nome', name: 'perfil.nome'  }, 
					{ data: 'created_at', name: 'created_at'  },
					{ data: 'ip_v4', name: 'ip_v4'  },
					{ data: 'host', name: 'host'  }, 
					],
				} ,   
				url_retorno:'/usuario',
			}
		},
		

		created() { 
			alertProcessando();
			userService.getUsuario( this.$route.params.id ) 
			.then(response => {
				this.usuario = response;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Usuário', error.data);
				alertProcessandoHide();
			});  

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-usuario').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '';			
		}, 

		
	}
	
</script>

<style scoped> 
</style>