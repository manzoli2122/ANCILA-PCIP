<template>             
	<div>
		<crudHeader texto="Alterar Comentario">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Comentario </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="api_url" :form="form" metodo="patch" :retorno="url_retorno" >
					
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

	import Form from '../../../_core/formulario/Form';
	
	import { comentarioService  }  from '../../../_services';

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
				}),
				api_url: comentarioService.getUrl() + '/' + this.$route.params.id,
				url_retorno:'/comentario',
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
			comentarioService.getComentario(this.$route.params.id) 
			.then(response => {
				this.model = response ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Comentario', error.data);
				alertProcessandoHide();
				if ( error.status === 401) {
					this.$store.dispatch('authentication/logout');			
				}
			});

			acertaMenu('menu-estatistica');
			document.getElementById('menu-estatistica-comentario').classList.add("active");		
			document.getElementById('li-nav-create').innerHTML = '';  			
		},

	}



</script>
