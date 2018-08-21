import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    },
    {
        path: '/create',
        component: require('./paginas/Cadastro')
    },    
    {
        path: '/edit/:id',
        component: require('./paginas/Edit')
    }, 
    {
        path: '/:id/assuntos',
        component: require('./paginas/Assuntos')
    },  
    
];


const disciplina = new Vue({
    el: '#disciplina',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
