<template>             
	<div> 
		<crudHeader :texto="'Perfil ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link :to="url_retorno" exact><a>Perfis </a></router-link> 
			</li> 
			<li class="breadcrumb-item">
				<router-link :to="url_retorno +'/' + this.$route.params.id + '/permissao'" exact><a>Permissões</a></router-link>
			</li>
			<li class="breadcrumb-item active">Historico</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 				
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Histórico de Permissão</h3>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatablePerfisPermissaoLog" >  
							<th pesquisavel>Responsável</th>
							<th pesquisavel>Ação</th> 
							<th pesquisavel>Permissão</th>
							<th pesquisavel>Data</th>
							<th pesquisavel>IP</th>
							<th pesquisavel>Host</th>
						</datatable> 
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar :url="url_retorno + '/' + this.$route.params.id + '/permissao'" />   
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
					order: [[ 4, "desc" ]],
					ajax: { 
						url: perfilService.getUrl() + '/' + this.$route.params.id + '/permissao/log/datatable'
					},
					columns: [ 
					{ data: 'autor.nome', name: 'autor.nome'  },
					{ data: 'acao', name: 'acao'  }, 
					{ data: 'permissao_nome', name: 'permissao_nome'  },
					{ data: 'created_at', name: 'created_at'  },
					{ data: 'ip_v4', name: 'ip_v4'  },
					{ data: 'host', name: 'host'  }, 
					],
				} ,    
				url_retorno:'/perfil',
			}
		},
		
		created() {
			alertProcessando();
			perfilService.getPerfil(this.$route.params.id )  
			.then(response => {
				this.perfil = response ;
				alertProcessandoHide();
			})
			.catch(error => { 
				alertProcessandoHide();
				toastErro('Não foi possivel achar a Perfil' , error.data);
			});  

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-perfil').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/perfil/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Perfil</a>'; 
		}, 
		
	}

</script>

<style scoped>

</style>