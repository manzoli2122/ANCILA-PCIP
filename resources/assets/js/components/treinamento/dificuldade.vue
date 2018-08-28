<template>
	<section class="dificuladade"> 

		<crudCard>
			<div class="card-header with-border text-center">
				<h3>
					<b>Dificuldade: </b> <small v-for="dif in temp.dificuldade">{{dif}} , </small>   
				</h3> 
			</div>            
			
			<form method="post" action="#"  @submit.prevent="enviarDificuldade">   
				<div class="card-body">  
					<div class="checkbox">
						<label >
							<input type="checkbox"  name="muitofacil" value="1" v-model="dificuldade.muitofacil">
							Muito Fácil
						</label> 
						<label style=" margin-left: 25px;">
							<input type="checkbox"  name="facil" value="1" v-model="dificuldade.facil">
							Fácil
						</label> 
						<label style=" margin-left: 25px;">
							<input type="checkbox"  name="medio" value="1" v-model="dificuldade.medio">
							Médio
						</label> 
						<label style=" margin-left: 25px;">
							<input type="checkbox"  name="dificil" value="1" v-model="dificuldade.dificil">
							Difícil
						</label> 
						<label style=" margin-left: 25px;">
							<input type="checkbox"  name="muitodificil" value="1" v-model="dificuldade.muitodificil">
							Muito Difícil
						</label> 
					</div> 
				</div> 
				<div class="card-footer align-right">   
					<button class="btn btn-warning btn-block "   type="submit">
						<i class="fa fa-check"></i> Alterar Dificuldade  
					</button>
				</div>
			</form> 
			
		</crudCard>  
 
	</section>

</template>




<script>
	import Form from '../core/Form';

	export default {
		props:[
		'url'              
		],

		data() {
			return {                

				dificuldade: new Form({
					muitofacil:'',
					facil:'',
					medio:'',
					dificil:'',
					muitodificil:'',
				}), 
				temp:'',
			}
		},


		methods: {

			enviarDificuldade() {

				this.dificuldade.post( this.url + '/dificuldade')
				.then(response => {
					console.log(response); 
					this.temp = response ;

				})            
				.catch(errors => console.log(errors));
			},


		},


	}



</script>

<style scoped>



</style>