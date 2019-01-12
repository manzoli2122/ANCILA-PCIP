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
							<th pesquisavel>created_at</th> 
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
					// pdf:{
					// 	url:this.url + this.$apiUsuario ,  
					// },
					ativacao:{
						url:this.url + this.$apiUsuario , 
						item:'Usuário',
					},
					exclusao:{
						url:this.url + this.$apiUsuario,
						evento:'usuarioRemovido',
						item:'Usuario',
					},
					order: [[ 3, "desc" ]],
					ajax: { 
						url: this.url + this.$apiUsuario + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },  
					{ data: 'email', name: 'email' },  
					{ data: 'created_at', name: 'created_at' },  
					{ data: 'status', name: 'status' }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'}
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

				var el2 = document.getElementById('menu-seguranca-usuario');
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