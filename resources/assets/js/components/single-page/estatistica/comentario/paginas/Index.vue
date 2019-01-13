<template>  
	<div>  
		<crudHeader texto="Comentários Cadastrados">
			<li class="breadcrumb-item">Comentários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableResposta"> 
							<th pesquisavel style="max-width:35px">ID</th>
							<th pesquisavel>Texto</th> 
							<th pesquisavel>Pergunta</th>  
							<th pesquisavel>Status</th>  
							<th pesquisavel>Usuario</th>  
							<th class="align-center" style="width:140px">Ações</th>
						</datatable> 
					</div>    
				</crudCard> 
			</div> 
		</div>  
	</div>
</template>

<script>
	
	import { comentarioService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		],  

		data() {
			return {                
				config: {
					ativacao:{
						url: comentarioService.getUrl(), 
						item:'Comentarios',
					},
					exclusao:{
						url: comentarioService.getUrl() ,
						evento:'ComentarioRemovido',
						item:'Comentarios',
					},
					order: [[ 0, "desc" ]],
					ajax: { 
						url: comentarioService.getUrl() + '/datatable'
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