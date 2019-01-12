<template>  
	<div>  
		<crudHeader texto="Tentativas Cadastradas">
			<li class="breadcrumb-item">Tentativa</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableDisciplina">  
							<th pesquisavel style="min-width:100px">Nome Usuario</th> 
							<th pesquisavel style="max-width:45%;min-width:150px">Disciplina</th>
							<th pesquisavel style="min-width:40px">Pergunta</th>  
							<th style="min-width:25px">Res</th>  
							<th pesquisavel style="min-width:40px">Certa</th>   
							<th pesquisavel  >Data</th>   
							<th pesquisavel  >latitude</th>   
							<th pesquisavel  >longitude</th>   
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
				 
				order: [[ 5, "desc" ]],
				ajax: { 
					url: this.url + this.$apiTentativa + '/datatable'
				},
				columns: [ 
				{ data: 'usuario.nome', name: 'usuario.nome' }, 
				{ data: 'disciplina.nome', name: 'disciplina.nome' }, 
				{ data: 'pergunta_id', name: 'pergunta_id' }, 
				{ data: 'resposta_id', name: 'resposta_id' }, 
				{ data: 'acerto', name: 'acerto' }, 
				{ data: 'created_at', name: 'created_at' }, 
				{ data: 'latitude', name: 'latitude' }, 
				{ data: 'longitude', name: 'longitude' }, 
				 
				],
			} , 
			reload:'',
		}
	}, 



	created() {
			 
			acertaMenu('menu-estatistica');

			document.getElementById('menu-estatistica-tentativa').classList.add("active");
			
			document.getElementById('li-nav-create').innerHTML = '';  
		},



		 
}

</script>
 
<style > 
.btn-sm{
	 margin-left: 10px; 
}
</style>