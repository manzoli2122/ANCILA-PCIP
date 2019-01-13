import SideBar from './layout/SideBar';
import Header from './layout/Header';
import { store } from './_store';
import { router } from './_helpers';

 
 
Vue.component('datatable', require('./_core/datatable/datatable.vue'));



Vue.component('crudCard', require('./_core/crud/card.vue')); 
Vue.component('crudHeader', require('./_core/crud/header.vue')); 
Vue.component('crudBotaoExcluir', require('./_core/crud/botaoExcluir.vue')); 
Vue.component('crudBotaoVoltar', require('./_core/crud/botaoVoltar.vue')); 
Vue.component('crudBotaoSalvar', require('./_core/crud/botaoSalvar.vue')); 
Vue.component('crudFormElemento', require('./_core/crud/ElementoForm.vue')); 
Vue.component('Formulario', require('./_core/crud/Formulario.vue'));  
Vue.component('select2', require('./_core/crud/SelectComponente.vue'));  
 

// Vue.prototype.$apiUsuario = '/api/v1/usuario';
// Vue.prototype.$apiPerfil = '/api/v1/perfil';
// Vue.prototype.$apiPermissao = '/api/v1/permissao';
// Vue.prototype.$apiLogin = '/api/v1/loginlog';


// Vue.prototype.$apiTentativa = '/api/v1/tentativa';
// Vue.prototype.$apiComentario = '/api/v1/comentario';

// Vue.prototype.$apiDisciplina = '/api/v1/disciplina';
// Vue.prototype.$apiAssunto    = '/api/v1/assunto';
// Vue.prototype.$apiPergunta   = '/api/v1/pergunta';
// Vue.prototype.$apiResposta   = '/api/v1/resposta';


// Vue.prototype.$apiTreinamento   = '/api/v1/treinamento';




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

 