// import Vue from 'vue';

import VueRouter from 'vue-router';

Vue.use(VueRouter);




export const router = new VueRouter({
	 
	routes: [
	{
		path: '/',
		component: require('../outras/paginas/Principal')
	},
	{
		path: '/login',
		component: require('../outras/login/Login')
	},
	{
		path: '/desenvolvedor',
		component: require('../outras/paginas/Desenvolvedor') , 
		meta: { requiresAuth: true}
	},
	{
		path: '/treinamento',
		component: require('../outras/treinamento/Pergunta'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/usuario',
		component: require('../seguranca/usuario/paginas/Index'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/usuario/edit/:id',
		component: require('../seguranca/usuario/paginas/Edit'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/usuario/:id/perfil',
		component: require('../seguranca/usuario/paginas/Perfil') , 
		meta: { requiresAuth: true}
	},   
	{
		path: '/usuario/:id/perfil/historico',
		component: require('../seguranca/usuario/paginas/HistoricoPerfil') , 
		meta: { requiresAuth: true}
	},    
	{
		path: '/perfil',
		component: require('../seguranca/perfil/paginas/Index'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/perfil/create',
		component: require('../seguranca/perfil/paginas/Cadastro'), 
		meta: { requiresAuth: true}
	},  
	{
		path: '/perfil/:id/permissao',
		component: require('../seguranca/perfil/paginas/Permissao'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/perfil/:id/usuarios',
		component: require('../seguranca/perfil/paginas/Usuarios'), 
		meta: { requiresAuth: true}
	},  
	{
		path: '/perfil/:id/permissao/historico',
		component: require('../seguranca/perfil/paginas/HistoricoPermissao'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/permissao',
		component: require('../seguranca/permissao/paginas/Index'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/permissao/create',
		component: require('../seguranca/permissao/paginas/Cadastro'), 
		meta: { requiresAuth: true}
	},    
	{
		path: '/permissao/edit/:id',
		component: require('../seguranca/permissao/paginas/Edit'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/permissao/:id/perfis',
		component: require('../seguranca/permissao/paginas/Perfis'), 
		meta: { requiresAuth: true}
	},  
	{
		path: '/loginlog',
		component: require('../seguranca/loginlog/paginas/Index'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/tentativa',
		component: require('../estatistica/tentativa/paginas/Index'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/comentario',
		component: require('../estatistica/comentario/paginas/Index'), 
		meta: { requiresAuth: true}
	},     
	{
		path: '/comentario/edit/:id',
		component: require('../estatistica/comentario/paginas/Edit'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/disciplina',
		component: require('../administrador/disciplina/paginas/Index'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/disciplina/create',
		component: require('../administrador/disciplina/paginas/Cadastro'), 
		meta: { requiresAuth: true}
	},    
	{
		path: '/disciplina/edit/:id',
		component: require('../administrador/disciplina/paginas/Edit'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/disciplina/:id/assuntos',
		component: require('../administrador/disciplina/paginas/Assuntos'), 
		meta: { requiresAuth: true}
	},  
	{
		path: '/assunto',
		component: require('../administrador/assunto/paginas/Index'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/assunto/create',
		component: require('../administrador/assunto/paginas/Cadastro'), 
		meta: { requiresAuth: true}
	},    
	{
		path: '/assunto/edit/:id',
		component: require('../administrador/assunto/paginas/Edit'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/assunto/show/:id',
		component: require('../administrador/assunto/paginas/Show'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/pergunta',
		component: require('../administrador/pergunta/paginas/Index'), 
		meta: { requiresAuth: true}
	},
	{
		path: '/pergunta/create',
		component: require('../administrador/pergunta/paginas/Cadastro'), 
		meta: { requiresAuth: true}
	},    
	{
		path: '/pergunta/edit/:id',
		component: require('../administrador/pergunta/paginas/Edit'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/pergunta/show/:id',
		component: require('../administrador/pergunta/paginas/Show'), 
		meta: { requiresAuth: true}
	},  
	{
		path: '/resposta',
		component: require('../administrador/resposta/paginas/Index'), 
		meta: { requiresAuth: true}
	}, 
	{
		path: '/resposta/edit/:id',
		component: require('../administrador/resposta/paginas/Edit'), 
		meta: { requiresAuth: true}
	},

    // otherwise redirect to home
    { path: '*', redirect: '/' }
    ]
});


router.beforeEach((to, from, next) => {
	if (to.matched.some(record => record.meta.requiresAuth)) {
		if ( !localStorage.getItem('user') ) {
			next({
				path: '/login',
				query: {
					redirect: to.fullPath,
				},
			});
		} else {
			next();
		}
	} else {
		next();
	}
})

 