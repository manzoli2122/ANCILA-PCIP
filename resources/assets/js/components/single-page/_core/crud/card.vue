<template>  
	<div class="row"> 
		<div class="col-lg-12">
			<div class="card  card-outline" v-bind:class="[color ? color : 'card-primary']" >   
				<slot></slot>
			</div>
		</div>
	</div>
</template>
 
<script>
	export default {

		props:[
		'color'  
		], 

		// methods: {

		// 	computed: { 
		// 		class_color: function () { 
		// 			if(this.color){
		// 				return this.color;
		// 			}
		// 			return 'card-primary'; 
		// 		}
		// 	},

		// } 
	}

</script>


<style >
 .text-red{
  color:red   !important;
}
 
</style>
