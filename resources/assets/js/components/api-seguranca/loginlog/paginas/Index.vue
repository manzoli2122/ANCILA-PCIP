<template>  
	<div>  
		<crudHeader texto="Logins Cadastrados">
			<li class="breadcrumb-item">Logins</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableLogins"> 
							<th pesquisavel style="max-width:20px">ID</th>
							<th pesquisavel>Nome</th>  
							<th pesquisavel>navegador</th>  
							<th pesquisavel   class="text-center">created_at</th> 
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
					 
					order: [[ 3, "desc" ]],
					ajax: { 
						url: this.url + this.$apiLogin + '/datatable'
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
			$(document).ready(function() {  
				var el3 = document.getElementById('li-nav-create');
				el3.innerHTML = '';  
				// el3.innerHTML = '<a href="admin#/resposta/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Pergunta</a>';  
			}); 
		},



		mounted(){
			$(document).ready(function() {  
				var treeview = document.getElementById('menu-seguranca-treeview'); 
				Array.from(treeview.childNodes).filter(function (value) {
					if(value.className == 'nav-item')
						Array.from(value.childNodes).filter(function (value) { 
							if(value.nodeName=="A"){
								value.classList.remove("active");  
							} 
						})  
					return value  ;
				})  ;

				var el2 = document.getElementById('menu-seguranca-loginlog');
				el2.classList.add("active"); 

			}); 
		},


	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>