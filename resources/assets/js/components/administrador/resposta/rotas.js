import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    },
    {
        path: '/create',
        component: require('./paginas/CadastroUnico')
    },    
    {
        path: '/edit/:id',
        component: require('./paginas/Edit')
    }, 
      
    
];


const resposta = new Vue({
    el: '#resposta',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
