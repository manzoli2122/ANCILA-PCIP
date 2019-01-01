import VueRouter from 'vue-router';
Vue.use(VueRouter);




let routes = [
    {
        path: '/',
        component: require('./tentativa/paginas/Index')
    }, 
    {
        path: '/tentativa',
        component: require('./tentativa/paginas/Index')
    }, 
    {
        path: '/comentario',
        component: require('./comentario/paginas/Index')
    },     
    {
        path: '/comentario/edit/:id',
        component: require('./comentario/paginas/Edit')
    }, 
];


Vue.prototype.$apiTentativa = '/api/v1/tentativa';
Vue.prototype.$apiComentario = '/api/v1/comentario';


const estatistica = new Vue({
    el: '#estatistica',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
