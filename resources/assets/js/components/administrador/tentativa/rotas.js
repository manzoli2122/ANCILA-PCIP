 import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    }, 
];


const tentativa = new Vue({
    el: '#tentativa',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
