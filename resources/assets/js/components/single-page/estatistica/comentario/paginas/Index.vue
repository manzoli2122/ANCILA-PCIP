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
			
			acertaMenu('menu-estatistica');

			document.getElementById('menu-estatistica-comentario').classList.add("active");
			
			document.getElementById('li-nav-create').innerHTML = '';  
 
		},


 


}

</script>
 
<style > 
.btn-sm{
	 margin-left: 10px; 
}
</style>