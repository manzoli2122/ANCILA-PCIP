<template>  
	<div>  
		<crudHeader texto="Disciplinas Cadastradas">
			<li class="breadcrumb-item">Disciplina</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableDisciplina"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
							<th pesquisavel>Status</th>  
							<th pesquisavel>Nivel</th>  
							<th class="text-center" style="min-width:150px">Ações</th>
						</datatable> 
					</div>    
				</crudCard> 
			</div> 
		</div>  
	</div>
</template>

<script>

	import { disciplinaService  }  from '../../../_services';

	export default {



		props:[
		'url' 
		],  

		data() {
			return {    
				url_disciplina: '',
				config: {
					ativacao:{
						url: disciplinaService.getUrl() , 
						item:'Disciplina',
					},
					exclusao:{
						url: disciplinaService.getUrl(),
						evento:'disciplinaRemovida',
						item:'Disciplina',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: disciplinaService.getUrl() + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },
					{ data: 'descricao', name: 'descricao' }, 
					{ data: 'status', name: 'status' }, 
					{ data: 'nivel', name: 'nivel' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} , 
				reload:'',
			}
		}, 



		created() {			
			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-disciplina').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/disciplina/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Disciplina</a>'; 
		},

 
	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>