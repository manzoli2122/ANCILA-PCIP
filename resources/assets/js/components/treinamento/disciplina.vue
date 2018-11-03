<template>
	<section class="dificuladade"> 
		
		<crudCard>
			<div class="card-header with-border text-center">
				<!-- <h3>
					<b>Disciplinas: </b> <small v-for="dif in temp.disciplina">{{dif}} , </small>    
				</h3>  -->
				<h3>
					<b>Disciplinas Atual: </b> 
					<small v-for="dif in disciplina" v-if="verifica(dif.id) " >{{dif.nome}} , </small>    
				</h3> 
			</div>    
			<form method="post" :action="url + '/disciplina'" id="formEscolherDisciplina" @submit.prevent="enviarDisciplina"> 
				<div class="card-body">  
					<div class="row">
						<div   class="col-md-12">
							<select name="disciplina" class="form-control  js-example-basic-multiple" > 
								<option  value="">Selecione a Disciplina </option>
								<option v-for="disc in disciplina"   :value="disc.id"> {{disc.nome}} </option>
							</select>   
						</div>
					</div> 
				</div> 
				<div class="card-footer align-right">   
					<button class="btn btn-warning btn-block "   type="submit">
						<i class="fa fa-check"></i> Alterar Disciplinas  
					</button>
				</div>
			</form>  
		</crudCard>  
		
	</section> 
</template>

<script>
	
	export default {
		props:[
		'url' , 'url_disciplina' 
		],

		data() {
			return {                
				disciplina:'',  
				temp:'',
			}
		},
		
		// computed: {    		
  //   		reversedMessage: function () {
  //     			return this.disciplina.filter(function (item) {
  //     				return item.id == 1
  //     			}) 
  //     		}
  //     	},


		watch: { 
			disciplina: function (newpergunta_id, oldpergunta_id) {
				// $('.js-example-basic-multiple').select2();
			} 
		},    
		
		methods: {


			verifica(id){
				if(this.temp){
					for (var i = this.temp.disciplina.length - 1; i >= 0; i--) {
						if(this.temp.disciplina[i] == id ){
							return true;
						}					
					}
				} 
				return false; 
			},


			enviarDisciplina() {
				var form = document.forms["formEscolherDisciplina"];
				
				var dados = jQuery(form).serialize()  ;

				axios.post( this.url + '/disciplina' , dados )
				.then(response => {
					console.log(response.data); 
					this.temp = response.data ;
					// if(this.temp.disciplina.length > 0 ){
						this.$emit('mudouDisciplina', this.temp);
					// }  
				})
				.catch(errors => {
					console.log(errors);
				}); 
			},
			
		},
		
		mounted(){
			axios.get( this.url + '/disciplina'  )
				.then(response => { 
					this.temp = response.data ; 
				})
				.catch(errors => {
					console.log(errors);
				});
		},



		created() { 
			axios.get(this.url_disciplina + '/all'  )
			.then(response => {
				this.disciplina = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar as disciplinas'); 
			});

			// this.enviarDisciplina();
		},

	}
	
</script>

<style scoped> 
</style>