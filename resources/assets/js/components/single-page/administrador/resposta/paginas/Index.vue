<template>  
	<div>  
		<crudHeader texto="Respostas Cadastrados">
			<li class="breadcrumb-item">Respostas</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid">
				<crudCard>
					<div class="card-body  table-responsive"> 
						<datatable :config="config" id="datatableResposta"> 
							<th pesquisavel style="max-width:35px">ID</th>
							<th pesquisavel>Texto</th> 
							<th pesquisavel>Pergunta</th>       
							<th>tentativas</th>            
							<th class="align-center" style="width:140px">Ações</th> 
						</datatable> 
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
						url:this.url + this.$apiResposta, 
						item:'Respostas',
					},
					exclusao:{
						url:this.url + this.$apiResposta ,
						evento:'respostaRemovida',
						item:'Respostas',
					},
					order: [[ 0, "desc" ]],
					ajax: { 
						url: this.url + this.$apiResposta + '/datatable'
					},
					columns: [
					{ data: 'id', name: 'id'  },
					{ data: 'texto', name: 'texto' }, 
					{ data: 'pergunta_id', name: 'pergunta_id' }, 
					{ data: 'count', name: 'count'  }, 
					{ data: 'action', name: 'action', orderable: false, searchable: false, class: 'align-center'}
					],
				} , 
				reload:'',
			}
		}, 


		created() {

			acertaMenu('menu-administrador');

			document.getElementById('menu-administrador-resposta').classList.add("active");
			
			document.getElementById('li-nav-create').innerHTML = '';  


		},

 
	}

</script>

<style > 
.btn-sm{
	margin-left: 10px; 
}
</style>