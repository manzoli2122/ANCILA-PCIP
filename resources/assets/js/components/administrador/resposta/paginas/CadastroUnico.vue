<template>             
	<div> 
		<crudHeader texto="Adicionar Resposta">
			<li class="breadcrumb-item">
				<router-link to="/" exact><a>Respostas </a></router-link> 
			</li>
			<li class="breadcrumb-item active">Criação</li>
		</crudHeader>  
		<div class="content">
			<div class="container-fluid">   
				<form method="POST" action="/resposta" @submit.prevent="onSubmit" @keydown="form.errors.clear($event.target.name)">
					<crudCard>
			<div class="card-body"> 
				 
			<crudFormElemento :errors="form.errors.has('nome')" :errors_texto="form.errors.get('nome')">
					<label for="texto">Texto da Resposta:</label>
					<textarea id="texto" name="texto" class="form-control" v-model="form.texto" style="height:200px" v-bind:class="{ 'is-invalid': form.errors.has('texto') }"></textarea> 
				</crudFormElemento> 

				<crudFormElemento :errors="form.errors.has('descricao')" :errors_texto="form.errors.get('descricao')">
					<label  for="correta" >Esta resposta é a certa?:</label>
					<select v-model="form.correta" id="correta" class="form-control" name="correta" required style="width: 100%" v-bind:class="{ 'is-invalid': form.errors.has('correta') }"> 
						<option  value="true">Sim</option>   
						<option  value="false" selected >Não</option>
					</select>  
				</crudFormElemento> 

				<crudFormElemento :errors="form.errors.has('produto_id')" :errors_texto="form.errors.get('produto_id')">
					<label  for="pergunta_id" style="display: block;" >Pergunta:</label>
					<select2   v-model="form.pergunta_id" class="form-control" required v-bind:class="{ 'is-invalid': form.errors.has('pergunta_id') }">
						<option    value="">Selecione a Pergunta </option> 
						<option v-for="item in perguntas" :key="item.id" :value="item.id"> {{ item.texto }}</option> 
					</select2> 
				</crudFormElemento> 



			</div>
			<div class="card-footer text-right">
				<crudBotaoVoltar url="/"/>  
				<crudBotaoSalvar :disabled="form.errors.any()" /> 
			</div>
		</crudCard> 

				

			</form> 
		</div> 
	</div>   
</div>
</template>


<script> 
	import Form from '../../../core/Form'; 
	export default {

		props:[
		'url' , 'url_pergunta'
		], 

		data() {
			return {  
				perguntas: '',              
				form: new Form({
					texto: '',   
					pergunta_id: '',   
					correta:'false' ,          
				})
			}
		}, 

		created() {
			axios.get(this.url_pergunta + '/all/criada'  )
			.then(response => {
				this.perguntas = response.data ;
			})
			.catch(error => {
				toastErro('Não foi possivel achar as perguntas');

			});
		},

		methods: {

			onSubmit() {
				this.form.post(this.url)
				.then(response =>
					swal({

						type: 'success',
						showCloseButton: true,
						title: 'Resposta Cadastrada com sucesso!!',
						timer: 5000,
						width: 400,

						confirmButtonColor: '#646464',
						confirmButtonText: '<h4>OK</h4>',
						confirmButtonClass: 'bg-green',

					})
					)
				.catch(errors => console.log(errors));
			}

		}

	} 

</script>