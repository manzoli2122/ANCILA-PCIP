<template>  
	<div>  
		<crudHeader texto="Meu perfil">
			<li class="breadcrumb-item">Meu perfil</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				<crudCard>
					<div class="card-body box-profile">
						<div class="text-center">
							<img class="profile-user-img img-fluid img-circle"
							src="/img/darinho.gif"
							alt="User profile picture">
						</div>

						<h3 class="profile-username text-center">{{user.nome}}</h3>

						 

						<ul class="list-group list-group-unbordered mb-3">
							<li class="list-group-item">
								<b>Email</b> <a class="float-right">{{user.email}}</a>
							</li>
							<li class="list-group-item">
								<b>Apelido</b> <a class="float-right">{{user.apelido}}</a>
							</li> 
						</ul>
 
						<router-link to="/notificacoes" exact class="btn btn-primary btn-block"><a>Notificações</a></router-link>


						<router-link to="/alterar/senha" exact class="btn btn-success btn-block"><a>Alterar Senha</a></router-link>
					</div>

				</crudCard> 
			</div> 
		</div>  
	</div>
</template>

<script>

	export default {

		props:[
		'url' , 'user'
		],  


		data() {
			return {                
				 
			}
		},

		// created(){
		// 	Echo.private('login.' + this.user.id)
		//     	.listen('LoginEvent', (e) => {
		//     		toastErro('Voce destivou o canal - ' , e.user.name);
		//         	console.log(e.user);
		//     	});
		// },

		// destroyed(){
		// 	Echo.leave('login.' + this.user.id);
		// },



	}

</script>

<style > 
 
</style>