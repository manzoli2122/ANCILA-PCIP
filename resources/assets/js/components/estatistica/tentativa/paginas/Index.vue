<template>  
	<div>  
		<crudHeader texto="Tentativas Cadastradas">
			<li class="breadcrumb-item">Tentativa</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatableService :config="config" id="datatableDisciplina">  
							<th pesquisavel style="min-width:100px">Nome Usuario</th> 
							<th pesquisavel style="max-width:45%;min-width:150px">Disciplina</th>
							<th pesquisavel style="min-width:40px">Pergunta</th>  
							<th style="min-width:25px">Res</th>  
							<th pesquisavel style="min-width:40px">Certa</th>   
							<th pesquisavel  >Data</th>   
							<th pesquisavel  >latitude</th>   
							<th pesquisavel  >longitude</th>   
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
				 
				order: [[ 5, "desc" ]],
				ajax: { 
					url: this.url + this.$apiTentativa + '/datatable'
				},
				columns: [ 
				{ data: 'usuario.nome', name: 'usuario.nome' }, 
				{ data: 'disciplina.nome', name: 'disciplina.nome' }, 
				{ data: 'pergunta_id', name: 'pergunta_id' }, 
				{ data: 'resposta_id', name: 'resposta_id' }, 
				{ data: 'acerto', name: 'acerto' }, 
				{ data: 'created_at', name: 'created_at' }, 
				{ data: 'latitude', name: 'latitude' }, 
				{ data: 'longitude', name: 'longitude' }, 
				 
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

				var el2 = document.getElementById('menu-estatistica-tentativa');
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