import VueRouter from 'vue-router';
Vue.use(VueRouter);




let routes = [
    {
        path: '/',
        component: require('./usuario/paginas/Index')
    },
    {
        path: '/usuario',
        component: require('./usuario/paginas/Index')
    }, 
    {
        path: '/usuario/edit/:id',
        component: require('./usuario/paginas/Edit')
    },
    {
        path: '/usuario/:id/perfil',
        component: require('./usuario/paginas/Perfil') 
    },   
    {
        path: '/usuario/:id/perfil/historico',
        component: require('./usuario/paginas/HistoricoPerfil') 
    },    
    {
        path: '/perfil',
        component: require('./perfil/paginas/Index')
    },
    {
        path: '/perfil/create',
        component: require('./perfil/paginas/Cadastro')
    },  
    {
        path: '/perfil/:id/permissao',
        component: require('./perfil/paginas/Permissao')
    }, 
    {
        path: '/perfil/:id/usuarios',
        component: require('./perfil/paginas/Usuarios')
    },  
    {
        path: '/perfil/:id/permissao/historico',
        component: require('./perfil/paginas/HistoricoPermissao')
    },
    {
        path: '/permissao',
        component: require('./permissao/paginas/Index')
    },
    {
        path: '/permissao/create',
        component: require('./permissao/paginas/Cadastro')
    },    
    {
        path: '/permissao/edit/:id',
        component: require('./permissao/paginas/Edit')
    }, 
    {
        path: '/permissao/:id/perfis',
        component: require('./permissao/paginas/Perfis')
    },  
    {
        path: '/loginlog',
        component: require('./loginlog/paginas/Index')
    }, 
];



Vue.prototype.$apiUsuario = '/api/v1/usuario';
Vue.prototype.$apiPerfil = '/api/v1/perfil';
Vue.prototype.$apiPermissao = '/api/v1/permissao';
Vue.prototype.$apiLogin = '/api/v1/loginlog';



 
const seguranca = new Vue({
    el: '#seguranca',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
