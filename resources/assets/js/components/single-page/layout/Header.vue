 <template>   
 	<nav class="main-header navbar navbar-expand bg-white navbar-light border-bottom" id="header">
 		<!-- Left navbar links -->
 		<ul class="navbar-nav">
 			<li class="nav-item">
 				<a class="nav-link" data-widget="pushmenu" href="#">
 					<i class="fa fa-bars"></i>
 				</a>
 			</li> 
 			<li class="nav-item d-none d-sm-inline-block" id="li-nav-create"></li>
 		</ul> 
 		<!-- Right navbar links -->
 		<ul class="navbar-nav ml-auto"  v-if="!loggingIn"> 
 			<li class="nav-item"> 
 				<router-link  to="/login" exact  class="nav-link">Entrar  
 					<i class="fa fa-sign-in"></i>  
 				</router-link>	 
 			</li>  
 		</ul>

 		<ul class="navbar-nav ml-auto"  v-if="loggingIn"> 
 			<li class="nav-item">
 				<a class="nav-link" v-on:click="sair" href="#"> Sair  
 					<i class="fa fa-sign-in"></i>  
 				</a>
 			</li>  
 		</ul>
 	</nav>
 </template>

 <script>

 	export default {

 		computed: {
 			loggingIn () {
 				return this.$store.state.authentication.status.loggedIn ; 
 			}
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