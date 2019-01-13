<template>             
	<div v-if="permissao"> 
		<crudHeader :texto="'Permissão - ' + permissao.nome">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Permissões </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Perfis</h3>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatablePerfis"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
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
	
	import { permissaoService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {        
				permissao:'', 
				config: {
					order: [[ 1, "asc" ]],
					ajax: { 
						url: permissaoService.getUrl() + '/' + this.$route.params.id + '/perfis/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },
					{ data: 'descricao', name: 'descricao' },  
					],
				} ,  
				url_retorno:'/permissao',
			}
		},

		



		created() { 
			alertProcessando();
			permissaoService.getPermissao(this.$route.params.id)  
			.then(response => {
				this.permissao = response ;
				alertProcessandoHide();
			})
			.catch(error => { 
				toastErro('Não foi possivel achar a Permissão' , error.data); 
				alertProcessandoHide();
				this.$router.push( this.url_retorno );
			});   
			

			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-permissao').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/permissao/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Permissão</a>';
		}, 
		

	}
	
</script>

<style scoped> 
</style>