<aside class="main-sidebar sidebar-light-warning elevation-4">

	<a href="/" class="bg-white brand-link ">
		<img src="/img/ancila.png" alt="SGPM-TEMPLATE" class="brand-image">
		<span class="brand-text font-weight-light">
			<b>{{env('APP_NAME')}}</b>
		</span>
	</a>

	<!-- Sidebar -->
	<div class="sidebar">

		@if( Auth::user() )
		<!-- Sidebar user panel (optional) -->
		<div class="user-panel mt-3 pb-3 mb-3 d-flex">
			<div class="image">
				<img src="/img/dare.gif" class="img-circle elevation-2" alt="User Image">
			</div>
			<div class="info">
				<a href="{{ route('profile')}}" class="d-block">{{ Auth::user()->apelido }}</a>
			</div>
		</div>
		@endif
 


		<!-- Sidebar Menu -->
		<nav class="mt-2">
			<ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu" data-accordion="false">

				<li class="nav-item">
					<a href="/" class="nav-link">
						<i class="nav-icon fa fa-home  "></i>
						<p>Principal</p>
					</a>
				</li>

				
				
				
				
				<li class="nav-item">
					<a href="{{ route('treinamento.index')}}" class="nav-link">
						<i class="nav-icon fa fa-gamepad text-danger"></i>
						<p>Treinamento</p>
					</a>
				</li>

				@if( Auth::user() )
				@perfil('Admin')
				<li class="nav-item has-treeview" id="menu-seguranca">
					<a href="#" class="nav-link active">
						<i class="nav-icon fa-lg fa-2x fa fa-lock"></i>
						<p>Segurança
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						
						

						@if(Route::getRoutes()->hasNamedRoute('permissao.index'))
						<li class="nav-item">
							<a href="{{ route('permissao.index')}}" class="nav-link " id="menu-seguranca-permissao">
								<i class="nav-icon fa fa-unlock fa-lg fa-2x  text-danger"></i>
								<p>Permissão
									<span class="right badge badge-danger">New</span>
								</p>
							</a>
						</li>
						@endif 

						@if(Route::getRoutes()->hasNamedRoute('perfil.index'))
						<li class="nav-item">
							<a href="{{ route('perfil.index')}}" class="nav-link " id="menu-seguranca-perfil">
								<i class="nav-icon fa fa-id-card fa-lg fa-2x text-success"></i>
								<p>Perfil</p>
							</a>
						</li>
						@endif 

						@if(Route::getRoutes()->hasNamedRoute('usuario.index'))
						<li class="nav-item">
							<a href="{{ route('usuario.index')}}" class="nav-link " id="menu-seguranca-usuario" >
								<i class="nav-icon fa fa-users fa-lg fa-2x text-info "></i>
								<p>Usuário</p>
							</a>
						</li>
						@endif
						
						

						
						 


					</ul>
				</li>
				@endperfil
				@endif
				 





				@if( Auth::user() )
				@permissao(['disciplina' , 'resposta' , 'pergunta' ,'assunto'] ) 
				<li class="nav-item has-treeview " id="menu-administrador">
					<a href="#" class="nav-link active">
						<i class="nav-icon fa fa-briefcase  fa-lg fa-2x"></i>
						<p>Administrador
							<i class="right fa fa-angle-left"></i>
						</p>
					</a>
					<ul class="nav nav-treeview">
						
						@permissao('disciplina') 
							@if(Route::getRoutes()->hasNamedRoute('disciplina.index'))
							<li class="nav-item">
								<a href="{{ route('disciplina.index')}}" class="nav-link " id="menu-administrador-disciplina">
									<i class="nav-icon fa fa-book fa-lg fa-2x  "></i>
									<p>Disciplina </p>
								</a>
							</li>
							@endif  
						@endpermissao


						@permissao('assunto')
							@if(Route::getRoutes()->hasNamedRoute('assunto.index'))
							<li class="nav-item" >
								<a href="{{ route('assunto.index')}}" class="nav-link " id="menu-administrador-assunto">
									<i class="nav-icon fa fa-comments fa-lg fa-2x text-warning"></i>
									<p>Assunto</p>
								</a>
							</li>
							@endif  

						@endpermissao

						@permissao('pergunta')
							@if(Route::getRoutes()->hasNamedRoute('pergunta.index'))
							<li class="nav-item">
								<a href="{{ route('pergunta.index')}}" class="nav-link " id="menu-administrador-pergunta">
									<i class="nav-icon fa fa-question fa-lg fa-2x text-info"></i>
									<p>Pergunta </p>
								</a>
							</li>
							@endif 

						@endpermissao

						@permissao('resposta')
							@if(Route::getRoutes()->hasNamedRoute('resposta.index'))
							<li class="nav-item">
								<a href="{{ route('resposta.index')}}" class="nav-link " id="menu-administrador-resposta">
									<i class="nav-icon fa  fa-bullhorn fa-lg fa-2x text-success"></i>
									<p>Resposta </p>
								</a>
							</li>
							@endif 
 						@endpermissao
						 	
						@permissao('tentativa') 
							@if(Route::getRoutes()->hasNamedRoute('tentativa.index'))
							<li class="nav-item">
								<a href="{{ route('tentativa.index')}}" class="nav-link " id="menu-administrador-tentativa">
									<i class="nav-icon fa fa-book fa-lg fa-2x  "></i>
									<p>Tentativas </p>
								</a>
							</li>
							@endif  
						@endpermissao

						@perfil('Admin') 
							@if(Route::getRoutes()->hasNamedRoute('comentario.index'))
							<li class="nav-item">
								<a href="{{ route('comentario.index')}}" class="nav-link " id="menu-administrador-comentario">
									<i class="nav-icon fa fa-book fa-lg fa-2x  "></i>
									<p>Comentário </p>
								</a>
							</li>
							@endif  
						@endperfil


 
					</ul>
				</li>
				@endpermissao
				@endif
				 




			</ul>
		</nav>
	</div>
</aside>
