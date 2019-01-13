<template>  
	<div>  
		<crudHeader texto="Permissões Cadastradas">
			<li class="breadcrumb-item">Permissões 	</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatablePermissao"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
							<th class="text-center">Ações</th>
						</datatable> 
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
				config: {
					exclusao:{
						url: permissaoService.getUrl() ,
						evento:'permissaoRemovida',
						item:'Permissão',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: permissaoService.getUrl() + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },
					{ data: 'descricao', name: 'descricao' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} , 
				reload:'',
			}
		}, 



		created() {
			
			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-permissao').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/permissao/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Permissão</a>'; 
		},


 
	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>