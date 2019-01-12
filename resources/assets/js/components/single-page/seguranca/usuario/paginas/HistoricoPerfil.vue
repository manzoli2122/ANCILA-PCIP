<template>             
	<div>  
		<crudHeader :texto="'Usuário - ' + usuario.nome ">
			<li class="breadcrumb-item"><router-link to="/usuario" exact><a>Usuários</a></router-link></li> 
			<li class="breadcrumb-item">
				<router-link :to="'/usuario/' + this.$route.params.id + '/perfil'" exact><a>Perfis</a></router-link>
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
						<datatableService :config="config" id="datatableUsuariosPerfisLog">  
							<th pesquisavel>Responsável</th>
							<th pesquisavel>Ação</th>
							<th pesquisavel>Perfil</th> 
							<th pesquisavel>Data</th>
							<th pesquisavel>IP</th>
							<th pesquisavel>Host</th>
						</datatableService> 
					</div>  
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="'/usuario/' + this.$route.params.id + '/perfil'" />   
					</div>  
				</crudCard > 
				
			</div> 
		</div>  
	</div>
</template>


<script>
	
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
						url: this.url + this.$apiUsuario + '/' + this.$route.params.id + '/perfil/log/datatable'
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
			}
		},
		

		created() { 
			alertProcessando();
			axios.get(this.url + this.$apiUsuario + '/' + this.$route.params.id)
			.then(response => {
				this.usuario = response.data;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Usuário', error.response.data);
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