<template>   
	<div> 
		<div  v-if="config.pdf" class="text-right">
			<h4><a v-if="datatable" :href="url_pdf"><span class="right badge badge-primary">Gerar Pdf</span></a></h4>
		</div> 
		
		<table class="table table-bordered table-striped  table-hover " :id="id" style="width:100%;">
			<thead>     
				<tr>
					<slot></slot>
				</tr>
			</thead>  
		</table>  

	</div>
</template>

<script>

	import { authHeader } from '../../_helpers'; 

	export default {

		props:[
		'config'  , 'id' , 'reload'
		],  

		watch: { 
		 	reload: function (newreload, oldreload) { 
				  this.datatable.ajax.reload(); 
		 	}
		 },
	 
		data() {
			return {          
				datatable:'',
			}
		},

		computed:{
			url_pdf : function(){
				return this.config.ajax.url + '/pdf?token=' + JSON.parse(localStorage.getItem('user')) + '&' + jQuery.param( this.datatable.ajax.params() )   ; // b=1&
			}
		},
			

		mounted() {
			this.datatable = this.montarDatatable(   );  
			if(this.config.exclusao){
				this.adicionarFuncaoExcluir();				
			} 
			if(this.config.ativacao){
				this.adicionarFuncaoAtivacao();				
			} 
		},


		methods: { 
 			
 			adicionarFuncaoAtivacao(  ) {  
				var vm = this ; 
				this.datatable.on('draw', function () {
					$('[btn-ativar]').click(function (){  
						let id =  $(this).data('id');  
						vm.ativarRecursoPeloId( id  ); 
					}); 
					$('[btn-desativar]').click(function (){  
						let id =  $(this).data('id');  
						vm.desativarRecursoPeloId( id  ); 
					}); 
				}); 
			} ,

			desativarRecursoPeloId(  id   ) { 
 				var vm = this ; 
			    alertConfimacao('Confirma a Desativação do ', vm.config.ativacao.item , 
			        function() { 
						alertProcessando();
			         axios.delete( vm.config.ativacao.url + '/desativacao/'  + id  , {headers: authHeader() }  )
						.then(response => {  
							vm.datatable.ajax.reload();
							alertProcessandoHide();
							toastSucesso('Desativação do(a) ' + vm.config.ativacao.item + ' realizado(a) com sucesso!!' ); 
						})
						.catch(error => {
							alertProcessandoHide();	
							toastErro('Não foi possivel Desativar ' + vm.config.ativacao.item , error.response.data.message );
						});  
			        }
			    );
			},

			ativarRecursoPeloId(  id   ) { 
 				var vm = this ; 
			    alertConfimacao('Confirma a Ativação ', vm.config.ativacao.item , 
			        function() { 
						alertProcessando();
			            axios.post( vm.config.ativacao.url + '/ativacao/'  + id ,null, {headers: authHeader() }  )
						.then(response => {  
							vm.datatable.ajax.reload();
							alertProcessandoHide();
							toastSucesso('Ativação do(a) ' + vm.config.ativacao.item + ' realizado(a) com sucesso!!' ); 
						})
						.catch(error => {
							alertProcessandoHide();	
							toastErro('Não foi possivel Ativar ' + vm.config.ativacao.item , error.response.data.message );
						});  
			        }
			    );
			},





			adicionarFuncaoExcluir(  ) {  
				var vm = this ; 
				this.datatable.on('draw', function () {
					$('[btn-excluir]').click(function (){  
						let id =  $(this).data('id');  
						vm.excluirRecursoPeloId( id  ); 
					}); 
				}); 
			} ,

		  
			excluirRecursoPeloId(  id   ) { 
 				var vm = this ; 
			    alertConfimacao('Confirma a Exclusão ', vm.config.exclusao.item , 
			        function() { 
						alertProcessando();
			            axios.delete( vm.config.exclusao.url + '/'  + id , {headers: authHeader() }  )
						.then(response => { 
							vm.$emit(vm.config.exclusao.evento , response.data );
							vm.datatable.ajax.reload();
							alertProcessandoHide();
							toastSucesso('Exclusão do(a) ' + vm.config.exclusao.item + ' realizado(a) com sucesso!!' ); 
						})
						.catch(error => {
							alertProcessandoHide();	
							toastErro('Não foi possivel remover ' + vm.config.exclusao.item , error.response.data.message );
						});  
			        }
			    );
			},
 


			montarDatatable(   lengthMenu = [ [ 10, 20, 30, 40, 50, 70, 100, 150, -1],   [ 10, 20, 30, 40, 50, 70, 100, 150, "Todos"]  ]) { 
				var seletorTabela = '#' + this.id ;  
				var configPadrao = {
					processing: true,
					serverSide: true,
					pagingType: "simple_numbers",
					lengthMenu: lengthMenu,
					language: { 
							"sEmptyTable": "Nenhum registro encontrado",
							"sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
							"sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
							"sInfoFiltered": "(Filtrados de _MAX_ registros)",
							"sInfoPostFix": "",
							"sInfoThousands": ".",
							"sLengthMenu": "_MENU_ resultados por página",
							"sLoadingRecords": "Carregando...",
							"sProcessing": "Processando...",
							"sZeroRecords": "Nenhum registro encontrado",
							"sSearch": "Pesquisar",
							"oPaginate": {
								"sNext": "Próximo",
								"sPrevious": "Anterior",
								"sFirst": "Primeiro",
								"sLast": "Último"
							},
							"oAria": {
								"sSortAscending": ": Ordenar colunas de forma ascendente",
								"sSortDescending": ": Ordenar colunas de forma descendente"
							
							}
					},
					ajax: { type: 'post',	data: { }, headers: authHeader() }, 
			        
			        initComplete:function(){
			        //Retira a busca a cada caractere digitado. Pesquisando apenas com Enter  
			        	var $searchInput = $(seletorTabela  +'_filter input'); 
			        	$searchInput.unbind(); 
			        	$searchInput.bind('keyup', function(e) {
			        		if (e.keyCode == 13) {
			        			dataTable.search(this.value).draw();
			        		}
			        	});
			        }
			        
			    }; 
			    
			     	
			    var config = jQuery.extend(true, {}, configPadrao , this.config ); 	
			    // var config = _.merge( configPadrao , this.config ); 	
			    
			  
			    $(seletorTabela + ' thead th[pesquisavel]').each(function() {
			    // Adiciona os campos para busca individual das colunas
			    	var title = $(seletorTabela + ' thead th').eq($(this).index()).text();
			    	$(this).html('<input type="text" pesquisavel placeholder="' + title + '" style="width:100%;" />');
			    }); 
			    var dataTable = $(seletorTabela).DataTable(config); 

			    dataTable.columns().eq(0).each(function(colIdx) { 
			    // Aplica a busca individual das colunas
			    	$('input', dataTable.column(colIdx).header()).on('keypress change click', function(e) {
			    		if (e.type === 'change' || e.which === 13) {
			    			dataTable
			    			.column(colIdx)
			    			.search(this.value)
			    			.draw(); 
			    			e.stopPropagation();
			    		}
			    	}); 
			    	$('input', dataTable.column(colIdx).header()).on('click', function(e) {
			    		e.stopPropagation();
			    	});
			    }); 
		    	return dataTable;
			}





	},


}

</script>



<style>
.btn-sm{
	 margin-left: 10px; 
}

table.dataTable {
	clear: both;
	margin-top: 6px !important;
	margin-bottom: 6px !important;
	max-width: none !important;
	border-collapse: separate !important;
	border-spacing: 0;
}
table.dataTable td,
table.dataTable th {
	-webkit-box-sizing: content-box;
	box-sizing: content-box;
}
table.dataTable td.dataTables_empty,
table.dataTable th.dataTables_empty {
	text-align: center;
}
table.dataTable.nowrap th,
table.dataTable.nowrap td {
	white-space: nowrap;
}

div.dataTables_wrapper div.dataTables_length label {
	font-weight: normal;
	text-align: left;
	white-space: nowrap;
}
div.dataTables_wrapper div.dataTables_length select {
	width: auto;
	display: inline-block;
}
div.dataTables_wrapper div.dataTables_filter {
	text-align: right;
}
div.dataTables_wrapper div.dataTables_filter label {
	font-weight: normal;
	white-space: nowrap;
	text-align: left;
}
div.dataTables_wrapper div.dataTables_filter input {
	margin-left: 0.5em;
	display: inline-block;
	width: auto;
}
div.dataTables_wrapper div.dataTables_info {
	padding-top: 0.85em;
	white-space: nowrap;
}
div.dataTables_wrapper div.dataTables_paginate {
	margin: 0;
	white-space: nowrap;
	text-align: right;
}
div.dataTables_wrapper div.dataTables_paginate ul.pagination {
	margin: 2px 0;
	white-space: nowrap;
	justify-content: flex-end;
}
div.dataTables_wrapper div.dataTables_processing {
	position: absolute;
	top: 50%;
	left: 50%;
	width: 200px;
	margin-left: -100px;
	margin-top: -26px;
	text-align: center;
	padding: 1em 0;
}

table.dataTable thead > tr > th.sorting_asc, table.dataTable thead > tr > th.sorting_desc, table.dataTable thead > tr > th.sorting,
table.dataTable thead > tr > td.sorting_asc,
table.dataTable thead > tr > td.sorting_desc,
table.dataTable thead > tr > td.sorting {
	padding-right: 30px;
}
table.dataTable thead > tr > th:active,
table.dataTable thead > tr > td:active {
	outline: none;
}
table.dataTable thead .sorting,
table.dataTable thead .sorting_asc,
table.dataTable thead .sorting_desc,
table.dataTable thead .sorting_asc_disabled,
table.dataTable thead .sorting_desc_disabled {
	cursor: pointer;
	position: relative;
}
table.dataTable thead .sorting:before, table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_desc_disabled:before,
table.dataTable thead .sorting_desc_disabled:after {
	position: absolute;
	bottom: 0.9em;
	display: block;
	opacity: 0.3;
}
table.dataTable thead .sorting:before,
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:before,
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc_disabled:before {
	right: 1em;
	content: "\2191";
}
table.dataTable thead .sorting:after,
table.dataTable thead .sorting_asc:after,
table.dataTable thead .sorting_desc:after,
table.dataTable thead .sorting_asc_disabled:after,
table.dataTable thead .sorting_desc_disabled:after {
	right: 0.5em;
	content: "\2193";
}
table.dataTable thead .sorting_asc:before,
table.dataTable thead .sorting_desc:after {
	opacity: 1;
}
table.dataTable thead .sorting_asc_disabled:before,
table.dataTable thead .sorting_desc_disabled:after {
	opacity: 0;
}

div.dataTables_scrollHead table.dataTable {
	margin-bottom: 0 !important;
}

div.dataTables_scrollBody table {
	border-top: none;
	margin-top: 0 !important;
	margin-bottom: 0 !important;
}
div.dataTables_scrollBody table thead .sorting:before,
div.dataTables_scrollBody table thead .sorting_asc:before,
div.dataTables_scrollBody table thead .sorting_desc:before,
div.dataTables_scrollBody table thead .sorting:after,
div.dataTables_scrollBody table thead .sorting_asc:after,
div.dataTables_scrollBody table thead .sorting_desc:after {
	display: none;
}
div.dataTables_scrollBody table tbody tr:first-child th,
div.dataTables_scrollBody table tbody tr:first-child td {
	border-top: none;
}

div.dataTables_scrollFoot > .dataTables_scrollFootInner {
	box-sizing: content-box;
}
div.dataTables_scrollFoot > .dataTables_scrollFootInner > table {
	margin-top: 0 !important;
	border-top: none;
}

@media screen and (max-width: 767px) {
	div.dataTables_wrapper div.dataTables_length,
	div.dataTables_wrapper div.dataTables_filter,
	div.dataTables_wrapper div.dataTables_info,
	div.dataTables_wrapper div.dataTables_paginate {
		text-align: center;
	}
}
table.dataTable.table-sm > thead > tr > th {
	padding-right: 20px;
}
table.dataTable.table-sm .sorting:before,
table.dataTable.table-sm .sorting_asc:before,
table.dataTable.table-sm .sorting_desc:before {
	top: 5px;
	right: 0.85em;
}
table.dataTable.table-sm .sorting:after,
table.dataTable.table-sm .sorting_asc:after,
table.dataTable.table-sm .sorting_desc:after {
	top: 5px;
}

table.table-bordered.dataTable th,
table.table-bordered.dataTable td {
	border-left-width: 0;
}
table.table-bordered.dataTable th:last-child, table.table-bordered.dataTable th:last-child,
table.table-bordered.dataTable td:last-child,
table.table-bordered.dataTable td:last-child {
	border-right-width: 0;
}
table.table-bordered.dataTable tbody th,
table.table-bordered.dataTable tbody td {
	border-bottom-width: 0;
}

div.dataTables_scrollHead table.table-bordered {
	border-bottom-width: 0;
}

div.table-responsive > div.dataTables_wrapper > div.row {
	margin: 0;
}
div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:first-child {
	padding-left: 0;
}
div.table-responsive > div.dataTables_wrapper > div.row > div[class^="col-"]:last-child {
	padding-right: 0;
}

.table th, .table td {
	padding: 0.3rem;
	vertical-align: inherit;
	border-top: 1px solid #dee2e6;
}

.table thead th {
	vertical-align: inherit; 
}

</style>