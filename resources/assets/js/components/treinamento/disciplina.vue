<template>
	<section class="dificuladade"> 
		
		<crudCard>
			<div class="card-header with-border text-center">
				<h3>
					<b>Disciplinas: </b> <small v-for="dif in temp.disciplina">{{dif}} , </small>    
				</h3> 
			</div>    
			<form method="post" :action="url + '/disciplina'" id="formEscolherDisciplina" @submit.prevent="enviarDisciplina"> 
				<div class="card-body">  
					<div class="row">
						<div   class="col-md-12">
							<select name="disciplina[]" multiple="multiple" class="form-control  js-example-basic-multiple"> 
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
		
		watch: { 
			disciplina: function (newpergunta_id, oldpergunta_id) {
				$('.js-example-basic-multiple').select2();
			} 
		},    
		
		methods: {

			enviarDisciplina() {
				var form = document.forms["formEscolherDisciplina"];
				
				var dados = jQuery(form).serialize()  ;

				axios.post( this.url + '/disciplina' , dados )
				.then(response => {
					console.log(response.data); 
					this.temp = response.data ;
				})
				.catch(errors => {
					console.log(errors);
				});




/*
 			form.submit(function () {
 				var dados = jQuery(this).serialize();
 				

 				axios.post( this.url + '/disciplina' ,  dados )
			    .then(response => {
			       console.log(response); 
					this.temp = response ;
			    })
			    .catch(errors => {
			        console.log(errors);
			    });

 				return false
 			});

 			var elements = form.querySelectorAll("input, select, textarea");
 			var dados = {};

 			for (var i = 0; i < elements.length; ++i) {
 				var element = elements[i];
 				var name = element.name;
 				var value = element.value;
 				if (name) {
 					alert( name );
 					alert( value );
 					dados[name] = value;
 					alert( dados );
 				}
 			}
			
			axios.post( this.url + '/disciplina' , JSON.stringify(dados) )
			    .then(response => {
			       console.log(response); 
					this.temp = response ;
			    })
			    .catch(errors => {
			        console.log(errors);
			    });
			    */
			},
			
		},
		
		created() { 
			axios.get(this.url_disciplina + '/all'  )
			.then(response => {
				this.disciplina = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar as disciplinas'); 
			});
		},

	}
	
</script>

<style scoped>



</style>