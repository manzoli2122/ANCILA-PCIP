<template>  
	<div>  
		<crudHeader texto="Disciplinas Cadastradas">
			<li class="breadcrumb-item">Disciplina</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableDisciplina"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
							<th pesquisavel>Status</th>  
							<th class="text-center" style="min-width:150px">Ações</th>
						</datatableService> 
					</div>    
				</crudCard> 
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
			config: {
				ativacao:{
						url:this.url , 
						item:'Disciplina',
				},
				exclusao:{
					url:this.url,
					evento:'disciplinaRemovida',
					item:'Disciplina',
				},
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/datatable'
				},
				columns: [
				{ data: 'id', name: 'id'  },
				{ data: 'nome', name: 'nome' },
				{ data: 'descricao', name: 'descricao' }, 
				{ data: 'status', name: 'status' }, 
				{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
				],
			} , 
			reload:'',
		}
	}, 
}

</script>
 
<style > 
.btn-sm{
	 margin-left: 10px; 
}
</style>