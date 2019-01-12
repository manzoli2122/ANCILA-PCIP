<template>
	<section class="dificuladade"  > 
		
		<crudCard>
			<div class="card-header with-border text-center">
				<h3>
					<b>Disciplinas Atual: </b> 
					<small>{{disciplina_atual}} </small>    
				</h3> 
			</div>    
			<form method="post" :action="url + '/disciplina'" id="formEscolherDisciplina" @submit.prevent="enviarDisciplina"> 
				<div class="card-body">  
					<div class="row">
						<div   class="col-md-12">
							<select name="disciplina" v-model="disciplina_atual_id" class="form-control  js-example-basic-multiple" > 
								<option  value="">Selecione a Disciplina </option>
								<option v-for="disc in disciplinas"   :value="disc.id"> {{disc.nome}} </option>
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
		'url' , 'disciplinas' , 'disciplina_atual'
		],

		data() {
			return {    
				disciplina_atual_id:'',
			}
		},
		
		
		methods: {
  

			enviarDisciplina() {


				localStorage.setItem('disciplina',  this.disciplina_atual_id  );
				this.$emit('mudouDisciplina',  this.disciplina_atual_id  );


				// var form = document.forms["formEscolherDisciplina"];
				
				// var dados = jQuery(form).serialize()  ;

				// axios.post( this.url + '/disciplina' , dados )
				// .then(response => {
				// 	// console.log(response.data); 
				// 	this.$emit('mudouDisciplina', response.data.disciplina);					 
				// })
				// .catch(errors => {
				// 	console.log(errors);
				// }); 
			},
			
		},
		 

	}
	
</script>

<style scoped> 
</style>