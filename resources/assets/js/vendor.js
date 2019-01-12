
window._ = require('lodash');
window.Popper = require('popper.js').default;
   

try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}
 


window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
 



// let token = document.head.querySelector('meta[name="csrf-token"]');
 
// if (token) {
//     window.axios.defaults.headers.common['X-CSRF-TOKEN'] = token.content;
// } else {
//     console.error('CSRF token not found: https://laravel.com/docs/csrf#csrf-x-csrf-token');
// }
 



// window.token_api = document.head.querySelector('meta[name="api-token"]');

if (localStorage.getItem('user')) {
   // window.axios.defaults.headers.common['Authorization'] = 'Bearer ' + JSON.parse( localStorage.getItem('user') ) ;
}
 // else {
    // console.error('token api not found');
// }





require('datatables.net');
require('datatables.net-bs4');



window.moment = require('moment');
window.moment.locale('pt-BR');
  
window.iziToast = require('izitoast');
window.swal = require('sweetalert2');
window.select2 = require('select2');
 