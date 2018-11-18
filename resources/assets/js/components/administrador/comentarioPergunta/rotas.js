import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    },
     
    {
        path: '/edit/:id',
        component: require('./paginas/Edit')
    }, 
      
    
];


const comentario = new Vue({
    el: '#comentario',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
