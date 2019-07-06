<template>  
	<div>  
		<crudHeader texto="Perguntas Cadastrados">
			<li class="breadcrumb-item">Perguntas</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatablePergunta"> 
							<th pesquisavel style="max-width:35px">ID</th>
							<th pesquisavel>Texto</th> 
							<th pesquisavel>Assunto</th>       
							<th pesquisavel>Dificuldade</th>       
							<th pesquisavel>Status</th>       
							<th pesquisavel>Resposta</th>       
							<th pesquisavel>Disciplina</th> 
							<th class="align-center" style="width:150px">Ações</th> 
						</datatable> 
					</div>    
				</crudCard> 
			</div> 
		</div>  
	</div>
</template>

<script>
	
	import { perguntaService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		],  

		data() {
			return {                
				config: {
					pdf:{
						url: perguntaService.getUrl() ,  
					},
					ativacao:{
						url: perguntaService.getUrl() , 
						item:'Pergunta',
					},
					exclusao:{
						url:this.url,
						evento:'perguntaoRemovida',
						item:'Pergunta',
					},
					order: [[ 0, "desc" ]],
					ajax: { 
						url: perguntaService.getUrl() + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'pergunta.id'  },
					{ data: 'texto', name: 'pergunta.texto' }, 
					{ data: 'assunto.nome', name: 'assunto.nome' }, 
					{ data: 'dificuldade', name: 'dificuldade' }, 
					{ data: 'status', name: 'status' }, 
					{ data: 'resposta_certa_id', name: 'resposta_certa_id' }, 
					{ data: 'disciplina', name: 'assunto.disciplina_id'  },  
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
					],
				} , 
				reload:'',
			}
		}, 


		created() {			
			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-pergunta').classList.add("active"); 
			document.getElementById('li-nav-create').innerHTML = '<a href="#/pergunta/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Pergunta</a>'; 	 
		},

 
	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>