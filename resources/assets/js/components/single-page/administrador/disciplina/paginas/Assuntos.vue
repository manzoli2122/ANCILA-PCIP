<template>             
	<div v-if="disciplina"> 
		<crudHeader :texto="'Disciplina - ' + disciplina.nome">
			<li class="breadcrumb-item">
				<router-link   to="/disciplina" exact><a>Disciplinas </a></router-link> 
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
						<datatableService :config="config" id="datatableAssunto"> 
							<th style="max-width:50px">ID</th>
							<th pesquisavel>Nome</th> 
							<th  class="text-center"  pesquisavel style="max-width:100px">Nº Perguntas</th> 
							<th>Status</th>  
							<th class="text-center" style="min-width:100px">Ações</th>
						</datatableService>  
					</div>

					<div class="card-footer text-right">
						<crudBotaoVoltar url="/disciplina" />   
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
				disciplina:'', 
				config: {
					ativacao:{
						url:this.url + this.$apiAssunto  , 
						item:'Assuntos',
					},
					exclusao:{
						url:this.url + this.$apiAssunto ,
						evento:'assuntoRemovida',
						item:'Assunto',
					},
					order: [[ 1, "asc" ]],
					ajax: { 
						url: this.url + this.$apiDisciplina + '/' + this.$route.params.id + '/assuntos/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'nome', name: 'nome' },  
					{ data: 'perguntas_count', name: 'perguntas_count', class: 'text-center' }, 
					{ data: 'status', name: 'assunto.deleted_at' },
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'text-center'} 
					],
				} , 
			}
		},

		



		created() { 
			alertProcessando();
			axios.get(this.url + this.$apiDisciplina + '/' + this.$route.params.id )
			.then(response => {
				this.disciplina = response.data ;
				alertProcessandoHide();
			})
			.catch(error => { 
				toastErro('Não foi possivel achar a Disciplina' , error.response.data); 
				alertProcessandoHide();
				this.$router.push('/');
			});   


			acertaMenu('menu-administrador');

			document.getElementById('menu-administrador-disciplina').classList.add("active");

			document.getElementById('li-nav-create').innerHTML = '<a href="admin#/disciplina/create" class="nav-link"><i class="fa fa-plus"></i> Cadastrar Disciplina</a>'; 
			
		}, 
		

	}
	
</script>

<style scoped> 
</style>