<template>             
	<div v-if="perfil"> 
		<crudHeader :texto="'Perfil - ' + perfil.nome">
			<li class="breadcrumb-item">
				<router-link   to="/perfil" exact><a>Perfis </a></router-link> 
			</li> 
            <li class="breadcrumb-item active">Usuários</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-header text-center">
						<h3 class="card-title">Usuários</h3>  
					</div>
					<div class="card-body  table-responsive">  
						<datatableService :config="config" id="datatableUsuarios">  
							<th pesquisavel style="max-width:90px">CPF</th> 
							<th pesquisavel>Nome</th> 
						</datatableService>  
					</div> 
					<div class="card-footer text-right">
						<crudBotaoVoltar url="/perfil" />   
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
            perfil:'', 
            config: {
				order: [[ 1, "asc" ]],
				ajax: { 
					url: this.url + this.$apiPerfil+ '/' + this.$route.params.id + '/usuarios/datatable'
				},
				columns: [
				{ data: 'user_id', name: 'id'  }, 
				{ data: 'nome', name: 'nome' }, 
				],
			} , 
       	}
	},

	 



    created() {
 		alertProcessando();
 		axios.get(this.url + this.$apiPerfil + '/' + this.$route.params.id )
 		.then(response => {
			 this.perfil = response.data ;
			 alertProcessandoHide();
 		})
 		.catch(error => { 
			alertProcessandoHide();
 			toastErro('Não foi possivel achar a Perfil' , error.response.data);
 			this.$router.push('/perfil'); 
         });   
	 }, 
	 
 

 }
 
 </script>
 
 <style scoped> 
 </style>