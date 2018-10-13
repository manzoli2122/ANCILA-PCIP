import VueRouter from 'vue-router';
Vue.use(VueRouter);

let routes = [
    {
        path: '/',
        component: require('./paginas/Index')
    }, 
    {
        path: '/notificacoes',
        component: require('./paginas/Notificacao') 
    },  
    {
        path: '/alterar/senha',
        component: require('./paginas/alterarSenha') 
    }, 
      
       
    
];
 
const profile = new Vue({
    el: '#profile',
    router : new VueRouter({
            routes,
            linkActiveClass: 'is-active'
        })
 
});
