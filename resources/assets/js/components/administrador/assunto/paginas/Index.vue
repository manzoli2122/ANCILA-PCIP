<template>  
	<div>  
		<crudHeader texto="Assuntos Cadastrados">
			<li class="breadcrumb-item">Assunto</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableAssunto"> 
							<th class="text-center"  style="max-width:30px">ID</th>
							<th pesquisavel>Nome</th>
							<!-- <th pesquisavel>Descrição</th>   -->
							<th pesquisavel>Disciplina</th>  
							<th class="text-center" pesquisavel style="max-width:50px">Status</th> 
							<th  class="text-center" style="max-width:40px">Perg.</th>
							<th class="text-center" style="min-width:140px">Ações</th>
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
						item:'Assunto',
				},
				exclusao:{
					url:this.url,
					evento:'assuntoRemovida',
					item:'Assunto',
				},
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/datatable'
				},
				columns: [
				{ data: 'id', name: 'assunto.id' , class: 'text-center' },
				{ data: 'nome', name: 'assunto.nome' },
				// { data: 'descricao', name: 'assunto.descricao' }, 
				{ data: 'nomedisciplina', name: 'disciplina.nome' }, 
				{ data: 'status', name: 'assunto.deleted_at' , class: 'text-center'}, 
				{ data: 'perguntas_count', name: 'perguntas_count', class: 'text-center' },
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