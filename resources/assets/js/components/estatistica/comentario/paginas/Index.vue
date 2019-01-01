<template>  
	<div>  
		<crudHeader texto="Comentários Cadastrados">
			<li class="breadcrumb-item">Comentários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableResposta"> 
							<th pesquisavel style="max-width:35px">ID</th>
							<th pesquisavel>Texto</th> 
							<th pesquisavel>Pergunta</th>  
							<th pesquisavel>Status</th>  
							<th pesquisavel>Usuario</th>  
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
						url:this.url + this.$apiComentario, 
						item:'Comentarios',
				},
				exclusao:{
					url:this.url  + this.$apiComentario ,
					evento:'ComentarioRemovido',
					item:'Comentarios',
				},
				order: [[ 0, "desc" ]],
				ajax: { 
					url: this.url  + this.$apiComentario + '/datatable'
				},
				columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'texto', name: 'texto' }, 
					{ data: 'pergunta_id', name: 'pergunta_id' },  
					{ data: 'status', name: 'status' },  
					{ data: 'usuario.nome', name: 'usuario.nome' },  
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
				],
			} , 
			reload:'',
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
				var treeview = document.getElementById('menu-estatistica-treeview'); 
				Array.from(treeview.childNodes).filter(function (value) {
					if(value.className == 'nav-item')
						Array.from(value.childNodes).filter(function (value) { 
							if(value.nodeName=="A"){
								value.classList.remove("active");  
							} 
						})  
					return value  ;
				})  ;

				var el2 = document.getElementById('menu-estatistica-comentario');
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