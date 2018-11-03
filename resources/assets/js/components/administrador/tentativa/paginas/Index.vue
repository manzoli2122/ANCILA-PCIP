<template>  
	<div>  
		<crudHeader texto="Disciplinas Cadastradas">
			<li class="breadcrumb-item">Tentativa</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableDisciplina"> 
							<!-- <th style="max-width:15px">ID</th> -->
							<!-- <th pesquisavel>Usuario</th> -->
							<th pesquisavel style="min-width:100px">Nome Usuario</th>
							<!-- <th pesquisavel>Disc.</th>   -->
							<th pesquisavel style="max-width:45%;min-width:150px">Disciplina</th>
							<th pesquisavel style="min-width:40px">Pergunta</th>  
							<th style="min-width:25px">Res</th>  
							<th pesquisavel style="min-width:40px">Certa</th>   
							<th pesquisavel  >Data</th>   
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
				 
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + '/datatable'
				},
				columns: [
				// { data: 'id', name: 'id'  },
				// { data: 'user_id', name: 'user_id' },
				{ data: 'usuario.nome', name: 'usuario.nome' },
				// { data: 'disciplina_id', name: 'disciplina_id' }, 
				{ data: 'disciplina.nome', name: 'disciplina.nome' }, 
				{ data: 'pergunta_id', name: 'pergunta_id' }, 
				{ data: 'resposta_id', name: 'resposta_id' }, 
				{ data: 'acerto', name: 'acerto' }, 
				{ data: 'created_at', name: 'created_at' }, 
				 
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