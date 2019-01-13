 <template>  
 	<div>  
 		<crudHeader texto="Desenvolvedor">
 			<li class="breadcrumb-item">Desenvolvedor</li>
 		</crudHeader> 
 		<div class="content">
 			<div class="container-fluid"> 
 				<br>
 				<div class="row text-center">
 					<div class="col-12 col-sm-12">
 						<h5>BRUNO MANZOLI DO NASCIMENTO</h5>
 					</div> 
 					<div class="col-12 col-sm-6">
 						<p>Nascido em 21 de setembro de 1988 na cidade de São Gabriel da Palha, filho de Izabel Vencioneck Manzoli e Edis Mariano Manzoli. Com um ano de idade mudou-se com sua família para o Estado de Rondônia, onde morou até os 4 anos de idade.</p>
 					</div> 
 					<div class="col-12 col-sm-6">
 						<p>
 							<img src="/img/desenvolvedor/01-infancia.JPG" alt="INFÂNCIA"  width="35%" align=”middle”>
 							<img src="/img/desenvolvedor/02-rondonia.jpg" alt="INFÂNCIA"  width="26%" align=”middle”>
 							<img src="/img/desenvolvedor/03-infancia.JPG" alt="INFÂNCIA"  width="35%" align=”middle”>
 						</p>
 					</div>


 					<div class="col-12 col-sm-6">
 						<p>Curso o ensino médio jutamente com o curso de técnico em Agropecuária na antiga Escola Agrotécnica Federal de Colatina (EAF-COL) atual IFES. </p>
 					</div>
 					<div class="col-12 col-sm-6">
 						<p>
 							<img src="/img/desenvolvedor/10-eafcol.jpg" alt="EAFCOL1"  width="45%" align=”middle”>
 							<img src="/img/desenvolvedor/11-eafcol.jpg" alt="EAFCOL2"  width="45%" align=”middle”>
 						</p>
 					</div>

 					
 					<div class="col-12 col-sm-6">
 						<p>Em 2007 Começou o curso técnico em mecânica no antigo CEFET-ES de Vitória atual IFES, onde integrou a equipe de Atletismo nas modalidades de Lançamento de dardo, Arremesso de Peso e Arremesso de Disco. Participou de uma commpetição em São Paulo entre alunos dos CEFET de todo Brasil.</p>
 					</div>
 					<div class="col-12 col-sm-6">
 						<p>
 							<img src="/img/desenvolvedor/20-IFES.jpeg" alt="IFES1"  width="32%" align=”middle”>
 							<img src="/img/desenvolvedor/21-IFES.jpeg" alt="IFES2"  width="55%" align=”middle”>
 						</p>
 					</div>


 					
 					<div class="col-12 col-sm-6">
 						<p>Em 16 de Agosto de 2007 Ingressou na Polícia Militar do Espirito Santo, fazendo parte do 3º pelotão do CFSD de 2007.</p>
 					</div>
 					<div class="col-12 col-sm-6">
 						<p>
 							<img src="/img/desenvolvedor/30-CFSD.JPG" alt="CFSD"  width="70%" align=”middle”>
 						</p>
 					</div>

 					

 					<div class="col-12 col-sm-6">
 						<p>Em 2008 após se formar Soldado da PMES, passou a servir no Regimento de Polícia Montada, onde concluiu o curso de Especialização em policiamento montado.</p>
 						<p>
 							<img src="/img/desenvolvedor/42-cavalaria.JPG" alt="cavalaria3"  width="50%" align=”middle”>
 						</p>
 					</div>
 					<div class="col-12 col-sm-6">
 						<p>
 							<img src="/img/desenvolvedor/40-cavalaria.JPG" alt="cavalaria1"  width="45%" align=”middle”>
 							<img src="/img/desenvolvedor/41-cavalaria.jpg" alt="cavalaria2"  width="45%" align=”middle”>
 						</p>
 					</div>
 					

 					

 					<div class="col-12 col-sm-6">
 						<p>Em 2010 casou com Elisandra do Nascimento.</p>
 					</div>
 					<div class="col-12 col-sm-6">
 						<p>
 							<img src="/img/desenvolvedor/50-CASAMENTO.JPG" alt="CASAMENTO"  width="70%" align=”middle”>
 						</p>
 					</div>
 					


 					<p>
 						<img src="/img/desenvolvedor/60-FAMILIA.JPG" alt="FAMILIA1"  width="50%" align=”middle”>
 					</p>

 					<p>
 						<img src="/img/desenvolvedor/61-FAMILIA.JPG" alt="FAMILIA2"  width="50%" align=”middle”>
 					</p>




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
 			acertaMenu('menu-desenvolvedor');
			document.getElementById('li-nav-create').innerHTML = '';  
		},

		

	}

</script>

<style > 

</style>