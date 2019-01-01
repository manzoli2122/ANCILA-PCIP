<template>             
	<div>
		<crudHeader texto="Alterar Comentario">
			<li class="breadcrumb-item">
				<router-link   to="/comentario" exact><a>Comentario </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="url + this.$apiComentario +'/' + $route.params.id" :form="form" metodo="patch" retorno="comentario" >
					
					<crudFormElemento :errors="form.errors.has('status')" :errors_texto="form.errors.get('status')">
						<label for="status">Status:</label> 
						<select2   v-model="form.status" class="form-control  " v-bind:class="{ 'is-invalid': form.errors.has('status') }"> 
							<option   value="Criada"> Criada </option>
							<option   value="Validada"> Validada </option>
							<option   value="Invalidada"> Invalidada </option>
							<option   value="Solucionada">   Solucionada </option>
							<option   value="Restrita">   Restrita </option>
						</select2>  
					</crudFormElemento>  


					<crudFormElemento :errors="form.errors.has('texto')" :errors_texto="form.errors.get('texto')"> 
						<label for="texto">Texto da Resposta:</label>
						<textarea id="texto" name="texto" class="form-control" v-model="form.texto" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('texto') }" disabled></textarea> 
					</crudFormElemento> 
 

					 
 
				</Formulario>  
			</div> 
		</div>    
	</div>
</template>


<script>

	import Form from '../../../core/Form';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				model:'',
				form: new Form({
					texto: '',                        
                    status: ''             
				})
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.texto = this.model.texto;
				this.form.status = this.model.status;
			}

		},    

		created() {
			alertProcessando();
			axios.get(this.url + this.$apiComentario + '/' + this.$route.params.id )
			.then(response => {
				this.model = response.data ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Comentario', error.response.data);
				alertProcessandoHide();
			});
		},

	}



</script>
