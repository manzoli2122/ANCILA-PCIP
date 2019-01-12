<template>             
	<div v-if="disciplina"> 
		<crudHeader :texto="'Disciplina - ' + disciplina.nome">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Disciplinas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Assuntos</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">  
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Assuntos</h3>  
					</div>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableAssunto"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th> 
							<th  class="text-center"  pesquisavel style="max-width:100px">Nº Perguntas</th> 
							<th>Status</th>  
							<th class="text-center" style="min-width:100px">Ações</th>
						</datatable>  
					</div>

					<div class="card-footer text-right">
						<crudBotaoVoltar :url="url_retorno" />   
					</div>        
				</crudCard>  
			</div> 
		</div>   
	</div>
</template>


<script>
	
	import { assuntoService , disciplinaService }  from '../../../_services';

	export default {

		props:[
		'url'  
		], 

		data() {
			return {        
				disciplina:'', 
				config: {
					ativacao:{
						url: assuntoService.getUrl()  , 
						item:'Assuntos',
					},
					exclusao:{
						url: assuntoService.getUrl() ,
						evento:'assuntoRemovida',
						item:'Assunto',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: disciplinaService.getUrl() + '/' + this.$route.params.id + '/assuntos/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },  
					{ data: 'perguntas_count', name: 'perguntas_count', class: 'text-center' }, 
					{ data: 'status', name: 'assunto.deleted_at' },
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'} 
					],
				} , 
				url_retorno:'/disciplina',

			}
		},

		



		created() { 
			
			alertProcessando();

			disciplinaService.getDisciplina(this.$route.params.id)  
			.then(response => {
				this.disciplina = response ;
				alertProcessandoHide();
			})
			.catch(error => { 
				toastErro('Não foi possivel achar a Disciplina' , error.data); 
				alertProcessandoHide();
				this.$router.push(this.url_retorno);
			});   


			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-disciplina').classList.add("active");
			document.getElementById('li-nav-create').innerHTML = '<a href="#/disciplina/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Disciplina</a>'; 
			
		}, 
		

	}
	
</script>

<style scoped> 
</style>