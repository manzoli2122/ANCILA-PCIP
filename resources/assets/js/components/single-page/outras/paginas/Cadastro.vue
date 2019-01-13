 <template>  
 	<div>  
 		<crudHeader texto="Cadastro">
 			<li class="breadcrumb-item">Cadastro</li>
 		</crudHeader> 
 		<div class="content">
 			<div class="container-fluid"> 
 				<form @submit.prevent="cadastrar" aria-label="Cadastrar">  
 					<div class="row"> 
 						<div class="col-lg-12"> 
 							<div class="card  card-outline" v-bind:class="[color ? color : 'card-primary']" > 
 								<div class="card-body">  
 									<div class="form-group">
 										<label for="nome">Nome:</label>
 										<input type="text" id="nome" name="nome" class="form-control" v-model="nome" required>
 									</div> 
 									<div class="form-group">
 										<label for="email">Email:</label>
 										<input type="text" id="email" name="email" class="form-control" v-model="email" required> 
 									</div> 
 									<div class="row">
 										<div class="col-md-6"> 
 											<div class="form-group">
 												<label for="id">CPF:</label>
 												<input type="number" name="id" class="form-control" v-model="id" required> 
 											</div> 
 										</div>
 										<div class="col-md-6">
 											<div class="form-group">
 												<label for="apelido">Apelido:</label>
 												<input type="text" name="apelido" class="form-control" v-model="apelido" required>  
 											</div> 
 										</div>
 									</div>

 									<div class="row">
 										<div class="col-md-6"> 
 											<div class="form-group">
 												<label for="password">Senha:</label>
 												<input type="password" name="password" class="form-control" required v-model="password">  
 											</div> 
 										</div>
 										<div class="col-md-6">  
 											<div class="form-group">
 												<label for="passwordConfirm">Confirmar Senha:</label>
 												<input type="password" name="passwordConfirm" class="form-control" v-model="passwordConfirm"  required>  
 											</div> 
 										</div>
 									</div>

 								</div> 

 								<div class="card-footer text-right">
 									<button type="submit" class="btn btn-primary">
 										Cadastrar
 									</button> 
 								</div> 
 							</div>
 						</div>
 					</div> 
 				</form> 
 			</div> 
 		</div>  
 	</div>
 </template>

 <script>

 	export default {

 		   

 		data() {
 			return {                
 				nome: '',
 				email: '',
 				id: '',
 				apelido: '',
 				password: '',
 				passwordConfirm: '',
 			}
 		},

 		created() { 
 			// acertaMenu('menu-principal');  
 			// document.getElementById('li-nav-create').innerHTML = '';   
 		},

 		methods: {
 			cadastrar (e) {

 				let data = {};  
				data['nome'] =  this.nome  ;  
				data['email'] =  this.email  ;  
				data['id'] =  this.id  ;  
				data['apelido'] =  this.apelido  ;  
				data['password'] =  this.password  ;  
				data['passwordConfirm'] =  this.passwordConfirm  ;  

				alertProcessando();
 				axios.post( '/api/auth/cadastro'  , data     )
 				.then(response => {    
 					alertProcessandoHide();
 					toastSucesso('Cadastro realizado com Sucesso!!'); 
 					// resolve( response.data);  
 					this.$router.push('/login');
 					
 				})
 				.catch(error => {  
 					alertProcessandoHide();
 					toastErro('Não foi possivel realizar o cadastro');
 					
 					// reject(error.response);
 				}) 
 
 			},
 		},

 	}

 </script>

 <style > 
 
</style>