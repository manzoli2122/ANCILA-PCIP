 <template>   
 	<aside class="main-sidebar sidebar-light-warning elevation-4" id="sidebar"> 
 		<a href="#/" class="bg-white brand-link ">
 			<img src="/img/ancila.png" alt="SGPM-TEMPLATE" class="brand-image">
 			<span class="brand-text font-weight-light">
 				<b>Treinamento</b>
 			</span>
 		</a>

 		
 		<div class="sidebar"> 

 			<div class="user-panel mt-3 pb-3 mb-3 d-flex" v-if="loggingIn">
 				<div class="image">
 					<img src="/img/dare.gif" class="img-circle elevation-2" alt="User Image">
 				</div>
 				<div class="info">
 					<a href="#/profile" class="d-block">{{usuario}}</a>
 				</div>
 			</div> 
 			
 			<!-- Sidebar Menu -->
 			<nav class="mt-2">
 				<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false" id="menu">

 					<li class="nav-item">
 						<a href="#/" class="nav-link" id="menu-principal-link">
 							<i class="nav-icon fa fa-home"></i>
 							<p>Principal</p>
 						</a>
 					</li>
 					
 					<li class="nav-item" v-if="loggingIn">
 						<a href="#/treinamento" class="nav-link" id="menu-treinamento">
 							<i class="nav-icon fa fa-gamepad text-danger"></i>
 							<p>Treinamento</p>
 						</a>
 					</li>
 					
 					<li class="nav-item" v-if="loggingIn">
 						<a href="#/desenvolvedor" class="nav-link" id="menu-desenvolvedor-link">
 							<i class="nav-icon fa fa-user"></i>
 							<p>Desenvolvedor</p>
 						</a>
 					</li>

 					
 					



 					

 					<li class="nav-item has-treeview" id="menu-seguranca" v-if="admin">
 						<a href="#" class="nav-link" id="menu-seguranca-link">
 							<i class="nav-icon fa-lg fa-2x fa fa-lock"></i>
 							<p>Segurança
 								<i class="right fa fa-angle-left"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview" id="menu-seguranca-treeview">
 							
 							<li class="nav-item">
 								<a href="#/usuario" class="nav-link " id="menu-seguranca-usuario" >
 									<i class="nav-icon fa fa-users fa-lg fa-2x text-info "></i>
 									<p>Usuário</p>
 								</a>
 							</li>
 							
 							<li class="nav-item">
 								<a href="#/perfil" class="nav-link " id="menu-seguranca-perfil">
 									<i class="nav-icon fa fa-id-card fa-lg fa-2x text-success"></i>
 									<p>Perfil</p>
 								</a>
 							</li>
 							
 							<li class="nav-item">
 								<a href="#/permissao" class="nav-link " id="menu-seguranca-permissao">
 									<i class="nav-icon fa fa-unlock fa-lg fa-2x  text-danger"></i>
 									<p>Permissão </p>
 								</a>
 							</li>

 							<li class="nav-item">
 								<a href="#/loginlog" class="nav-link " id="menu-seguranca-loginlog">
 									<i class="nav-icon fa fa-lock fa-lg fa-2x  text-warning"></i>
 									<p>Log Login
 										<span class="right badge badge-warning">New</span>
 									</p>
 								</a>
 							</li>
 							
 						</ul>
 					</li>







 					

 					<li class="nav-item has-treeview " id="menu-estatistica" v-if="admin">
 						<a href="#" class="nav-link " id="menu-estatistica-link">
 							<i class="nav-icon fa fa-briefcase  fa-lg fa-2x"></i>
 							<p>Estatisticas
 								<i class="right fa fa-angle-left"></i>
 							</p>
 						</a>
 						<ul class="nav nav-treeview" id="menu-estatistica-treeview">
 							
 							<li class="nav-item">
 								<a href="#/tentativa" class="nav-link " id="menu-estatistica-tentativa">
 									<i class="nav-icon fa fa-book fa-lg fa-2x  "></i>
 									<p>Tentativas </p>
 								</a>
 							</li> 
 							
 							<li class="nav-item">
 								<a href="#/comentario" class="nav-link " id="menu-estatistica-comentario">
 									<i class="nav-icon fa fa-book fa-lg fa-2x  "></i>
 									<p>Comentário </p>
 								</a>
 							</li> 
 							
 						</ul>
 					</li>
 					


 					
 					

 					

 					

 					
 					
 					<li class="nav-item has-treeview " id="menu-administrador"  v-if="loggingIn"> 
 						<a href="#" class="nav-link" id="menu-administrador-link">
 							<i class="nav-icon fa fa-briefcase  fa-lg fa-2x"></i>
 							<p> Administrador <i class="right fa fa-angle-left"></i></p>		
 						</a> 
 						<ul class="nav nav-treeview" id="menu-administrador-treeview">	
 							
 							
 							<li class="nav-item">		
 								<a href="#/disciplina" class="nav-link " id="menu-administrador-disciplina">			
 									<i class="nav-icon fa fa-book fa-lg fa-2x  "></i>	
 									<p> Disciplina </p>							
 								</a>			
 							</li>     
 							
 							<li class="nav-item" >				
 								<a href="#/assunto" class="nav-link " id="menu-administrador-assunto">					
 									<i class="nav-icon fa fa-comments fa-lg fa-2x text-warning"></i>
 									<p> Assunto </p>						
 								</a>			
 							</li>	
 							
 							<li class="nav-item">
 								<a href="#/pergunta" class="nav-link" id="menu-administrador-pergunta">
 									<i class="nav-icon fa fa-question fa-lg fa-2x text-info"></i>
 									<p> Pergunta </p>
 								</a>
 							</li> 
 							
 							<li class="nav-item">
 								<a href="#/resposta" class="nav-link " id="menu-administrador-resposta">
 									<i class="nav-icon fa  fa-bullhorn fa-lg fa-2x text-success"></i>
 									<p> Resposta </p>
 								</a>
 							</li> 
 							


 						</ul>

 					</li> 


 				</ul>
 			</nav>
 		</div>
 	</aside>

 </template>

 <script>

 	export default {

 		computed: {
 			loggingIn () {
 				return this.$store.state.authentication.status.loggedIn ; 
 			},

 			usuario () {
 				if(this.$store.state.authentication.user){
 					return this.$store.state.authentication.user.apelido ; 
 				}
 				return'' ; 
 			},

 			admin () {
 				if(this.$store.state.authentication.perfis){
 					return this.$store.state.authentication.perfis.filter(
 						perfil => { if(perfil == 'Admin'){
 							return true;
 						}} ).length > 0 ;
 				}
 				return false;
 			},

 			perfis () {
 				if(this.$store.state.authentication.perfis){
 					return this.$store.state.authentication.perfis ; 
 				}
 				return '';
 			},

 		},
 		

 		data() {
 			return {                
 				
 			}
 		},


 		methods: {
 			sair (e) { 
 				const { dispatch } = this.$store;
 				dispatch('authentication/logout' ); 
 			}
 		}
 		
 	}

 </script>

 <style > 
 
</style>