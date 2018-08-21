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
        path: '/show/:id',
        component: require('./paginas/Show')
    },  
    
];


const assunto = new Vue({
    el: '#assunto',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
