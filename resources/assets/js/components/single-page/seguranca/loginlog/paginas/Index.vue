<template>  
	<div>  
		<crudHeader texto="Logins Cadastrados">
			<li class="breadcrumb-item">Logins</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableLogins"> 
							<th pesquisavel style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>  
							<th pesquisavel>navegador</th>  
							<th pesquisavel   class="text-center">created_at</th> 
						</datatable> 
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

					order: [[ 3, "desc" ]],
					ajax: { 
						url: '/api/v1/loginlog' + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'usuario.nome', name: 'usuario.nome' },   
					{ data: 'navegador', name: 'navegador' },   
					{data: 'created_at', name: 'created_at' }
					],
				} ,  
			}
		},

		created() {
			acertaMenu('menu-seguranca');
			document.getElementById('menu-seguranca-loginlog').classList.add("active");			
			document.getElementById('li-nav-create').innerHTML = '';  
		},

 

	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>