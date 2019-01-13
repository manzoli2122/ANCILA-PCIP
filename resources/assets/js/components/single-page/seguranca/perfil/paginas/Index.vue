<template>  
	<div>  
		<crudHeader texto="Perfis Cadastrados">
			<li class="breadcrumb-item">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config"  id="datatablePerfis"> 
							<th style="max-width:30px">ID</th>
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
	
	import { perfilService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		],  

		data() {
			return {                
				config: {
					exclusao:{
						url: perfilService.getUrl(),
						evento:'perfilRemovido',
						item:'Perfil',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: perfilService.getUrl() + '/datatable'
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
			document.getElementById('menu-seguranca-perfil').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/perfil/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Perfil</a>';  

		},

	}

</script>

<style >
.btn-sm{
	margin-left: 10px; 
}
</style>