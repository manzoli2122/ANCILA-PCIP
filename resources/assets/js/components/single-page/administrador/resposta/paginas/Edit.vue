<template>             
	<div>
		<crudHeader texto="Alterar Resposta">
			<li class="breadcrumb-item">
				<router-link   :to="url_retorno" exact><a>Respostas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Edição</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">
				<Formulario :url="api_url" :form="form" metodo="patch" :retorno="url_retorno">		
					<crudFormElemento :errors="form.errors.has('texto')" :errors_texto="form.errors.get('texto')"> 
						<label for="texto">Texto da Resposta:</label>
						<textarea id="texto" name="texto" class="form-control" v-model="form.texto" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('texto') }"></textarea> 
					</crudFormElemento> 
 

					<crudFormElemento :errors="form.errors.has('correta')" :errors_texto="form.errors.get('correta')">
						<label  for="correta" >Esta resposta é a certa?:</label>
						<select v-model="form.correta" id="correta" class="form-control" name="correta" required style="width: 100%" v-bind:class="{ 'is-invalid': form.errors.has('correta') }"> 
							<option  value="true">Sim</option>   
							<option  value="false" selected >Não</option>
						</select>     
					</crudFormElemento> 
 
				</Formulario>  
			</div> 
		</div>    
	</div>
</template>


<script>

	import Form from '../../../_core/formulario/Form';

	import { respostaService  }  from '../../../_services';

	export default {

		props:[
		'url' 
		], 

		data() {
			return {                
				model:'',
				form: new Form({
					texto: '',                        
                    correta: 'false'             
				}),
				api_url: respostaService.getUrl() + '/' + this.$route.params.id,
				url_retorno:'/resposta',
			}
		},

		watch: { 
			model: function (newmodel, oldmodel) {
				this.form.texto = this.model.texto;
			}

		},    

		created() {
			alertProcessando();
			respostaService.getResposta( this.$route.params.id ) 
			.then(response => {
				this.model = response ;
				alertProcessandoHide();
			})
			.catch(error => {
				toastErro('Não foi possivel achar o Assunto', error.data);
				if ( error.status === 401) {
					this.$store.dispatch('authentication/logout');			
				}
				alertProcessandoHide();
			});

			acertaMenu('menu-administrador');
			document.getElementById('menu-administrador-resposta').classList.add("active");		
			document.getElementById('li-nav-create').innerHTML = '';
			
		},

	}

</script>
