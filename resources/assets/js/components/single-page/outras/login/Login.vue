 <template>  
 	<div>  
 		<crudHeader texto="Login">
 			<li class="breadcrumb-item">Login</li>
 		</crudHeader> 
 		<div class="content">
 			<div class="container-fluid">  
 				<div class="row justify-content-center"> 
 					<div class="col-md-8">
 						<div class="card">
 							<div class="card-header">Entrar </div> 
 							<div class="card-body">
 								<form @submit.prevent="login" aria-label="Entrar">	 
 									<div class="form-group row" v-if="error_login">
 										<div class="col-md-2"></div>
 										<div class="col-md-8">
 											<div class="alert alert-danger alert-dismissible" >
 												<button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
 												<h5><i class="icon fa fa-ban"></i> Erro!</h5>
 												 {{error_login}}
 											</div>

 										</div>
 									</div> 

 									<div class="form-group row">
 										<label for="id" class="col-sm-4 col-form-label text-md-right">CPF</label>
 										<div class="col-md-6">
 											<input id="id" type="text" class="form-control" name="id" v-model="username" required autofocus> 
 										</div>
 									</div> 
 									<div class="form-group row">
 										<label for="password" class="col-md-4 col-form-label text-md-right">Senha</label> 
 										<div class="col-md-6">
 											<input v-model="password" id="password" type="password" class="form-control" name="password" required> 
 										</div>
 									</div> 
 									<div class="form-group row mb-0">
 										<div class="col-md-8 offset-md-4">
 											<button type="submit" class="btn btn-primary">
 												Entrar
 											</button> 
 										</div>
 									</div>
 									<br> 
 								</form> 
 								<div class="form-group row mb-0">
 									<div class="col-md-8 offset-md-4">
 										<a href="#/cadastro">CLIQUE AQUI PARA CRIAR USUÁRIO</a> 
 									</div>
 								</div>
 							</div>
 						</div>
 					</div>
 				</div> 

 			</div> 
 		</div>  
 	</div>
 </template>

 <script>

 	export default {


 		data() {
 			return {                
 				username: '',
 				password: '',
 				submitted: false, 
 			}
 		},

 		computed: { 
 			error_login () {
 				return this.$store.state.authentication.mensagem;
 			}, 
 		},


 		created () {
 			this.$store.dispatch('authentication/logout');
 		},


 		methods: {
 			login (e) {
 				this.submitted = true;
 				const { username, password } = this;
 				const { dispatch } = this.$store;
 				if (username && password) { 		
 					alertProcessando();			
 					dispatch('authentication/login', { username, password }) 
 					.then(() => { 
 						alertProcessandoHide();
 						this.$router.push('/');
 					})
 					.catch(error => { 
 						this.erro = error;
 						alertProcessandoHide();
 					});
 				}
 			},
 		},

 	}

 </script>

 <style > 

</style>