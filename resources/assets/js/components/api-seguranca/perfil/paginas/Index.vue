<template>  
	<div>  
		<crudHeader texto="Perfis Cadastrados">
			<li class="breadcrumb-item">Perfis</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config"  id="datatablePerfis"> 
							<th style="max-width:30px">ID</th>
							<th pesquisavel>Nome</th>
							<th pesquisavel>Descrição</th>  
							<th class="text-center">Ações</th>
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
					exclusao:{
						url:this.url + this.$apiPerfil,
						evento:'perfilRemovido',
						item:'Perfil',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: this.url + this.$apiPerfil + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },
					{ data: 'descricao', name: 'descricao' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
					],
				} , 
				reload:'',
			}
		},
		

		created() {
			$(document).ready(function() {  
				var el3 = document.getElementById('li-nav-create');
				
				el3.innerHTML = '<a href="seguranca#/perfil/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Perfil</a>';  
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

				var el2 = document.getElementById('menu-seguranca-perfil');
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