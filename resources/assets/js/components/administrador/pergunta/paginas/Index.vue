<template>  
	<div>  
		<crudHeader texto="Perguntas Cadastrados">
			<li class="breadcrumb-item">Perguntas</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatablePergunta"> 
							<th pesquisavel style="max-width:35px">ID</th>
							<th pesquisavel>Texto</th> 
							<th pesquisavel>Assunto</th>       
							<th pesquisavel>Dificuldade</th>       
							<th pesquisavel>Status</th>       
							<th>Disciplina</th> 
							<th class="align-center" style="width:140px">Ações</th>
							 

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
						item:'Pergunta',
				},
				exclusao:{
					url:this.url,
					evento:'perguntaoRemovida',
					item:'Pergunta',
				},
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/datatable'
				},
				columns: [
				{ data: 'id', name: 'pergunta.id'  },
			        { data: 'texto', name: 'pergunta.texto' }, 
			        { data: 'assunto.nome', name: 'assunto.nome' }, 
			        { data: 'dificuldade', name: 'dificuldade' }, 
			        { data: 'status', name: 'status' }, 
			        { data: 'disciplina', name: 'assunto.disciplina_id'  },  
			        { data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
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