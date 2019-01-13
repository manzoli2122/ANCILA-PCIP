 <template>  
	<div>  
		<crudHeader texto="Principal">
			<li class="breadcrumb-item">Principal</li>
		</crudHeader> 
		<div class="content">
			<div class="container-fluid"> 
				 <br>
				 <div class="row">
				 	<div class="col">
				 		<a href="/single#/treinamento" class="btn btn-success btn-block">
				 		<i class="fa fa-gamepad text-danger"></i> Treinar 
				 	</a>
				 	</div>
				 	
				 </div> 
			</div> 
		</div>  
	</div>
</template>

<script>

	export default {

		props:[
		'url' 
		],  

		data() {
			return {                
				 
			}
		},

		created() { 
			acertaMenu('menu-principal');  
			document.getElementById('li-nav-create').innerHTML = '';   
		},
 
	}

</script>

<style > 
 
</style>