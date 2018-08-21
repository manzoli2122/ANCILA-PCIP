<template>  
	<div>  
		<crudHeader texto="Respostas Cadastrados">
			<li class="breadcrumb-item">Respostas</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableResposta"> 
							<th pesquisavel style="max-width:35px">ID</th>
							<th pesquisavel>Texto</th> 
							<th pesquisavel>Pergunta</th>       
							<th>tentativas</th>            
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
						item:'Respostas',
				},
				exclusao:{
					url:this.url,
					evento:'respostaRemovida',
					item:'Respostas',
				},
				order: [[ 2, "asc" ]],
				ajax: { 
					url: this.url + '/datatable'
				},
				columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'texto', name: 'texto' }, 
					{ data: 'pergunta_id', name: 'pergunta_id' }, 
					{ data: 'count', name: 'count'  }, 
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