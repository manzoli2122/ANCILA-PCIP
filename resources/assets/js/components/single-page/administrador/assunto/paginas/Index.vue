<template>  
	<div>  
		<crudHeader texto="Assuntos Cadastrados">
			<li class="breadcrumb-item">Assunto</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableAssunto"> 
							<th class="text-center"  style="max-width:30px">ID</th>
							<th pesquisavel>Nome</th>
							<!-- <th pesquisavel>Descrição</th>   -->
							<th pesquisavel>Disciplina</th>  
							<th class="text-center" pesquisavel style="max-width:50px">Status</th> 
							<th  class="text-center" style="max-width:40px">Perg.</th>
							<th class="text-center" style="min-width:140px">Ações</th>
						</datatable> 
					</div>    
				</crudCard> 
			</div> 
		</div>   
	</div>
</template>

<script>
	
	import { assuntoService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		],  

		data() {
			return {                
				config: {
					ativacao:{
						url: assuntoService.getUrl() , 
						item:'Assunto',
					},
					exclusao:{
						url: assuntoService.getUrl() ,
						evento:'assuntoRemovida',
						item:'Assunto',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url:  assuntoService.getUrl() + '/datatable', 
					},
					columns: [
					{ data: 'id', name: 'assunto.id' , class: 'text-center' },
					{ data: 'nome', name: 'assunto.nome' }, 
					{ data: 'nomedisciplina', name: 'disciplina.nome' }, 
					{ data: 'status', name: 'assunto.deleted_at' , class: 'text-center'}, 
					{ data: 'perguntas_count', name: 'perguntas_count', class: 'text-center' },
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} , 
				reload:'',
			}
		}, 


		created() { 
			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-assunto').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/assunto/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Assunto</a>'; 
		},



	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>