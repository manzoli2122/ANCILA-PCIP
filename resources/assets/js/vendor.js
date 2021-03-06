// window._ = require('lodash');
// window.Popper = require('popper.js').default;
   
try {
    window.$ = window.jQuery = require('jquery');
    require('bootstrap');
} catch (e) {}
 
window.axios = require('axios');
window.axios.defaults.headers.common['X-Requested-With'] = 'XMLHttpRequest';
 
require('datatables.net');
require('datatables.net-bs4');

window.moment = require('moment');
window.moment.locale('pt-BR');
  
window.iziToast = require('izitoast');
window.swal = require('sweetalert2');
window.select2 = require('select2');
 