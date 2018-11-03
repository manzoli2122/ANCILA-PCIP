<template>  
	<div>  
		<crudHeader texto="Usuários Cadastrados">
			<li class="breadcrumb-item">Usuários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableUsuarios"> 
							<th pesquisavel style="max-width:90px">CPF</th>
							<th pesquisavel>Nome</th> 
							<th pesquisavel>Email</th> 
							<th pesquisavel style="max-width:60px">Status</th>
							<th style="min-width:200px" class="text-center">Ações</th> 
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
					pdf:{
						url:this.url ,  
					},
					ativacao:{
						url:this.url , 
						item:'Usuário',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: this.url + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },  
					{ data: 'email', name: 'email' },  
					{ data: 'status', name: 'status' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} ,  
			}
		},

	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>