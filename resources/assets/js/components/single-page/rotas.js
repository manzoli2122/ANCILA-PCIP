import SideBar from './layout/SideBar';

import Header from './layout/Header';

import { store } from './_store';

import { router } from './_helpers';

 
 
Vue.component('datatable', require('./_core/datatable/datatable.vue'));


Vue.prototype.$apiUsuario = '/api/v1/usuario';
Vue.prototype.$apiPerfil = '/api/v1/perfil';
Vue.prototype.$apiPermissao = '/api/v1/permissao';
Vue.prototype.$apiLogin = '/api/v1/loginlog';


Vue.prototype.$apiTentativa = '/api/v1/tentativa';
Vue.prototype.$apiComentario = '/api/v1/comentario';

Vue.prototype.$apiDisciplina = '/api/v1/disciplina';
Vue.prototype.$apiAssunto    = '/api/v1/assunto';
Vue.prototype.$apiPergunta   = '/api/v1/pergunta';
Vue.prototype.$apiResposta   = '/api/v1/resposta';


Vue.prototype.$apiTreinamento   = '/api/v1/treinamento';




const SideBarVue = new Vue({
    el: '#sidebar',   
    store,
    render: h => h(SideBar)  
});



const headerVue = new Vue({
    el: '#header', 
    router,   
    store,
    render: h => h(Header)  
});

 
const seguranca = new Vue({
    el: '#single',
    router,
    store,
 
});

 