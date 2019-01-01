import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./disciplina/paginas/Index')
    },
    {
        path: '/disciplina',
        component: require('./disciplina/paginas/Index')
    },
    {
        path: '/disciplina/create',
        component: require('./disciplina/paginas/Cadastro')
    },    
    {
        path: '/disciplina/edit/:id',
        component: require('./disciplina/paginas/Edit')
    }, 
    {
        path: '/disciplina/:id/assuntos',
        component: require('./disciplina/paginas/Assuntos')
    },  
    {
        path: '/assunto',
        component: require('./assunto/paginas/Index')
    },
    {
        path: '/assunto/create',
        component: require('./assunto/paginas/Cadastro')
    },    
    {
        path: '/assunto/edit/:id',
        component: require('./assunto/paginas/Edit')
    }, 
    {
        path: '/assunto/show/:id',
        component: require('./assunto/paginas/Show')
    }, 
    {
        path: '/pergunta',
        component: require('./pergunta/paginas/Index')
    },
    {
        path: '/pergunta/create',
        component: require('./pergunta/paginas/Cadastro')
    },    
    {
        path: '/pergunta/edit/:id',
        component: require('./pergunta/paginas/Edit')
    }, 
    {
        path: '/pergunta/show/:id',
        component: require('./pergunta/paginas/Show')
    },  
    {
        path: '/resposta',
        component: require('./resposta/paginas/Index')
    }, 
    {
        path: '/resposta/edit/:id',
        component: require('./resposta/paginas/Edit')
    },
    
];



Vue.prototype.$apiDisciplina = '/api/v1/disciplina';
Vue.prototype.$apiAssunto    = '/api/v1/assunto';
Vue.prototype.$apiPergunta   = '/api/v1/pergunta';
Vue.prototype.$apiResposta   = '/api/v1/resposta';




const administrador = new Vue({
    el: '#administrador',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
